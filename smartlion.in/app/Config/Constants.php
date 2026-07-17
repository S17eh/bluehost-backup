<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_LOW instead.
 */
define('EVENT_PRIORITY_LOW', 200);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_NORMAL instead.
 */
define('EVENT_PRIORITY_NORMAL', 100);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_HIGH instead.
 */
define('EVENT_PRIORITY_HIGH', 10);

// ================================== Custom Constants ================================== //

define('SUCCESS_ST', 1);
define('VALIDATION_ST', 0);
define('ERROR_ST', 0);

define('SOMETHING_WRONG', "Something wan't to wrong please try again!");
define('ACCESS_DENIED_MSG', "You do not have permission to access this data!");
define('INVALID_USER', 'User is invalid.');
// Authentication
define('INVALID_TOKEN_MSG', 'Token is invalid!');

// Auth
define('LOGOUT_SUCCESS', 'Logout has been successfully.');
define('TOKEN_NOT_FOUND', 'User token is not valid.');
define('REGISTER_SUCCESS', 'User has been registered successfully.');
define('EMAIL_SEND', 'Email sent on your registered email address.');

// Profile
define('CHANGE_PASSWORD_SUCCESS', 'Password has been changed successfully.');
define('CURRENT_PASSWORD_NOT_MATCH', 'Current password not match.');

// Role
global $roleStatus;
global $workMode;
global $salaryChart;

$roleStatus = [['label' => 'Active'], ['label' => 'Inactive']];
$workMode = ['Office', 'Home', 'Remote', 'Hybrid'];
$salaryChart = [['name' => '1 Thousand', 'amount' => 1000], ['name' => '5 Thousand', 'amount' => 5000], ['name' => '10 Thousand', 'amount' => 10000], ['name' => '50 Thousand', 'amount' => 50000], ['name' => '1 Lakhs', 'amount' => 100000], ['name' => '5 Lakhs', 'amount' => 500000], ['name' => '10 Lakhs', 'amount' => 1000000], ['name' => '15 Lakhs', 'amount' => 1500000], ['name' => '20 Lakhs', 'amount' => 2000000]];

global $sourceFrom, $noticePeriod, $degreeType, $maritalStatus;
$sourceFrom = ['Google', 'nokari.com', 'shine.com', 'LinkedIn', 'Indeed'];
$noticePeriod = ['Immediate', '15 Days', '1 Month', '2 Month', 'Other'];
$degreeType = ['HSC', 'SSC', 'Diploma', 'Doctoral/Ph.D', 'Graduate', 'Postgraduate', 'Undergraduate'];
$maritalStatus = ['single', 'married', 'widowed', 'divorced', 'separated'];

define('ADD_ROLE_LEVEL', 'Role level has been added successfully.');
define('UPDATE_ROLE_LEVEL', 'Role level has been updated successfully.');
define('DELETE_ROLE_LEVEL', 'Role level has been deleted successfully.');
define('ROLE_LEVEL_NOT_FOUND', 'Role level not found please try again.');

define('ADD_ROLE', 'Role has been added successfully.');
define('UPDATE_ROLE', 'Role has been updated successfully.');
define('DELETE_ROLE', 'Role has been deleted successfully.');
define('ROLE_NOT_FOUND', 'Role not found please try again.');

// Permission Group
define('ADD_PERMISSION_GROUP', 'Permission group has been added successfully.');
define('UPDATE_PERMISSION_GROUP', 'Permission group has been updated successfully.');
define('DELETE_PERMISSION_GROUP', 'Permission group has been deleted successfully.');
define('PERMISSION_GROUP_NOT_FOUND', 'Permission group not found please try again.');

// Restriction
define('ADD_RESTRICTION', 'Restriction has been added successfully.');
define('UPDATE_RESTRICTION', 'Restriction has been updated successfully.');
define('DELETE_RESTRICTION', 'Restriction has been deleted successfully.');
define('RESTRICTION_NOT_FOUND', 'Restriction not found please try again');

// User
define('ADD_USER', 'User has been added successfully.');
define('UPDATE_USER', 'User has been updated successfully.');
define('DELETE_USER', 'User has been deleted successfully.');
define('USER_NOT_FOUND', 'User not found please try again.');
define('USER_PROFILE_UPDATE', 'User profile has been  updated successfully.');
define('DELETE_USER_DOC', 'User document has been deleted successfully.');
define('USER_DOC_NOT_FOUND', 'User document not found please try again.');
define('ADD_USER_DOC', 'User document has been added successfully.');

