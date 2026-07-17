<?php

namespace App\Models;

use CodeIgniter\Model;

class Job extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'jobs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['job_code', 'employer_id', 'title', 'job_type_id', 'work_mode', 'position_title', 'no_of_position', 'description', 'candidate_profile', 'skill', 'work_experience_min', 'work_experience_max', 'salary_min_lakhs', 'salary_min_thousands', 'salary_max_lakhs', 'salary_max_thousands', 'perks_benefits', 'country_id', 'state_id', 'city_id', 'post_code', 'industry_id', 'preferred_industry', 'functional_area', 'education', 'start_date', 'shift', 'end_date', 'assign_to', 'status', 'created_at', 'updated_at'];
    // protected $allowedFields    = ['employer_id', 'title', 'requirement', 'location', 'category', 'position_title', 'no_of_position', 'start_date', 'end_date', 'work_experience', 'salary', 'salary_type', 'status', 'created_at', 'updated_at'];

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
        0 => 'title',
        1 => 'employer_name',
        2 => 'start_date',
        3 => 'position_title',
        4 => 'status',
    ];

    /**
     * This function mainly use for listing data
     * @param array $filters
     * @param boolean $returnAssoc
     * @param boolean $returnSingleRow
     * 
     * @return mixed
     */
    public function getResource($filters = [], $returnAssoc = false, $returnSingleRow = false)
    {
        $builder = $this->builder();
        $builder->select('jobs.*,employer.name as employer_name,job_types.name as job_type');
        $builder->join('employer', 'employer.id=jobs.employer_id', 'LEFT');
        $builder->join('job_types', 'job_types.id=jobs.job_type_id', 'LEFT');

        if (isset($filters['id']) && $filters['id'] != '') $builder->where('jobs.id', $filters['id']);

        if (isset($filters['employer_id']) && $filters['employer_id'] != '0' && $filters['employer_id'] != '') $builder->where('jobs.employer_id', $filters['employer_id']);

        if (isset($filters['title']) && $filters['title'] != '0' && $filters['title'] != '') $builder->like('jobs.title', $filters['title'], 'both');

        if (isset($filters['position_title']) && $filters['position_title'] != '0' && $filters['position_title'] != '') $builder->like('jobs.position_title', $filters['position_title'], 'both');

        if (isset($filters['status']) &&  $filters['status'] != '') $builder->where('jobs.status', $filters['status']);

        if (isset($filters['type']) && $filters['type'] != '') $builder->where('job_types.id', $filters['type']);

        if (isset($filters['work_mode']) && $filters['work_mode'] != '') $builder->where('jobs.work_mode', $filters['work_mode']);

        if (isset($filters['minimum_work_experience']) && $filters['minimum_work_experience'] != '') $builder->where('jobs.work_experience_min >=', $filters['minimum_work_experience']);

        if (isset($filters['maximum_work_experience']) && $filters['maximum_work_experience'] != '') $builder->where('jobs.work_experience_max <=', $filters['maximum_work_experience']);

        # Filter With Eduction
        if (isset($filters['skill'])) {
            $condition1 = [];
            foreach ($filters['skill'] as $value) :
                $condition1[] = "FIND_IN_SET('$value',jobs.skill) > 0";
            endforeach;
            $builder->where(implode(" OR ", $condition1));
        }

        # Filter With Eduction
        if (isset($filters['education'])) {
            $condition = [];
            foreach ($filters['education'] as $value) :
                $condition[] = "FIND_IN_SET($value,jobs.education) > 0";
            endforeach;
            $builder->where(implode(" OR ", $condition));
        }

        if (isset($filters['search']) && $filters['search'] != '') {
            $search = $this->db->escapeString((string) $filters['search']);
            $builder->like('jobs.title', $search);
        }

        if ((isset($filters['displayLength']) && isset($filters['displayStart']))  && $filters['displayLength'] != '' && $filters['displayStart'] != '' && $filters['displayLength'] != '-1') {
            $builder->limit($filters['displayLength'], $filters['displayStart']);
        }

        if (isset($filters['orderDir']) &&  isset($filters['orderColumn'])) {
            $order  = self::ORDERABLE[$filters['orderColumn']];
            $dir    = $filters['orderDir'];
            $builder->orderBy($order, $dir);
        }

        $query = $builder->get();

        if ($returnSingleRow) {
            $results = $query->getRowArray();
        } else {
            if (isset($filters['title']) && $filters['title'] != '0') $builder->like('jobs.title', $filters['title'], 'both');
            if (isset($filters['position_title']) && $filters['position_title'] != '0') $builder->like('jobs.position_title', $filters['position_title'], 'both');
            if (isset($filters['status']) && $filters['status'] != '0') $builder->like('jobs.status', $filters['status'], 'both');

            $results['totalCount'] = (int) $builder->countAllResults();
            if ($returnAssoc) {
                $results['data'] = [];
                foreach ($query->getResultArray() as $roleDetails) {
                    $results['data'][$roleDetails['id']] = $roleDetails;
                }
            } else {
                $results['data'] = $query->getResultArray();
            }
        }
        return $results;
    }


    public function resource($filters = [], $pagination = true)
    {
        $builder = $this->builder();
        $builder->select('jobs.*,employer.name as employer_name,job_types.name as job_type');
        $builder->join('employer', 'employer.id=jobs.employer_id', 'LEFT');
        $builder->join('job_types', 'job_types.id=jobs.job_type_id', 'LEFT');

        if (isset($filters['id']) && $filters['id'] != '') $builder->where('jobs.id', $filters['id']);
        if (isset($filters['employer_id']) && $filters['employer_id'] != '0' && $filters['employer_id'] != '') $builder->where('jobs.employer_id', $filters['employer_id']);
        if (isset($filters['status']) &&  $filters['status'] != '') $builder->where('jobs.status', $filters['status']);
        if (isset($filters['type']) && $filters['type'] != '') $builder->where('job_types.id', $filters['type']);
        if (isset($filters['work_mode']) && $filters['work_mode'] != '') $builder->where('jobs.work_mode', $filters['work_mode']);
        if (isset($filters['minimum_work_experience']) && $filters['minimum_work_experience'] != '') $builder->where('jobs.work_experience_min >=', $filters['minimum_work_experience']);
        if (isset($filters['maximum_work_experience']) && $filters['maximum_work_experience'] != '') $builder->where('jobs.work_experience_max <=', $filters['maximum_work_experience']);

        if (isset($filters['title']) && $filters['title'] != '0' && $filters['title'] != '') $builder->like('jobs.title', $filters['title'], 'both');
        if (isset($filters['position_title']) && $filters['position_title'] != '0' && $filters['position_title'] != '') $builder->like('jobs.position_title', $filters['position_title'], 'both');

        # Filter With Eduction
        if (isset($filters['skill'])) {
            $condition1 = [];
            foreach ($filters['skill'] as $value) :
                $condition1[] = "FIND_IN_SET('$value',jobs.skill) > 0";
            endforeach;
            $builder->where(implode(" OR ", $condition1));
        }

        # Filter With Eduction
        if (isset($filters['education'])) {
            $condition = [];
            foreach ($filters['education'] as $value) :
                $condition[] = "FIND_IN_SET($value,jobs.education) > 0";
            endforeach;
            $builder->where(implode(" OR ", $condition));
        }

        if (isset($filters['search']) && $filters['search'] != '') {
            $search = $this->db->escapeString((string) $filters['search']);
            $builder->like('jobs.title', $search);
        }

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
