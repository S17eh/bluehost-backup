<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use Exception;

class LocationController extends BaseController
{
    use ResponseTrait;
    protected $country;
    protected $state;
    protected $city;

    public function __construct()
    {
        $this->country = new Country();
        $this->state = new State();
        $this->city = new City();
    }

    public function countryList()
    {
        $request = $this->request->getGet();
        $response = $this->country->getResource($request);
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    public function stateList()
    {
        $request = $this->request->getGet();
        $response = $this->state->getResource($request);
        $response['countryList'] = $this->country->countryByStatus();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    public function cityList()
    {
        $request = $this->request->getGet();
        $response = $this->city->getResource($request);
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    public function addEditCity()
    {
        $request = $this->request->getPost();

        if ($request['type'] === 'edit' && isset($request['id'])) {
            $response = $this->city->getResource($request, false, true);
            $response['stateList'] = $this->state->getByCountry((int) $request['country_id']);
            $response['countryList'] = $this->country->countryByStatus();
            $response['countryList'] = $this->country->countryByStatus();
        } elseif ($request['type'] === 'state') {
            $response['stateList'] = $this->state->getByCountry((int) $request['country_id']);
        } else {
            $response['countryList'] = $this->country->countryByStatus();
        }
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }


    public function createCity()
    {
        $request = $this->request->getPost();
        $validationRules = [
            'name' => ['label' => 'name', 'rules' => 'required'],
            'state_id' => ['label' => 'state', 'rules' => 'required'],
        ];
        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $this->city->save([
                'name' => $request['name'],
                'state_id' => $request['state_id'],
                'status' => $request['status'],
                'created_at' => Time::now()
            ]);
        } catch (Exception $err) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => ADD_CITY]);
    }

    public function updateCity()
    {
        $request = $this->request->getPost();
        $validationRules = [
            'name' => ['label' => 'name', 'rules' => 'required'],
            'state_id' => ['label' => 'state', 'rules' => 'required'],
        ];
        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $this->city->update($request['id'], [
                'name' => $request['name'],
                'state_id' => $request['state_id'],
                'status' => $request['status'],
                'updated_at' => Time::now()
            ]);
        } catch (Exception $err) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => UPDATE_CITY]);
    }

    public function deleteCity()
    {
        $request = $this->request->getPost();
        $city = $this->city->getResource($request, false, true);

        if ($city) {
            $cityID = $city['id'];
            try {
                $this->db->transBegin();
                $this->city->delete($cityID);
            } catch (\Exception $err) {
                $this->db->transRollback();
                return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
            }
            $this->db->transCommit();
            return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => DELETE_CITY]);
        }
        return $this->respond(['status' => ERROR_ST, 'status_code' => 200, 'message' => CITY_NOT_FOUND], '404');
    }

    public function changeStatus()
    {
        $request = $this->request->getPost();
        $validationRules      = [
            'module'      => ['label' => 'module', 'rules' => 'required'],
            'status'    => ['label' => 'status', 'rules' => 'required']
        ];

        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $newData['status'] = $request['status'];
            $request['module'] === 'country' && $this->country->update($request['id'], $newData);
            $request['module'] === 'state' && $this->state->update($request['id'], $newData);
            $request['module'] === 'city' && $this->city->update($request['id'], $newData);
        } catch (Exception $ex) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => 'Status has been updated successfully.']);
    }
    public function getStateByID()
    {
        $request = $this->request->getPost();
        $state = $this->db->table('states')->where('country_id',$request['country_id'])->get()->getResultArray();

        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $state]);

    }
    public function getCityByID()
    {
        $request = $this->request->getPost();
        $city = $this->db->table('cities')->where('state_id',$request['state_id'])->get()->getResultArray();

        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $city]);

    }
}
