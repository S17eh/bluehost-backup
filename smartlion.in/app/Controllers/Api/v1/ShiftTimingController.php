<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use App\Models\ShiftTiming;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use Exception;

class ShiftTimingController extends BaseController
{
    use ResponseTrait;
    protected $shiftTiming;

    public function __construct()
    {
        $this->shiftTiming = new ShiftTiming();
    }

    public function index()
    {
        $request = $this->request->getGet();
        $response = $this->shiftTiming->getResource($request);
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    public function create()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'name'          => ['label' => 'name', 'rules' => 'required|is_unique[shift_timings.name]'],
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

            $this->shiftTiming->save($newData);
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => ADD_SHIFT_TIMING]);
    }

    public function update()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'name'          => ['label' => 'name', 'rules' => 'required|is_unique[shift_timings.name,id,{id}]'],
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

            $this->shiftTiming->update($request['id'], $newData);
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => UPDATE_SHIFT_TIMING]);
    }

    public function delete()
    {
        $request = $this->request->getPost();
        $shiftTimingData = $this->shiftTiming->getResource($request, false, true);

        if ($shiftTimingData) {
            $shiftTimingID = $shiftTimingData['id'];
            try {
                $this->db->transBegin();
                $this->shiftTiming->delete($shiftTimingID);
            } catch (\Exception $err) {
                $this->db->transRollback();
                return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
            }
            $this->db->transCommit();
            return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => DELETE_SHIFT_TIMING]);
        }
        return $this->respond(['status' => ERROR_ST, 'status_code' => 200, 'message' => SHIFT_TIMING_NOT_FOUND], '404');
    }
}
