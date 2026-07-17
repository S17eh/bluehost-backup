import { AddRoleLevel, DeleteRoleLevel, EditRoleLevel, RoleLevelList } from 'store/ApiConstant';
import { AxiosAuthServices } from './axios/axiosServices';

export function RoleLevelListApi(params) {
    return AxiosAuthServices.get(RoleLevelList, params);
}

export function addUpdateRoleLevelApi(data) {
    const formData = new FormData();
    formData.append('level_name', data.name);
    formData.append('parent_level', data.parent_level);
    formData.append('description', data.description);
    if (data.id !== '' && data.formType === 'edit') {
        formData.append('id', data.id);
        return AxiosAuthServices.post(EditRoleLevel, formData);
    } else {
        return AxiosAuthServices.post(AddRoleLevel, formData);
    }
}

export function deleteRoleLevelApi(data) {
    const formData = new FormData();
    formData.append('id', data.id);
    return AxiosAuthServices.post(DeleteRoleLevel, formData);
}
