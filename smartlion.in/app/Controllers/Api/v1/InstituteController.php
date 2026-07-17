<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use App\Models\Institute;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use Exception;

class InstituteController extends BaseController
{
    use ResponseTrait;
    protected $Institute;

    public function __construct()
    {
        $this->Institute = new Institute();
    }

    public function index()
    {
        $request = $this->request->getGet();
        $response = $this->Institute->getResource($request);
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    public function create()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'name'          => ['label' => 'name', 'rules' => 'required|is_unique[institutes.name]']
        ];

        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $newData = [
                'name'      => $request['name'],
                'created_at'    => Time::now()
            ];

            $this->Institute->save($newData);
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => ADD_INSTITUTE]);
    }

    public function update()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'name'          => ['label' => 'name', 'rules' => 'required|is_unique[institutes.name,id,{id}]']
        ];

        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $newData = [
                'name'      => $request['name'],
                'updated_at'    => Time::now()
            ];

            $this->Institute->update($request['id'], $newData);
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => UPDATE_INSTITUTE]);
    }

    public function delete()
    {
        $request = $this->request->getPost();
        $InstituteData = $this->Institute->getResource($request, false, true);

        if ($InstituteData) {
            $InstituteID = $InstituteData['id'];
            try {
                $this->db->transBegin();
                $this->Institute->delete($InstituteID);
            } catch (\Exception $err) {
                $this->db->transRollback();
                return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
            }
            $this->db->transCommit();
            return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => DELETE_INSTITUTE]);
        }
        return $this->respond(['status' => ERROR_ST, 'status_code' => 200, 'message' => INSTITUTE_NOT_FOUND], '404');
    }

    public function createInstituteFromCandidate()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'name'          => ['label' => 'name', 'rules' => 'required|is_unique[institutes.name]']
        ];

        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $newData = [
                'name'      => $request['name'],
                'created_at'    => Time::now()
            ];

            $this->Institute->save($newData);
            $InstituteID = $this->Institute->getInsertID();
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        $keyData = (object) $this->Institute->select('id,name')->find($InstituteID);
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $keyData]);
    }
}
