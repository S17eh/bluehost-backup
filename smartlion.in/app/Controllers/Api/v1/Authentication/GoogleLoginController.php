<?php

namespace App\Controllers\Api\V1\Authentication;

use App\Controllers\BaseController;
use App\Models\User;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use Exception;
use Google;

class GoogleLoginController extends BaseController
{
    use ResponseTrait;

    protected $user;
    protected $appToken;

    public function __construct()
    {
        $this->user = new User();
    }

    public function google_login(){
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => CHANGE_PASSWORD_SUCCESS]);
    }
}
