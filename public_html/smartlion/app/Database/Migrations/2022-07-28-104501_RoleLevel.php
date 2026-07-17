<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RoleLevel extends Migration
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
            'level_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'parent_level' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                "null" => true
            ],
            'description' => [
                "type" => "TEXT",
                "null" => true
            ],
            'is_default' => [
                'type' => 'ENUM',
                'constraint' => ['Yes', 'No'],
                'default' => 'No'
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('role_levels');
    }

    public function down()
    {
        $this->forge->dropTable('role_levels');
    }
}
