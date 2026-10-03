<?php

namespace App\Controllers;

class Menu extends BaseController
{
    public function index(): string
    {
        helper('url');

        // Remplace les url par tes vraies routes
        $menu = [
            'name'  => 'Dashboard Admin',
            'items' => [
                ['num' => '01', 'icon' => 'orbit',   'title' => 'Tableau de bord', 'url' => site_url('dashboard'),
                 'text' => "Une vue d'ensemble de votre activité : revenus, commandes et indicateurs clés, mis à jour en temps réel pour décider plus vite."],
                ['num' => '02', 'icon' => 'blob',    'title' => 'Utilisateurs',    'url' => site_url('users'),
                 'text' => "Gérez les comptes, les rôles et les permissions de votre équipe et de vos clients depuis un seul écran."],
                ['num' => '03', 'icon' => 'atom',    'title' => 'Commandes',       'url' => site_url('orders'),
                 'text' => "Suivez chaque commande, de la validation à la livraison, et traitez les retours sans quitter la page."],
                ['num' => '04', 'icon' => 'waves',   'title' => 'Produits',        'url' => site_url('products'),
                 'text' => "Ajoutez, modifiez et organisez votre catalogue : stocks, prix, catégories et visuels au même endroit."],
                ['num' => '05', 'icon' => 'flower',  'title' => 'Rapports',        'url' => site_url('reports'),
                 'text' => "Exportez des rapports clairs sur les ventes, les visites et les performances de chaque période."],
                ['num' => '06', 'icon' => 'gear',    'title' => 'Paramètres',      'url' => site_url('settings'),
                 'text' => "Configurez la plateforme, les notifications et la sécurité selon les besoins de votre organisation."],
            ],
        ];

        return view('menu_page', ['menu' => $menu]);
    }
}
