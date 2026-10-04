<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRequestsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'citizen_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'service_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'type'         => ['type' => 'VARCHAR', 'constraint' => 50],
            'description'  => ['type' => 'TEXT'],
            'location'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status'       => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'nouveau'],
            'agent_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('citizen_id');
        $this->forge->addKey('status');
        $this->forge->addForeignKey('citizen_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('agent_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('service_id', 'services', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('requests');
    }

    public function down()
    {
        $this->forge->dropTable('requests', true);
    }
}