<?php

namespace App\Models;

use CodeIgniter\Model;

class City extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'cities';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'state_id', 'status', 'created_at', 'updated_at'];

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
        1 => 'state_name',
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
        $builder->select('cities.id,cities.name,cities.state_id,cities.status,states.name as state_name, states.country_id');
        $builder->join('states', 'states.id=cities.state_id', 'LEFT');

        if (isset($filters['id']) && $filters['id'] != '') $builder->where('cities.id', $filters['id']);

        if (isset($filters['state_id']) && $filters['state_id'] != '') $builder->where('cities.state_id', $filters['state_id']);

        if (isset($filters['search']) && $filters['search'] != '') {
            $search = $this->db->escapeString((string) $filters['search']);
            $builder->like('cities.name', $search);
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


    # Get City list by state_id
    public function ByState($stateID)
    {
        $builder = $this->builder();
        $builder->where('state_id', $stateID);
        $query = $builder->get();
        $results = $query->getResultArray();
        return $results ?? [];
    }
}
