<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
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
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'unique'     => true,
            ],
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'unique'     => true,
            ],
            'personal_email' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'mobile_number' => [
                'type' => 'BIGINT',
                'constraint' => '20',
            ],
            'alternate_mobile_number' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'gender' => [
                'type' => 'ENUM',
                'constraint' => ['Male', 'Female', 'Other'],
                'null' => true,
            ],
            'country' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'state' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'postcode' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'verified_email' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'role_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'assign_to' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'role_type' => [
                'type' => 'ENUM',
                'constraint' => ['SuperAdmin', 'User', 'Employer', 'Candidate'],
                'null' => true,
            ],
            'employer_id' => [
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
        $this->forge->addForeignKey('role_id', 'role', 'id', false, 'SET NULL');
        $this->forge->addForeignKey('employer_id', 'employer', 'id', false, 'SET NULL');
        $this->forge->addForeignKey('country', 'countries', 'id', false, 'SET NULL');
        $this->forge->addForeignKey('state', 'states', 'id', false, 'SET NULL');
        $this->forge->addForeignKey('city', 'cities', 'id', false, 'SET NULL');
        $this->forge->createTable('user');
        $this->forge->addForeignKey('assign_to', 'user', 'id', false, 'SET NULL');
    }

    public function down()
    {
        $this->forge->dropTable('user');
    }
}
