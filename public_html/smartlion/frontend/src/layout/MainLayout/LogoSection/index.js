import { Link } from 'react-router-dom';

// material-ui
import { ButtonBase } from '@mui/material';

// project imports
import config from 'config';
import Logo from 'ui-component/Logo';
import Logo1 from 'assets/images/logo.png';

// ==============================|| MAIN LOGO ||============================== //

const LogoSection = () => (
    <ButtonBase disableRipple component={Link} to={config.defaultPath}>
        {/* <Logo /> */}
        <img src={Logo1} alt="logo" height="45" />
    </ButtonBase>
);

export default LogoSection;