// Status Master
define('ADD_STATUS', 'Status has been added successfully.');
define('UPDATE_STATUS', 'Status has been updated successfully.');
define('DELETE_STATUS', 'Status has been deleted successfully.');
define('STATUS_NOT_FOUND', 'Status not found please try again');

// Employer
define('ADD_EMPLOYER', 'Employer has been added successfully.');
define('UPDATE_EMPLOYER', 'Employer has been updated successfully.');
define('DELETE_EMPLOYER', 'Employer has been deleted successfully.');
define('EMPLOYER_NOT_FOUND', 'Employer not found please try again');
define('ADD_EMPLOYER_USER', 'Employer user has been added successfully.');
define('DELETE_EMPLOYER_DOC', 'Employer document has been deleted successfully.');
define('EMPLOYER_DOC_NOT_FOUND', 'Employer document not found please try again');

// Jobs
define('ADD_JOB', 'Job has been added successfully.');
define('UPDATE_JOB', 'Job has been updated successfully.');
define('DELETE_JOB', 'Job has been deleted successfully.');
define('JOB_NOT_FOUND', 'Job not found please try again.');

define('UPDATE_JOB_CANDIDATE', 'Job candidate has been updated successfully.');

// Candidate
define('ADD_CANDIDATE', 'Candidate has been added successfully.');
define('UPDATE_CANDIDATE', 'Candidate has been updated successfully.');
define('DELETE_CANDIDATE', 'Candidate has been deleted successfully.');
define('CANDIDATE_NOT_FOUND', 'Candidate not found please try again.');

// Location
define('ADD_CITY', 'City has been added successfully.');
define('UPDATE_CITY', 'City has been updated successfully.');
define('DELETE_CITY', 'City has been deleted successfully.');
define('CITY_NOT_FOUND', 'City not found please try again.');

// Industry
define('ADD_INDUSTRY', 'Industry has been added successfully.');
define('UPDATE_INDUSTRY', 'Industry has been updated successfully.');
define('DELETE_INDUSTRY', 'Industry has been deleted successfully.');
define('INDUSTRY_NOT_FOUND', 'Industry not found please try again.');


// Industry
define('ADD_EDUCATION', 'Eduction has been added successfully.');
define('UPDATE_EDUCATION', 'Eduction has been updated successfully.');
define('DELETE_EDUCATION', 'Eduction has been deleted successfully.');
define('EDUCATION_NOT_FOUND', 'Eduction not found please try again.');

// JobTitle
define('ADD_JOB_TITLE', 'Job title has been added successfully.');
define('UPDATE_JOB_TITLE', 'Job title has been updated successfully.');
define('DELETE_JOB_TITLE', 'Job title has been deleted successfully.');
define('JOB_TITLE_NOT_FOUND', 'Job title not found please try again.');

// JobType
define('ADD_JOB_TYPE', 'Job type has been added successfully.');
define('UPDATE_JOB_TYPE', 'Job type has been updated successfully.');
define('DELETE_JOB_TYPE', 'Job type has been deleted successfully.');
define('JOB_TYPE_NOT_FOUND', 'Job type not found please try again.');

// KeySkill
define('ADD_KEY_SKILL', 'Key skill has been added successfully.');
define('UPDATE_KEY_SKILL', 'Key skill has been updated successfully.');
define('DELETE_KEY_SKILL', 'Key skill has been deleted successfully.');
define('KEY_SKILL_NOT_FOUND', 'Key skill not found please try again.');

// Institute
define('ADD_INSTITUTE', 'Institute has been added successfully.');
define('UPDATE_INSTITUTE', 'Institute has been updated successfully.');
define('DELETE_INSTITUTE', 'Institute has been deleted successfully.');
define('INSTITUTE_NOT_FOUND', 'Institute not found please try again.');


// Functional Area
define('ADD_FUNCTIONAL_AREA', 'Functional area has been added successfully.');
define('UPDATE_FUNCTIONAL_AREA', 'Functional area has been updated successfully.');
define('DELETE_FUNCTIONAL_AREA', 'Functional area has been deleted successfully.');
define('FUNCTIONAL_AREA_NOT_FOUND', 'Functional area not found please try again.');


// Shift Timing
define('ADD_SHIFT_TIMING', 'Shift timing has been added successfully.');
define('UPDATE_SHIFT_TIMING', 'Shift timing has been updated successfully.');
define('DELETE_SHIFT_TIMING', 'Shift timing has been deleted successfully.');
define('SHIFT_TIMING_NOT_FOUND', 'Shift timing not found please try again.');
