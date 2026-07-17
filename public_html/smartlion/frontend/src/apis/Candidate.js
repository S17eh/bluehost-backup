import {
    AddCandidate,
    CandidateAddData,
    CandidateAddView,
    CandidateEditData,
    CandidateList,
    CourseList,
    DeleteCandidate,
    EditCandidate,
    JobCityList,
    JobStateList
} from 'store/ApiConstant';
import { AxiosAuthServices } from './axios/axiosServices';

export function candidateViewApi() {
    return AxiosAuthServices.get(CandidateAddData);
}

export function candidateEditDataApi(params) {
    return AxiosAuthServices.get(CandidateEditData, params);
}

export function candidateListApi(params) {
    return AxiosAuthServices.get(CandidateList, params);
}

export function candidateCourseListApi(type) {
    return AxiosAuthServices.get(CourseList, type);
}

export function candidateStateApi(data) {
    const formData = new FormData();
    formData.append('country_id', data.country_id);
    return AxiosAuthServices.post(JobStateList, formData);
}

export function candidateCityApi(data) {
    const formData = new FormData();
    formData.append('state_id', data.state_id);
    return AxiosAuthServices.post(JobCityList, formData);
}

export function addUpdateCandidateApi(data) {
    const formData = new FormData();
    formData.append('source_from', data.source_from);
    formData.append('full_name', data.name);
    formData.append('email', data.email);
    data.alternate_email.map((i, idx) => {
        formData.append('alternate_email[]', i);
    });
    data.mobile_number.map((i, idx) => {
        formData.append('mobile_number[]', i);
    });
    formData.append('current_ctc_lakh', data.current_ctc_lakh);
    formData.append('current_ctc_thousand', data.current_ctc_thousand);
    formData.append('expected_ctc_lakh', data.expected_ctc_lakh);
    formData.append('expected_ctc_thousand', data.expected_ctc_thousand);
    formData.append('experience', data.experience_fresher);
    formData.append('notice_period', data.notice_period);
    data.current_skill.map((val) => {
        formData.append('current_skill[]', val.name);
    });
    formData.append('address', data.address);
    formData.append('country_id', data.country);
    formData.append('state_id', data.state);
    formData.append('city_id', data.city);
    formData.append('post_code', data.postcode);
    formData.append('gender', data.gender);
    formData.append('date_of_birth', data.dob);
    formData.append('marital_status', data.marital_status);
    formData.append('job_status', '');
    formData.append('assign', data.assign);
    formData.append('revenue', data.revenue);
    formData.append('upload_resume', data.upload_resume);
    formData.append('status', data.status);
    data.experience_fresher === '0' &&
        data.experience.map((i, idx) => {
            formData.append(`experiences[${idx}][company_name]`, i.company_name);
            formData.append(`experiences[${idx}][designation]`, i.designation);
            formData.append(`experiences[${idx}][start_date]`, i.start_date);
            formData.append(`experiences[${idx}][end_date]`, i.end_date);
            let val = i.is_default_company ? 'Yes' : 'No';
            formData.append(`experiences[${idx}][is_default_company]`, val);
        });
    data.education.map((i, idx) => {
        formData.append(`educations[${idx}][type]`, i.type);
        formData.append(`educations[${idx}][course_id]`, i.course_id);
        formData.append(`educations[${idx}][specification]`, i.specification);
        formData.append(`educations[${idx}][institute_name]`, i.institute_name);
        formData.append(`educations[${idx}][start_date]`, i.start_date);
        formData.append(`educations[${idx}][end_date]`, i.end_date);
    });
    formData.append('profile_picture', data.profile_picture);
    if (data.id !== '' && data.formType === 'edit') {
        formData.append('id', data.id);
        return AxiosAuthServices.post(EditCandidate, formData);
    } else {
        return AxiosAuthServices.post(AddCandidate, formData);
    }
}

export function deleteCandidateApi(data) {
    const formData = new FormData();
    formData.append('id', data.id);
    return AxiosAuthServices.post(DeleteCandidate, formData);
}
