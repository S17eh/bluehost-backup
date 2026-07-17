import { LOGIN, LOGOUT } from './actions';

export const initialState = {
    isLoggedIn: false,
    isInitialized: false,
    user: null,
    access: {}
};

const accountReducer = (state = initialState, action) => {
    switch (action.type) {
        case LOGIN: {
            const { user, access } = action.payload;
            return {
                ...state,
                isLoggedIn: action.payload?.isLoggedIn,
                isInitialized: true,
                user,
                access
            };
        }
        case LOGOUT: {
            return {
                ...state,
                isLoggedIn: false,
                isInitialized: true,
                user: {},
                access: {}
            };
        }
        default: {
            return { ...state };
        }
    }
};

export default accountReducer;
