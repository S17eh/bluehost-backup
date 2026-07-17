import { AddCity, AddEditCity, ChangeStatus, CityList, CountryList, DeleteCity, EditCity, StateList } from 'store/ApiConstant';
import { AxiosAuthServices } from './axios/axiosServices';

export function CountryListApi(params) {
    return AxiosAuthServices.get(CountryList, params);
}
export function StateListApi(params) {
    return AxiosAuthServices.get(StateList, params);
}

export function changeStatusApi(data) {
    const formData = new FormData();
    formData.append('id', data.id);
    formData.append('status', data.status);
    formData.append('module', data.module);
    return AxiosAuthServices.post(ChangeStatus, formData);
}

export function CityListApi(params) {
    return AxiosAuthServices.get(CityList, params);
}

export function addUpdateCityApi(data) {
    const formData = new FormData();
    formData.append('name', data.city);
    formData.append('state_id', data.state);
    formData.append('status', data.status);
    if (data.id !== '' && data.formType === 'edit') {
        formData.append('id', data.id);
        return AxiosAuthServices.post(EditCity, formData);
    } else {
        return AxiosAuthServices.post(AddCity, formData);
    }
}

export function AddEditCityApi(data) {
    const formData = new FormData();
    formData.append('type', data.type);
    if (data.type === 'edit') {
        formData.append('id', data.id);
        formData.append('country_id', data.country_id);
    } else if (data.type === 'state') {
        formData.append('country_id', data.country_id);
    }
    return AxiosAuthServices.post(AddEditCity, formData);
}

export function deleteCityApi(data) {
    const formData = new FormData();
    formData.append('id', data.id);
    return AxiosAuthServices.post(DeleteCity, formData);
}
