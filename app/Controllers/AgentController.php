<?php

namespace App\Controllers;

use App\Models\UserModel;
use Modules\Requests\Infrastructure\RequestModel;
use Modules\Requests\Infrastructure\RequestRepository;

class AgentController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();

        $agent = $userModel
            ->where('id', session()->get('user_id'))
            ->first();

        $db = \Config\Database::connect();

        $service = $db->table('services')
            ->where('id', $agent['service_id'])
            ->get()
            ->getRowArray();

        $requestRepository = new RequestRepository(new RequestModel());

        $serviceId = (int) $agent['service_id'];

        $stats = [
            'total' => $requestRepository->countByService($serviceId),

            'nouveau' => $requestRepository->countByServiceAndStatus(
                $serviceId,
                'nouveau'
            ),

            'en_cours' => $requestRepository->countByServiceAndStatus(
                $serviceId,
                'en_cours'
            ),

            'resolu' => $requestRepository->countByServiceAndStatus(
                $serviceId,
                'resolu'
            ),
        ];

        $chart = $requestRepository->getLastSevenDaysStats($serviceId);

        return view('agent/dashboard', [
            'agent' => $agent,
            'service' => $service,
            'stats' => $stats,
            'chart' => $chart,
        ]);
    }
}