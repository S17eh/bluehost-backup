<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/home123', 'Home::index');

$routes->group('api', function ($routes) {
    $routes->group('v1', ['filter' => 'auth', 'namespace' => 'App\Controllers\Api\v1'], function ($routes) {

        $routes->group('auth', ['namespace' => 'App\Controllers\Api\v1\Authentication'], function ($routes) {
            $routes->get('/', 'AuthController::index');
            $routes->post('login', 'AuthController::checkLogin');
            $routes->post('register', 'AuthController::register');
            $routes->post('forgot-password', 'AuthController::forgotPassword');
            $routes->post('reset-password', 'AuthController::resetPassword');
            $routes->post('logout', 'AuthController::logout', ['filter' => 'auth']);
        });

        $routes->group('authentication', ['filter' => 'auth', 'namespace' => 'App\Controllers\Api\v1\Authentication'], function ($routes) {
            $routes->get('role-list', 'RoleController::index');
            $routes->post('role-create', 'RoleController::create');
            $routes->post('role-update', 'RoleController::update');
            $routes->post('role-delete', 'RoleController::delete');

            $routes->group('role-level', function ($routes) {
                $routes->get('list', 'RoleLevelController::index');
                $routes->post('create', 'RoleLevelController::create');
                $routes->post('update', 'RoleLevelController::update');
                $routes->post('delete', 'RoleLevelController::delete');
            });

            $routes->group('permission', function ($routes) {
                $routes->get('list', 'PermissionController::index');
                $routes->get('group-list', 'PermissionController::groupList');
                $routes->post('group-create', 'PermissionController::groupCreate');
                $routes->post('group-update', 'PermissionController::groupUpdate');
                $routes->post('group-delete', 'PermissionController::groupDelete');
            });

            // Restriction
            $routes->group('restriction', function ($routes) {
                $routes->get('list', 'RestrictionController::index');
                $routes->post('create', 'RestrictionController::create');
                $routes->post('update', 'RestrictionController::update');
                $routes->post('delete', 'RestrictionController::delete');
            });
        });


        $routes->group('dashboard', function ($routes) {
            $routes->post('/', 'DashboardController::index');
            $routes->get('monthly-revenue-list', 'DashboardController::monthlyRevenueList');
        });

        $routes->group('report', function ($routes) {
            $routes->post('organization-chart', 'ReportController::OrganizationChart');
        });

        // Status Master
        $routes->group('status-master', function ($routes) {
            $routes->get('list', 'StatusMasterController::index');
            $routes->post('create', 'StatusMasterController::create');
            $routes->post('update', 'StatusMasterController::update');
            $routes->post('delete', 'StatusMasterController::delete');
        });

        // Location
        $routes->group('location', function ($routes) {
            $routes->get('country-list', 'LocationController::countryList');
            $routes->get('state-list', 'LocationController::stateList');
            $routes->get('city-list', 'LocationController::cityList');
            $routes->post('add-edit-city', 'LocationController::addEditCity');
            $routes->post('create-city', 'LocationController::createCity');
            $routes->post('update-city', 'LocationController::updateCity');
            $routes->post('delete-city', 'LocationController::deleteCity');
            $routes->post('change-status', 'LocationController::changeStatus');
            $routes->post('get-state', 'LocationController::getStateByID');
            $routes->post('get-city', 'LocationController::getCityByID');
        });

        // Employer
        $routes->group('employer', function ($routes) {
            $routes->get('list', 'EmployerController::index');
            $routes->post('create', 'EmployerController::create');
            $routes->post('update', 'EmployerController::update');
            $routes->post('delete', 'EmployerController::delete');
            $routes->post('add-user', 'EmployerController::addUser');
            $routes->get('document-list', 'EmployerController::documentList');
            $routes->post('download-document', 'EmployerController::downloadDocument');
            $routes->post('delete-document', 'EmployerController::deleteDocument');
        });

        // Job
        $routes->group('job', function ($routes) {
            $routes->get('list', 'JobController::index');
            $routes->post('view', 'JobController::view');
            $routes->post('create', 'JobController::create');
            $routes->post('update', 'JobController::update');
            $routes->post('delete', 'JobController::delete');
            $routes->post('update-assign', 'JobController::updateAssign');
            $routes->get('job-candidates-list', 'JobController::jobCandidateList');
            $routes->get('job-candidates', 'JobController::allJobCandidates');
            $routes->post('add-remove-job-candidates', 'JobController::addRemoveJobCandidate');
            $routes->post('update-job-candidates', 'JobController::updateJobCandidate');
        });

        # Candidate
        $routes->group('candidate', function ($routes) {
            $routes->get('list', 'CandidateController::index');
            $routes->get('add', 'CandidateController::add');
            $routes->get('edit', 'CandidateController::edit');
            $routes->post('create', 'CandidateController::create');
            $routes->post('update', 'CandidateController::update');
            $routes->post('delete', 'CandidateController::delete');
            $routes->get('course-list', 'CandidateController::courseList');
        });

        // User
        $routes->group('user', function ($routes) {
            $routes->get('list', 'UserController::index');
            $routes->post('view', 'UserController::view');
            $routes->post('create', 'UserController::create');
            $routes->post('update', 'UserController::update');
            $routes->post('profile', 'UserController::updateProfile');
            $routes->post('delete', 'UserController::delete');

            $routes->get('document-list', 'UserController::documentList');
            $routes->post('upload-document', 'UserController::uploadDocument');
            $routes->post('delete-document', 'UserController::deleteDocument');

            $routes->get('role-users', 'UserController::roleUsers');

            // Export User
            $routes->post('export', 'UserController::exportUser');
            $routes->post('import', 'UserController::importUser');
            $routes->post('save-import', 'UserController::saveImportUser');
        });

        // Industry
        $routes->group('industry', function ($routes) {
            $routes->get('list', 'IndustryController::index');
            $routes->post('create', 'IndustryController::create');
            $routes->post('update', 'IndustryController::update');
            $routes->post('delete', 'IndustryController::delete');
        });

        // Education
        $routes->group('education', function ($routes) {
            $routes->get('list', 'EducationController::index');
            $routes->post('create', 'EducationController::create');
            $routes->post('update', 'EducationController::update');
            $routes->post('delete', 'EducationController::delete');
        });

        // functional area
        $routes->group('functional-area', function ($routes) {
            $routes->get('list', 'FunctionalAreaController::index');
            $routes->post('create', 'FunctionalAreaController::create');
            $routes->post('update', 'FunctionalAreaController::update');
            $routes->post('delete', 'FunctionalAreaController::delete');
            $routes->post('add-from-job', 'FunctionalAreaController::createFromJob');
        });

        // Job Title
        $routes->group('job-title', function ($routes) {
            $routes->get('list', 'JobTitleController::index');
            $routes->post('create', 'JobTitleController::create');
            $routes->post('update', 'JobTitleController::update');
            $routes->post('delete', 'JobTitleController::delete');

            $routes->post('add-title-job', 'JobTitleController::addTitleFromJob');
        });

        // Job Type
        $routes->group('job-type', function ($routes) {
            $routes->get('list', 'JobTypeController::index');
            $routes->post('create', 'JobTypeController::create');
            $routes->post('update', 'JobTypeController::update');
            $routes->post('delete', 'JobTypeController::delete');
        });

        // Key Skill
        $routes->group('key-skill', function ($routes) {
            $routes->get('list', 'KeySkillController::index');
            $routes->post('create', 'KeySkillController::create');
            $routes->post('update', 'KeySkillController::update');
            $routes->post('delete', 'KeySkillController::delete');

            $routes->post('add-from-job', 'KeySkillController::createKeySkillFromJob');
        });

        // Institute
        $routes->group('institute', function ($routes) {
            $routes->get('list', 'InstituteController::index');
            $routes->post('create', 'InstituteController::create');
            $routes->post('update', 'InstituteController::update');
            $routes->post('delete', 'InstituteController::delete');

            $routes->post('add-from-candidate', 'InstituteController::createInstituteFromCandidate');
        });

        // Shift Timing
        $routes->group('shift-timing', function ($routes) {
            $routes->get('list', 'ShiftTimingController::index');
            $routes->post('create', 'ShiftTimingController::create');
            $routes->post('update', 'ShiftTimingController::update');
            $routes->post('delete', 'ShiftTimingController::delete');
        });

        // Profile
        $routes->group('profile', function ($routes) {
            $routes->post('change-password', 'UserController::changePassword');
        });

        $routes->group('notification', function ($routes) {
            $routes->get('list', 'NotificationController::index');
        });
    });
});

$routes->get('/(:any)', function () {
    return view('frontend');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
