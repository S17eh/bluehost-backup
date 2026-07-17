<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CandidateEducation extends Migration
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
            'candidate_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'course_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'specification' => [
                "type" => "TEXT",
                "null" => true
            ],
            'institute_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'start_date' => [
                'type' => 'DATE',
            ],
            'end_date' => [
                'type' => 'DATE',
                'default' => null
            ],
            'is_student' => [
                'type' => 'ENUM',
                'constraint' => ['Yes', 'No'],
                'default' => 'No'
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('candidate_id', 'candidates', 'id', false, 'CASCADE');
        $this->forge->addForeignKey('course_id', 'educations', 'id', false, 'CASCADE');
        $this->forge->createTable('candidate_education');
    }

    public function down()
    {
        $this->forge->dropTable('candidate_education');
    }
}
