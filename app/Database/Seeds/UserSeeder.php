<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Table users : id, role_id, name, email, password_hash, created_at, updated_at, deleted_at
        $roles = [];
        foreach ($this->db->table('roles')->get()->getResultArray() as $r) {
            $roles[$r['code']] = $r['id'];
        }

        $hash = password_hash('Terra@2026', PASSWORD_DEFAULT); // mot de passe de test commun

        $users = [
            // [role, nom, email, il y a combien de jours]
            ['admin',   'Admin Terra Nova', 'admin@terranova.test',    30],
            ['agent',   'Hery Rakoto',      'agent1@terranova.test',   28],
            ['agent',   'Naina Rasoa',      'agent2@terranova.test',   28],
            ['citoyen', 'Rado Andria',      'citoyen1@terranova.test', 14],
            ['citoyen', 'Lala Ravelo',      'citoyen2@terranova.test', 10],
            ['citoyen', 'Tojo Randria',     'citoyen3@terranova.test',  5],
        ];

        $rows = [];
        foreach ($users as [$role, $name, $email, $daysAgo]) {
            $date = date('Y-m-d H:i:s', strtotime("-{$daysAgo} days"));
            $rows[] = [
                'role_id'       => $roles[$role],
                'name'          => $name,
                'email'         => $email,
                'password_hash' => $hash,
                'created_at'    => $date,
                'updated_at'    => $date,
                'deleted_at'    => null,
            ];
        }

        $this->db->table('users')->insertBatch($rows);
    }
}
