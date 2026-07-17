import { AddIndustry, DeleteIndustry, EditIndustry, IndustryList } from 'store/ApiConstant';
import { AxiosAuthServices } from './axios/axiosServices';

export function IndustryListApi(params) {
    return AxiosAuthServices.get(IndustryList, params);
}
export function addUpdateIndustryApi(data) {
    const formData = new FormData();
    formData.append('name', data.name);
    formData.append('description', data.description);
    formData.append('status', data.status);
    if (data.id !== '' && data.formType === 'edit') {
        formData.append('id', data.id);
        return AxiosAuthServices.post(EditIndustry, formData);
    } else {
        return AxiosAuthServices.post(AddIndustry, formData);
    }
}

export function deleteIndustryApi(data) {
    const formData = new FormData();
    formData.append('id', data.id);
    return AxiosAuthServices.post(DeleteIndustry, formData);
}
