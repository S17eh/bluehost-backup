<?php

namespace App\Controllers\Api\V1\Authentication;

use App\Controllers\BaseController;
use App\Models\Permission;
use App\Models\PermissionGroup;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use Exception;

class PermissionController extends BaseController
{
    use ResponseTrait;
    protected $permission;
    protected $permissionGroup;

    public function __construct()
    {
        $this->permission = new Permission();
        $this->permissionGroup = new PermissionGroup();
    }

    public function index()
    {
        $request = $this->request->getGet();
        $permissions = $this->permission->getPermission($request);
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $permissions]);
    }

    public function groupList()
    {
        $request = $this->request->getGet();
        $response = $this->permissionGroup->getPermissionGroup($request);
        $response['permissionList'] = $this->permission->getPermissionForGroup();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    public function groupCreate()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'name' => ['label' => 'name', 'rules' => 'required|is_unique[permission_group.name]'],
            'description' => ['label' => 'description', 'rules' => 'required']
        ];
        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $permissions = isset($request['permissions']) && !empty($request['permissions']) ? implode(',', $request['permissions']) : Null;
            $restrictions = isset($request['restrictions']) && !empty($request['restrictions']) ? implode(',', $request['restrictions']) : Null;
            $newData = [
                'name' => $request['name'],
                'description' => $request['description'],
                'permissions' => $permissions,
                'restrictions' => $restrictions,
                'created_at' => Time::now()
            ];

            $this->permissionGroup->save($newData);
        } catch (Exception $err) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => ADD_PERMISSION_GROUP]);
    }

    public function groupUpdate()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'name' => ['label' => 'name', 'rules' => 'required|is_unique[permission_group.name,id,{id}]'],
            'description' => ['label' => 'description', 'rules' => 'required']
        ];
        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $permissions = isset($request['permissions']) && !empty($request['permissions']) ? implode(',', $request['permissions']) : Null;
            $restrictions = isset($request['restrictions']) && !empty($request['restrictions']) ? implode(',', $request['restrictions']) : Null;
            $newData = [
                'name' => $request['name'],
                'description' => $request['description'],
                'permissions' => $permissions,
                'restrictions' => $restrictions,
                'updated_at' => Time::now()
            ];

            $this->permissionGroup->update($request['id'], $newData);
        } catch (Exception $err) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => UPDATE_PERMISSION_GROUP]);
    }

    public function groupDelete()
    {
        $request = $this->request->getPost();
        $permissionGroup = $this->permissionGroup->getPermissionGroup($request, false, true);

        if ($permissionGroup) {
            $permissionGroupID = $permissionGroup['id'];
            try {
                $this->db->transBegin();
                $this->permissionGroup->delete($permissionGroupID);
            } catch (\Exception $err) {
                $this->db->transRollback();
                return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
            }
            $this->db->transCommit();
            return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => DELETE_RESTRICTION]);
        }
        return $this->respond(['status' => ERROR_ST, 'status_code' => 200, 'message' => RESTRICTION_NOT_FOUND], '404');
    }
}
