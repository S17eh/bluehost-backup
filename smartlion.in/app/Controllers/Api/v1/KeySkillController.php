<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use App\Models\KeySkill;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use Exception;

class KeySkillController extends BaseController
{
    use ResponseTrait;
    protected $keySkill;

    public function __construct()
    {
        $this->keySkill = new KeySkill();
    }

    public function index()
    {
        $request = $this->request->getGet();
        $response = $this->keySkill->getResource($request);
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    public function create()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'name'          => ['label' => 'name', 'rules' => 'required|is_unique[key_skills.name]'],
            'status'        => ['label' => 'status', 'rules' => 'required|in_list[Active,Inactive]']
        ];

        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $newData = [
                'name'      => $request['name'],
                'status'      => $request['status'],
                'created_at'    => Time::now()
            ];

            $this->keySkill->save($newData);
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => ADD_KEY_SKILL]);
    }

    public function update()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'name'          => ['label' => 'name', 'rules' => 'required|is_unique[key_skills.name,id,{id}]'],
            'status'        => ['label' => 'status', 'rules' => 'required|in_list[Active,Inactive]']
        ];

        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $newData = [
                'name'      => $request['name'],
                'status'      => $request['status'],
                'updated_at'    => Time::now()
            ];

            $this->keySkill->update($request['id'], $newData);
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => UPDATE_KEY_SKILL]);
    }

    public function delete()
    {
        $request = $this->request->getPost();
        $keySkillData = $this->keySkill->getResource($request, false, true);

        if ($keySkillData) {
            $keySkillID = $keySkillData['id'];
            try {
                $this->db->transBegin();
                $this->keySkill->delete($keySkillID);
            } catch (\Exception $err) {
                $this->db->transRollback();
                return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
            }
            $this->db->transCommit();
            return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => DELETE_KEY_SKILL]);
        }
        return $this->respond(['status' => ERROR_ST, 'status_code' => 200, 'message' => KEY_SKILL_NOT_FOUND], '404');
    }

    public function createKeySkillFromJob()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'name'          => ['label' => 'name', 'rules' => 'required|is_unique[key_skills.name]']
        ];

        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $newData = [
                'name'      => $request['name'],
                'status'      => 'Active',
                'created_at'    => Time::now()
            ];

            $this->keySkill->save($newData);
            $keySkillID = $this->keySkill->getInsertID();
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        $keyData = (object) $this->keySkill->select('id,name')->find($keySkillID);
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $keyData]);
    }
}
