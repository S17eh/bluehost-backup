<?php

namespace App\Models;

use CodeIgniter\Model;

class State extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'states';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'country_id', 'status', 'created_at', 'updated_at'];

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
        1 => 'country_name',
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
        $builder->select('states.id,states.name,states.country_id,states.status,countries.name as country_name');
        $builder->join('countries', 'countries.id=states.country_id', 'LEFT');

        if (isset($filters['id']) && $filters['id'] != '') $builder->where('states.id', $filters['id']);

        if (isset($filters['country_id']) && $filters['country_id'] != '0') $builder->where('states.country_id', $filters['country_id']);

        if (isset($filters['search']) && $filters['search'] != '') {
            $search = $this->db->escapeString((string) $filters['search']);
            $builder->like('states.name', $search);
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
            if (isset($filters['country_id']) && $filters['country_id'] != '0') $builder->where('states.country_id', $filters['country_id']);
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


    /**
     * This function return Country wise State List
     * 
     * @param int $countryID
     * @param string $status
     * 
     * @return array
     */
    public function getByCountry($countryID, $status = 'Active')
    {
        $builder = $this->builder();
        $builder->select('id,name');
        $builder->where('country_id', $countryID);
        $builder->where('status', $status);
        $query = $builder->get();
        $result =  $query->getResultArray();
        return $result;
    }
}
