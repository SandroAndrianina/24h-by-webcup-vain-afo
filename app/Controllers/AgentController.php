<?php

namespace App\Controllers;

use App\Models\UserModel;

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

        return view('agent/dashboard', [
            'agent' => $agent,
            'service' => $service
        ]);
    }
}