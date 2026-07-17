import { Button, Grid, InputAdornment, OutlinedInput, Typography } from '@mui/material';
import { IconSearch } from '@tabler/icons';
import { useState, useTransition } from 'react';
import { gridSpacing } from 'store/constant';
import MainCard from 'ui-component/cards/MainCard';
import CityList from './CityList';
import useAuth from 'hooks/useAuth';
import { AddCircleOutlineOutlined as AddCircleOutlineOutlinedIcon } from '@mui/icons-material';
import CommonDialog from 'utils/CommonDialog';
import AddEditCity from './AddEditCity';
import { AddEditCityApi } from 'apis/Location';
import { apiErrorSnackBar } from 'utils/SnackBar';

const Index = () => {
    const [search, setSearch] = useState('');
    const { checkRestriction } = useAuth();
    const [callApi, setCallApi] = useState(false);
    const [openAdd, setOpenAdd] = useState(false);
    const [countryData, setCountryData] = useState([]);

    const [, startTransition] = useTransition();

    const addData = () => {
        AddEditCityApi({ type: 'add' })
            .then((res) => {
                setCountryData(res.data.data.countryList);
                setOpenAdd((prevState) => !prevState);
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };

    const handleSearch = (event) => {
        startTransition(() => setSearch(event.target.value));
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
                                    <Typography variant="column">City List</Typography>
                                </Grid>
                                {checkRestriction('CAN_ADD_STATUS') && (
                                    <Grid item>
                                        <Button variant="contained" onClick={() => addData()}>
                                            <AddCircleOutlineOutlinedIcon sx={{ mr: 0.5 }} /> Add City
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
                <CityList search={search} callApi={callApi} />
            </MainCard>
            {openAdd && (
                <CommonDialog open={openAdd} title="Add City" onClose={() => setOpenAdd((prevState) => !prevState)} id="addCity">
                    <AddEditCity formId="addCity" onSubmit={submitHandler} countryData={countryData} />
                </CommonDialog>
            )}
        </>
    );
};

export default Index;
