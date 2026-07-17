import { Button, Grid, InputAdornment, OutlinedInput, Typography } from '@mui/material';
import { AddCircleOutlineOutlined as AddCircleOutlineOutlinedIcon } from '@mui/icons-material';
import { IconSearch } from '@tabler/icons';
import MainCard from 'ui-component/cards/MainCard';
import { gridSpacing } from 'store/constant';
import useAuth from 'hooks/useAuth';
import IndustryList from './IndustryList';
import { useState } from 'react';
import CommonDialog from 'utils/CommonDialog';
import AddEditIndustry from './AddEditIndustry';

const Index = () => {
    const { checkRestriction } = useAuth();
    const [search, setSearch] = useState('');
    const [callApi, setCallApi] = useState(false);
    const [openAdd, setOpenAdd] = useState(false);

    const addData = () => {
        setOpenAdd((prevState) => !prevState);
    };

    const handleSearch = (event) => {
        setSearch(event.target.value);
    };

    const submitHandler = () => {
        setOpenAdd((prevState) => !prevState);
        setCallApi((prevState) => !prevState);
    };

    return (
        <>
            <MainCard
                title={
                    <Grid container alignItems="center" spacing={gridSpacing} sx={{ mb: -1, mt: -4 }}>
                        <Grid item xs={12}>
                            <Grid container alignItems="center" spacing={gridSpacing}>
                                <Grid item sx={{ flexGrow: 1 }}>
                                    <Typography variant="column">Industry List</Typography>
                                </Grid>
                                {checkRestriction('CAN_ADD_INDUSTRY') && (
                                    <Grid item>
                                        <Button variant="contained" onClick={() => addData()}>
                                            <AddCircleOutlineOutlinedIcon sx={{ mr: 0.5 }} /> Add Industry
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
                <IndustryList search={search} callApi={callApi} />
            </MainCard>
            {openAdd && (
                <CommonDialog open={openAdd} title="Add Industry" onClose={() => setOpenAdd((prevState) => !prevState)} id="addIndustry">
                    <AddEditIndustry formId="addIndustry" onSubmit={submitHandler} />
                </CommonDialog>
            )}
        </>
    );
};

export default Index;
