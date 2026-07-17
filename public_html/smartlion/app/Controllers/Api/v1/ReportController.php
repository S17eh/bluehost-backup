<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use App\Models\User;
use CodeIgniter\API\ResponseTrait;

class ReportController extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        //
    }

    public function OrganizationChart()
    {
        $userModel = new User();
        $loginUserID = getTokenUserID();

        $response = $userModel->OrganizationData($loginUserID);

        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }
}
