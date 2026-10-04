<?php

namespace App\Controllers;

use App\Models\UserModel;
use Modules\Requests\Infrastructure\RequestModel;
use Modules\Requests\Infrastructure\RequestRepository;

class AgentRequestController extends BaseController
{
    private function getAgent(): array
    {
        $userModel = new UserModel();

        return $userModel
            ->where('id', session()->get('user_id'))
            ->first();
    }

    private function getRepository(): RequestRepository
    {
        return new RequestRepository(new RequestModel());
    }

    public function index()
    {
        $agent = $this->getAgent();

        $serviceId = (int) $agent['service_id'];

        $requests = $this->getRepository()->findByService($serviceId);

        return view('agent/requests/index', [
            'agent' => $agent,
            'requests' => $requests,
        ]);
    }

    public function show(int $id)
    {
        $agent = $this->getAgent();

        $request = $this->getRepository()->findById($id);

        if ($request === null) {
            return redirect()
                ->to(site_url('agent/requests'))
                ->with('error', 'Demande introuvable.');
        }

        if ($request->serviceId() !== (int) $agent['service_id']) {
            return redirect()
                ->to(site_url('agent/requests'))
                ->with('error', 'Accès refusé.');
        }

        return view('agent/requests/show', [
            'agent' => $agent,
            'request' => $request,
        ]);
    }

    public function updateStatus(int $id)
    {
        $agent = $this->getAgent();

        $request = $this->getRepository()->findById($id);

        if ($request === null) {
            return redirect()
                ->to(site_url('agent/requests'))
                ->with('error', 'Demande introuvable.');
        }

        if ($request->serviceId() !== (int) $agent['service_id']) {
            return redirect()
                ->to(site_url('agent/requests'))
                ->with('error', 'Accès refusé.');
        }

        $status = $this->request->getPost('status');

        $allowedStatuses = [
            'nouveau',
            'en_cours',
            'resolu'
        ];

        if (!in_array($status, $allowedStatuses, true)) {
            return redirect()
                ->back()
                ->with('error', 'Statut invalide.');
        }

        $updated = $this->getRepository()->updateStatus(
            $id,
            $status,
            (int) $agent['id']
        );

        if (!$updated) {
            return redirect()
                ->back()
                ->with('error', 'Impossible de modifier le statut.');
        }

        return redirect()
            ->to(site_url('agent/requests/' . $id))
            ->with('success', 'Le statut de la demande a été modifié.');
    }
}