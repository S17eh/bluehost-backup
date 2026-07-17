<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use App\Entities\Collection;
use App\Models\Candidate;
use App\Models\Country;
use App\Models\Education;
use App\Models\Employer;
use App\Models\FunctionalArea;
use App\Models\Industry;
use App\Models\Job;
use App\Models\JobCandidate;
use App\Models\JobTitle;
use App\Models\JobType;
use App\Models\KeySkill;
use App\Models\ShiftTiming;
use App\Models\StatusMaster;
use App\Models\User;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use Exception;

class JobController extends BaseController
{
    use ResponseTrait;
    protected $job;
    protected $employer;

    public function __construct()
    {
        $this->job = new Job();
        $this->employer = new Employer();
    }

    public function view()
    {
        global $workMode;
        global $salaryChart;
        $request = $this->request->getPost();
        $response = null;
        $job = null;
        if ($request['type'] == "add") {
            $job = $this->job->select('job_code')->orderBy('id', 'DESC')->get()->getRow();
            // exit;
            $jobNo = 0;

            if (!$job || $job->job_code == "") {
                $jobNo = str_pad('00001', 5, "0", STR_PAD_LEFT);
            } else {
                $jobNo = $job->job_code + 1;
                $jobNo = str_pad($jobNo, 5, "0", STR_PAD_LEFT);
            }
            $employerList = Model(Employer::class)->select('id,name')->where('status', 'Active')->get()->getResultArray();
            $jobTitle = model(JobTitle::class)->select('id,name')->where('status', 'Active')->get()->getResultArray();
            $jobType = model(JobType::class)->select('id,name')->where('status', 'Active')->get()->getResultArray();
            $keySkill = model(KeySkill::class)->select('id,name')->where('status', 'Active')->get()->getResultArray();
            $shiftTiming = model(ShiftTiming::class)->select('id,name')->where('status', 'Active')->get()->getResultArray();
            $functionalArea = model(FunctionalArea::class)->select('id,name')->where('status', 'Active')->get()->getResultArray();
            $industries = model(Industry::class)->select('id,name')->where('status', 'Active')->get()->getResultArray();
            $countries = model(Country::class)->select('id,name')->where('status', 'Active')->get()->getResultArray();
            $education = model(Education::class)->select('id,name,type')->orderBy('type', 'ASC')->where('status', 'Active')->get()->getResultArray();
            $newEducation = model(Education::class)->ByTypeEduction();

            $response = [
                'job_code' => $jobNo,
                'job_title' => $jobTitle,
                'job_type' => $jobType,
                'key_skill' => $keySkill,
                'shift_timing' => $shiftTiming,
                'industries' => $industries,
                'functional_area' => $functionalArea,
                'education' => $education,
                'new_education' => $newEducation,
                'work_mode' => $workMode,
                'salaryChart' => $salaryChart,
                'employer_list' => $employerList,
                'countries' => $countries,
            ];
        }
        if (isset($request['id']) && $request['type'] == "edit") {
            $job = $this->job->select('jobs.*,job_types.name as job_type_name')->where("jobs.id", $request['id'])->join('job_types', 'jobs.job_type_id = job_types.id')->get()->getRowArray();
            $job['preferred_industry'] = explode(',', $job['preferred_industry']);
            $job['shift'] = explode(',', $job['shift']);
            $job['education'] = explode(',', $job['education']);
            $job['skill'] = explode(',', $job['skill']);
            $job['functional_area'] = explode(',', $job['functional_area']);
            $stateList = $this->db->table('states')->where('country_id', $job['country_id'])->get()->getResultArray();
            $cityList = $this->db->table('cities')->where('state_id', $job['state_id'])->get()->getResultArray();
            // print_r($job);exit;
            $jobTitle = model(JobTitle::class)->select('id,name')->where('status', 'Active')->get()->getResultArray();
            $jobType = model(JobType::class)->select('id,name')->where('status', 'Active')->get()->getResultArray();
            $keySkill = model(KeySkill::class)->select('id,name')->where('status', 'Active')->get()->getResultArray();
            $shiftTiming = model(ShiftTiming::class)->select('id,name')->where('status', 'Active')->get()->getResultArray();
            $functionalArea = model(FunctionalArea::class)->select('id,name')->where('status', 'Active')->get()->getResultArray();
            $industries = model(Industry::class)->select('id,name')->where('status', 'Active')->get()->getResultArray();
            $countries = model(Country::class)->select('id,name')->where('status', 'Active')->get()->getResultArray();
            $education = model(Education::class)->select('id,name,type')->orderBy('type', 'ASC')->where('status', 'Active')->get()->getResultArray();
            $newEducation = model(Education::class)->ByTypeEduction();
            $response = [
                "job" => $job,
                'job_title' => $jobTitle,
                'job_type' => $jobType,
                'key_skill' => $keySkill,
                'shift_timing' => $shiftTiming,
                'industries' => $industries,
                'functional_area' => $functionalArea,
                'education' => $education,
                'new_education' => $newEducation,
                'work_mode' => $workMode,
                'salaryChart' => $salaryChart,
                'state_list' => $stateList,
                'city_list' => $cityList,
                'countries' => $countries,

            ];
        }
        if (isset($request['id']) && $request['type'] == "view") {
            $job = $this->job->where("jobs.id", $request['id'])->select('jobs.*,status_master.name as status,job_types.name as job_type_name,industry.name as industry_name,employer.name as employer_name,countries.name as country_name,states.name as state_name, cities.name as city_name')
                ->join('countries', 'countries.id = jobs.country_id')
                ->join('industry', 'industry.id = jobs.industry_id')
                ->join('job_types', 'job_types.id = jobs.job_type_id')
                ->join('employer', 'employer.id = jobs.employer_id')
                ->join('states', 'states.id = jobs.state_id')
                ->join('status_master', 'status_master.id = jobs.status')
                ->join('cities', 'cities.id = jobs.city_id')
                ->get()->getRowArray();

            $job['preferred_industry']  = array_column($this->db->table('industry')->select('name')->whereIn('id', explode(',', $job['preferred_industry']))->get()->getResultArray(), 'name');
            $job['shift']  = array_column($this->db->table('shift_timings')->select('name')->whereIn('id', explode(',', $job['shift']))->get()->getResultArray(), 'name');
            $job['education']  = array_column($this->db->table('educations')->select('name')->whereIn('id', explode(',', $job['education']))->get()->getResultArray(), 'name');

            $job['skill'] = explode(',', $job['skill']);
            $job['functional_area'] = explode(',', $job['functional_area']);

            $response = [
                "job" => $job,
            ];
        }


        // print_r($response);
        // exit;
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    public function index()
    {
        $request = $this->request->getGet();

        $data = $this->job->resource($request)->get()->getResultArray();
        foreach ($data as $key => $value) :
            $data[$key]['has_candidate'] = (model(JobCandidate::class)->where('job_id', $value['id'])->countAllResults()) > 0 ? true : false;
        endforeach;
        $response = Collection::tableData(
            $data,
            $this->job->resource($request, false)->countAllResults()
        );
        $response['employerList'] = $this->employer->select('id,name')->where('status', 'Active')->findAll();
        $response['userList'] = model(User::class)->UserDropDown();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    public function create()
    {
        $request = $this->request->getPost();
        $userID = getTokenUserID();
        $validationRules = [
            'job_code' => ['label' => 'job code', 'rules' => 'required'],
            'title' => ['label' => 'title', 'rules' => 'required'],
            'employer_id' => ['label' => 'company', 'rules' => 'required'],
            'job_type' => ['label' => 'job type', 'rules' => 'required'],
            'work_mode' => ['label' => 'work mode', 'rules' => 'required'],
            'position_title' => ['label' => 'position title', 'rules' => 'required'],
            'no_of_position' => ['label' => 'no of position', 'rules' => 'required'],
            'description' => ['label' => 'description', 'rules' => 'required'],
            'skill' => ['label' => 'skill', 'rules' => 'required'],
            'work_experience_min' => ['label' => 'work experience min', 'rules' => 'required'],
            'work_experience_max' => ['label' => 'work experience max', 'rules' => 'required'],
            'salary_min_lakhs' => ['label' => 'salary min lakhs', 'rules' => 'required'],
            'salary_max_lakhs' => ['label' => 'salary max lakhs', 'rules' => 'required'],
            'salary_min_thousands' => ['label' => 'salary min thousands', 'rules' => 'required'],
            'salary_max_thousands' => ['label' => 'salary max thousands', 'rules' => 'required'],
            // 'salary_min' => ['label' => 'salary min', 'rules' => 'required'],
            // 'salary_max' => ['label' => 'salary max', 'rules' => 'required'],
            'country' => ['label' => 'country', 'rules' => 'required'],
            'state' => ['label' => 'state', 'rules' => 'required'],
            'city' => ['label' => 'city', 'rules' => 'required'],
            'post_code' => ['label' => 'post_code', 'rules' => 'required'],
            'industry' => ['label' => 'industry', 'rules' => 'required'],
            'functional_area' => ['label' => 'functional area', 'rules' => 'required'],
            'education' => ['label' => 'education', 'rules' => 'required'],
            'start_date' => ['label' => 'start date', 'rules' => 'required'],
            'shift' => ['label' => 'shift', 'rules' => 'required'],
            'end_date' => ['label' => 'end date', 'rules' => 'required'],
            'status' => ['label' => 'status', 'rules' => 'required'],
        ];
        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;
        !empty($request['preferred_industry']) ? $preferred_industry = $request['preferred_industry'] : $preferred_industry = [];
        $this->db->transBegin();
        try {
            $data = [
                'job_code' => $request['job_code'],
                'employer_id' => $request['employer_id'],
                'title' => $request['title'],
                'job_type_id' => $request['job_type'],
                'work_mode' => $request['work_mode'],
                'position_title' => $request['position_title'],
                'no_of_position' => $request['no_of_position'],
                'description' => $request['description'],
                'candidate_profile' => $request['candidate_profile'],
                'skill' => implode(',', $request['skill']),
                'work_experience_min' => $request['work_experience_min'],
                'work_experience_max' => $request['work_experience_max'],
                'salary_min_lakhs' => $request['salary_min_lakhs'],
                'salary_max_lakhs' => $request['salary_max_lakhs'],
                'salary_min_thousands' => $request['salary_min_thousands'],
                'salary_max_thousands' => $request['salary_max_thousands'],
                // 'salary_min' => $request['salary_min'],
                // 'salary_max' => $request['salary_max'],
                'perks_benefits' => $request['perks_benefits'],
                'country_id' => $request['country'],
                'state_id' => $request['state'],
                'city_id' => $request['city'],
                'post_code' => $request['post_code'],
                'industry_id' => $request['industry'],
                'preferred_industry' => implode(',', $preferred_industry),
                'functional_area' => implode(',', $request['functional_area']),
                'education' => implode(',', $request['education']),
                'start_date' => $request['start_date'],
                'shift' => implode(',', $request['shift']),
                'end_date' => $request['end_date'],
                'status' => $request['status'],
                'created_at' => Time::now()
            ];
            $this->job->save($data);
            model(Notification::class)->setNotification($userID, 'Create Job', $request['title'] . ' , New job create');
        } catch (Exception $err) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG . $err->getMessage()], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => ADD_JOB]);
    }

    public function update()
    {
        $request = $this->request->getPost();
        $validationRules = [
            'title' => ['label' => 'title', 'rules' => 'required'],
            'employer_id' => ['label' => 'company', 'rules' => 'required'],
            'job_type' => ['label' => 'job type', 'rules' => 'required'],
            'work_mode' => ['label' => 'work mode', 'rules' => 'required'],
            'position_title' => ['label' => 'position title', 'rules' => 'required'],
            'no_of_position' => ['label' => 'no of position', 'rules' => 'required'],
            'description' => ['label' => 'description', 'rules' => 'required'],
            'skill' => ['label' => 'skill', 'rules' => 'required'],
            'work_experience_min' => ['label' => 'work experience min', 'rules' => 'required'],
            'work_experience_max' => ['label' => 'work experience max', 'rules' => 'required'],
            'salary_min_lakhs' => ['label' => 'salary min lakhs', 'rules' => 'required'],
            'salary_max_lakhs' => ['label' => 'salary max lakhs', 'rules' => 'required'],
            'salary_min_thousands' => ['label' => 'salary min thousands', 'rules' => 'required'],
            'salary_max_thousands' => ['label' => 'salary max thousands', 'rules' => 'required'],
            // 'salary_min' => ['label' => 'salary min', 'rules' => 'required'],
            // 'salary_max' => ['label' => 'salary max', 'rules' => 'required'],
            'country' => ['label' => 'country', 'rules' => 'required'],
            'state' => ['label' => 'state', 'rules' => 'required'],
            'city' => ['label' => 'city', 'rules' => 'required'],
            'post_code' => ['label' => 'post_code', 'rules' => 'required'],
            'industry' => ['label' => 'industry', 'rules' => 'required'],
            'functional_area' => ['label' => 'functional area', 'rules' => 'required'],
            'education' => ['label' => 'education', 'rules' => 'required'],
            'start_date' => ['label' => 'start date', 'rules' => 'required'],
            'shift' => ['label' => 'shift', 'rules' => 'required'],
            'end_date' => ['label' => 'end date', 'rules' => 'required'],
            'status' => ['label' => 'status', 'rules' => 'required'],
        ];
        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;
        !empty($request['preferred_industry']) ? $preferred_industry = $request['preferred_industry'] : $preferred_industry = [];
        $this->db->transBegin();
        try {
            $this->job->update($request['id'], [
                'employer_id' => $request['employer_id'],
                'title' => $request['title'],
                'job_type_id' => $request['job_type'],
                'work_mode' => $request['work_mode'],
                'position_title' => $request['position_title'],
                'no_of_position' => $request['no_of_position'],
                'description' => $request['description'],
                'candidate_profile' => $request['candidate_profile'],
                'skill' => implode(',', $request['skill']),
                'work_experience_min' => $request['work_experience_min'],
                'work_experience_max' => $request['work_experience_max'],
                'salary_min_lakhs' => $request['salary_min_lakhs'],
                'salary_max_lakhs' => $request['salary_max_lakhs'],
                'salary_min_thousands' => $request['salary_min_thousands'],
                'salary_max_thousands' => $request['salary_max_thousands'],
                // 'salary_min' => $request['salary_min'],
                // 'salary_max' => $request['salary_max'],
                'perks_benefits' => $request['perks_benefits'],
                'country_id' => $request['country'],
                'state_id' => $request['state'],
                'city_id' => $request['city'],
                'post_code' => $request['post_code'],
                'industry_id' => $request['industry'],
                'preferred_industry' => implode(',', $preferred_industry),
                'functional_area' => implode(',', $request['functional_area']),
                'education' => implode(',', $request['education']),
                'start_date' => $request['start_date'],
                'shift' => implode(',', $request['shift']),
                'end_date' => $request['end_date'],
                'status' => $request['status'],
                'updated_at' => Time::now(),
            ]);
        } catch (Exception $err) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => UPDATE_JOB]);
    }

    public function delete()
    {
        $request = $this->request->getPost();
        $job = $this->job->getResource($request, false, true);

        if ($job) {
            $jobID = $job['id'];
            try {
                $this->db->transBegin();
                $this->job->delete($jobID);
            } catch (\Exception $err) {
                $this->db->transRollback();
                return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
            }
            $this->db->transCommit();
            return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => DELETE_JOB]);
        }
        return $this->respond(['status' => ERROR_ST, 'status_code' => 200, 'message' => JOB_NOT_FOUND], '404');
    }


    # Update Job Assign
    public function updateAssign()
    {
        $request = $this->request->getPost();

        try {
            $this->db->transBegin();
            $data['assign_to'] = $request['user_id'];
            $this->job->update($request['id'], $data);
        } catch (\Exception $err) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => UPDATE_JOB]);
    }

    public function allJobCandidates()
    {
        $request = $this->request->getGet();
        $candidateModel = new Candidate();
        $data = $candidateModel->listForJobApplication($request)->get()->getResultArray();
        foreach ($data as $key => $value) :
            $data[$key]['id'] =  $value['id'];
            $data[$key]['alternate_email'] = $value['alternate_email'] !== "" ? explode(',', $value['alternate_email']) : [];
            $data[$key]['mobile_number'] =  $value['mobile_number'];
        endforeach;

        $response['candidate_list'] = Collection::tableData(
            $data,
            $candidateModel->listForJobApplication($request, false)->countAllResults()
        );
        $response['selected_candidate'] =  model(JobCandidate::class)->where('job_id', $request['job_id'])->findColumn('candidate_id')  ?? [];
        $response['key_skill'] = model(KeySkill::class)->select('id,name')->where('status', 'Active')->get()->getResultArray();

        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    public function addRemoveJobCandidate()
    {
        $request = $this->request->getPost();
        if ($request['action'] === 'add') {

            try {
                $defaultStatus = model(StatusMaster::class)->where('is_default', 'Yes')->first();
                if (!$defaultStatus)
                    return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => 'Please add default status']);
                $newData = [
                    'job_id' => $request['job_id'],
                    'candidate_id' => $request['candidate_id'],
                    'status_id' => $defaultStatus['id'],
                    'created_by' => getTokenUserID(),
                    'created_at' => Time::now(),
                    'updated_at' => Time::now(),
                ];
                model(JobCandidate::class)->insert($newData);
            } catch (Exception $err) {
                $this->db->transRollback();
                return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG . $err->getMessage()], '400');
            }
            $this->db->transCommit();
        } else {
            $jobCandidateDetail = model(JobCandidate::class)->where('job_id', $request['job_id'])->where('candidate_id', $request['candidate_id'])->first();
            if ($jobCandidateDetail) {
                $jobCandidateID = $jobCandidateDetail['id'];
                try {
                    $this->db->transBegin();
                    model(JobCandidate::class)->delete($jobCandidateID);
                } catch (\Exception $err) {
                    $this->db->transRollback();
                    return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG], '400');
                }
                $this->db->transCommit();
            }
        }
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => 'success']);
    }

    public function jobCandidateList()
    {
        $request = $this->request->getGet();

        $data = model(JobCandidate::class)->resource($request)->get()->getResultArray();
        $response = Collection::tableData(
            $data,
            model(JobCandidate::class)->resource($request, false)->countAllResults()
        );
        $response['statusList'] = model(StatusMaster::class)->findAll();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'data' => $response]);
    }

    public function updateJobCandidate()
    {
        $request = $this->request->getPost();
        $validationRules = [
            'id' => ['label' => 'job candidate id', 'rules' => 'required'],
            'status_id' => ['label' => 'status', 'rules' => 'required'],
            'is_hired' => ['label' => 'is hired', 'rules' => 'required'],
            // 'revenue' => ['label' => 'status', 'rules' => 'required'],
        ];
        if (!$this->validate($validationRules)) :
            $message = GET_VALIDATION_MSG($this->validator->getErrors());
            return $this->respond(['status' => VALIDATION_ST, 'status_code' => 200, 'message' => $message]);
        endif;

        $this->db->transBegin();
        try {
            $newData['status_id'] = $request['status_id'];
            $newData['is_hired'] = $request['is_hired'];
            $newData['revenue'] = isset($request['revenue']) ? $request['revenue'] : 0.00;
            $newData['updated_at'] = Time::now();
            model(JobCandidate::class)->update($request['id'], $newData);
        } catch (Exception $err) {
            $this->db->transRollback();
            return $this->respond(['status' => ERROR_ST, 'status_code' => 400, 'message' => SOMETHING_WRONG . $err->getMessage()], '400');
        }
        $this->db->transCommit();
        return $this->respond(['status' => SUCCESS_ST, 'status_code' => 200, 'message' => UPDATE_JOB_CANDIDATE]);
    }
}
