import { AddCircleOutlineOutlined as AddCircleOutlineOutlinedIcon, FilterAlt } from '@mui/icons-material';
import { Button, ButtonBase, Grid, InputAdornment, MenuItem, OutlinedInput, TextField, Typography, useTheme } from '@mui/material';
import { IconSearch } from '@tabler/icons';
import useAuth from 'hooks/useAuth';
import { useState } from 'react';
import { gridSpacing } from 'store/constant';
import MainCard from 'ui-component/cards/MainCard';
import Transitions from 'ui-component/extended/Transitions';
import CommonDialog from 'utils/CommonDialog';
import AddEditEmployer from './AddEditEmployer';
import EmployerList from './EmployerList';

const initialFilter = {
    filterCompanyName: '',
    filterNumber: '',
    filterEmail: '',
    filterStatus: ''
};

const status = [{ label: 'Active' }, { label: 'Inactive' }];

const Index = () => {
    const theme = useTheme();
    const { checkRestriction } = useAuth();
    const [search, setSearch] = useState('');
    const [openAdd, setOpenAdd] = useState(false);
    const [callApi, setCallApi] = useState(false);
    const [filterOpen, setFilterOpen] = useState(false);
    const [filter, setFilter] = useState(initialFilter);

    const canAdd = checkRestriction('CAN_ADD_EMPLOYER');

    const handleSearch = (event) => {
        setSearch(event.target.value);
    };

    const addData = () => {
        setOpenAdd((prevState) => !prevState);
    };

    const submitHandler = () => {
        setOpenAdd((prevState) => !prevState);
        setCallApi((prevState) => !prevState);
    };

    const openFilter = () => {
        setFilterOpen((prevState) => !prevState);
    };

    const handleFilter = (key, event) => {
        if (key !== 'reset') {
            const newString = event;
            setFilter({ ...filter, [key]: newString });
        } else {
            setFilter({ ...initialFilter });
        }
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
                                    <Typography variant="column">Company List</Typography>
                                </Grid>
                                <Grid item>
                                    <ButtonBase
                                        disableRipple
                                        onClick={() => {
                                            openFilter();
                                        }}
                                    >
                                        {JSON.stringify(filter) !== JSON.stringify(initialFilter) ? (
                                            <FilterAlt sx={{ fontWeight: 500, color: 'secondary.dark' }} />
                                        ) : (
                                            <FilterAlt sx={{ fontWeight: 500, color: 'secondary.200' }} />
                                        )}

                                        <Typography variant="h5" sx={{ mt: 0.5 }}>
                                            Filter
                                        </Typography>
                                    </ButtonBase>
                                </Grid>
                                {canAdd && (
                                    <Grid item>
                                        <Button variant="contained" onClick={() => addData()}>
                                            <AddCircleOutlineOutlinedIcon sx={{ mr: 0.5 }} /> Add Company
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
                {filterOpen ? (
                    <Transitions type="grow" in={filterOpen} position="top-left" direction="up">
                        <MainCard
                            content={false}
                            sx={{
                                padding: '20px',
                                background: theme.palette.mode === 'dark' ? theme.palette.dark.main : theme.palette.primary.light
                            }}
                        >
                            <Grid container spacing={gridSpacing}>
                                <Grid item md={3} xs={12}>
                                    <TextField
                                        size="small"
                                        label="Name"
                                        fullWidth
                                        id="filterCompanyName"
                                        value={filter.filterCompanyName}
                                        onChange={(e) => handleFilter('filterCompanyName', e.target.value)}
                                    />
                                </Grid>
                                <Grid item md={3} xs={12}>
                                    <TextField
                                        size="small"
                                        label="Email"
                                        fullWidth
                                        id="filterEmail"
                                        value={filter.filterEmail}
                                        onChange={(e) => handleFilter('filterEmail', e.target.value)}
                                    />
                                </Grid>
                                <Grid item md={3} xs={12}>
                                    <TextField
                                        size="small"
                                        label="Mobile"
                                        type="number"
                                        fullWidth
                                        id="filterNumber"
                                        value={filter.filterNumber}
                                        onChange={(e) => handleFilter('filterNumber', e.target.value)}
                                    />
                                </Grid>
                                <Grid item md={3} xs={12}>
                                    <TextField
                                        size="small"
                                        label="Status"
                                        fullWidth
                                        id="filterStatus"
                                        select
                                        value={filter.filterStatus}
                                        onChange={(e) => handleFilter('filterStatus', e.target.value)}
                                    >
                                        {status.map((i, idx) => (
                                            <MenuItem key={idx} value={i.label}>
                                                {i.label}
                                            </MenuItem>
                                        ))}
                                    </TextField>
                                </Grid>
                                {JSON.stringify(filter) !== JSON.stringify(initialFilter) ? (
                                    <Grid item>
                                        <Button variant="outlined" color="primary" onClick={() => handleFilter('reset', undefined)}>
                                            Clear All
                                        </Button>
                                    </Grid>
                                ) : null}
                            </Grid>
                        </MainCard>
                    </Transitions>
                ) : null}
                <EmployerList search={search} callApi={callApi} filter={filter} />
            </MainCard>

            {openAdd && (
                <CommonDialog open={openAdd} title="Add Company" onClose={() => setOpenAdd((prevState) => !prevState)} id="addEmployer">
                    <AddEditEmployer formId="addEmployer" onSubmit={submitHandler} />
                </CommonDialog>
            )}
        </>
    );
};

export default Index;
