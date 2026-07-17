<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use App\Entities\Collection;
use App\Models\Notification;
use CodeIgniter\API\ResponseTrait;

class NotificationController extends BaseController
{
    use ResponseTrait;
    protected $notification;

    public function __construct()
    {
        $this->notification = new Notification();
    }

    public function index()
    {
        $request = $this->request->getGet();
        $data = $this->notification->resource($request)->get()->getResultArray();

        $response = Collection::tableData(
            $data,
            $this->notification->resource($request, false)->countAllResults()
        );
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }
}
