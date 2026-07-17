<?php

/**************************************
 * Get first error message from array *
 **************************************/

use App\Models\AppToken;
use CodeIgniter\I18n\Time;

if (!function_exists('GET_VALIDATION_MSG')) {

    /**
     * @param array $errors
     * @return string
     */
    function GET_VALIDATION_MSG(array $errors)
    {
        $error = '';
        foreach ($errors as $val) {
            $error = $val;
            break;
        }
        return $error;
    }
}

/*******************************************
 * For check url (path file) is exist or not 
 *******************************************/
function UR_exists($url)
{
    $headers = get_headers($url);
    return stripos($headers[0], "200 OK") ? true : false;
}



/**************************************
 *        Get Client IP Address       *
 **************************************/
if (!function_exists("getClientIpAddress")) {

    function getClientIpAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //Checking IP From Shared Internet
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //To Check IP is Pass From Proxy
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }
}

/*****************************************
 *    Return Response in Json Formate    *
 *****************************************/
if (!function_exists('json_response')) {
    function json_response($message = null, $code = 200)
    {
        header_remove();
        http_response_code($code);
        header('Content-Type: application/json');
        $status = array(
            200 => '200 OK',
            400 => '400 Bad Request',
            401 => '401 unauthorized',
            404 => '404 Not Found',
            422 => 'Unprocessable Entity',
            500 => '500 Internal Server Error'
        );
        header('Status: ' . $status[$code]);
        exit(json_encode($message));
    }
}

/**************************************
 *          Check User Token          *
 **************************************/
if (!function_exists("getToken")) {

    function getToken()
    {
        $headerData =  getallheaders();
        if (isset($headerData['Authorization'])) {
            $app_token = $headerData['Authorization'];
        } elseif (isset($headerData['authorization'])) {
            $app_token = $headerData['authorization'];
        } else {
            $app_token = '';
        }

        return $app_token;
    }
}

/**************************************
 *          Check User Token          *
 **************************************/
if (!function_exists("checkToken")) {

    function checkToken()
    {
        $headerData =  getallheaders();
        if (isset($headerData['Authorization'])) {
            $app_token = $headerData['Authorization'];
        } elseif (isset($headerData['authorization'])) {
            $app_token = $headerData['authorization'];
        } else {
            json_response([
                'status' => 0,
                'status_code' => 401,
                'message' => 'Token is missing.'
            ], 401);
        }

        $appToken = new AppToken();
        if ($appToken->where('token', $app_token)->first()) {
            return true;
        } else {
            json_response([
                'status' => 0,
                'status_code' => 401,
                'message' => 'Invalid Token.'
            ], 401);
        }
    }
}

/*****************************************
 *            GET Token User            *
 *****************************************/
if (!function_exists('getTokenUserID')) {
    function getTokenUserID()
    {
        return model(AppToken::class)->__getTokenUserID();
    }
}

/*****************************************
 *    Amount format function             *
 *****************************************/
if (!function_exists('format_amount')) {
    function format_amount($amount = 0, $currency = "INR", $locale = "en_IN", $fraction = 2)
    {
        $convertedAmount = number_to_currency($amount, $currency, $locale, $fraction);
        return $convertedAmount;
    }
}
