<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use App\Models\Industry;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use Exception;

class IndustryController extends BaseController
{
    use ResponseTrait;
    protected $industry;

    public function __construct()
    {
        $this->industry = new Industry();
    }

    public function index()
    {
        $request = $this->request->getGet();
        $response = $this->industry->getResource($request);
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    public function create()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'name'          => ['label' => 'name', 'rules' => 'required|is_unique[industry.name]'],
            'description'   => ['label' => 'description', 'rules' => 'required'],
            'status'        => ['label' => 'status', 'rules' => 'required']
        ];

        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $newData = [
                'name'      => $request['name'],
                'description'      => $request['description'],
                'status'      => $request['status'],
                'created_at'    => Time::now()
            ];

            $this->industry->save($newData);
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => ADD_INDUSTRY]);
    }

    public function update()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'name'          => ['label' => 'name', 'rules' => 'required|is_unique[industry.name,id,{id}]'],
            'description'   => ['label' => 'description', 'rules' => 'required'],
            'status'        => ['label' => 'status', 'rules' => 'required']
        ];

        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $newData = [
                'name'      => $request['name'],
                'description'      => $request['description'],
                'status'      => $request['status'],
                'updated_at'    => Time::now()
            ];

            $this->industry->update($request['id'], $newData);
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => UPDATE_INDUSTRY]);
    }

    public function delete()
    {
        $request = $this->request->getPost();
        $industry = $this->industry->getResource($request, false, true);

        if ($industry) {
            $industryID = $industry['id'];
            try {
                $this->db->transBegin();
                $this->industry->delete($industryID);
            } catch (\Exception $err) {
                $this->db->transRollback();
                return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
            }
            $this->db->transCommit();
            return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => DELETE_INDUSTRY]);
        }
        return $this->respond(['status' => ERROR_ST, 'status_code' => 200, 'message' => INDUSTRY_NOT_FOUND], '404');
    }
}
