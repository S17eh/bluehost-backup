import { Button, Grid, InputAdornment, OutlinedInput, Typography } from '@mui/material';
import { IconSearch } from '@tabler/icons';
import { useState, useTransition } from 'react';
import { gridSpacing } from 'store/constant';
import MainCard from 'ui-component/cards/MainCard';
import CommonDialog from 'utils/CommonDialog';
import AddEditEducation from './AddEditEducation';
import EducationList from './EducationList';
import { AddCircleOutlineOutlined } from '@mui/icons-material';
import { EducationListApi } from 'apis/Setting';
import { apiErrorSnackBar } from 'utils/SnackBar';
import { useEffect } from 'react';
import useAuth from 'hooks/useAuth';

const params = {
    search: '',
    displayLength: 10,
    displayStart: 0,
    orderDir: 'ASC',
    orderColumn: 0
};

const Index = () => {
    const { checkRestriction } = useAuth();
    const [search, setSearch] = useState('');
    const [callApi, setCallApi] = useState(false);
    const [, startTransition] = useTransition();
    const [openAdd, setOpenAdd] = useState(false);
    const [initData, setInitData] = useState({});

    const submitHandler = () => {
        setOpenAdd((prevState) => !prevState);
        setCallApi((prevState) => !prevState);
    };

    const addData = () => {
        setOpenAdd((prevState) => !prevState);
    };

    const handleSearch = (event) => {
        startTransition(() => setSearch(event.target.value));
    };

    // useEffect(() => {
    //     EducationListApi(params)
    //         .then((res) => {
    //             setInitData(res.data.data);
    //         })
    //         .catch((err) => {
    //             apiErrorSnackBar(err);
    //         });
    // }, []);

    return (
        <>
            <MainCard
                title={
                    <Grid container spacing={gridSpacing} sx={{ mb: -1, mt: -4 }}>
                        <Grid item xs={12}>
                            <Grid container spacing={gridSpacing}>
                                <Grid item sx={{ flexGrow: 1 }}>
                                    <Typography variant="column">Education List</Typography>
                                </Grid>
                                {checkRestriction('CAN_ADD_EDUCATION') && (
                                    <Grid item>
                                        <Button variant="contained" onClick={() => addData()}>
                                            <AddCircleOutlineOutlined sx={{ mr: 0.5 }} /> Add Education
                                        </Button>
                                    </Grid>
                                )}
                                <Grid item>
                                    <OutlinedInput
                                        id="input-search-list-style1"
                                        placeholder="Search"
                                        startAdornment={
                                            <InputAdornment position="start">
                                                <IconSearch stroke={1.5} size="1rem" />
                                            </InputAdornment>
                                        }
                                        size="small"
                                        onChange={handleSearch}
                                        autoComplete="off"
                                    />
                                </Grid>
                            </Grid>
                        </Grid>
                    </Grid>
                }
                content={true}
            >
                <EducationList search={search} callApi={callApi} initData={initData} setInitData={setInitData} />
            </MainCard>
            {openAdd && (
                <CommonDialog open={openAdd} title="Add Education" onClose={() => setOpenAdd((prevState) => !prevState)} id="addEducation">
                    <AddEditEducation formId="addEducation" onSubmit={submitHandler} initData={initData} />
                </CommonDialog>
            )}
        </>
    );
};

export default Index;
