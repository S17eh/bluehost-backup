// assets
import { IconBrandChrome, IconDashboard, IconGitFork, IconUsers } from '@tabler/icons';

// constant
const icons = { IconBrandChrome, IconDashboard, IconGitFork, IconUsers };

// ==============================|| SAMPLE PAGE & DOCUMENTATION MENU ITEMS ||============================== //

const menuItems = [
    {
        id: 'dashboard',
        title: 'Dashboard',
        type: 'item',
        url: '/',
        icon: icons.IconDashboard,
        isIcon: true,
        breadcrumbs: false
    },
    {
        id: 'user',
        title: 'User',
        type: 'item',
        url: '/user',
        icon: icons.IconUsers,
        isIcon: true,
        breadcrumbs: true,
        target: false
    },
    {
        id: 'company',
        title: 'Company',
        type: 'item',
        url: '/company',
        icon: icons.IconUsers,
        isIcon: true,
        breadcrumbs: true,
        target: false
    },
    {
        id: 'job',
        title: 'Job',
        type: 'item',
        url: '/job',
        icon: icons.IconUsers,
        isIcon: true,
        breadcrumbs: true,
        target: false
    },
    {
        id: 'candidate',
        title: 'Candidate',
        type: 'item',
        url: '/candidate',
        icon: icons.IconUsers,
        isIcon: true,
        breadcrumbs: true,
        target: false
    },
    {
        id: 'notification',
        title: 'Notification',
        type: 'item',
        url: '/notification',
        icon: icons.IconUsers,
        isIcon: true,
        breadcrumbs: true,
        target: false
    },
    {
        id: 'reports',
        title: 'Reports',
        type: 'collapse',
        icon: icons.IconGitFork,
        isIcon: true,
        children: [
            {
                id: 'hierarchy-chart',
                title: 'Hierarchy Chart',
                type: 'item',
                url: '/reports/hierarchy-chart',
                breadcrumbs: true,
                isIcon: false,
                target: false
            }
        ]
    },
    {
        id: 'role-permission',
        title: 'Role & Permission',
        type: 'collapse',
        icon: icons.IconGitFork,
        isIcon: true,
        children: [
            {
                id: 'role',
                title: 'Role',
                type: 'item',
                url: '/role-permission/role',
                breadcrumbs: true,
                isIcon: false,
                target: false
            },
            {
                id: 'role-level',
                title: 'Role Level',
                type: 'item',
                url: '/role-permission/role-level',
                breadcrumbs: true,
                isIcon: false,
                target: false
            },
            {
                id: 'permission',
                title: 'Permission',
                type: 'collapse',
                icon: icons.IconGitFork,
                isIcon: true,
                children: [
                    {
                        id: 'permission-list',
                        title: 'Permission List',
                        type: 'item',
                        url: '/role-permission/permission/permission-list',
                        breadcrumbs: true,
                        isIcon: false,
                        target: false
                    },
                    {
                        id: 'permission-group',
                        title: 'Permission Group',
                        type: 'item',
                        url: '/role-permission/permission/permission-group',
                        breadcrumbs: true,
                        isIcon: false,
                        target: false
                    }
                ]
            },
            {
                id: 'restriction',
                title: 'Restriction',
                type: 'item',
                isIcon: false,
                url: '/role-permission/restriction',
                breadcrumbs: true,
                target: false
            }
        ]
    },
    {
        id: 'settings',
        title: 'Master Settings',
        type: 'collapse',
        isIcon: true,
        children: [
            {
                id: 'job-title',
                title: 'Job Title',
                type: 'item',
                url: '/settings/job-title',
                breadcrumbs: true,
                isIcon: false,
                target: false
            },
            {
                id: 'job-type',
                title: 'Job Type',
                type: 'item',
                url: '/settings/job-type',
                breadcrumbs: true,
                isIcon: false,
                target: false
            },
            {
                id: 'key-skill',
                title: 'Key Skill',
                type: 'item',
                url: '/settings/key-skill',
                breadcrumbs: true,
                isIcon: false,
                target: false
            },
            {
                id: 'status-master',
                title: 'Status Master',
                type: 'item',
                url: '/settings/status-master',
                breadcrumbs: true,
                isIcon: false,
                target: false
            },
            {
                id: 'industry',
                title: 'Industry',
                type: 'item',
                url: '/settings/industry',
                breadcrumbs: true,
                isIcon: false,
                target: false
            },
            {
                id: 'functional-area',
                title: 'Functional Area',
                type: 'item',
                url: '/settings/functional-area',
                breadcrumbs: true,
                isIcon: false,
                target: false
            },
            {
                id: 'education',
                title: 'Education',
                type: 'item',
                url: '/settings/education',
                breadcrumbs: true,
                isIcon: false,
                target: false
            },
            {
                id: 'shift-timing',
                title: 'Shift Timing',
                type: 'item',
                url: '/settings/shift-timing',
                breadcrumbs: true,
                isIcon: false,
                target: false
            },
            {
                id: 'location',
                title: 'Location',
                type: 'collapse',
                icon: icons.IconGitFork,
                isIcon: true,
                children: [
                    {
                        id: 'country',
                        title: 'Country',
                        type: 'item',
                        url: '/settings/location/country',
                        breadcrumbs: true,
                        isIcon: false,
                        target: false
                    },
                    {
                        id: 'state',
                        title: 'State',
                        type: 'item',
                        url: '/settings/location/state',
                        breadcrumbs: true,
                        isIcon: false,
                        target: false
                    },
                    {
                        id: 'city',
                        title: 'City',
                        type: 'item',
                        url: '/settings/location/city',
                        breadcrumbs: true,
                        isIcon: false,
                        target: false
                    }
                ]
            }
        ]
    }
];

const other = {
    id: 'main-menu',
    type: 'group',
    children: menuItems
};

export default other;
