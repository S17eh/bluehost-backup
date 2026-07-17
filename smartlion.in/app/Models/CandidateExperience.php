<?php

namespace App\Models;

use CodeIgniter\Model;

class CandidateExperience extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'candidate_experience';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['candidate_id', 'company_name', 'designation', 'start_date', 'end_date', 'is_default_company', 'created_at'];

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
        $builder->where('candidate_id', $ID);
        $query = $builder->get();
        $results = $query->getResultArray();

        if ($results)
            foreach ($results as $key => $value) :
                $results[$key]['id'] = (int) $value['id'];
                $results[$key]['candidate_id'] = (int) $value['candidate_id'];
                $results[$key]['is_default_company'] = $value['is_default_company'] === 'Yes' ? 1 : 0;
            endforeach;

        return $results;
    }
}
