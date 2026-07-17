<?php

namespace App\Models;

use CodeIgniter\Model;

use function PHPUnit\Framework\isNull;

class Candidate extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'candidates';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'source_from',
        'full_name',
        'email',
        'alternate_email',
        'mobile_number',
        'current_ctc_lakh',
        'current_ctc_thousand',
        'expected_ctc_lakh',
        'expected_ctc_thousand',
        'experience',
        'notice_period',
        'current_skill',
        'profile_picture',
        'resume',
        'address',
        'country_id',
        'state_id',
        'city_id',
        'post_code',
        'gender',
        'date_of_birth',
        'marital_status',
        'job_status',
        'status',
        'created_at',
        'updated_at',
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

    const ORDERABLE = [
        0 => 'full_name',
        1 => 'email',
        2 => 'status'
    ];

    /**
     * This function mainly use for listing data
     * @param array $filters
     * @param boolean $returnAssoc
     * @param boolean $returnSingleRow
     * 
     * @return mixed
     */
    public function getResource($filters = [])
    {
        $builder = $this->builder();
        $builder->select('candidates.id, candidates.full_name, candidates.email, candidates.mobile_number, candidates.status');
        $builder->select('IF(candidates.profile_picture IS NOT NULL,CONCAT("' . base_url("candidate_profile") . '/' . '",candidates.profile_picture),null) AS profile_picture');

        if (isset($filters['search']) && $filters['search'] != '') {
            $search = $this->db->escapeString((string) $filters['search']);
            $builder->like('full_name', $search);
            $builder->orLike('email', $search);
        }

        // if (isset($filters['current_skill']) && $filters['current_skill'] != '') {
        //     $currentSkill = $this->db->escapeString((string) $filters['current_skill']);
        //     $builder->like('current_skill', $currentSkill);
        // }
        if (isset($filters['current_skill'])) {
            $condition1 = [];
            foreach ($filters['current_skill'] as $value) :
                $condition1[] = "FIND_IN_SET('$value',current_skill) > 0";
            endforeach;
            $builder->where(implode(" OR ", $condition1));
        }

        if (isset($filters['source']) && $filters['source'] != '') {
            $builder->where('source_from', $filters['source']);
        }

        if (isset($filters['notice_period']) && $filters['notice_period'] != '') {
            $builder->where('notice_period', $filters['notice_period']);
        }

        if (isset($filters['gender']) && $filters['gender'] != '') {
            $builder->where('gender', $filters['gender']);
        }

        if (isset($filters['status']) && $filters['status'] != '') {
            $builder->where('status', $filters['status']);
        }

        # Pagination & OrderBy Code
        if ((isset($filters['displayLength']) && isset($filters['displayStart']))  && $filters['displayLength'] != '' && $filters['displayStart'] != '' && $filters['displayLength'] != '-1') {
            $builder->limit($filters['displayLength'], $filters['displayStart']);
        }
        if (isset($filters['orderDir']) &&  isset($filters['orderColumn'])) {
            $order  = self::ORDERABLE[$filters['orderColumn']];
            $dir    = $filters['orderDir'];
            $builder->orderBy($order, $dir);
        }

        $query = $builder->get();
        $results['totalCount'] = (int) $builder->countAllResults();
        $results['data'] = $query->getResultArray();

        return $results;
    }

    /**
     * Get Candidate All Data
     * 
     * @param int $ID
     * @return mixed
     */
    public function getCandidateAllData(int $ID)
    {
        $builder = $this->builder();
        $builder->select('candidates.*');
        $builder->select('IF(candidates.profile_picture IS NOT NULL,CONCAT("' . base_url("candidate_profile") . '/' . '",candidates.profile_picture),"") AS profile_picture');
        $builder->select('IF(candidates.resume IS NOT NULL,CONCAT("' . base_url("candidate_resume") . '/' . '",candidates.resume),"") AS resume');
        $builder->select('countries.name AS country_name, states.name AS state_name, cities.name AS city_name');
        $builder->join('countries', 'countries.id=candidates.country_id', 'LEFT');
        $builder->join('states', 'states.id=candidates.state_id', 'LEFT');
        $builder->join('cities', 'cities.id=candidates.city_id', 'LEFT');
        $builder->where('candidates.id', $ID);
        $query = $builder->get();
        $result = $query->getRowArray();


        if ($result) {
            $result['id']                       = (int) $result['id'];
            $result['current_ctc_lakh']         = (int) $result['current_ctc_lakh'];
            $result['current_ctc_thousand']     = (int) $result['current_ctc_thousand'];
            $result['expected_ctc_lakh']        = (int) $result['expected_ctc_lakh'];
            $result['expected_ctc_thousand']    = (int) $result['expected_ctc_thousand'];
            $result['country_id']               = (int) $result['country_id'];
            $result['state_id']                 = (int) $result['state_id'];
            $result['city_id']                  = (int) $result['city_id'];
            $result['current_skill']            = $result['current_skill'] != '' ? explode(',', $result['current_skill']) : [];


            $result['alternate_email']  =  $result['alternate_email'] ?  explode(',', $result['alternate_email']) : [];
            $result['mobile_number']    = $result['mobile_number'] ? explode(',', $result['mobile_number']) : [];
            $experience                 = model(CandidateExperience::class)->byCandidateID($ID);
            $education                  = model(CandidateEducation::class)->byCandidateID($ID);
            $result['experiences']      = $experience ?? [];
            $result['educations']       = $education ?? [];
        }

        return $result;
    }


    public function listForJobApplication($filters = array(), $pagination = true)
    {
        $builder = $this->builder();
        $builder->select('id,source_from,full_name,email,alternate_email,mobile_number,job_status');
        if (isset($filters['search']) && $filters['search'] !== '') {
            $search = $this->db->escapeString((string) $filters['search']);
            $builder->like('full_name', $search);
            $builder->orLike('email', $search);
            $builder->orLike('mobile_number', $search);
        }
        // if (isset($filters['currentSkill']) && $filters['currentSkill'] !== '') {
        //     $currentSkill = $this->db->escapeString((string) $filters['currentSkill']);
        //     $builder->orLike('current_skill', $currentSkill);
        // }

        if (isset($filters['currentSkill'])) {
            $condition1 = [];
            foreach ($filters['currentSkill'] as $value) :
                $condition1[] = "FIND_IN_SET('$value',current_skill) > 0";
            endforeach;
            $builder->where(implode(" OR ", $condition1));
        }



        if ($pagination) {
            if ((isset($filters['displayLength']) && isset($filters['displayStart']))  && $filters['displayLength'] != '' && $filters['displayStart'] != '' && $filters['displayLength'] != '-1') {
                $builder->limit($filters['displayLength'], $filters['displayStart']);
            }

            if (isset($filters['orderDir']) &&  isset($filters['orderColumn'])) {
                // $order  = self::ORDERABLE[$filters['orderColumn']];
                $dir    = $filters['orderDir'];
                $builder->orderBy('full_name', $dir);
            }
        }
        return $builder;
    }
}
