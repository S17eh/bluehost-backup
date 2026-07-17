import { AddCircleOutlineOutlined, ArrowCircleDownOutlined, ArrowCircleUpOutlined, FilterAlt } from '@mui/icons-material';
import { Button, ButtonBase, Grid, InputAdornment, MenuItem, OutlinedInput, TextField, Typography, useTheme } from '@mui/material';
import { IconSearch } from '@tabler/icons';
import useAuth from 'hooks/useAuth';
import { useState } from 'react';
import { gridSpacing } from 'store/constant';
import MainCard from 'ui-component/cards/MainCard';
import CommonDialog from 'utils/CommonDialog';
import AddEditUser from './AddEditUser';
import UserList from './UserList';
import { useLocation } from 'react-router-dom';
import Transitions from 'ui-component/extended/Transitions';
import { ExportUserApi, ImportUserApi, UserViewApi } from 'apis/User';
import CenterDialog from 'views/utilities/CenterDialog';
import ImportUser from './ImportUser';

const initialFilter = {
    filterName: '',
    filterUserName: '',
    filterEmail: '',
    filterCountry: '',
    filterStatus: ''
};

const status = [{ label: 'Active' }, { label: 'Inactive' }];

const User = () => {
    const theme = useTheme();
    const location = useLocation();
    const { checkRestriction } = useAuth();
    const [search, setSearch] = useState('');
    const [roleList, setRoleList] = useState([]);
    const [openAdd, setOpenAdd] = useState(false);
    const [callApi, setCallApi] = useState(false);
    const [importOpen, setImportOpen] = useState(false);
    const [importData, setImportData] = useState({});
    const [filterOpen, setFilterOpen] = useState(false);
    const [filter, setFilter] = useState(initialFilter);
    const [initData, setInitData] = useState({});

    const employer = location.state?.employerData ?? '';

    const addData = () => {
        UserViewApi({ type: 'add' })
            .then((res) => {
                setInitData(res.data.data);
                setOpenAdd((prevState) => !prevState);
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };

    const handleSearch = (event) => {
        setSearch(event.target.value);
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

    const exportUserHandler = () => {
        ExportUserApi()
            .then((res) => {
                const a = document.createElement('a');
                a.href = res.data.data.file_base64;
                a.download = res.data.data.file_name;
                a.click();
            })
            .catch((err) => {
                console.log(err);
            });
    };

    const fileHandler = (event) => {
        const obj = { file: event.currentTarget.files[0] };
        ImportUserApi(obj)
            .then((res) => {
                setImportOpen((prevState) => !prevState);
                setImportData(res.data.data);
            })
            .catch((err) => console.error(err));
    };

    const importSubmitHandler = () => {
        setImportOpen((prevState) => !prevState);
        setImportData([]);
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
                                    <Typography variant="column">{employer && employer.name} Users List</Typography>
                                </Grid>
                                {/* Import & Export User menu */}
                                {checkRestriction('CAN_IMPORT_USER') && (
                                    <Grid item>
                                        <Button variant="outlined" component="label">
                                            <ArrowCircleDownOutlined sx={{ mr: 0.5 }} /> Import
                                            <TextField
                                                sx={{ display: 'none' }}
                                                type="file"
                                                size="small"
                                                inputProps={{
                                                    accept: '.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel'
                                                }}
                                                onChange={(event) => {
                                                    fileHandler(event);
                                                }}
                                            />
                                        </Button>
                                    </Grid>
                                )}
                                {checkRestriction('CAN_EXPORT_USER') && (
                                    <Grid item>
                                        <Button variant="outlined" onClick={exportUserHandler}>
                                            <ArrowCircleUpOutlined sx={{ mr: 0.5 }} /> Export
                                        </Button>
                                    </Grid>
                                )}
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
                                {checkRestriction('CAN_ADD_USER') && !employer && (
                                    <Grid item>
                                        <Button variant="contained" onClick={() => addData()}>
                                            <AddCircleOutlineOutlined sx={{ mr: 0.5 }} /> Add User
                                        </Button>
                                    </Grid>
                                )}
                                {/* <Grid item>
                                    <FormControl size="small" sx={{ minWidth: '100px' }}>
                                        <InputLabel id="employer">Employers</InputLabel>
                                        <Select
                                            fullWidth
                                            labelId="employer"
                                            id="employer"
                                            label="Employers"
                                            defaultValue="0"
                                            onChange={(e) => {
                                                setEmployerFilter(e.target.value);
                                            }}
                                        >
                                            <MenuItem value="0">Select</MenuItem>
                                        </Select>
                                    </FormControl>
                                </Grid> */}

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
                                        id="filterName"
                                        value={filter.filterName}
                                        onChange={(e) => handleFilter('filterName', e.target.value)}
                                    />
                                </Grid>
                                <Grid item md={3} xs={12}>
                                    <TextField
                                        size="small"
                                        label="Username"
                                        fullWidth
                                        id="filterUserName"
                                        value={filter.filterUserName}
                                        onChange={(e) => handleFilter('filterUserName', e.target.value)}
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
                                        label="Country"
                                        fullWidth
                                        id="filterCountry"
                                        value={filter.filterCountry}
                                        onChange={(e) => handleFilter('filterCountry', e.target.value)}
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
                <UserList
                    search={search}
                    callApi={callApi}
                    setRoleList={setRoleList}
                    roleList={roleList}
                    employerId={employer && employer.id}
                    filter={filter}
                    setInitData={setInitData}
                    initData={initData}
                />
            </MainCard>

            {importOpen && (
                <CenterDialog
                    open={importOpen}
                    title="Import User"
                    onClose={() => setImportOpen((prevState) => !prevState)}
                    id="importUser"
                    sx={{
                        '&>div:nth-of-type(3)': {
                            '&>div': {
                                minWidth: { md: '70%', xs: '90%' }
                            }
                        }
                    }}
                >
                    <ImportUser formId="importUser" importData={importData} onSubmit={importSubmitHandler} />
                </CenterDialog>
            )}

            {openAdd && (
                <CommonDialog open={openAdd} title="Add User" onClose={() => setOpenAdd((prevState) => !prevState)} id="addUser">
                    <AddEditUser formId="addUser" onSubmit={submitHandler} roleList={roleList} initData={initData} />
                </CommonDialog>
            )}
        </>
    );
};
export default User;
