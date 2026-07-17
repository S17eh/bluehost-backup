import * as actionTypes from './actions';

export const initialState = {
    selectedItem: 'dashboard',
    isChild: false,
    opened: true,
    selectedCollapse: [],
    permissions: [
        'dashboard',
        'profile',
        'user',
        'company',
        'role',
        'permission-list',
        'permission-group',
        'restriction',
        'job-title',
        'job-type',
        'key-skill',
        'status-master',
        'industry',
        'functional-area',
        'education',
        'shift-timing',
        'country',
        'state',
        'city',
        'job',
        'candidate'
    ]
};

const menuReducer = (state = initialState, action) => {
    switch (action.type) {
        case actionTypes.SELECTED_ITEM:
            return {
                ...state,
                selectedItem: action.selectedItem
            };
        case actionTypes.OPEN_DRAWER:
            return {
                ...state,
                opened: action.opened
            };
        case actionTypes.SELECTED_COLLAPSE:
            return {
                ...state,
                selectedCollapse: action.selectedCollapse
            };
        case actionTypes.DEFAULT_PERMISSION:
            return {
                ...state,
                permissions: action.permissions
            };
        default:
            return state;
    }
};

export default menuReducer;
