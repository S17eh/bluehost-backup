<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Education extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name'  => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'parent_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Active', 'Inactive'],
                'default' => 'Active'
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('parent_id', 'educations', 'id', false, 'CASCADE');
        $this->forge->createTable('educations');
    }

    public function down()
    {
        $this->forge->dropTable('educations');
    }
}
