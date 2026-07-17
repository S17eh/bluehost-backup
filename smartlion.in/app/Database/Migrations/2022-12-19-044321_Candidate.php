<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Candidate extends Migration
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
            'full_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'source_from' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'unique'     => true,
            ],
            'alternate_email' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'mobile_number' => [
                'type' => 'BIGINT',
                'constraint' => '20',
            ],
            'current_ctc_lakh' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'current_ctc_thousand' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'expected_ctc_lakh' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'expected_ctc_thousand' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'experience' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'notice_period' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'profile_picture' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => null
            ],
            'address' => [
                'type' => 'TEXT',
                'default' => null,
            ],
            'country_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'state_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'city_id' => [
                'type' => 'INT',
                'constraint' => '10',
                'unsigned' => true,
                'null' => true
            ],
            'post_code' => [
                'type' => 'VARCHAR',
                'constraint' => '100'
            ],
            'gender' => [
                'type' => 'ENUM',
                'constraint' => ['Male', 'Female', 'Other'],
                'null' => true,
            ],
            'date_of_birth' => [
                'type' => 'DATE',
            ],
            'marital_status' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'job_status' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => null
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
                'default' => null
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('country_id', 'countries', 'id', false, 'SET NULL');
        $this->forge->addForeignKey('state_id', 'states', 'id', false, 'SET NULL');
        $this->forge->addForeignKey('city_id', 'cities', 'id', false, 'SET NULL');
        $this->forge->createTable('candidates');
    }

    public function down()
    {
        $this->forge->dropTable('candidates');
    }
}
