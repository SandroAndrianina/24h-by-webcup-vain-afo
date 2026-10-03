<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRequestsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'type'              => ['type' => 'VARCHAR', 'constraint' => 50],
            'title'             => ['type' => 'VARCHAR', 'constraint' => 150],
            'description'       => ['type' => 'TEXT'],
            'location'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'status'            => ['type' => 'ENUM', 'constraint' => ['nouveau', 'en_cours', 'traite'], 'default' => 'nouveau'],
            'assigned_agent_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('status');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        // true = "IF NOT EXISTS" : ne plante pas si la table existe deja
        $this->forge->createTable('requests', true);
    }

    public function down()
    {
        $this->forge->dropTable('requests', true);
    }
}
