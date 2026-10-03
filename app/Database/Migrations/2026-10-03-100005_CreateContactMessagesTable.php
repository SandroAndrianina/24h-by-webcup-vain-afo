<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContactMessagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'message'           => ['type' => 'TEXT'],
            'status'            => ['type' => 'ENUM', 'constraint' => ['nouveau', 'en_cours', 'traite'], 'default' => 'nouveau'],
            'assigned_agent_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('status');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('assigned_agent_id', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('contact_messages');
    }

    public function down()
    {
        $this->forge->dropTable('contact_messages', true);
    }
}
