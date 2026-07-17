import { useRoutes } from 'react-router-dom';

// routes
import MainRoutes from './MainRoutes';
import AuthenticationRoutes from './AuthenticationRoutes';
import useAuth from 'hooks/useAuth';
import { useSelector } from 'react-redux';
import Loadable from 'ui-component/Loadable';
import { lazy } from 'react';

// elements
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
const Education = Loadable(lazy(() => import('views/settings/education/index')));
const ShiftTiming = Loadable(lazy(() => import('views/settings/shiftTiming/index')));
const Country = Loadable(lazy(() => import('views/settings/country/index')));
const State = Loadable(lazy(() => import('views/settings/state/index')));
const City = Loadable(lazy(() => import('views/settings/city/index')));

// ==============================|| ROUTING RENDER ||============================== //
// function setPermission(elem, permission) {
//     return elem.filter((item) =>
//         item.children ? (item.children = setPermission(item.children, permission)) : permission.includes(item.id)
//     );
// }

const routeElement = {
    dashboard: <DashboardDefault />,
    profile: <Profile />,
    user: <User />,
    company: <Employer />,
    job: <Job />,
    candidate: <Candidate />,
    notification: <Notification />,
    hierarchychart: <OrganizationChart />,
    role: <Role />,
    rolelevel: <RoleLevel />,
    permissionlist: <Permission />,
    permissiongroup: <PermissionGroup />,
    restriction: <Restriction />,
    jobtitle: <JobTitle />,
    jobtype: <JobType />,
    keyskill: <KeySkill />,
    statusmaster: <StatusMaster />,
    industry: <Industry />,
    functionalarea: <FunctionalArea />,
    education: <Education />,
    shifttiming: <ShiftTiming />,
    country: <Country />,
    state: <State />,
    city: <City />
};

export default function ThemeRoutes() {
    const { access } = useAuth();
    const menuSelector = useSelector((state) => state.menu);
    const defaultPermissions = menuSelector.permissions;
    const extraPermission = ['profile'];
    const userPermission = access && access.permissions ? [...access.permissions, ...extraPermission] : defaultPermissions;
    function checkPermission(object) {
        return object.filter((item) => {
            if (item.children) {
                if (checkPermission(item.children).length != 0) {
                    return (item.children = checkPermission(item.children));
                }
            } else {
                return userPermission.includes(item.id);
            }
        });
    }

    const objMenuRoutes = JSON.parse(JSON.stringify(MainRoutes));

    function addElement(object) {
        return object.map((item) => {
            if (item.element) {
                item.element = routeElement[item.id.replace('-', '')];
            }
            item.children && addElement(item.children);
        });
    }

    let routeByPermission = checkPermission(objMenuRoutes.children);
    addElement(objMenuRoutes.children);

    const NewMainRoutes = {
        path: MainRoutes.path,
        element: MainRoutes.element,
        children: routeByPermission
    };

    return useRoutes([NewMainRoutes, AuthenticationRoutes]);
}
