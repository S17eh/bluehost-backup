<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRole extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'group_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'level_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'can_delete' => [
                'type' => 'ENUM',
                'constraint' => ['Yes', 'No'],
                'default' => 'Yes'
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
        $this->forge->addForeignKey('level_id', 'role_levels', 'id', false, 'CASCADE');
        $this->forge->createTable('role');
    }

    public function down()
    {
        $this->forge->dropTable('role');
    }
}
