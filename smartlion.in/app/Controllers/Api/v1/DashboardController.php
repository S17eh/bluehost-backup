<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use App\Entities\Collection;
use App\Models\Dashboard;
use App\Models\Employer;
use App\Models\User;
use CodeIgniter\API\ResponseTrait;

class DashboardController extends BaseController
{
    use ResponseTrait;
    protected $user;
    protected $dashboard;

    public function __construct()
    {
        $this->user = new User();
        $this->dashboard = new Dashboard();
    }

    public function index()
    {
        $loginUserID = getTokenUserID();
        $userDetails = $this->user->find($loginUserID);

        // if ($userDetails['user_type'] === 'SuperAdmin') {
            return $this->adminDashboard();
        // }
    }

    public function adminDashboard()
    {
        $data = $this->dashboard->forAdminInit();

        $response = $data;
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    public function monthlyRevenueList()
    {
        $companyModel = new Employer();
        $request = $this->request->getGet();

        $data = $companyModel->monthlyRevenue($request)->get()->getResultArray();
        // foreach ($data as $key => $value) :
        //     $data[$key]['amount'] = format_amount($value['amount']);
        // endforeach;
        $response = Collection::tableData(
            $data,
            $companyModel->monthlyRevenue($request, false)->countAllResults()
        );
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }
}
