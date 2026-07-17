<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleLevel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'role_levels';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['level_name', 'parent_level', 'description', 'is_default', 'created_at', 'updated_at'];

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
        0 => 'level_name',
        1 => 'parent_level_name',
    ];

    public function getResource(array $filters = [], bool $isTotal = true)
    {
        $builder = $this->builder();
        $builder->select('role_levels.*');
        $builder->select('rl.level_name as parent_level_name');
        $builder->join('role_levels as rl', 'rl.id=role_levels.parent_level', 'LEFT');
        if (isset($filters['search']) && $filters['search'] != '') {
            $search = $this->db->escapeString((string) $filters['search']);
            $builder->like('role_levels.level_name', $search);
            $builder->like('rl.level_name', $search);
        }

        if (isset($filters['parent_level']) && $filters['parent_level'] != '0') {
            $builder->where('role_levels.parent_level', $filters['parent_level']);
        }

        if ($isTotal) {
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

    # Get Parent Level List
    public function levelList()
    {
        $builder = $this->builder();
        $builder->select('id,level_name');
        $builder->orderBy('level_name');
        $query = $builder->get();
        $result = $query->getResultArray();
        return $result;
    }

    public function ByID($ID)
    {
        $builder = $this->builder();
        $builder->select('role_levels.*');
        $builder->select('rl.level_name as parent_level_name');
        $builder->join('role_levels as rl', 'rl.id=role_levels.parent_level', 'LEFT');
        $builder->where('role_levels.id', $ID);
        $query = $builder->get();
        $result = $query->getRowArray();
        return $result;
    }
}
