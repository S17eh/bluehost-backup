import { AddStatus, DeleteStatus, EditStatus, StatusList } from 'store/ApiConstant';
import { AxiosAuthServices } from './axios/axiosServices';

export function StatusListApi(params) {
    return AxiosAuthServices.get(StatusList, params);
}

export function addUpdateStatusApi(data) {
    console.log(data);
    const formData = new FormData();
    formData.append('name', data.name);
    formData.append('is_default', data.is_default);
    formData.append('status', data.status);

    if (data.id !== '' && data.formType === 'edit') {
        formData.append('id', data.id);
        return AxiosAuthServices.post(EditStatus, formData);
    } else {
        return AxiosAuthServices.post(AddStatus, formData);
    }
}

export function deleteStatusApi(data) {
    const formData = new FormData();
    formData.append('id', data.id);
    return AxiosAuthServices.post(DeleteStatus, formData);
}
