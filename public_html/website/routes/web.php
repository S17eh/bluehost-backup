<?php

use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\CMSController;
use App\Http\Controllers\Backend\CorporateSolutionController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\RecruitmentController;
use App\Http\Controllers\Backend\ServiceController;
use App\Http\Controllers\Backend\TeamController;
use App\Http\Controllers\Backend\TestimonialController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// dd(Request::segment(1));

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::get('/', function () {
    return view('index');
})->name('frontend');

Route::prefix('admin')->group(function () {

    // auth
    Route::match(['get', 'post'], 'login', [AuthController::class, 'login'])->name('login');
    Route::get('logout', [AuthController::class, 'Logout'])->name('logout');

    Route::group(['middleware' => 'credential'], function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('profile', [DashboardController::class, 'profile'])->name('profile');
        Route::post('profile/update', [DashboardController::class, 'profileUpdate'])->name('profile-update');

        Route::prefix('home')->group(function () {
            Route::get('/', [CMSController::class, 'home'])->name('home');
            Route::get('edit', [CMSController::class, 'homeEdit'])->name('home-edit');
            Route::post('save', [CMSController::class, 'homeSave'])->name('home-save');
        });
        Route::prefix('current-opening')->group(function () {
            Route::get('/', [CMSController::class, 'currentOpening'])->name('current-opening');
            Route::post('save', [CMSController::class, 'currentOpeningSave'])->name('current-opening-save');
            Route::get('edit/{id}', [CMSController::class, 'currentOpeningEdit'])->name('current-opening-edit');
            Route::post('update/{id}', [CMSController::class, 'currentOpeningUpdate'])->name('current-opening-update');
            Route::get('delete/{id}', [CMSController::class, 'currentOpeningDelete'])->name('current-opening-delete');
        });

        Route::prefix('about-us')->group(function () {
            Route::get('/', [CMSController::class, 'aboutUs'])->name('about-us');
            Route::get('edit', [CMSController::class, 'aboutUsEdit'])->name('about-us-edit');
            Route::post('save', [CMSController::class, 'aboutUsSave'])->name('about-us-save');
        });

        Route::prefix('team')->group(function () {
            Route::get('/', [TeamController::class, 'index'])->name('team');
            Route::post('save', [TeamController::class, 'save'])->name('team-save');
            Route::get('edit/{id}', [TeamController::class, 'edit'])->name('team-edit');
            Route::post('update/{id}', [TeamController::class, 'update'])->name('team-update');
            Route::get('delete/{id}', [TeamController::class, 'delete'])->name('team-delete');
        });

        Route::prefix('testimonial')->group(function () {
            Route::get('/', [TestimonialController::class, 'index'])->name('testimonial');
            Route::post('save', [TestimonialController::class, 'save'])->name('testimonial-save');
            Route::get('edit/{id}', [TestimonialController::class, 'edit'])->name('testimonial-edit');
            Route::post('update/{id}', [TestimonialController::class, 'update'])->name('testimonial-update');
            Route::get('delete/{id}', [TestimonialController::class, 'delete'])->name('testimonial-delete');
        });
        Route::prefix('services')->group(function () {
            Route::get('/', [ServiceController::class, 'index'])->name('services');
            Route::get('edit', [ServiceController::class, 'edit'])->name('services-edit');
            Route::post('update', [ServiceController::class, 'update'])->name('services-update');

            Route::get('corporate-solution', [CorporateSolutionController::class, 'index'])->name('corporate-solution');
            Route::get('corporate-solution/edit/{id}', [CorporateSolutionController::class, 'edit'])->name('corporate-solution-edit');
            Route::post('corporate-solution/update/{id}', [CorporateSolutionController::class, 'update'])->name('corporate-solution-update');

            Route::get('recruitment', [RecruitmentController::class, 'index'])->name('recruitmentIndex');
            Route::post('recruitment/save', [RecruitmentController::class, 'save'])->name('recruitment-save');
            Route::get('recruitment/edit/{id}', [RecruitmentController::class, 'edit'])->name('recruitment-edit');
            Route::post('recruitment/update/{id}', [RecruitmentController::class, 'update'])->name('recruitment-update');
            Route::get('recruitment/delete/{id}', [RecruitmentController::class, 'delete'])->name('recruitment-delete');
        });
    });
});

