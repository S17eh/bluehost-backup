import {
    AddEducation,
    AddFunctionalArea,
    AddFunctionalAreaFromJob,
    AddJobTitle,
    AddJobTitleFromJob,
    AddJobType,
    AddKeySkill,
    AddKeySkillFromJob,
    AddShiftTiming,
    DeleteEducation,
    DeleteFunctionalArea,
    DeleteJobTitle,
    DeleteJobType,
    DeleteKeySkill,
    DeleteShiftTiming,
    EditEducation,
    EditFunctionalArea,
    EditJobTitle,
    EditJobType,
    EditKeySkill,
    EditShiftTiming,
    EducationList,
    FunctionalAreaList,
    JobTitleList,
    JobTypeList,
    KeySkillList,
    ShiftTimingList
} from 'store/ApiConstant';
import { AxiosAuthServices } from './axios/axiosServices';

export function JobTitleListApi(params) {
    return AxiosAuthServices.get(JobTitleList, params);
}

export function AddJobTitleFromJobApi(data) {
    const formData = new FormData();
    formData.append('name', data.name);

    return AxiosAuthServices.post(AddJobTitleFromJob, formData);
}

export function addUpdateJobTitleApi(data) {
    const formData = new FormData();
    formData.append('name', data.name);
    formData.append('status', data.status);
    if (data.id !== '' && data.formType === 'edit') {
        formData.append('id', data.id);
        return AxiosAuthServices.post(EditJobTitle, formData);
    } else {
        return AxiosAuthServices.post(AddJobTitle, formData);
    }
}

export function deleteJobTitleApi(data) {
    const formData = new FormData();
    formData.append('id', data.id);
    return AxiosAuthServices.post(DeleteJobTitle, formData);
}

// ========== Job Type ========== //

export function JobTypeListApi(params) {
    return AxiosAuthServices.get(JobTypeList, params);
}
export function addUpdateJobTypeApi(data) {
    const formData = new FormData();
    formData.append('name', data.name);
    formData.append('status', data.status);
    if (data.id !== '' && data.formType === 'edit') {
        formData.append('id', data.id);
        return AxiosAuthServices.post(EditJobType, formData);
    } else {
        return AxiosAuthServices.post(AddJobType, formData);
    }
}

export function deleteJobTypeApi(data) {
    const formData = new FormData();
    formData.append('id', data.id);
    return AxiosAuthServices.post(DeleteJobType, formData);
}

// ========== Key Skill ========== //

export function KeySkillListApi(params) {
    return AxiosAuthServices.get(KeySkillList, params);
}
export function addUpdateKeySkillFromJobApi(data) {
    const formData = new FormData();
    formData.append('name', data.name);

    return AxiosAuthServices.post(AddKeySkillFromJob, formData);
}

export function addUpdateKeySkillApi(data) {
    const formData = new FormData();
    formData.append('name', data.name);
    formData.append('status', data.status);
    if (data.id !== '' && data.formType === 'edit') {
        formData.append('id', data.id);
        return AxiosAuthServices.post(EditKeySkill, formData);
    } else {
        return AxiosAuthServices.post(AddKeySkill, formData);
    }
}

export function deleteKeySkillApi(data) {
    const formData = new FormData();
    formData.append('id', data.id);
    return AxiosAuthServices.post(DeleteKeySkill, formData);
}

// ========== Functional Area ========== //

export function FunctionalAreaListApi(params) {
    return AxiosAuthServices.get(FunctionalAreaList, params);
}
export function addUpdateFunctionalAreaFromJobApi(data) {
    const formData = new FormData();
    formData.append('name', data.name);

    return AxiosAuthServices.post(AddFunctionalAreaFromJob, formData);
}

export function addUpdateFunctionalAreaApi(data) {
    const formData = new FormData();
    formData.append('name', data.name);
    formData.append('status', data.status);
    if (data.id !== '' && data.formType === 'edit') {
        formData.append('id', data.id);
        return AxiosAuthServices.post(EditFunctionalArea, formData);
    } else {
        return AxiosAuthServices.post(AddFunctionalArea, formData);
    }
}

export function deleteFunctionalAreaApi(data) {
    const formData = new FormData();
    formData.append('id', data.id);
    return AxiosAuthServices.post(DeleteFunctionalArea, formData);
}

// ========== Shift Timing ========== //

export function ShiftTimingListApi(params) {
    return AxiosAuthServices.get(ShiftTimingList, params);
}
export function addUpdateShiftTimingApi(data) {
    const formData = new FormData();
    formData.append('name', data.name);
    formData.append('status', data.status);
    if (data.id !== '' && data.formType === 'edit') {
        formData.append('id', data.id);
        return AxiosAuthServices.post(EditShiftTiming, formData);
    } else {
        return AxiosAuthServices.post(AddShiftTiming, formData);
    }
}

export function deleteShiftTimingApi(data) {
    const formData = new FormData();
    formData.append('id', data.id);
    return AxiosAuthServices.post(DeleteShiftTiming, formData);
}

// ========== Education ========== //

export function EducationListApi(params) {
    return AxiosAuthServices.get(EducationList, params);
}
export function addUpdateEducationApi(data) {
    const formData = new FormData();
    formData.append('name', data.name);
    formData.append('type', data.type);
    formData.append('parent_id', data.parent_degree);
    formData.append('status', data.status);
    if (data.id !== '' && data.formType === 'edit') {
        formData.append('id', data.id);
        return AxiosAuthServices.post(EditEducation, formData);
    } else {
        return AxiosAuthServices.post(AddEducation, formData);
    }
}

export function deleteEducationApi(data) {
    const formData = new FormData();
    formData.append('id', data.id);
    return AxiosAuthServices.post(DeleteEducation, formData);
}
