<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddServiceIdToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'service_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'role_id'
            ]
        ]);

        $this->forge->addForeignKey(
            'service_id',
            'services',
            'id',
            'CASCADE',
            'SET NULL',
            'users_service_id_foreign'
        );
    }

    public function down()
    {
        $this->forge->dropForeignKey('users', 'users_service_id_foreign');
        $this->forge->dropColumn('users', 'service_id');
    }
}
