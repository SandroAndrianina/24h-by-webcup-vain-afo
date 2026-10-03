<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('RoleSeeder');
        $this->call('UserSeeder');
        $this->call('ServiceSeeder');
        $this->call('AnnouncementSeeder');
        $this->call('ContactMessageSeeder');
    }
}
