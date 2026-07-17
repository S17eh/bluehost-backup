import { AddEmployer, AddEmployerUser, DeleteEmployer, DeleteEmployerDoc, EditEmployer, EmployerList } from 'store/ApiConstant';
import { AxiosAuthServices } from './axios/axiosServices';

export function employerListApi(params) {
    return AxiosAuthServices.get(EmployerList, params);
}

export function addUpdateEmployerApi(data) {
    const formData = new FormData();
    formData.append('name', data.name);
    formData.append('register_name', data.register_name);
    formData.append('gst_no', data.gst_no);
    formData.append('email', data.email);
    formData.append('mobile_number', data.mobile_number);
    formData.append('website', data.website);
    formData.append('address', data.address);
    formData.append('logo', data.logo);
    formData.append('rate', data.rate);
    formData.append('status', data.status);

    data.document.map((i, idx) => {
        formData.append('documents[]', i);
    });

    data.alternate_email.map((v) => {
        formData.append('alternate_email[]', v);
    });
    data.alternate_mobile_number.map((v) => {
        formData.append('alternate_mobile_number[]', v);
    });

    if (data.id !== '' && data.formType === 'edit') {
        formData.append('id', data.id);
        return AxiosAuthServices.post(EditEmployer, formData);
    } else {
        return AxiosAuthServices.post(AddEmployer, formData);
    }
}

export function deleteEmployerApi(data) {
    const formData = new FormData();
    formData.append('id', data.id);
    return AxiosAuthServices.post(DeleteEmployer, formData);
}

export function deleteEmployerDocumentApi(data) {
    const formData = new FormData();
    formData.append('id', data.id);
    return AxiosAuthServices.post(DeleteEmployerDoc, formData);
}

export function addEmployerUserApi(data) {
    const formData = new FormData();
    formData.append('username', data.username);
    formData.append('first_name', data.first_name);
    formData.append('last_name', data.last_name);
    formData.append('email', data.email);
    formData.append('password', data.password);
    formData.append('mobile_number', data.mobile_number);
    formData.append('gender', data.gender);
    formData.append('address', data.address);
    formData.append('country', data.country);
    formData.append('state', data.state);
    formData.append('city', data.city);
    formData.append('postcode', data.postcode);
    formData.append('employer_id', data.employer_id);
    return AxiosAuthServices.post(AddEmployerUser, formData);
}
