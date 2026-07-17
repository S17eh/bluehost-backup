<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class Notification extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'notification';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'notification_type', 'message', 'is_read', 'created_at'];

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
        0 => 'notification_type',
        1 => 'created_by',
        2 => 'created_at',
    ];
    public function resource($filters = array(), $pagination = true)
    {
        $builder = $this->builder();
        $builder->select('notification.*');
        $builder->select('CONCAT(user.first_name," ",user.last_name) as created_by');
        $builder->join('user', 'user.id=notification.user_id');
        if (isset($filters['search']) && $filters['search'] !== '') {
            $search = $this->db->escapeString((string) $filters['search']);
            $builder->like('notification.notification_type', $search);
            $builder->orLike('notification.message', $search);
            // $builder->like('user.full_name', $search);
            // $builder->orLike('user.last_name', $search);
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


    public function setNotification($userID, $notificationType = '', $message = '')
    {
        $newData = [
            'user_id' => $userID,
            'notification_type' => $notificationType,
            'message' => $message,
            'is_read' => '0',
            'created_at' => Time::now()
        ];
        $this->builder()->insert($newData);
    }
}
