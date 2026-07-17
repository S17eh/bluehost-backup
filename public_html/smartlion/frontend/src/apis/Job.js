import {
    AddJob,
    AddRemoveJobCandidate,
    CandidatesForJob,
    DeleteJob,
    EditJob,
    JobCandidatesList,
    JobCityList,
    JobList,
    JobStateList,
    UpdateJobAssign,
    UpdateJobCandidate,
    ViewJob
} from 'store/ApiConstant';
import { AxiosAuthServices } from './axios/axiosServices';

export function jobListApi(params) {
    return AxiosAuthServices.get(JobList, params);
}

export function jobViewApi(data) {
    const formData = new FormData();
    formData.append('type', data.type);
    formData.append('id', data.id);
    return AxiosAuthServices.post(ViewJob, formData);
}

export function addUpdateJobApi(data) {
    const formData = new FormData();
    formData.append('job_code', data.job_code);
    formData.append('employer_id', data.employer_id);
    formData.append('title', data.title);
    formData.append('job_type', data.job_type);
    formData.append('work_mode', data.work_mode);
    formData.append('position_title', data.position_title);
    formData.append('no_of_position', data.no_of_position);
    formData.append('description', data.description);
    formData.append('candidate_profile', data.candidate_profile);
    data.key_skill
        ? data.key_skill.map((val) => {
              formData.append('skill[]', val);
          })
        : [];
    formData.append('work_experience_min', data.work_experience_min);
    formData.append('work_experience_max', data.work_experience_max);
    formData.append('salary_min', data.salary_min);
    formData.append('salary_max', data.salary_max);
    formData.append('perks_benefits', data.perks_benefits);
    formData.append('country', data.country);
    formData.append('state', data.state);
    formData.append('city', data.city);
    formData.append('post_code', data.post_code);
    formData.append('industry', data.industry);
    data.preferred_industry.map((val) => {
        formData.append('preferred_industry[]', val);
    });
    data.functional_area.map((val) => {
        formData.append('functional_area[]', val);
    });
    data.education.map((i) => {
        formData.append('education[]', i);
    });
    formData.append('start_date', data.start_date);
    formData.append('end_date', data.end_date);
    data.shift.map((val) => {
        formData.append('shift[]', val);
    });
    formData.append('status', data.status);

    if (data.id !== '' && data.formType === 'edit') {
        formData.append('id', data.id);
        return AxiosAuthServices.post(EditJob, formData);
    } else {
        return AxiosAuthServices.post(AddJob, formData);
    }
}

export function deleteJobApi(data) {
    const formData = new FormData();
    formData.append('id', data.id);
    return AxiosAuthServices.post(DeleteJob, formData);
}

export function JobStateApi(data) {
    const formData = new FormData();
    formData.append('country_id', data.country_id);
    return AxiosAuthServices.post(JobStateList, formData);
}

export function JobCityApi(data) {
    const formData = new FormData();
    formData.append('state_id', data.state_id);
    return AxiosAuthServices.post(JobCityList, formData);
}

export function UpdateJobAssignTo(data) {
    const formData = new FormData();
    formData.append('id', data.id);
    formData.append('user_id', data.user_id);
    return AxiosAuthServices.post(UpdateJobAssign, formData);
}

/********************************************
 *               Job Candidates              
 | Here below all job candidate related
 | functions like add, remove, list etc. 
 ********************************************/

export function JobCandidateListApi(params) {
    return AxiosAuthServices.get(JobCandidatesList, params);
}

export function CandidatesForJobApi(params) {
    return AxiosAuthServices.get(CandidatesForJob, params);
}

export function AddRemoveJobCandidatesApi(data) {
    const formData = new FormData();
    formData.append('job_id', data.job_id);
    formData.append('candidate_id', data.candidate_id);
    formData.append('action', data.action);
    return AxiosAuthServices.post(AddRemoveJobCandidate, formData);
}

export function UpdateJobCandidatesApi(data) {
    const formData = new FormData();
    formData.append('id', data.id);
    formData.append('status_id', data.status_id);
    formData.append('is_hired', data.is_hired);
    {
        data.is_hired === 'Yes' && formData.append('revenue', data.revenue);
    }
    return AxiosAuthServices.post(UpdateJobCandidate, formData);
}
