<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnnouncementsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'title'        => ['type' => 'VARCHAR', 'constraint' => 200],
            'content'      => ['type' => 'TEXT'],
            'published_at' => ['type' => 'DATETIME', 'null' => true],
            'author_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('published_at');
        $this->forge->addForeignKey('author_id', 'users', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('announcements');
    }

    public function down()
    {
        $this->forge->dropTable('announcements', true);
    }
}
