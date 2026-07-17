<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Job extends Migration
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
            'employer_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'job_type_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'work_mode' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'position_title' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'no_of_position' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'candidate_profile' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'skill' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'work_experience_min' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'work_experience_max' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'salary_min' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'salary_max' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'perks_benefits' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => true
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
            'industry_id' => [
                'type' => 'INT',
                'constraint' => '10',
                'unsigned' => true,
                'null' => true
            ],
            'preferred_industry' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'functional_area' => [
                'type' => 'VARCHAR',
                'constraint' => '100'
            ],
            'education' => [
                'type' => 'VARCHAR',
                'constraint' => '100'
            ],
            'start_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'shift' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            'end_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'assign_to ' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
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
        $this->forge->addForeignKey('employer_id', 'employer', 'id', false, 'CASCADE');
        $this->forge->addForeignKey('job_type_id', 'job_types', 'id', false, 'SET NULL');
        $this->forge->addForeignKey('industry_id', 'industry', 'id', false, 'SET NULL');
        $this->forge->addForeignKey('country_id', 'countries', 'id', false, 'SET NULL');
        $this->forge->addForeignKey('state_id', 'states', 'id', false, 'SET NULL');
        $this->forge->addForeignKey('city_id', 'cities', 'id', false, 'SET NULL');
        $this->forge->addForeignKey('assign_to', 'user', 'id', false, 'SET NULL');
        $this->forge->createTable('jobs');
    }

    public function down()
    {
        $this->forge->dropTable('jobs');
    }
}
