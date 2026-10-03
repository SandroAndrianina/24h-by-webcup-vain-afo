<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run()
    {
        // Table announcements : id, title, content, published_at, author_id, updated_at, deleted_at
        $admin = $this->db->table('users')->where('email', 'admin@terranova.test')->get()->getRowArray();

        $items = [
            // [titre, contenu, publié il y a X jours]
            [
                'Ouverture de la plateforme numérique de Terra Nova',
                "Les habitants peuvent désormais créer leur compte, consulter les services municipaux et contacter l'administration en ligne.",
                0,
            ],
            [
                'Nouveaux horaires des navettes',
                "Les navettes Centre-Dôme circulent désormais toutes les 10 minutes entre 6h et 22h.",
                1,
            ],
            [
                'Campagne de vaccination au centre médical',
                "Une campagne de vaccination gratuite a lieu chaque mercredi au centre médical central. Aucun rendez-vous n'est nécessaire.",
                2,
            ],
            [
                "Maintenance du réseau d'énergie",
                "Une courte maintenance du réseau est prévue dans le quartier des Serres. Les coupures éventuelles ne dépasseront pas 30 minutes.",
                3,
            ],
            [
                'Inscriptions scolaires ouvertes',
                "Les inscriptions pour la nouvelle année scolaire sont ouvertes au service Éducation et jeunesse, sur place ou en ligne.",
                5,
            ],
        ];

        $rows = [];
        foreach ($items as [$title, $content, $daysAgo]) {
            $date = date('Y-m-d H:i:s', strtotime("-{$daysAgo} days"));
            $rows[] = [
                'title'        => $title,
                'content'      => $content,
                'published_at' => $date,
                'author_id'    => $admin['id'],
                'updated_at'   => $date,
                'deleted_at'   => null,
            ];
        }

        $this->db->table('announcements')->insertBatch($rows);
    }
}
