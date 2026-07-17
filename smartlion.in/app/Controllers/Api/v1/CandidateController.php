<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use App\Models\Candidate;
use App\Models\CandidateEducation;
use App\Models\CandidateExperience;
use App\Models\City;
use App\Models\Country;
use App\Models\Education;
use App\Models\Institute;
use App\Models\State;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use Exception;

class CandidateController extends BaseController
{
    use ResponseTrait;
    protected $candidate;
    protected $candidateEducation;
    protected $candidateExperience;

    public function __construct()
    {
        $this->candidate = new Candidate();
        $this->candidateEducation = new CandidateEducation();
        $this->candidateExperience = new CandidateExperience();
    }

    # List candidate function
    public function index()
    {
        $request = $this->request->getGet();
        $response = $this->candidate->getResource($request);
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    public function add()
    {
        global $degreeType, $sourceFrom, $noticePeriod, $maritalStatus;
        $response['initData'] = [
            'sourceFromList'    => $sourceFrom,
            'noticePeriodList'  => $noticePeriod,
            'degreeTypeList'    => $degreeType,
            'maritalList'       => $maritalStatus,
            'key_skill'         => model(KeySkill::class)->select('id,name')->where('status', 'Active')->get()->getResultArray(),
            'instituteList'     => model(Institute::class)->select('id,name')->get()->getResultArray(),
            'countryList'       => model(Country::class)->countryByStatus(),
            'educationList'     => model(Education::class)->ByTypeEduction(),
            'stateList'         => [],
            'cityList'          => [],

        ];
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    # Create Candidate function
    public function create()
    {
        $request = $this->request->getPost();

        $validationRules = [
            'source_from'   => ['label' => 'source from', 'rules' => 'required'],
            'full_name'     => ['label' => 'full name', 'rules' => 'required'],
            'email'         => ['label' => 'email', 'rules' => 'required|valid_email|is_unique[candidates.email]'],
            // 'mobile_number' => ['label' => 'mobile number', 'rules' => 'required'],
        ];

        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        try {
            $this->db->transBegin();

            $fileName = null;
            $profile = $this->request->getFile('profile_picture');
            if ($profile && $profile->getName() != null) {
                $fileName = time() . '_' . $profile->getRandomName();
                $profile->move(FCPATH . '/candidate_profile/', $fileName);
            }

            $resumeFile = null;
            $resume = $this->request->getFile('upload_resume');
            if ($resume && $resume->getName() != null) {
                $resumeFile = time() . '_' . $resume->getRandomName();
                $resume->move(FCPATH . '/candidate_resume/', $resumeFile);
            }

            $newData = [
                'source_from'           => $request['source_from'],
                'full_name'             => $request['full_name'],
                'email'                 => $request['email'],
                'alternate_email'       => implode(',', $request['alternate_email']),
                'mobile_number'         => implode(',', $request['mobile_number']),
                'current_ctc_lakh'      => $request['current_ctc_lakh'],
                'current_ctc_thousand'  => $request['current_ctc_thousand'],
                'expected_ctc_lakh'     => $request['expected_ctc_lakh'],
                'expected_ctc_thousand' => $request['expected_ctc_thousand'],
                'experience'            => $request['experience'],
                'notice_period'         => $request['notice_period'],
                'current_skill'         => sizeof($request['current_skill']) > 0 ? implode(',', $request['current_skill']) : null,
                'profile_picture'       => $fileName,
                'resume'                => $resumeFile,
                'address'               => $request['address'],
                'country_id'            => $request['country_id'],
                'state_id'              => $request['state_id'],
                'city_id'               => $request['city_id'],
                'post_code'             => $request['post_code'],
                'gender'                => $request['gender'],
                'date_of_birth'         => $request['date_of_birth'],
                'marital_status'        => $request['marital_status'],
                'job_status'            => $request['job_status'],
                'status'                => $request['status'],
                'created_at'            => Time::now(),
            ];
            $this->candidate->insert($newData);
            // # Get inserted ID
            $candidateID = $this->candidate->getInsertID();

            $experienceData = [];
            if (isset($request['experiences'])) {
                foreach ($request['experiences'] as $value) {
                    $experienceData[] = [
                        'candidate_id' => $candidateID,
                        'company_name' => $value['company_name'],
                        'designation' => $value['designation'],
                        'start_date' => $value['start_date'],
                        'end_date' => $value['end_date'] === '' ? null : $value['end_date'],
                        'is_default_company' => $value['is_default_company'],
                        'created_at' => Time::now()
                    ];
                };
                # Insert Batch of Candidate Experience Data
                $this->candidateExperience->insertBatch($experienceData);
            }

            $educationData = [];
            foreach ($request['educations'] as $key => $value) :
                $educationData[] = [
                    'candidate_id' => $candidateID,
                    'type' => $value['type'],
                    'course_id' => $value['course_id'],
                    'specification' => $value['specification'],
                    'institute_name' => $value['institute_name'],
                    'start_date' => $value['start_date'],
                    'end_date' => $value['is_student'] === 'Yes' ? null : $value['end_date'],
                    'is_student' => $value['is_student'],
                    'created_at' => Time::now()
                ];
            endforeach;
            # Insert Batch of Candidate Education
            $this->candidateEducation->insertBatch($educationData);
        } catch (Exception $err) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG . $err], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => ADD_CANDIDATE]);
    }

    public function edit()
    {
        global $degreeType, $sourceFrom, $noticePeriod, $maritalStatus;
        $request = $this->request->getGet();
        $candidateID = $request['id'];
        $candidateData = $this->candidate->getCandidateAllData($candidateID);
        $response['candidateData'] = $candidateData;
        $response['initData'] = [
            'sourceFromList'    => $sourceFrom,
            'noticePeriodList'  => $noticePeriod,
            'degreeTypeList'    => $degreeType,
            'maritalList'       => $maritalStatus,
            'key_skill'         => model(KeySkill::class)->select('id,name')->where('status', 'Active')->get()->getResultArray(),
            'instituteList'     => model(Institute::class)->select('id,name')->get()->getResultArray(),
            'countryList'       => model(Country::class)->countryByStatus(),
            'educationList'     => model(Education::class)->ByTypeEduction(),
            'stateList'         => model(State::class)->getByCountry((int) $candidateData['country_id']),
            'cityList'          => model(City::class)->ByState((int) $candidateData['state_id']),
        ];
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    # Update candidate function
    public function update()
    {
        $request = $this->request->getPost();
        $validationRules = [
            'source_from'   => ['label' => 'source from', 'rules' => 'required'],
            'full_name'     => ['label' => 'full name', 'rules' => 'required'],
            'email'         => ['label' => 'email', 'rules' => 'required|valid_email|is_unique[candidates.email,id,{id}]'],
            'mobile_number' => ['label' => 'mobile number', 'rules' => 'required'],
        ];

        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;


        try {
            $this->db->transBegin();
            $candidateDetails = $this->candidate->find($request['id']);

            $fileName = $candidateDetails['profile_picture'];
            $profile = $this->request->getFile('profile_picture');
            if ($profile && $profile->getName() != null) {
                if (!empty($candidateDetails) && $candidateDetails['profile_picture'] != null && file_exists(FCPATH . '/candidate_profile/' . $candidateDetails['profile_picture'])) {
                    unlink(FCPATH . '/candidate_profile/' . $candidateDetails['profile_picture']);
                }
                $fileName = time() . '_' . $profile->getRandomName();
            }


            $resumeFile = $candidateDetails['resume'];
            $resume = $this->request->getFile('upload_resume');
            if ($resume && $resume->getName() != null) {
                if ($candidateDetails && $resumeFile != '') {
                    if (file_exists(FCPATH . "/candidate_resume/" . $resumeFile)) {
                        unlink(FCPATH . "/candidate_resume/" . $resumeFile);
                    }
                }
                $resumeFile = time() . '_' . $resume->getRandomName();
                // $resume->move(FCPATH . '/candidate_resume/', $resumeFile);
            }

            $ID = $request['id'];
            $newData = [
                'source_from'           => $request['source_from'],
                'full_name'             => $request['full_name'],
                'email'                 => $request['email'],
                'alternate_email'       => implode(',', $request['alternate_email']),
                'mobile_number'         => implode(',', $request['mobile_number']),
                'current_ctc_lakh'      => $request['current_ctc_lakh'],
                'current_ctc_thousand'  => $request['current_ctc_thousand'],
                'expected_ctc_lakh'     => $request['expected_ctc_lakh'],
                'expected_ctc_thousand' => $request['expected_ctc_thousand'],
                'experience'            => $request['experience'],
                'notice_period'         => $request['notice_period'],
                'current_skill'         => sizeof($request['current_skill']) > 0 ? implode(',', $request['current_skill']) : null,
                'profile_picture'       => $fileName,
                'resume'                => $resumeFile,
                'address'               => $request['address'],
                'country_id'            => $request['country_id'],
                'state_id'              => $request['state_id'],
                'city_id'               => $request['city_id'],
                'post_code'             => $request['post_code'],
                'gender'                => $request['gender'],
                'date_of_birth'         => $request['date_of_birth'],
                'marital_status'        => $request['marital_status'],
                'job_status'            => $request['job_status'],
                'status'                => $request['status'],
                'updated_at'            => Time::now(),
            ];
            $this->candidate->update($ID, $newData);

            # Delete candidate experience by candidate_id
            $this->candidateExperience->where('candidate_id', $ID)->delete();
            $experienceData = [];
            if (isset($request['experiences'])) :
                foreach ($request['experiences'] as $value) :
                    $experienceData[] = [
                        'candidate_id'          => $ID,
                        'company_name'          => $value['company_name'],
                        'designation'           => $value['designation'],
                        'start_date'            => $value['start_date'],
                        'end_date'              => $value['end_date'],
                        'is_default_company'    => $value['is_default_company'],
                        'created_at'            => Time::now()
                    ];
                endforeach;
                # Insert Batch of Candidate Experience Data
                $this->candidateExperience->insertBatch($experienceData);
            endif;
            # Delete candidate experience by candidate_id
            $this->candidateEducation->where('candidate_id', $ID)->delete();
            $educationData = [];
            foreach ($request['educations'] as $key => $value) :
                $educationData[] = [
                    'candidate_id'      => $ID,
                    'type'              => $value['type'],
                    'course_id'         => $value['course_id'],
                    'specification'     => $value['specification'],
                    'institute_name'    => $value['institute_name'],
                    'start_date'        => $value['start_date'],
                    'end_date'          => $value['is_student'] === 'Yes' ? null : $value['end_date'],
                    'is_student'        => $value['is_student'],
                    'created_at'        => Time::now()
                ];
            endforeach;
            # insert Batch of Candidate Education
            $this->candidateEducation->insertBatch($educationData);
            $this->db->transCommit();

            if ($profile && $profile->getName() != null) {
                $profile->move(FCPATH . '/candidate_profile/', $fileName);
            }
            if ($resume && $resume->getName() != null) {
                $resume->move(FCPATH . '/candidate_resume/', $resumeFile);
            }
        } catch (Exception $err) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG . $err->getMessage()], '400');
        }

        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => UPDATE_CANDIDATE]);
    }

    # Delete candidate function
    public function delete()
    {
        $request = $this->request->getPost();
        $candidateDetails = $this->candidate->find($request['id']);

        if ($candidateDetails) {
            $candidateID = $candidateDetails['id'];

            if ($candidateDetails['profile_picture'] != '' && file_exists(FCPATH . '/candidate_profile/' . $candidateDetails['profile_picture'])) {
                unlink(FCPATH . '/candidate_profile/' . $candidateDetails['profile_picture']);
            }
            if ($candidateDetails['resume'] != '' && file_exists(FCPATH . '/candidate_profile/' . $candidateDetails['resume'])) {
                unlink(FCPATH . '/candidate_resume/' . $candidateDetails['resume']);
            }

            $this->db->transBegin();
            $this->candidate->delete($candidateID);
            $this->db->transCommit();
            return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => DELETE_CANDIDATE]);
        }
        return $this->respond(['status' => ERROR_ST, 'status_code' => 200, 'message' => CANDIDATE_NOT_FOUND], '404');
    }

    # GetCourse List
    public function courseList()
    {
        $request = $this->request->getGet();
        $type = $request['type'];
        $response = model(Education::class)->ByType($type);
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }
}
