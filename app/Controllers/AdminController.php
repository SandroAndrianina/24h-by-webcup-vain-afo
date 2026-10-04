<?php

namespace App\Controllers;

use Config\Database;

class AdminController extends BaseController
{
    public function index()
    {
        return redirect()->to(site_url('admin/dashboard'));
    }

    public function dashboard(): string
    {
        $db = Database::connect();

        $usersCount         = $db->table('users')->where('deleted_at', null)->countAllResults();
        $requestsCount      = $db->table('requests')->where('deleted_at', null)->countAllResults();
        $announcementsCount = $db->table('announcements')->where('deleted_at', null)->countAllResults();
        $servicesCount      = $db->table('services')->where('deleted_at', null)->countAllResults();
        $agentsCount        = $db->table('users')->where('role_id', 2)->where('deleted_at', null)->countAllResults();
        $citizensCount      = $db->table('users')->where('role_id', 3)->where('deleted_at', null)->countAllResults();
        $alertsCount        = $db->table('announcements')->where('is_alert', 1)->where('deleted_at', null)->countAllResults();

        $seriesAround = fn(int $total) => array_map(
            fn($i) => max(1, $total - rand(0, 3) + $i % 3),
            range(1, 8)
        );

        $dash = [
            'name'   => 'Tableau de bord — TERRA NOVA',
            'alerts' => $alertsCount,
            'best'   => [
                'label'   => 'Utilisateurs inscrits',
                'value'   => $usersCount,
                'suffix'  => '',
                'change'  => '+12,4%',
                'series'  => $seriesAround($usersCount),
            ],
            'kpis' => [
                ['label' => 'Demandes', 'value' => $requestsCount,      'change' => '+8,1%',  'direction' => 'up'],
                ['label' => 'Annonces', 'value' => $announcementsCount, 'change' => '+3,2%',  'direction' => 'up'],
                ['label' => 'Agents',   'value' => $agentsCount,        'change' => '+1,5%',  'direction' => 'up'],
                ['label' => 'Citoyens', 'value' => $citizensCount,      'change' => '+11,7%', 'direction' => 'up'],
            ],
            'traffic' => [
                'total'  => $requestsCount * 12,
                'change' => '+5,8%',
                'series' => $seriesAround($requestsCount * 12),
                'labels' => ['Lun','Mar','Mer','Jeu','Ven','Sam','Dim'],
            ],
            'modules' => [
                ['tag' => 'Demandes',     'count' => $requestsCount,      'series' => $seriesAround($requestsCount)],
                ['tag' => 'Annonces',     'count' => $announcementsCount, 'series' => $seriesAround($announcementsCount)],
                ['tag' => 'Services',     'count' => $servicesCount,      'series' => $seriesAround($servicesCount)],
                ['tag' => 'Utilisateurs', 'count' => $usersCount,         'series' => $seriesAround($usersCount)],
            ],
            'ranges' => [
                '7j'  => ['total' => $requestsCount * 7,   'series' => $seriesAround($requestsCount * 7)],
                '30j' => ['total' => $requestsCount * 30,  'series' => $seriesAround($requestsCount * 30)],
                '12m' => ['total' => $requestsCount * 365, 'series' => $seriesAround($requestsCount * 365)],
            ],
        ];

        return view('admin/dashboard_admin', ['dash' => $dash]);
    }

    /** D08 — Liste des utilisateurs avec rôles */
    public function users(): string
    {
        $db = Database::connect();

        $users = $db->table('users u')
            ->select('u.id, u.name, u.email, u.created_at, r.code AS role_code, r.label AS role_label')
            ->join('roles r', 'r.id = u.role_id', 'left')
            ->where('u.deleted_at', null)
            ->orderBy('u.created_at', 'DESC')
            ->get()
            ->getResultArray();

        return view('admin/users', ['users' => $users]);
    }

    /** D09 — Changer le rôle d'un utilisateur */
    public function updateRole(int $id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Interdit']);
        }

        $roleCode = $this->request->getPost('role');
        $valid    = ['admin', 'agent', 'citoyen'];

        if (!in_array($roleCode, $valid, true)) {
            return redirect()->back()->with('error', 'Rôle invalide.');
        }

        $db   = Database::connect();
        $role = $db->table('roles')->where('code', $roleCode)->get()->getRowArray();

        if (!$role) {
            return redirect()->back()->with('error', 'Rôle introuvable.');
        }

        $db->table('users')->where('id', $id)->update(['role_id' => $role['id']]);

        return redirect()->to(site_url('admin/users'))->with('success', 'Rôle mis à jour.');
    }
}