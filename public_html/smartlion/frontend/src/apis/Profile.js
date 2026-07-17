import { AddDocument, ChangePassword, DeleteDocument, DocumentList, ProfileUpdate } from 'store/ApiConstant';
import { AxiosAuthServices } from './axios/axiosServices';

export function changePasswordApi(data) {
    const formData = new FormData();
    formData.append('current_password', data.current_password);
    formData.append('password', data.new_password);
    return AxiosAuthServices.post(ChangePassword, formData);
}

export function updateProfileApi(data) {
    const formData = new FormData();
    formData.append('id', data.id);
    formData.append('first_name', data.first_name);
    formData.append('last_name', data.last_name);
    data.alternate_mobile_number.map((i) => formData.append('alternate_mobile_number[]', i));
    formData.append('personal_email', data.personal_email);
    formData.append('address', data.address);
    formData.append('gender', data.gender);
    formData.append('country', data.country);
    formData.append('state', data.state);
    formData.append('city', data.city);
    formData.append('postcode', data.postcode);
    formData.append('image', data.profile_picture);
    return AxiosAuthServices.post(ProfileUpdate, formData);
}

export function documentListApi(params) {
    return AxiosAuthServices.get(DocumentList, params);
}

export function addDocumentApi(data) {
    const formData = new FormData();
    formData.append('id', data.id);
    formData.append('documents', data.documents);
    return AxiosAuthServices.post(AddDocument, formData);
}

export function deleteDocumentApi(data) {
    const formData = new FormData();
    formData.append('id', data.id);
    return AxiosAuthServices.post(DeleteDocument, formData);
}
