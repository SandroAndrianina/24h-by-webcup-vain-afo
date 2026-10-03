<?php

namespace App\Controllers\Api;

use App\Libraries\Format;
use App\Libraries\Messages;
use App\Models\ContactMessageModel;
use CodeIgniter\HTTP\ResponseInterface;

class MessageController extends BaseApiController
{
    /** POST /api/messages  (citoyen) */
    public function create(): ResponseInterface
    {
        $data = ['message' => trim((string) ($this->payload()['message'] ?? ''))];
        if (! $this->validateData($data, ['message' => 'required|min_length[5]|max_length[2000]'])) {
            return $this->validationError();
        }

        $id = (new ContactMessageModel())->insert([
            'user_id'           => $this->userId(), // le citoyen connecté, jamais lu dans la requête
            'message'           => $data['message'],
            'status'            => 'nouveau',
            'assigned_agent_id' => Messages::pickAgentId(),
        ]);

        return $this->json(Format::message(Messages::base()->find($id)), 201);
    }

    /** GET /api/messages/mine  (citoyen) */
    public function mine(): ResponseInterface
    {
        $rows = Messages::base()
            ->where('contact_messages.user_id', $this->userId())
            ->orderBy('contact_messages.created_at', 'DESC')
            ->orderBy('contact_messages.id', 'DESC')
            ->findAll();

        return $this->json(['items' => array_map([Format::class, 'message'], $rows)]);
    }

    /** GET /api/messages?status=...  (agent : ses messages / admin : tous) */
    public function index(): ResponseInterface
    {
        $query = Messages::base();

        if ($this->roleCode() === 'agent') {
            $query->where('contact_messages.assigned_agent_id', $this->userId());
        }

        $status = $this->request->getGet('status');
        if ($status !== null && $status !== '') {
            if (! in_array($status, Messages::STATUSES, true)) {
                return $this->error('Données invalides.', 422, ['status' => 'Statut inconnu.']);
            }
            $query->where('contact_messages.status', $status);
        }

        $rows = $query
            ->orderBy('contact_messages.updated_at', 'DESC')
            ->orderBy('contact_messages.id', 'DESC')
            ->findAll();

        return $this->json(['items' => array_map([Format::class, 'message'], $rows)]);
    }

    /** GET /api/messages/{id} */
    public function show($id = null): ResponseInterface
    {
        $row = Messages::base()->find((int) $id);
        if (! $row) {
            return $this->notFound();
        }

        $role = $this->roleCode();
        $me   = $this->userId();
        $ok   = $role === 'admin'
            || ($role === 'citoyen' && (int) $row['user_id'] === $me)
            || ($role === 'agent' && (int) $row['assigned_agent_id'] === $me);

        if (! $ok) {
            return $this->error('Accès interdit à ce message.', 403);
        }

        return $this->json(Format::message($row));
    }

    /** PATCH /api/messages/{id}/status  (agent assigné / admin) */
    public function status($id = null): ResponseInterface
    {
        $row = Messages::base()->find((int) $id);
        if (! $row) {
            return $this->notFound();
        }

        if ($this->roleCode() === 'agent' && (int) $row['assigned_agent_id'] !== $this->userId()) {
            return $this->error("Ce message n'est pas assigné à votre compte.", 403);
        }

        $data = ['status' => (string) ($this->payload()['status'] ?? '')];
        if (! $this->validateData($data, ['status' => 'required|in_list[nouveau,en_cours,traite]'])) {
            return $this->validationError();
        }

        (new ContactMessageModel())->update((int) $id, ['status' => $data['status']]);

        return $this->json(Format::message(Messages::base()->find((int) $id)));
    }

    /** PATCH /api/messages/{id}/assign  (admin) */
    public function assign($id = null): ResponseInterface
    {
        if (! Messages::base()->find((int) $id)) {
            return $this->notFound();
        }

        $agentId = (int) ($this->payload()['agentId'] ?? 0);

        $agent = db_connect()->query(
            "SELECT u.id FROM users u
               JOIN roles r ON r.id = u.role_id
              WHERE u.id = ? AND r.code = 'agent' AND u.deleted_at IS NULL",
            [$agentId]
        )->getRowArray();

        if (! $agent) {
            return $this->error('Données invalides.', 422, ['agentId' => "Cet identifiant n'est pas celui d'un agent."]);
        }

        (new ContactMessageModel())->update((int) $id, ['assigned_agent_id' => $agentId]);

        return $this->json(Format::message(Messages::base()->find((int) $id)));
    }
}
