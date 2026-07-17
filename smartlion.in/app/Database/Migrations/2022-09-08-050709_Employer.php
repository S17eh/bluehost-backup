<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Employer extends Migration
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
                'constraint' => '255',
            ],
            'register_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'gst_no' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'unique'     => true,
            ],
            'alternate_email' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'mobile_number' => [
                'type' => 'BIGINT',
                'constraint' => '20',
                'unique'     => true,
            ],
            'alternate_mobile_number' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'website' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'logo' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => true,
            ],
            'rate_type' => [
                'type' => 'ENUM',
                'constraint' => ['1', '2'],
                'default' => '1'
            ],
            'rate' => [
                'type' => 'FLOAT',
                'constraint' => [10, 2],
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
        $this->forge->createTable('employer');
    }

    public function down()
    {
        $this->forge->dropTable('employer');
    }
}
