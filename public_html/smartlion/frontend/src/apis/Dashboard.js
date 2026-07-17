import { CompanyMonthlyRevenue, dashboard } from 'store/ApiConstant';
import { AxiosAuthServices } from './axios/axiosServices';

export function CompanyMonthlyRevenueApi(params) {
    return AxiosAuthServices.get(CompanyMonthlyRevenue, params);
}

export function DashboardApi() {
    return AxiosAuthServices.post(dashboard);
}
