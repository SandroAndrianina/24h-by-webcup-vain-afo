<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            [
                'name'              => 'Construction',
                'short_description' => 'Conception, rénovation et suivi de vos chantiers, des plans initiaux à la livraison, avec coordination des équipes et contrôle des coûts.',
                'icon'              => 'orbit',
                'image'             => 'construction.jpg',
            ],
            [
                'name'              => 'Sanitaire',
                'short_description' => 'Installation et entretien des réseaux sanitaires, équipements de plomberie et systèmes d’évacuation, dans le respect des normes.',
                'icon'              => 'blob',
                'image'             => 'sanitaire.jpg',
            ],
            [
                'name'              => 'Énergétique',
                'short_description' => 'Audit, installation et optimisation des systèmes énergétiques pour réduire la consommation et améliorer l’efficacité des bâtiments.',
                'icon'              => 'atom',
                'image'             => 'energie.jpg',
            ],
            [
                'name'              => 'Sécuritaire',
                'short_description' => 'Étude et installation de solutions de sécurité, contrôle d’accès, surveillance et prévention des risques sur vos sites.',
                'icon'              => 'waves',
                'image'             => 'security.jpg',
            ],
            [
                'name'              => 'Agronomique',
                'short_description' => 'Accompagnement agricole : étude des sols, choix des cultures, gestion des ressources et suivi technique des exploitations.',
                'icon'              => 'flower',
                'image'             => 'agrnomie.jpg',
            ],
            [
                'name'              => 'Maintenance technologique',
                'short_description' => 'Maintenance préventive et corrective de vos équipements et infrastructures technologiques pour garantir leur disponibilité.',
                'icon'              => 'gear',
                'image'             => 'technologie.jpg',
            ],
        ];

        $now = date('Y-m-d H:i:s');

        foreach ($services as &$s) {
            $s['created_at'] = $now;
            $s['updated_at'] = $now;
        }

        $this->db->table('services')->insertBatch($services);
    }
}