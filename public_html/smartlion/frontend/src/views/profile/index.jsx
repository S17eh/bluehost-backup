import { AccountCircleTwoTone, LockTwoTone } from '@mui/icons-material';
import NoteAddTwoToneIcon from '@mui/icons-material/NoteAddTwoTone';
import { Box, Grid, Tab, Tabs } from '@mui/material';
import { useState } from 'react';
import { gridSpacing } from 'store/constant';
import MainCard from 'ui-component/cards/MainCard';
import ChangePassword from './ChangePassword';
import Documents from './Documents';
import { ProfileDetails } from './ProfileDetails';

const Index = () => {
    const [currentTab, setCurrentTab] = useState('profile');
    const handleChangeTab = (newValue) => {
        setCurrentTab(newValue);
    };
    const PROFILE_TABS = [
        {
            label: 'Profile',
            value: 'profile',
            icon: <AccountCircleTwoTone fontSize="small" />,
            component: <ProfileDetails />,
            display: 'both'
        },
        {
            label: 'Change Password',
            value: 'change_password',
            icon: <LockTwoTone fontSize="small" />,
            component: <ChangePassword />,
            display: 'edit'
        },
        {
            label: 'Document',
            value: 'document',
            icon: <NoteAddTwoToneIcon fontSize="small" />,
            component: <Documents />,
            display: 'edit'
        }
    ];
    return (
        <>
            <MainCard
                title={
                    <Grid container alignItems="center" spacing={gridSpacing} sx={{ mb: -1, mt: -4 }}>
                        <Grid item xs={12}>
                            <Tabs
                                value={currentTab}
                                scrollButtons="auto"
                                variant="scrollable"
                                // allowScrollButtonsMobile
                                onChange={(e, val) => handleChangeTab(val)}
                                TabIndicatorProps={{ style: { bottom: '10px' } }}
                                sx={{ marginTop: '-20px', marginBottom: '-28px' }}
                            >
                                {PROFILE_TABS.map((tab) => (
                                    <Tab
                                        disableRipple
                                        key={tab.value}
                                        value={tab.value}
                                        icon={tab.icon}
                                        label={tab.label}
                                        iconPosition="start"
                                    />
                                ))}
                            </Tabs>
                        </Grid>
                    </Grid>
                }
                content={true}
            >
                {PROFILE_TABS.map((tab) => {
                    const isMatched = tab.value === currentTab;
                    return isMatched && <Box key={tab.value}>{tab.component}</Box>;
                })}
            </MainCard>
        </>
    );
};

export default Index;
