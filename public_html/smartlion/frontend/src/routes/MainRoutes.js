import { lazy } from 'react';

// project imports
import MainLayout from 'layout/MainLayout';
import Loadable from 'ui-component/Loadable';
import AuthGuard from 'utils/route-guard/AuthGuard';

// dashboard routing
const DashboardDefault = Loadable(lazy(() => import('views/dashboard')));
const Profile = Loadable(lazy(() => import('views/profile')));
const User = Loadable(lazy(() => import('views/user')));
const Employer = Loadable(lazy(() => import('views/employer')));
const Job = Loadable(lazy(() => import('views/job')));
const Candidate = Loadable(lazy(() => import('views/candidate')));
const Notification = Loadable(lazy(() => import('views/notification')));
const OrganizationChart = Loadable(lazy(() => import('views/reports/organizationChart/index')));
const Role = Loadable(lazy(() => import('views/role/index')));
const RoleLevel = Loadable(lazy(() => import('views/roleLevel/index')));
const Permission = Loadable(lazy(() => import('views/permission/index')));
const PermissionGroup = Loadable(lazy(() => import('views/permission/group/index')));
const Restriction = Loadable(lazy(() => import('views/restriction/index')));
const StatusMaster = Loadable(lazy(() => import('views/settings/status/index')));
const JobTitle = Loadable(lazy(() => import('views/settings/jobTitle/index')));
const JobType = Loadable(lazy(() => import('views/settings/jobType/index')));
const KeySkill = Loadable(lazy(() => import('views/settings/keySkill/index')));
const Industry = Loadable(lazy(() => import('views/settings/industry/index')));
const FunctionalArea = Loadable(lazy(() => import('views/settings/functionalArea/index')));
const ShiftTiming = Loadable(lazy(() => import('views/settings/shiftTiming/index')));
const Education = Loadable(lazy(() => import('views/settings/education/index')));
const Country = Loadable(lazy(() => import('views/settings/country/index')));
const State = Loadable(lazy(() => import('views/settings/state/index')));
const City = Loadable(lazy(() => import('views/settings/city/index')));

// ==============================|| MAIN ROUTING ||============================== //

const routeItems = [
    {
        id: 'dashboard',
        path: '/',
        element: <DashboardDefault />
    },
    {
        id: 'profile',
        path: '/profile',
        element: <Profile />
    },
    {
        id: 'user',
        path: 'user',
        element: <User />
    },
    {
        id: 'company',
        path: 'company',
        element: <Employer />
    },
    {
        id: 'job',
        path: 'job',
        element: <Job />
    },
    {
        id: 'candidate',
        path: 'candidate',
        element: <Candidate />
    },
    {
        id: 'notification',
        path: 'notification',
        element: <Notification />
    },
    {
        id: 'reports',
        path: 'reports',
        children: [
            {
                id: 'hierarchy-chart',
                path: 'hierarchy-chart',
                element: <OrganizationChart />
            }
        ]
    },
    {
        id: 'role-permission',
        path: 'role-permission',
        children: [
            {
                id: 'role',
                path: 'role',
                element: <Role />
            },
            {
                id: 'role-level',
                path: 'role-level',
                element: <RoleLevel />
            },
            {
                id: 'permission',
                path: 'permission',
                children: [
                    {
                        id: 'permission-list',
                        path: 'permission-list',
                        element: <Permission />
                    },
                    {
                        id: 'permission-group',
                        path: 'permission-group',
                        element: <PermissionGroup />
                    }
                ]
            },
            {
                id: 'restriction',
                path: 'restriction',
                element: <Restriction />
            }
        ]
    },
    {
        id: 'settings',
        path: 'settings',
        children: [
            {
                id: 'job-title',
                path: 'job-title',
                element: <JobTitle />
            },
            {
                id: 'job-type',
                path: 'job-type',
                element: <JobType />
            },
            {
                id: 'key-skill',
                path: 'key-skill',
                element: <KeySkill />
            },
            {
                id: 'industry',
                path: 'industry',
                element: <Industry />
            },
            {
                id: 'functional-area',
                path: 'functional-area',
                element: <FunctionalArea />
            },
            {
                id: 'education',
                path: 'education',
                element: <Education />
            },
            {
                id: 'shift-timing',
                path: 'shift-timing',
                element: <ShiftTiming />
            },
            {
                id: 'status-master',
                path: 'status-master',
                element: <StatusMaster />
            },
            {
                id: 'location',
                path: 'location',
                children: [
                    {
                        id: 'country',
                        path: 'country',
                        element: <Country />
                    },
                    {
                        id: 'state',
                        path: 'state',
                        element: <State />
                    },
                    {
                        id: 'city',
                        path: 'city',
                        element: <City />
                    }
                ]
            }
        ]
    }
];

// function setPermission(elem) {
//     const permissionData = ['dashboard', 'profile', 'user', 'employer', 'role', 'permission-list', 'permission-group', 'restriction'];
//     return elem.filter((item) => (item.children ? (item.children = setPermission(item.children)) : permissionData.includes(item.id)));
// }

const MainRoutes = {
    path: '/',
    element: (
        <AuthGuard>
            <MainLayout />
        </AuthGuard>
    ),
    children: routeItems
};

export default MainRoutes;
