<?php

namespace App\Models;

use CodeIgniter\Model;

class Education extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'educations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'type', 'parent_id', 'status', 'created_at', 'updated_at'];

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
        1 => 'type',
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
    public function getResource($filters = [], $returnAssoc = false, $returnSingleRow = false)
    {
        $builder = $this->builder();
        $builder->select('educations.*,parent_degree.name as parent_degree_name');
        $builder->join('educations as parent_degree', 'educations.parent_id = parent_degree.id', 'LEFT');
        if (isset($filters['id']) && $filters['id'] != '') $builder->where('id', $filters['id']);

        if (isset($filters['search']) && $filters['search'] != '') {
            $search = $this->db->escapeString((string) $filters['search']);
            $builder->like('educations.name', $search);
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

    public function ByType($type)
    {
        $builder = $this->builder();
        $builder->where('type', $type);
        $builder->where('status', 'Active');
        $query = $builder->get();
        $results = $query->getResultArray();
        if ($results) {
            foreach ($results as $key => $value) {
                $results[$key]['id'] = (int) $value['id'];
            }
        }
        return $results ?? [];
    }


    public function ByTypeEduction()
    {
        global $degreeType;
        $data = [];
        foreach ($degreeType as $value) :
            $builder = $this->builder();
            $builder->select('id,name,type');
            $builder->where('type', $value);
            $builder->where('parent_id', null);
            $builder->where('status', 'Active');
            $builder->orderBy('name', 'ASC');
            $query = $builder->get();
            $results = $query->getResultArray();

            $parentData = [];
            foreach ($results as $key => $parent) :
                $educationBuilder = $this->builder();
                $educationBuilder->select('id,name,type');
                $educationBuilder->where('parent_id', $parent['id']);
                $educationBuilder->where('status', 'Active');
                $educationBuilder->orderBy('name', 'ASC');
                $educationQuery = $educationBuilder->get();
                $educationResult = $educationQuery->getResultArray();
                $parentData[$key] = $parent;
                $parentData[$key]['degree'] = $educationResult;
            endforeach;

            $data[] = [
                'type' => $value,
                'parents' => $parentData
            ];

        endforeach;

        return $data;
    }

    public function ByIDEduction($type)
    {

        $builder = $this->builder();
        $builder->select('id,name,type');
        $builder->where('type', $type);
        $builder->where('parent_id', null);
        $builder->where('status', 'Active');
        $builder->orderBy('name', 'ASC');
        $query = $builder->get();
        $results = $query->getResultArray();


        foreach ($results as $key => $parent) :
            $educationBuilder = $this->builder();
            $educationBuilder->select('id,name,type');
            $educationBuilder->where('parent_id', $parent['id']);
            $educationBuilder->where('status', 'Active');
            $educationBuilder->orderBy('name', 'ASC');
            $educationQuery = $educationBuilder->get();
            $educationResult = $educationQuery->getResultArray();

            $results[$key] = $parent;
            $results[$key]['degree'] = $educationResult;
        endforeach;

        // $data[] = [
        //     'type' => $value,
        //     'parents' => $parentData
        // ];


        return $results;
    }
}
