<?php

namespace App\Models;

use CodeIgniter\Model;

class JobCandidate extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'job_candidates';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['job_id', 'candidate_id', 'status_id', 'is_hired', 'revenue', 'created_by', 'created_at', 'updated_at'];

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

    const ORDERABLE = [
        0 => 'candidate_name',
        1 => 'assignee_name',
        2 => 'status_name'
    ];

    public function resource($filters = array(), $pagination = true)
    {
        $builder = $this->builder();
        $builder->select('job_candidates.*,candidates.full_name as candidate_name, status_master.name as status_name');
        $builder->select('CONCAT(user.first_name," ", user.last_name) as assignee_name');

        $builder->join('candidates', 'candidates.id=job_candidates.candidate_id');
        $builder->join('user', 'user.id=job_candidates.created_by');
        $builder->join('status_master', 'status_master.id=job_candidates.status_id');

        if (isset($filters['search']) && $filters['search'] !== '') {
            $search = $this->db->escapeString((string) $filters['search']);
            // $builder->like('user.first_name', $search);
            // $builder->orLike('user.last_name', $search);
            // $builder->orLike('status_master.name', $search);
            $builder->like('candidates.full_name', $search);
        }

        isset($filters['job_id']) && $filters['job_id'] !== '0' && $builder->where('job_id', $filters['job_id']);

        if ($pagination) {
            if ((isset($filters['displayLength']) && isset($filters['displayStart']))  && $filters['displayLength'] != '' && $filters['displayStart'] != '' && $filters['displayLength'] != '-1') {
                $builder->limit($filters['displayLength'], $filters['displayStart']);
            }
            if (isset($filters['orderDir']) &&  isset($filters['orderColumn'])) {
                $order  = self::ORDERABLE[$filters['orderColumn']];
                $dir    = $filters['orderDir'];
                $builder->orderBy($order, $dir);
            }
        }
        return $builder;
    }
}
