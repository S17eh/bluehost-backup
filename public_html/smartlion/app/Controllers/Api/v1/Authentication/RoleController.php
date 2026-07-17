<?php

namespace App\Controllers\Api\V1\Authentication;

use App\Controllers\BaseController;
use App\Models\PermissionGroup;
use App\Models\Role;
use App\Models\RoleLevel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use Exception;

class RoleController extends BaseController
{
    use ResponseTrait;
    protected $role;
    protected $permissionGroup;

    public function __construct()
    {
        $this->role = new Role();
        $this->roleLevel = new RoleLevel();
        $this->permissionGroup = new PermissionGroup();
    }

    public function index()
    {
        global $roleStatus;
        $request = $this->request->getGet();
        $response = $this->role->getRoles($request);
        $response['roleStatus'] = $roleStatus;
        $response['levels'] = $this->roleLevel->levelList();
        $response['permissionGroups'] = $this->permissionGroup->getLists();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    public function create()
    {
        $request = $this->request->getPost();

        $validationRules      = [
            'name' => ['label' => 'name', 'rules' => 'required|is_unique[role.name]'],
            'status' => 'required',
        ];

        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $newData = [
                'name' => $request['name'],
                'group_id' => $request['group_id'],
                'level_id' => $request['level_id'],
                'status' => $request['status'],
                'created_at' => Time::now()
            ];
            $this->role->save($newData);
        } catch (\Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => ADD_ROLE]);
    }

    public function update()
    {
        $validationRules      = [
            'name' => ['label' => 'name', 'rules' => 'required|is_unique[role.name,id,{id}]'],
            'status' => 'required',
        ];

        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $request = $this->request->getPost();
            $newData = [
                'name' => $request['name'],
                'group_id' => $request['group_id'],
                'level_id' => $request['level_id'],
                'status' => $request['status'],
                'updated_at' => Time::now()
            ];
            $this->role->update($request['id'], $newData);
        } catch (\Exception $err) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => UPDATE_ROLE]);
    }

    public function delete()
    {
        $request = $this->request->getPost();
        $role = $this->role->getRoles($request, false, true);

        if ($role) {
            $roleID = $role['id'];
            try {
                $this->db->transBegin();
                $this->role->delete($roleID);
            } catch (\Exception $err) {
                $this->db->transRollback();
                return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
            }
            $this->db->transCommit();
            return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => DELETE_ROLE]);
        }
        return $this->respond(['status' => ERROR_ST, 'status_code' => 200, 'message' => ROLE_NOT_FOUND], '404');
    }
}
