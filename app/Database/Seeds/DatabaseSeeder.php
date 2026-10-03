<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // L'ordre compte : les tables liées viennent après celles dont elles dépendent
        $this->call('RoleSeeder');
        $this->call('UserSeeder');
        $this->call('ServiceSeeder');
        $this->call('AnnouncementSeeder');
        $this->call('ContactMessageSeeder');
    }
}
