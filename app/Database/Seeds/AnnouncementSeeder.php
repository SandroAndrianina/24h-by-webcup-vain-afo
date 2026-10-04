<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run()
    {
        $admin = $this->db->table('users')
            ->where('email', 'admin@terranova.test')
            ->get()
            ->getRowArray();

        if (!$admin) {
            throw new \RuntimeException("Admin user introuvable. Lance d'abord UserSeeder.");
        }

        $items = [
            [
                'Ouverture de la plateforme numérique de Terra Nova',
                "Les habitants peuvent désormais créer leur compte, consulter les services municipaux et contacter l'administration en ligne.",
                0, 0, null,
            ],
            [
                'Nouveaux horaires des navettes',
                "Les navettes Centre-Dôme circulent désormais toutes les 10 minutes entre 6h et 22h.",
                1, 0, null,
            ],
            [
                'Campagne de vaccination au centre médical',
                "Une campagne de vaccination gratuite a lieu chaque mercredi au centre médical central. Aucun rendez-vous n'est nécessaire.",
                2, 0, null,
            ],
            [
                "Maintenance du réseau d'énergie",
                "Une courte maintenance du réseau est prévue dans le quartier des Serres. Les coupures éventuelles ne dépasseront pas 30 minutes.",
                3, 0, null,
            ],
            [
                'Inscriptions scolaires ouvertes',
                "Les inscriptions pour la nouvelle année scolaire sont ouvertes au service Éducation et jeunesse, sur place ou en ligne.",
                5, 0, null,
            ],
            [
                'Alerte : montée inhabituelle du niveau de l\'eau — quartier Sud',
                "Une montée inhabituelle du niveau de l'eau est observée dans le quartier sud. Les habitants sont invités à éviter la zone et à suivre les consignes des services municipaux.",
                0, 1, 'inondation',
            ],
        ];

        $rows = [];
        foreach ($items as [$title, $content, $daysAgo, $isAlert, $category]) {
            $date = date('Y-m-d H:i:s', strtotime("-{$daysAgo} days"));
            $rows[] = [
                'title'          => $title,
                'content'        => $content,
                'is_alert'       => $isAlert,
                'alert_category' => $category,
                'published_at'   => $date,
                'author_id'      => $admin['id'],
                'updated_at'     => $date,
                'deleted_at'     => null,
            ];
        }

        $this->db->table('announcements')->insertBatch($rows);
    }
}