import { NotificationList } from 'store/ApiConstant';
import { AxiosAuthServices } from './axios/axiosServices';

export function NotificationListApi(params) {
    return AxiosAuthServices.get(NotificationList, params);
}
