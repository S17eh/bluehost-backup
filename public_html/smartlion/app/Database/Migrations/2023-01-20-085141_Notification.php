<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Notification extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'notification_type' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'message' => [
                'type' => 'TEXT',
                'default' => null,
            ],
            'is_read' => [
                'type' => 'ENUM',
                'constraint' => ['0', '1'],
                'default' => '0'
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'user', 'id', false, 'CASCADE');
        $this->forge->createTable('notification');
    }

    public function down()
    {
        $this->forge->dropTable('notification');
    }
}
