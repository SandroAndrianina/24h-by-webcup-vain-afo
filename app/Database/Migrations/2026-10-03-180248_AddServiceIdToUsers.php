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
                'after'      => 'role_id',
            ],
        ]);

        $this->forge->addForeignKey('service_id', 'services', 'id', 'SET NULL', 'CASCADE', 'users_service_id_foreign');
        $this->forge->processIndexes('users');
    }

    public function down()
    {
        // Supprime la FK seulement si elle existe
        $db = \Config\Database::connect();
        $fk = $db->query("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'users'
              AND CONSTRAINT_NAME = 'users_service_id_foreign'
        ")->getRow();

        if ($fk) {
            $this->forge->dropForeignKey('users', 'users_service_id_foreign');
        }

        if ($this->db->fieldExists('service_id', 'users')) {
            $this->forge->dropColumn('users', 'service_id');
        }
    }
}