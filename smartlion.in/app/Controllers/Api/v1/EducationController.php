<?php

namespace App\Controllers\Api\v1;

use App\Controllers\BaseController;
use App\Models\Education;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use Exception;
use phpDocumentor\Reflection\Types\Null_;

class EducationController extends BaseController
{
    use ResponseTrait;
    protected $education;

    public function __construct()
    {
        $this->education = new Education();
    }

    public function index()
    {
        global $degreeType;
        $request = $this->request->getGet();
        $response = $this->education->getResource($request);
        $response['degreeType'] = $degreeType;
        $response['parent'] = $this->education->where('parent_id =', null)->get()->getResultArray();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    public function create()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'name'          => ['label' => 'name', 'rules' => 'required|is_unique[educations.name]'],
            'type'          => ['label' => 'type', 'rules' => 'required'],
            'status'        => ['label' => 'status', 'rules' => 'required|in_list[Active,Inactive]']
        ];

        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $newData = [
                'name'        => $request['name'],
                'type'        => $request['type'],
                'parent_id'   => isset($request['parent_id']) && $request['parent_id'] != 0 && $request['parent_id'] != '' ? $request['parent_id'] : null,
                'status'      => $request['status'],
                'created_at'  => Time::now()
            ];

            $this->education->save($newData);
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG . $ex->getMessage()], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => ADD_EDUCATION]);
    }

    public function update()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'name'          => ['label' => 'name', 'rules' => 'required|is_unique[educations.name,id,{id}]'],
            'type'          => ['label' => 'type', 'rules' => 'required'],
            'status'        => ['label' => 'status', 'rules' => 'required|in_list[Active,Inactive]']
        ];

        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $newData = [
                'name'        => $request['name'],
                'type'        => $request['type'],
                'parent_id'   => isset($request['parent_id']) && $request['parent_id'] != 0 ? $request['parent_id'] : null,
                'status'      => $request['status'],
                'updated_at'  => Time::now()
            ];

            $this->education->update($request['id'], $newData);
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => UPDATE_EDUCATION]);
    }

    public function delete()
    {
        $request = $this->request->getPost();
        $education = $this->education->find($request['id']);

        if ($education) {
            $educationID = $education['id'];
            try {
                $this->db->transBegin();
                $this->education->delete($educationID);
            } catch (\Exception $err) {
                $this->db->transRollback();
                return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
            }
            $this->db->transCommit();
            return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => DELETE_EDUCATION]);
        }
        return $this->respond(['status' => ERROR_ST, 'status_code' => 200, 'message' => EDUCATION_NOT_FOUND], '404');
    }
}
