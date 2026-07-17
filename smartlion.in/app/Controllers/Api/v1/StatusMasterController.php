<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use App\Models\StatusMaster;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use Exception;

class StatusMasterController extends BaseController
{

    use ResponseTrait;
    protected $statusMaster;

    public function __construct()
    {
        $this->statusMaster = new StatusMaster();
    }

    public function index()
    {
        $request = $this->request->getGet();
        $response = $this->statusMaster->getResource($request);
        $isDefault =  $this->statusMaster->where('is_default', 'Yes')->countAllResults() > 0 ? true : false;
        foreach ($response['data'] as $key => $value) :
            $response['data'][$key]['has_default'] = $isDefault;
        endforeach;
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    public function create()
    {
        $request = $this->request->getPost();
        $this->db->transBegin();
        try {
            $newData = [
                'name'          => $request['name'],
                'is_default'    => $request['is_default'],
                'status'        => $request['status'],
                'created_at'    => Time::now()
            ];
            $this->statusMaster->save($newData);
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => ADD_STATUS]);
    }

    public function update()
    {
        $request = $this->request->getPost();
        $this->db->transBegin();
        try {
            $newData = [
                'name'          => $request['name'],
                'is_default'    => $request['is_default'],
                'status'        => $request['status'],
                'updated_at'    => Time::now()
            ];
            $this->statusMaster->update($request['id'], $newData);
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG . $ex->getMessage()], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => UPDATE_STATUS]);
    }

    public function delete()
    {
        $request = $this->request->getPost();
        $status = $this->statusMaster->getResource($request, false, true);

        if ($status) {
            $statusID = $status['id'];
            try {
                $this->db->transBegin();
                $this->statusMaster->delete($statusID);
            } catch (\Exception $err) {
                $this->db->transRollback();
                return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
            }
            $this->db->transCommit();
            return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => DELETE_STATUS]);
        }
        return $this->respond(['status' => ERROR_ST, 'status_code' => 200, 'message' => STATUS_NOT_FOUND], '404');
    }
}
