// material-ui
import { Typography } from '@mui/material';

// project imports
import NavGroup from './NavGroup';
import menuItem from 'menu-items';
import { useSelector } from 'react-redux';
import useAuth from 'hooks/useAuth';
import {
    IconBellRinging,
    IconBrandChrome,
    IconBriefcase,
    IconBuilding,
    IconDashboard,
    IconGitFork,
    IconMapPin,
    IconReportAnalytics,
    IconUsers,
    IconSettings
} from '@tabler/icons';
const icons = {
    IconBellRinging,
    IconBrandChrome,
    IconBriefcase,
    IconBuilding,
    IconDashboard,
    IconGitFork,
    IconMapPin,
    IconReportAnalytics,
    IconUsers,
    IconSettings
};

// ==============================|| SIDEBAR MENU LIST ||============================== //

const menuIcons = {
    dashboard: icons.IconDashboard,
    user: icons.IconUsers,
    company: icons.IconBuilding,
    job: icons.IconBriefcase,
    candidate: icons.IconUsers,
    notification: icons.IconBellRinging,
    reports: icons.IconReportAnalytics,
    rolepermission: icons.IconGitFork,
    permission: icons.IconGitFork,
    settings: icons.IconSettings,
    location: icons.IconMapPin
};

const MenuList = () => {
    const { access } = useAuth();
    const menuReducer = useSelector((state) => state.menu);
    const defaultPermissions = menuReducer.permissions;
    const userPermission = access && access.permissions ? access.permissions : defaultPermissions;

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

    const objMenuItems = JSON.parse(JSON.stringify(menuItem.items));

    function addIcon(object) {
        return object.map((item) => {
            if (item.isIcon) {
                item.icon = menuIcons[item.id.replace('-', '')];
            }
            item.children && addIcon(item.children);
        });
    }

    let menuByPermission = objMenuItems.filter((b) => {
        return checkPermission(b.children);
    });
    menuByPermission.filter((b) => addIcon(b.children));

    let newArray = [];
    objMenuItems.map((item) => {
        newArray.push({
            id: item.id,
            type: item.type,
            children: checkPermission(item.children)
        });
    });

    const navItems = newArray.map((item) => {
        switch (item.type) {
            case 'group':
                return <NavGroup key={item.id} item={item} selectedMenu={menuReducer.selectedMenu} />;
            default:
                return (
                    <Typography key={item.id} variant="h6" color="error" align="center">
                        Menu Items Error
                    </Typography>
                );
        }
    });

    return <>{navItems}</>;
};

export default MenuList;
