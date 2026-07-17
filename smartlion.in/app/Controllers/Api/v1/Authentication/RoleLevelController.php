<?php

namespace App\Controllers\Api\V1\Authentication;

use App\Controllers\BaseController;
use App\Entities\Collection;
use App\Models\RoleLevel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use Exception;

class RoleLevelController extends BaseController
{
    use ResponseTrait;
    protected $roleLevel;

    public function __construct()
    {
        $this->roleLevel = new RoleLevel();
    }

    public function index()
    {
        $request = $this->request->getGet();

        $getList = $this->roleLevel->getResource($request)->get()->getResultArray();
        foreach ($getList as $key => $value) :
            $getList[$key]['id'] = (int) $value['id'];
            $getList[$key]['is_default'] = $value['is_default'] === 'Yes' ? true : false;
        endforeach;

        $response = Collection::tableData(
            $getList,
            $this->roleLevel->getResource($request, false)->countAllResults()
        );
        $response['parentLevelList'] = $this->roleLevel->levelList();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    public function create()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'level_name'    => ['label' => 'name', 'rules' => 'required|is_unique[role_levels.level_name]'],
            'parent_level'  => ['label' => 'type', 'rules' => 'required'],
        ];

        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $newData = [
                'level_name'    => $request['level_name'],
                'parent_level'  => $request['parent_level'],
                'description'   => $request['description'],
                'is_default'    => 'No',
                'created_at'    => Time::now()
            ];
            $this->roleLevel->save($newData);
        } catch (Exception $err) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG . $err->getMessage()], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => ADD_ROLE_LEVEL]);
    }

    public function update()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'level_name'    => ['label' => 'level name', 'rules' => 'required|is_unique[role_levels.level_name,id,{id}]'],
            'parent_level'  => ['label' => 'parent level', 'rules' => 'required'],
        ];

        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $newData = [
                'level_name'    => $request['level_name'],
                'parent_level'  => $request['parent_level'],
                'description'   => $request['description'],
                'updated_at'    => Time::now()
            ];
            $this->roleLevel->update($request['id'], $newData);
        } catch (Exception $err) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG . $err->getMessage()], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => UPDATE_ROLE_LEVEL]);
    }

    public function delete()
    {
        $request = $this->request->getPost();
        $roleLevel = $this->roleLevel->find($request['id']);

        if ($roleLevel) {
            $roleLevelID = $roleLevel['id'];
            try {
                $this->db->transBegin();
                $this->roleLevel->delete($roleLevelID);
            } catch (\Exception $err) {
                $this->db->transRollback();
                return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
            }
            $this->db->transCommit();
            return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => DELETE_ROLE_LEVEL]);
        }
        return $this->respond(['status' => ERROR_ST, 'status_code' => 200, 'message' => ROLE_LEVEL_NOT_FOUND], '404');
    }
}
