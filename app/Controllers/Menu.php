<?php

namespace App\Controllers;

class Menu extends BaseController
{
    public function index(): string
    {
        helper('url');

        $menu = [
            'name'  => 'LISTE DES SERVICES DISPONIBLES',
            'items' => [
                ['num' => '01', 'icon' => 'orbit',  'title' => 'Construction', 'image' => base_url('assets/images/construction.jpg'), 'text' => 'Conception, rénovation et suivi de vos chantiers, des plans initiaux à la livraison, avec coordination des équipes et contrôle des coûts.'],
                ['num' => '02', 'icon' => 'blob',   'title' => 'Sanitaire', 'image' => base_url('assets/images/sanitaire.jpg'), 'text' => 'Installation et entretien des réseaux sanitaires, équipements de plomberie et systèmes d’évacuation, dans le respect des normes.'],
                ['num' => '03', 'icon' => 'atom',   'title' => 'Énergétique', 'image' => base_url('assets/images/energie.jpg'), 'text' => 'Audit, installation et optimisation des systèmes énergétiques pour réduire la consommation et améliorer l’efficacité des bâtiments.'],
                ['num' => '04', 'icon' => 'waves',  'title' => 'Sécuritaire', 'image' => base_url('assets/images/security.jpg'), 'text' => 'Étude et installation de solutions de sécurité, contrôle d’accès, surveillance et prévention des risques sur vos sites.'],
                ['num' => '05', 'icon' => 'flower', 'title' => 'Agronomique', 'image' => base_url('assets/images/agrnomie.jpg'), 'text' => 'Accompagnement agricole : étude des sols, choix des cultures, gestion des ressources et suivi technique des exploitations.'],
                ['num' => '06', 'icon' => 'gear',   'title' => 'Maintenance technologique', 'image' => base_url('assets/images/technologie.jpg'), 'text' => 'Maintenance préventive et corrective de vos équipements et infrastructures technologiques pour garantir leur disponibilité.'],
            ],
        ];

        return view('menu_page', ['menu' => $menu]);
    }
}
