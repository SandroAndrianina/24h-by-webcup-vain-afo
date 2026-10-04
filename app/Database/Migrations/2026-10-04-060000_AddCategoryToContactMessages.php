<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddCategoryToContactMessages extends Migration
{
    public function up()
    {
        $this->forge->addColumn('contact_messages', [
            'category' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
                'after'      => 'type',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('contact_messages', 'category');
    }
}