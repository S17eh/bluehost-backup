import { LoginApi, LogoutApi } from 'apis/Auth';
import { createContext, useEffect } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { LOGIN, LOGOUT } from 'store/actions';
import { apiErrorSnackBar, apiValidationSnackBar } from 'utils/SnackBar';

const setServiceToken = (serviceToken) => {
    if (serviceToken) {
        localStorage.setItem('serviceToken', JSON.stringify(serviceToken));
    } else {
        localStorage.removeItem('serviceToken');
    }
};

const AuthContext = createContext(null);

export const AuthProvider = ({ children }) => {
    const cart = useSelector((state) => state.account);
    const dispatch = useDispatch();

    useEffect(() => {
        const init = async () => {
            try {
                const serviceToken = localStorage.getItem('serviceToken');
                if (serviceToken) {
                    dispatch({
                        type: LOGIN,
                        payload: {
                            ...cart,
                            isLoggedIn: true
                        }
                    });
                } else {
                    dispatch({
                        type: LOGOUT
                    });
                }
            } catch (err) {
                // console.error(err);
                dispatch({
                    type: LOGOUT
                });
            }
        };

        init();
    }, []);

    const login = (values) => {
        LoginApi(values)
            .then((res) => {
                if (res.data && res.data.status === 1) {
                    localStorage.setItem('type', 'login');
                    const { data } = res.data;
                    setServiceToken(data.token);
                    dispatch({
                        type: LOGIN,
                        payload: {
                            isLoggedIn: true,
                            user: data.user,
                            access: data.access
                        }
                    });
                } else {
                    apiValidationSnackBar(res);
                }
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };

    const logOut = async () => {
        await LogoutApi()
            .then((res) => {
                dispatch({
                    type: LOGOUT,
                    payload: {
                        isLoggedIn: false
                    }
                });
                setServiceToken(null);
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };

    const checkRestriction = (slug) => {
        return cart.access.restriction ? cart.access.restriction.filter((a) => a === slug).length > 0 : false;
    };

    return <AuthContext.Provider value={{ ...cart, checkRestriction, login, logOut }}>{children}</AuthContext.Provider>;
};

export default AuthContext;
