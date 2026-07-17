<?php

use App\Http\Controllers\Api\MainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::controller(MainController::class)->group(function () {
    Route::get('home', 'home');
    Route::get('about-us', 'aboutUs');
    Route::get('current-opening', 'currentOpening');
    Route::get('services', 'services');
    Route::post('generate-pdf', 'generatePDF');
    Route::post('send-contact-email', 'sendCountUsEmail');
    Route::post('send-apply-job-email', 'sendApplyJobEmail');
    Route::get('contact-us', 'contactUs');
});
