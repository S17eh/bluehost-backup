<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'user';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username', 'first_name', 'last_name', 'email', 'personal_email', 'password', 'mobile_number', 'alternate_mobile_number', 'image', 'address', 'gender', 'country', 'state', 'city', 'postcode', 'verified_email', 'role_id', 'assign_to', 'user_type', 'employer_id', 'status', 'created_at', 'updated_at'
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
    protected $beforeInsert   = ['passwordHash'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['passwordHash'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    const ORDERABLE = [
        0 => 'first_name',
        1 => 'username',
        2 => 'email',
        3 => 'mobile_number',
        4 => 'role_name',
        5 => 'country_name',
        6 => 'status',
    ];

    protected function passwordHash(array $data)
    {
        if (isset($data['data']['password']))
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        return $data;
    }

    # This function for user login details
    public function ByEmail($email)
    {
        $builder = $this->builder()
            ->select('user.*,IF(image IS NOT NULL,CONCAT("' . base_url("profile_picture") . '/' . '",user.image),"") AS image,states.name as state_name,cities.name as city_name, countries.name as country_name')
            ->select('role.name as role_name')
            ->join('countries', 'countries.id = user.country', 'LEFT')
            ->join('states', 'states.id = user.state', 'LEFT')
            ->join('cities', 'cities.id = user.city', 'LEFT')
            ->join('role', 'role.id = user.role_id', 'LEFT')
            ->where('user.email', $email)->get()->getRowArray();

        return $builder;
    }

    /**
     * Get userList Data for user Listing
     */

    public function getUserList($filters = array(), $returnAssoc = false, $returnSingleRow = false)
    {
        $builder = $this->builder();
        $builder->select('user.*,countries.name as country_name');
        $builder->select('IF(image IS NOT NULL,CONCAT("' . base_url("profile_picture") . '/' . '",user.image),"") AS image');
        $builder->select('role.name as role_name');
        $builder->join('countries', 'countries.id = user.country', 'LEFT');
        $builder->join('role', 'role.id = user.role_id', 'LEFT');
        if (isset($filters['id']) && $filters['id'] != '') $builder->where('id', $filters['id']);

        if (isset($filters['employer_id']) && $filters['employer_id'] != '') $builder->where('user.employer_id', $filters['employer_id']);
        if (isset($filters['role_id']) && $filters['role_id'] != '') $builder->where('user.role_id', $filters['role_id']);

        if (isset($filters['name']) && $filters['name'] != '') {
            $builder->like('user.first_name', $filters['name']);
            $builder->orLike('user.last_name', $filters['name']);
        }
        if (isset($filters['username']) && $filters['username'] != '') $builder->like('user.username', $filters['username']);
        if (isset($filters['status']) && $filters['status'] != '') $builder->like('user.status', $filters['status']);
        if (isset($filters['email']) && $filters['email'] != '') $builder->like('user.email', $filters['email']);
        if (isset($filters['country']) && $filters['country'] != '') $builder->like('user.country', $filters['country']);

        if (isset($filters['search']) && $filters['search'] != '') {
            $search = $this->db->escapeString((string) $filters['search']);
            $builder->like('user.first_name', $search);
            $builder->orLike('user.last_name', $search);
            $builder->orLike('user.username', $search);
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

            if (isset($filters['name']) && $filters['name'] != '') {
                $builder->like('first_name', $filters['name']);
                $builder->orLike('last_name', $filters['name']);
            }
            if (isset($filters['username']) && $filters['username'] != '') $builder->like('username', $filters['username']);
            if (isset($filters['email']) && $filters['email'] != '') $builder->like('email', $filters['email']);
            if (isset($filters['country']) && $filters['country'] != '') $builder->like('country', $filters['country']);

            $results['totalCount'] = (int) $builder->countAllResults();
            if ($returnAssoc) {
                $results['data'] = [];
                foreach ($query->getResultArray() as $userDetails) {
                    $results['data'][$userDetails['id']] = $userDetails;
                }
            } else {
                $data = $query->getResultArray();
                foreach ($data as $key => $result) {
                    $data[$key]['alternate_mobile_number'] = !empty($result['alternate_mobile_number']) ? explode(',', $result['alternate_mobile_number'] ?? '') : [];
                    $data[$key]['documents'] = model(Documents::class)->select('id,document,CONCAT("' . base_url("user_documents") . '/' . '",document) AS document_url')->where('type', 'user')->where('parent_id', $result['id'])->get()->getResultArray();
                }
                $results['data'] = $data;
            }
        }

        return $results;
    }

    # User List for Dropdown
    public function UserDropDown()
    {
        $builder = $this->builder();
        $builder->select('id,CONCAT(first_name, " ", last_name) as name');
        $builder->whereNotIn('role_id', [1, 2, 3]);
        $results = $builder->get()->getResultArray();
        return $results;
    }


    public function OrganizationData($userID)
    {
        $builder = $this->builder();
        $builder->where('id', $userID);
        $builder->whereIn('user_type', ['SuperAdmin', 'User']);
        $query = $builder->get();
        $result = $query->getRowArray();

        $newData[] = [
            'name' => $result['first_name'] . ' ' . $result['last_name'],
            'child' =>  $this->OrganizationTree($result['id'])
        ];

        return $newData;
    }

    private function OrganizationTree($userID)
    {
        $newArray = [];
        $builder = $this->builder();
        $builder->where('assign_to', $userID);
        $builder->whereIn('user_type', ['SuperAdmin', 'User']);
        $query = $builder->get();
        $result = $query->getResultArray();
        foreach ($result as $value) :
            $newArray[] = [
                'name' => $value['first_name'] . ' ' . $value['last_name'],
                'child' =>  $this->OrganizationTree($value['id'])
            ];

        endforeach;
        return $newArray;
    }


    // This function for export user
    public function getByFilters($filters = array())
    {
        $builder = $this->builder();
        $builder->whereIn('user_type', ['User', 'Employer']);
        $query = $builder->get();
        $results = $query->getResultArray();
        return $results;
    }
}
