import { OrganizationChart } from 'store/ApiConstant';
import { AxiosAuthServices } from './axios/axiosServices';

export function OrganizationChartApi() {
    return AxiosAuthServices.post(OrganizationChart);
}
