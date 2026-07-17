<?php

namespace App\Models;

use CodeIgniter\Model;

class Dashboard extends Model
{
    public function forAdminInit()
    {
        $builder = $this->builder('employer');
        $builder->selectCount('employer.id', 'total_company');
        $builder->select("(SELECT COUNT(id) FROM jobs WHERE status = 'Active') as total_open_job");
        $query = $builder->get();
        $result = $query->getRowArray();
        return $result;
    }
}
