<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    public function run()
    {
        // Table contact_messages : id, user_id, message, status, assigned_agent_id, created_at, updated_at, deleted_at
        $ids = [];
        foreach ($this->db->table('users')->get()->getResultArray() as $u) {
            $ids[$u['email']] = $u['id'];
        }

        $agent1 = $ids['agent1@terranova.test'];
        $agent2 = $ids['agent2@terranova.test'];

        $items = [
            // [citoyen, message, statut, agent assigné, envoyé il y a X heures, dernière action il y a X heures]
            ['citoyen1@terranova.test', "Bonjour, un lampadaire est cassé devant le 12 rue des Serres. Pouvez-vous envoyer quelqu'un ?", 'nouveau',  $agent1, 2,  2],
            ['citoyen2@terranova.test', "Je souhaite savoir quels documents fournir pour un certificat de résidence.",                       'en_cours', $agent2, 20, 5],
            ['citoyen3@terranova.test', "La navette Dôme-Serres n'est pas passée ce matin à 7h30. Y a-t-il un problème sur la ligne ?",      'traite',   $agent1, 48, 30],
            ['citoyen1@terranova.test', "Comment inscrire mon enfant à l'école pour la prochaine année scolaire ?",                          'en_cours', $agent1, 12, 4],
            ['citoyen2@terranova.test', "Il y a une fuite d'eau dans le couloir de mon immeuble, bloc C. C'est urgent.",                     'nouveau',  $agent2, 1,  1],
            ['citoyen3@terranova.test', "Quels sont les horaires du centre médical pour la vaccination ?",                                   'traite',   $agent2, 72, 60],
            ['citoyen1@terranova.test', "Je voudrais déposer une demande de permis pour une extension de mon logement.",                     'nouveau',  $agent2, 3,  3],
            ['citoyen2@terranova.test', "Merci pour la réponse rapide concernant mon acte de naissance, tout est réglé.",                    'traite',   $agent1, 96, 90],
        ];

        $rows = [];
        foreach ($items as [$email, $message, $status, $agentId, $sentHoursAgo, $lastHoursAgo]) {
            $rows[] = [
                'user_id'           => $ids[$email],
                'message'           => $message,
                'status'            => $status,
                'assigned_agent_id' => $agentId,
                'created_at'        => date('Y-m-d H:i:s', strtotime("-{$sentHoursAgo} hours")),
                'updated_at'        => date('Y-m-d H:i:s', strtotime("-{$lastHoursAgo} hours")),
                'deleted_at'        => null,
            ];
        }

        $this->db->table('contact_messages')->insertBatch($rows);
    }
}
