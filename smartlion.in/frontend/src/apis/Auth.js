import { checkLogin, ForgotPassword, LogoutUser, register, ResetPassword } from 'store/ApiConstant';
import { AxiosAuthServices, AxiosServices } from './axios/axiosServices';

export function LoginApi(data) {
    const formData = new FormData();
    formData.append('email', data.email);
    formData.append('password', data.password);
    return AxiosServices.post(checkLogin, formData);
}

export function RegisterApi(data) {
    const formData = new FormData();
    formData.append('username', data.username);
    formData.append('first_name', data.first_name);
    formData.append('last_name', data.last_name);
    formData.append('email', data.email);
    formData.append('password', data.password);
    formData.append('mobile_number', data.mobile_number);
    formData.append('gender', data.gender);
    return AxiosServices.post(register, formData);
}

export function LogoutApi() {
    return AxiosAuthServices.post(LogoutUser);
}

export function ForgotPasswordApi(data) {
    const formData = new FormData();
    formData.append('email', data.email);
    return AxiosServices.post(ForgotPassword, formData);
}

export function ChangePasswordApi(data) {
    const formData = new FormData();
    formData.append('token', data.token);
    formData.append('password', data.new_password);
    return AxiosServices.post(ResetPassword, formData);
}
