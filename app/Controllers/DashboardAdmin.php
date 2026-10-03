<?php

namespace App\Controllers;

class DashboardAdmin extends BaseController
{
    public function index(): string
    {
        $dash = [
            'name'   => 'TERRA NOVA',
            'alerts' => 8,
            'best'   => [
                'label'  => 'Chiffre d’affaires',
                'value'  => 58340,
                'suffix' => ' €',
                'change' => '+12,8%',
                'series' => [28, 34, 31, 43, 39, 54, 49, 66, 62, 75, 69, 88],
            ],
            'kpis'   => [
                ['label' => 'Utilisateurs', 'value' => 4286, 'change' => '+8,4%', 'direction' => 'up'],
                ['label' => 'Commandes',    'value' => 1762, 'change' => '+12,1%', 'direction' => 'up'],
                ['label' => 'Tickets',      'value' => 18,   'change' => '-4,2%', 'direction' => 'down'],
            ],
            'traffic' => [
                'total'  => 12480,
                'change' => '+8,2%',
                'labels' => ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                'series' => [48, 62, 55, 74, 69, 91, 84],
            ],
            'channels' => [
                ['label' => 'Site web',    'value' => 48, 'count' => 5990],
                ['label' => 'Application', 'value' => 27, 'count' => 3370],
                ['label' => 'Partenaires', 'value' => 16, 'count' => 2000],
                ['label' => 'Autres',      'value' => 9,  'count' => 1120],
            ],
            'modules' => [
                ['tag' => 'Utilisateurs', 'count' => 4286, 'series' => [24, 30, 28, 43, 48, 58, 72, 78]],
                ['tag' => 'Commandes',    'count' => 1762, 'series' => [18, 24, 22, 36, 42, 55, 62, 70]],
                ['tag' => 'Catalogue',    'count' => 286,  'series' => [30, 34, 32, 38, 43, 47, 52, 58]],
                ['tag' => 'Rapports',     'count' => 42,   'series' => [12, 18, 16, 26, 30, 39, 43, 51]],
            ],
            'ranges' => [
                '24h' => ['total' => 486,   'series' => [18, 22, 19, 31, 28, 42, 38, 55, 49, 62, 58, 74]],
                '7j'  => ['total' => 3280,  'series' => [32, 28, 40, 47, 43, 59, 67, 62, 76, 71, 86, 94]],
                '30j' => ['total' => 13840, 'series' => [22, 31, 28, 43, 50, 47, 64, 59, 73, 79, 88, 100]],
            ],
        ];

        return view('dashAdmin', ['dash' => $dash]);
    }
}