if (Request::segment(1) !== "admin") {
    Route::get('/{any}', function () {
        return view('index');
    })->where('any', '.*');
} else {
    Route::prefix('admin')->group(function () {
        // auth
        Route::match(['get', 'post'], 'login', [AuthController::class, 'login'])->name('login');
        Route::get('logout', [AuthController::class, 'Logout'])->name('logout');

        Route::group(['middleware' => 'credential'], function () {
            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('profile', [DashboardController::class, 'profile'])->name('profile');
            Route::post('profile/update', [DashboardController::class, 'profileUpdate'])->name('profile-update');

            Route::prefix('home')->group(function () {
                Route::get('/', [CMSController::class, 'home'])->name('home');
                Route::get('edit', [CMSController::class, 'homeEdit'])->name('home-edit');
                Route::post('save', [CMSController::class, 'homeSave'])->name('home-save');

                Route::get('edit-image-section', [CMSController::class, 'homeImageEdit'])->name('home-image-section-edit');
                Route::post('save-image-section', [CMSController::class, 'homeImageSave'])->name('home-image-section-save');
            });
            Route::prefix('current-opening')->group(function () {
                Route::get('/', [CMSController::class, 'currentOpening'])->name('current-opening');
                Route::post('save', [CMSController::class, 'currentOpeningSave'])->name('current-opening-save');
                Route::get('edit/{id}', [CMSController::class, 'currentOpeningEdit'])->name('current-opening-edit');
                Route::post('update/{id}', [CMSController::class, 'currentOpeningUpdate'])->name('current-opening-update');
                Route::get('delete/{id}', [CMSController::class, 'currentOpeningDelete'])->name('current-opening-delete');
            });

            Route::prefix('about-us')->group(function () {
                Route::get('/', [CMSController::class, 'aboutUs'])->name('about-us');
                Route::get('edit', [CMSController::class, 'aboutUsEdit'])->name('about-us-edit');
                Route::post('save', [CMSController::class, 'aboutUsSave'])->name('about-us-save');
            });

            Route::prefix('contact-us')->group(function () {
                Route::get('/', [CMSController::class, 'contactUs'])->name('contact-us');
                Route::get('edit', [CMSController::class, 'contactUsEdit'])->name('contact-us-edit');
                Route::post('save', [CMSController::class, 'contactUsSave'])->name('contact-us-save');
            });

            Route::prefix('team')->group(function () {
                Route::get('/', [TeamController::class, 'index'])->name('team');
                Route::post('save', [TeamController::class, 'save'])->name('team-save');
                Route::get('edit/{id}', [TeamController::class, 'edit'])->name('team-edit');
                Route::post('update/{id}', [TeamController::class, 'update'])->name('team-update');
                Route::get('delete/{id}', [TeamController::class, 'delete'])->name('team-delete');
            });

            Route::prefix('testimonial')->group(function () {
                Route::get('/', [TestimonialController::class, 'index'])->name('testimonial');
                Route::post('save', [TestimonialController::class, 'save'])->name('testimonial-save');
                Route::get('edit/{id}', [TestimonialController::class, 'edit'])->name('testimonial-edit');
                Route::post('update/{id}', [TestimonialController::class, 'update'])->name('testimonial-update');
                Route::get('delete/{id}', [TestimonialController::class, 'delete'])->name('testimonial-delete');
            });
            Route::prefix('services')->group(function () {
                Route::get('/', [ServiceController::class, 'index'])->name('services');
                Route::get('edit', [ServiceController::class, 'edit'])->name('services-edit');
                Route::post('update', [ServiceController::class, 'update'])->name('services-update');

                Route::get('recruitment', [RecruitmentController::class, 'index'])->name('recruitmentIndex');
                Route::post('recruitment/save', [RecruitmentController::class, 'save'])->name('recruitment-save');
                Route::get('recruitment/edit/{id}', [RecruitmentController::class, 'edit'])->name('recruitment-edit');
                Route::post('recruitment/update/{id}', [RecruitmentController::class, 'update'])->name('recruitment-update');
                Route::get('recruitment/delete/{id}', [RecruitmentController::class, 'delete'])->name('recruitment-delete');
            });
        });
    });
}
