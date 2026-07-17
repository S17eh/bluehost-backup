<?php

namespace App\Models;

use CodeIgniter\Model;

class CandidateEducation extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'candidate_education';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'candidate_id',
        'type',
        'course_id',
        'specification',
        'institute_name',
        'start_date',
        'end_date',
        'is_student',
        'created_at'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function byCandidateID($ID)
    {
        $builder = $this->builder();
        $builder->select('candidate_education.*,educations.name as course_name,institutes.name as institute');
        $builder->join('educations', 'educations.id=candidate_education.course_id');
        $builder->join('institutes', 'institutes.id=candidate_education.institute_name');
        $builder->where('candidate_education.candidate_id', $ID);
        $query = $builder->get();
        $results = $query->getResultArray();

        if (!empty($results)) {
            foreach ($results as $key => $value) {
                $type = $value['type'];
                // $courseList = model(Education::class)->ByType($type);
                $courseList = model(Education::class)->where('type', $type)->where('parent_id', null)->get()->getResult();
                $results[$key]['id'] = (int) $value['id'];
                $results[$key]['candidate_id'] = (int) $value['candidate_id'];
                $results[$key]['course_id'] = (int) $value['course_id'];
                $results[$key]['courseList'] = $courseList;
                $results[$key]['degreeList'] =  model(Education::class)->where('type', $type)->where('parent_id', $value['course_id'])->get()->getResult();
            }
        }

        return $results;
    }
}
