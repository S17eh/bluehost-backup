<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JobCandidate extends Migration
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
            'job_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'candidate_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'status_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                "null" => true
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                "null" => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                "null" => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('job_id', 'jobs', 'id', false, 'CASCADE');
        $this->forge->addForeignKey('candidate_id', 'candidates', 'id', false, 'CASCADE');
        $this->forge->addForeignKey('status_id', 'status_master', 'id', false, 'SET NULL');
        $this->forge->addForeignKey('created_by', 'user', 'id', false, 'SET NULL');
        $this->forge->createTable('job_candidates');
    }

    public function down()
    {
        $this->forge->dropTable('job_candidates');
    }
}
