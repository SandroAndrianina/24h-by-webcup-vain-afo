<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Table roles : id, code, label
        $this->db->table('roles')->insertBatch([
            ['code' => 'admin',   'label' => 'Administrateur'],
            ['code' => 'agent',   'label' => 'Agent municipal'],
            ['code' => 'citoyen', 'label' => 'Citoyen'],
        ]);
    }
}
