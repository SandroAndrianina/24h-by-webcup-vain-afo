<?php

namespace App\Controllers\Api;

use App\Libraries\Format;
use App\Libraries\Messages;
use App\Libraries\NovaTerraClient;
use CodeIgniter\HTTP\ResponseInterface;

class AgentController extends BaseApiController
{
    /** GET /api/agent/dashboard  (agent : ses messages / admin : tous) */
    public function dashboard(): ResponseInterface
    {
        $isAgent = $this->roleCode() === 'agent';

        $count = db_connect()->table('contact_messages')
            ->select('status, COUNT(*) AS n')
            ->where('deleted_at', null);
        if ($isAgent) {
            $count->where('assigned_agent_id', $this->userId());
        }
        $rows = $count->groupBy('status')->get()->getResultArray();

        $byStatus = ['nouveau' => 0, 'en_cours' => 0, 'traite' => 0];
        foreach ($rows as $r) {
            $byStatus[$r['status']] = (int) $r['n'];
        }

        $latest = Messages::base();
        if ($isAgent) {
            $latest->where('contact_messages.assigned_agent_id', $this->userId());
        }
        $latest = $latest->orderBy('contact_messages.updated_at', 'DESC')
            ->orderBy('contact_messages.id', 'DESC')
            ->findAll(5);

        return $this->json([
            'counts' => [
                'nouveau' => $byStatus['nouveau'],
                'enCours' => $byStatus['en_cours'],
                'traite'  => $byStatus['traite'],
                'total'   => array_sum($byStatus),
            ],
            'needsAction' => $byStatus['nouveau'] + $byStatus['en_cours'],
            'latest'      => array_map([Format::class, 'message'], $latest),
        ]);
    }

    /** GET /api/agent/nova-requests  (agent, admin) : D19 */
    public function novaRequests(): ResponseInterface
    {
        try {
            $result = (new NovaTerraClient())->get();
        } catch (\RuntimeException $e) {
            return $this->error('API Nova Terra indisponible.', 502);
        }

        return $this->json([
            'session' => Format::novaSession($result['session']),
            'items'   => array_map([Format::class, 'novaRequest'], $result['requests']),
            'stale'   => $result['stale'],
        ]);
    }

    /** GET /api/agents  (admin) */
    public function agents(): ResponseInterface
    {
        $rows = db_connect()->query(
            "SELECT u.id, u.name, u.email
               FROM users u
               JOIN roles r ON r.id = u.role_id
              WHERE r.code = 'agent' AND u.deleted_at IS NULL
              ORDER BY u.name ASC"
        )->getResultArray();

        $items = array_map(static fn (array $r): array => [
            'id'    => (int) $r['id'],
            'name'  => $r['name'],
            'email' => $r['email'],
        ], $rows);

        return $this->json(['items' => $items]);
    }
}
