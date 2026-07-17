<?php

namespace App\Controllers\Api\v1;

use App\Controllers\BaseController;
use App\Models\FunctionalArea;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use Exception;

class FunctionalAreaController extends BaseController
{
    use ResponseTrait;
    protected $functionalArea;

    public function __construct()
    {
        $this->functionalArea = new FunctionalArea();
    }

    public function index()
    {
        $request = $this->request->getGet();
        $response = $this->functionalArea->getResource($request);
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    public function create()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'name'          => ['label' => 'name', 'rules' => 'required|is_unique[functional_areas.name]'],
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

            $this->functionalArea->save($newData);
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => ADD_FUNCTIONAL_AREA]);
    }

    public function update()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'name'          => ['label' => 'name', 'rules' => 'required|is_unique[functional_areas.name,id,{id}]'],
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

            $this->functionalArea->update($request['id'], $newData);
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => UPDATE_FUNCTIONAL_AREA]);
    }

    public function delete()
    {
        $request = $this->request->getPost();
        $functionalAreaData = $this->functionalArea->getResource($request, false, true);

        if ($functionalAreaData) {
            $functionalAreaID = $functionalAreaData['id'];
            try {
                $this->db->transBegin();
                $this->functionalArea->delete($functionalAreaID);
            } catch (\Exception $err) {
                $this->db->transRollback();
                return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
            }
            $this->db->transCommit();
            return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => DELETE_FUNCTIONAL_AREA]);
        }
        return $this->respond(['status' => ERROR_ST, 'status_code' => 200, 'message' => FUNCTIONAL_AREA_NOT_FOUND], '404');
    }

    public function createFromJob()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'name'          => ['label' => 'name', 'rules' => 'required|is_unique[functional_areas.name]']
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

            $this->functionalArea->save($newData);
            $functionalAreaID = $this->functionalArea->getInsertID();
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        $funcData = (object) $this->functionalArea->select('id,name')->find($functionalAreaID);
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $funcData]);
    }
}
