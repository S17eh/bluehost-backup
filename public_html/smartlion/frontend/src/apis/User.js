import {
    AddUser,
    DeleteUser,
    DeleteUserDoc,
    EditUser,
    ExportUser,
    ImportUser,
    RoleUser,
    SaveImportUser,
    UserList,
    ViewUser
} from 'store/ApiConstant';
import { AxiosAuthServices } from './axios/axiosServices';

export function userListApi(params) {
    return AxiosAuthServices.get(UserList, params);
}

export function AddUpdateUserApi(data) {
    const formData = new FormData();
    formData.append('username', data.username);
    formData.append('first_name', data.first_name);
    formData.append('last_name', data.last_name);
    formData.append('email', data.email);
    formData.append('personal_email', data.personal_email);
    formData.append('password', data.password);
    formData.append('mobile_number', data.mobile_number);
    formData.append('gender', data.gender);
    formData.append('address', data.address);
    formData.append('country', data.country);
    formData.append('state', data.state);
    formData.append('city', data.city);
    formData.append('postcode', data.postcode);
    formData.append('image', data.profile_picture);
    formData.append('role_id', data.role_id);
    formData.append('assign_to', data.assign_to);
    formData.append('status', data.status);

    data.alternate_mobile_number.map((v) => {
        formData.append('alternate_mobile_number[]', v);
    });

    data.document.map((i, idx) => {
        formData.append('documents[]', i);
    });

    if (data.id !== '' && data.formType === 'edit') {
        formData.append('id', data.id);
        return AxiosAuthServices.post(EditUser, formData);
    } else {
        return AxiosAuthServices.post(AddUser, formData);
    }
}

export function UserViewApi(data) {
    const formData = new FormData();
    formData.append('type', data.type);
    formData.append('id', data.id);
    return AxiosAuthServices.post(ViewUser, formData);
}

export function deleteUserApi(data) {
    const formData = new FormData();
    formData.append('id', data.id);
    return AxiosAuthServices.post(DeleteUser, formData);
}

export function deleteUserDocumentApi(data) {
    const formData = new FormData();
    formData.append('id', data.id);
    return AxiosAuthServices.post(DeleteUserDoc, formData);
}

export function roleUserApi(params) {
    return AxiosAuthServices.get(RoleUser, params);
}

export function ExportUserApi(data) {
    return AxiosAuthServices.post(ExportUser);
}

export function ImportUserApi(data) {
    const formData = new FormData();
    formData.append('file', data.file);
    return AxiosAuthServices.post(ImportUser, formData);
}

export function SaveImportUserApi(data) {
    const formData = new FormData();
    data.users.map((i, idx) => {
        formData.append(`users[${idx}][username]`, i.username);
        formData.append(`users[${idx}][first_name]`, i.first_name);
        formData.append(`users[${idx}][last_name]`, i.last_name);
        formData.append(`users[${idx}][email]`, i.email);
        formData.append(`users[${idx}][mobile_number]`, i.mobile_number);
        formData.append(`users[${idx}][gender]`, i.gender);
        formData.append(`users[${idx}][address]`, i.address);
        formData.append(`users[${idx}][role_id]`, i.role_id);
    });
    return AxiosAuthServices.post(SaveImportUser, formData);
}
