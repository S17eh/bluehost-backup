<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CandidateExperience extends Migration
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
            'company_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'designation' => [
                "type" => "TEXT",
                "null" => true
            ],
            'start_date' => [
                'type' => 'DATE',
            ],
            'end_date' => [
                'type' => 'DATE',
                'default' => null
            ],
            'is_default_company' => [
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
        $this->forge->createTable('candidate_experience');
    }

    public function down()
    {
        $this->forge->dropTable('candidate_experience');
    }
}
