<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddFieldsToContactMessages extends Migration
{
    public function up()
    {
        $this->forge->addColumn('contact_messages', [
            'type'     => ['type' => 'ENUM', 'constraint' => ['contact','demande','signalement'], 'default' => 'contact', 'after' => 'user_id'],
            'subject'  => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true, 'after' => 'type'],
            'location' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'message'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('contact_messages', ['type','subject','location']);
    }
}