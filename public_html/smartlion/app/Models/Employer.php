<?php

namespace App\Models;

use CodeIgniter\Model;

class Employer extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'employer';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'register_name', 'gst_no', 'email', 'alternate_email', 'mobile_number', 'alternate_mobile_number', 'website', 'address', 'logo', 'rate_type', 'rate', 'status', 'created_at', 'updated_at'];

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
        0 => 'name',
        1 => 'email',
        2 => 'mobile_number',
        3 => 'status',
    ];

    /**
     * This function mainly used for listing data
     * @param array $filters
     * @param boolean $returnAssoc
     * @param boolean $returnSingleRow
     * 
     * @return mixed
     */
    public function getResource($filters = [], $returnAssoc = false, $returnSingleRow = false)
    {
        $builder = $this->builder();
        $builder->select('id,name,register_name,gst_no,email,alternate_email,mobile_number,alternate_mobile_number,website,address,rate_type,rate,status');
        $builder->select('IF(logo IS NOT NULL,CONCAT("' . base_url("company_logo") . '/' . '",logo),"") AS logo');

        if (isset($filters['id']) && $filters['id'] != '') $builder->where('id', $filters['id']);
        if (isset($filters['company_name']) && $filters['company_name'] != '') $builder->like('name', $filters['company_name']);
        if (isset($filters['email']) && $filters['email'] != '') $builder->like('email', $filters['email']);
        if (isset($filters['mobile']) && $filters['mobile'] != '') $builder->like('mobile_number', $filters['mobile']);
        if (isset($filters['status']) && $filters['status'] != '') $builder->like('status', $filters['status']);

        if (isset($filters['search']) && $filters['search'] != '') {
            $search = $this->db->escapeString((string) $filters['search']);
            $builder->like('name', $search);
            $builder->orLike('email', $search);
            $builder->orLike('mobile_number', $search);
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
            if (isset($filters['company_name']) && $filters['company_name'] != '') $builder->like('name', $filters['company_name']);
            if (isset($filters['email']) && $filters['email'] != '') $builder->like('email', $filters['email']);
            if (isset($filters['mobile']) && $filters['mobile'] != '') $builder->like('mobile_number', $filters['mobile']);
            if (isset($filters['status']) && $filters['status'] != '') $builder->like('status', $filters['status']);

            $results['totalCount'] = (int) $builder->countAllResults();
            if ($returnAssoc) {
                $results['data'] = [];
                foreach ($query->getResultArray() as $roleDetails) {
                    $results['data'][$roleDetails['id']] = $roleDetails;
                }
            } else {

                $data = $query->getResultArray();
                foreach ($data as $key => $result) {
                    $data[$key]['alternate_email'] = !empty($result['alternate_email']) ? explode(',', $result['alternate_email'] ?? '') : [];
                    $data[$key]['alternate_mobile_number'] = !empty($result['alternate_mobile_number']) ? explode(',', $result['alternate_mobile_number'] ?? '') : [];
                    $data[$key]['documents'] = model(Documents::class)->select('id,document,CONCAT("' . base_url("company_documents") . '/' . '",document) AS document_url')->where('type', 'employer')->where('parent_id', $result['id'])->get()->getResultArray();
                }
                $results['data'] = $data;
            }
        }
        return $results;
    }

    const ORDERABLE_DASHBOARD = [
        0 => 'name',
        1 => 'amount'
    ];

    public function monthlyRevenue(array $filters = [], bool $pagination = true)
    {

        $builder = $this->builder();
        $builder->select('employer.name');
        $builder->selectSum("CASE WHEN(job_candidates.is_hired = 'YES') THEN (job_candidates.revenue) ELSE 0 END",  'amount');
        $builder->join('jobs', 'jobs.employer_id=employer.id');
        $builder->join('job_candidates', 'job_candidates.job_id=jobs.id');
        if (isset($filters['revenueDate'])) {
            $builder->where('MONTH(job_candidates.updated_at)', date('m', strtotime($filters['revenueDate'])));
            $builder->where('YEAR(job_candidates.updated_at)', date('Y', strtotime($filters['revenueDate'])));
        }
        $builder->groupBy('employer.id');
        if ($pagination) {
            if ((isset($filters['displayLength']) && isset($filters['displayStart']))  && $filters['displayLength'] != '' && $filters['displayStart'] != '' && $filters['displayLength'] != '-1') {
                $builder->limit($filters['displayLength'], $filters['displayStart']);
            }
            if (isset($filters['orderDir']) &&  isset($filters['orderColumn'])) {
                $order  = self::ORDERABLE_DASHBOARD[$filters['orderColumn']];
                $dir    = $filters['orderDir'];
                $builder->orderBy($order, $dir);
            }
        }
        return $builder;
    }
}
