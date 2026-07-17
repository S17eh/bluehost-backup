<?php

namespace App\Controllers\Api\v1;

use App\Controllers\BaseController;
use App\Models\JobType;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use Exception;

class JobTypeController extends BaseController
{
    use ResponseTrait;
    protected $jobType;

    public function __construct()
    {
        $this->jobType = new JobType();
    }

    public function index()
    {
        $request = $this->request->getGet();
        $response = $this->jobType->getResource($request);
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    public function create()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'name'          => ['label' => 'name', 'rules' => 'required|is_unique[job_types.name]'],
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

            $this->jobType->save($newData);
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => ADD_JOB_TYPE]);
    }

    public function update()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'name'          => ['label' => 'name', 'rules' => 'required|is_unique[job_types.name,id,{id}]'],
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

            $this->jobType->update($request['id'], $newData);
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => UPDATE_JOB_TYPE]);
    }

    public function delete()
    {
        $request = $this->request->getPost();
        $jobTypeData = $this->jobType->getResource($request, false, true);

        if ($jobTypeData) {
            $jobTypeID = $jobTypeData['id'];
            try {
                $this->db->transBegin();
                $this->jobType->delete($jobTypeID);
            } catch (\Exception $err) {
                $this->db->transRollback();
                return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
            }
            $this->db->transCommit();
            return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => DELETE_JOB_TYPE]);
        }
        return $this->respond(['status' => ERROR_ST, 'status_code' => 200, 'message' => JOB_TYPE_NOT_FOUND], '404');
    }
}
