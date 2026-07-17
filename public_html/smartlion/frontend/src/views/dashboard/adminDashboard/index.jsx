import { Grid } from '@mui/material';
import { DashboardApi } from 'apis/Dashboard';
import { useState } from 'react';
import { useEffect } from 'react';
import { gridSpacing } from 'store/constant';
import MonthlyRevenue from './MonthlyRevenue';
import PrimarySmallDarkCard from './smallCard/PrimarySmallDarkCard';
import SecondarySmallDarkCard from './smallCard/SecondarySmallDarkCard';

const initApiData = {
    totalCompanies: '0',
    totalOpenJobs: '0'
};
const Index = () => {
    const [isLoading, setLoading] = useState(true);
    useEffect(() => {
        DashboardApi()
            .then((res) => {
                initApiData.totalCompanies = res.data.data.total_company;
                initApiData.totalOpenJobs = res.data.data.total_open_job;
                setLoading(false);
            })
            .catch((err) => {
                console.error(err);
            });
    }, []);

    return (
        <Grid container spacing={gridSpacing}>
            <Grid item xs={12}>
                <Grid container spacing={gridSpacing}>
                    <Grid item lg={4} md={6} sm={6} xs={12}>
                        <PrimarySmallDarkCard isLoading={isLoading} title="Total Companies" count={initApiData.totalCompanies} />
                    </Grid>
                    <Grid item lg={4} md={6} sm={6} xs={12}>
                        <SecondarySmallDarkCard isLoading={isLoading} title="Total Active Job" count={initApiData.totalOpenJobs} />
                    </Grid>
                    {/* <Grid item lg={4} md={6} sm={6} xs={12}>
                        <PrimarySmallDarkCard isLoading={false} title="Total Companies" count={'5'} />
                    </Grid> */}
                </Grid>
            </Grid>
            <Grid item xs={12}>
                <Grid container spacing={gridSpacing}>
                    <Grid item md={6} sm={6} xs={12}>
                        <MonthlyRevenue />
                    </Grid>
                </Grid>
            </Grid>
        </Grid>
    );
};

export default Index;
