<?php

namespace App\Controllers\Api\v1;

use App\Controllers\BaseController;
use App\Models\JobTitle;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use Exception;

class JobTitleController extends BaseController
{
    use ResponseTrait;
    protected $jobTitle;

    public function __construct()
    {
        $this->jobTitle = new JobTitle();
    }

    public function index()
    {
        $request = $this->request->getGet();
        $response = $this->jobTitle->getResource($request);
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    public function create()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'name'          => ['label' => 'name', 'rules' => 'required|is_unique[job_titles.name]'],
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

            $this->jobTitle->save($newData);
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => ADD_JOB_TITLE]);
    }

    public function update()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'name'          => ['label' => 'name', 'rules' => 'required|is_unique[job_titles.name,id,{id}]'],
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

            $this->jobTitle->update($request['id'], $newData);
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => UPDATE_JOB_TITLE]);
    }

    public function delete()
    {
        $request = $this->request->getPost();
        $jobTitleData = $this->jobTitle->getResource($request, false, true);

        if ($jobTitleData) {
            $jobTitleID = $jobTitleData['id'];
            try {
                $this->db->transBegin();
                $this->jobTitle->delete($jobTitleID);
            } catch (\Exception $err) {
                $this->db->transRollback();
                return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
            }
            $this->db->transCommit();
            return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => DELETE_JOB_TITLE]);
        }
        return $this->respond(['status' => ERROR_ST, 'status_code' => 200, 'message' => JOB_TITLE_NOT_FOUND], '404');
    }


    public function addTitleFromJob()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'name'          => ['label' => 'name', 'rules' => 'required|is_unique[job_titles.name]']
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

            $this->jobTitle->save($newData);
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        $jobData = $this->jobTitle->select('id,name')->where('status', 'Active')->get()->getResultArray();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $jobData]);
    }
}
