import { AddCircleOutlineOutlined, FilterAlt } from '@mui/icons-material';
import {
    Autocomplete,
    Button,
    ButtonBase,
    Grid,
    InputAdornment,
    MenuItem,
    OutlinedInput,
    TextField,
    Typography,
    useTheme
} from '@mui/material';
import { IconSearch } from '@tabler/icons';
import { jobViewApi } from 'apis/Job';
import useAuth from 'hooks/useAuth';
import { useEffect, useMemo } from 'react';
import { useState } from 'react';
import { gridSpacing } from 'store/constant';
import MainCard from 'ui-component/cards/MainCard';
import Transitions from 'ui-component/extended/Transitions';
import CommonDialog from 'utils/CommonDialog';
import { apiErrorSnackBar } from 'utils/SnackBar';
import AddEditJob from './AddEditJob';
import JobList from './JobList';

const initialFilter = {
    filterTitle: '',
    filterPosition: '',
    jobTypeFilter: '',
    filterWorkMode: '',
    employerFilter: '',
    filterKeySkill: [],
    filterMinimumWorkExperience: '',
    filterMaximumWorkExperience: '',
    filterEducation: [],
    filterStatus: ''
};

const fixedArray = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30];

const Index = () => {
    const theme = useTheme();
    const { checkRestriction } = useAuth();
    const [search, setSearch] = useState('');
    const [openAdd, setOpenAdd] = useState(false);
    const [callApi, setCallApi] = useState(false);
    const [callInitApi, setCallInitApi] = useState(false);
    const [initData, setInitData] = useState([]);
    const [employerList, setEmployerList] = useState([]);
    const [filterOpen, setFilterOpen] = useState(false);
    const [filter, setFilter] = useState(initialFilter);
    const [maxExperienceArray, setMaxExperienceArray] = useState(fixedArray);
    const [minExperienceArray, setMinExperienceArray] = useState(fixedArray);

    const addData = () => {
        setOpenAdd((prevState) => !prevState);
    };

    useEffect(() => {
        jobViewApi({ type: 'add' })
            .then((res) => {
                setInitData(res.data.data);
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    }, [callInitApi]);

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

    const handleSearch = (event) => {
        setSearch(event.target.value);
    };

    const submitHandler = () => {
        setOpenAdd((prevState) => !prevState);
        setCallApi((prevState) => !prevState);
        setCallInitApi((prevState) => !prevState);
    };

    useMemo(() => {
        setMaxExperienceArray(fixedArray.filter((i) => filter.filterMinimumWorkExperience < i));
    }, [filter.filterMinimumWorkExperience]);

    useEffect(() => {
        filter.filterMaximumWorkExperience !== ''
            ? setMinExperienceArray(fixedArray.filter((i) => filter.filterMaximumWorkExperience > i))
            : setMinExperienceArray(fixedArray);
    }, [filter.filterMaximumWorkExperience]);

    return (
        <>
            <MainCard
                title={
                    <Grid container alignItems="center" spacing={gridSpacing} sx={{ mb: -1, mt: -4 }}>
                        <Grid item xs={12}>
                            <Grid container alignItems="center" spacing={gridSpacing}>
                                <Grid item sx={{ flexGrow: 1 }}>
                                    <Typography variant="column">Job List</Typography>
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
                                {checkRestriction('CAN_ADD_JOB') && (
                                    <Grid item>
                                        <Button variant="contained" onClick={() => addData()}>
                                            <AddCircleOutlineOutlined sx={{ mr: 0.5 }} /> Add Job
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
                                        label="Job Title"
                                        fullWidth
                                        id="filterTitle"
                                        value={filter.filterTitle}
                                        onChange={(e) => handleFilter('filterTitle', e.target.value)}
                                    />
                                </Grid>
                                <Grid item md={3} xs={12}>
                                    <TextField
                                        size="small"
                                        label="Job Type"
                                        fullWidth
                                        id="jobTypeFilter"
                                        select
                                        value={filter.jobTypeFilter}
                                        onChange={(e) => handleFilter('jobTypeFilter', e.target.value)}
                                    >
                                        <MenuItem key={-1} value="">
                                            All
                                        </MenuItem>
                                        {initData.job_type.map((val, idx) => (
                                            <MenuItem key={idx} value={val.id}>
                                                {val.name}
                                            </MenuItem>
                                        ))}
                                    </TextField>
                                </Grid>
                                <Grid item md={3} xs={12}>
                                    <TextField
                                        size="small"
                                        label="Work Mode"
                                        fullWidth
                                        id="filterWorkMode"
                                        select
                                        value={filter.filterWorkMode}
                                        onChange={(e) => handleFilter('filterWorkMode', e.target.value)}
                                    >
                                        <MenuItem key={-1} value="">
                                            All
                                        </MenuItem>
                                        {initData.work_mode.map((val, idx) => (
                                            <MenuItem key={idx} value={val}>
                                                {val}
                                            </MenuItem>
                                        ))}
                                    </TextField>
                                </Grid>
                                <Grid item md={3} xs={12}>
                                    <TextField
                                        size="small"
                                        label="Company"
                                        fullWidth
                                        id="employerFilter"
                                        select
                                        value={filter.employerFilter}
                                        onChange={(e) => handleFilter('employerFilter', e.target.value)}
                                    >
                                        <MenuItem key={-1} value="">
                                            All
                                        </MenuItem>
                                        {initData.employer_list.map((val, idx) => (
                                            <MenuItem key={idx} value={val.id}>
                                                {val.name}
                                            </MenuItem>
                                        ))}
                                    </TextField>
                                </Grid>
                                <Grid item md={3} xs={12}>
                                    <TextField
                                        size="small"
                                        label="Position"
                                        fullWidth
                                        id="filterPosition"
                                        value={filter.filterPosition}
                                        onChange={(e) => handleFilter('filterPosition', e.target.value)}
                                    />
                                </Grid>
                                <Grid item md={3} xs={12}>
                                    <Autocomplete
                                        multiple
                                        size="small"
                                        label="Key Skill"
                                        fullWidth
                                        id="filterKeySkill"
                                        options={initData.key_skill.map((o) => o.name)}
                                        value={filter.filterKeySkill}
                                        onChange={(_, value) => handleFilter('filterKeySkill', value)}
                                        renderInput={(params) => <TextField {...params} label="Key Skill" />}
                                    />
                                </Grid>
                                <Grid item md={3} xs={12}>
                                    <TextField
                                        size="small"
                                        label="Minimum Work Experience"
                                        fullWidth
                                        id="filterMinimumWorkExperience"
                                        select
                                        value={filter.filterMinimumWorkExperience}
                                        onChange={(e) => handleFilter('filterMinimumWorkExperience', e.target.value)}
                                    >
                                        <MenuItem key={-1} value="">
                                            All
                                        </MenuItem>
                                        {minExperienceArray.map((val, idx) => (
                                            <MenuItem key={idx} value={val}>
                                                {val}
                                            </MenuItem>
                                        ))}
                                    </TextField>
                                </Grid>
                                <Grid item md={3} xs={12}>
                                    <TextField
                                        size="small"
                                        label="Maximum Work Experience"
                                        fullWidth
                                        id="filterMaximumWorkExperience"
                                        select
                                        value={filter.filterMaximumWorkExperience}
                                        onChange={(e) => handleFilter('filterMaximumWorkExperience', e.target.value)}
                                    >
                                        <MenuItem key={-1} value="">
                                            All
                                        </MenuItem>
                                        {maxExperienceArray.map((val, idx) => (
                                            <MenuItem key={idx} value={val}>
                                                {val}
                                            </MenuItem>
                                        ))}
                                    </TextField>
                                </Grid>
                                <Grid item md={3} xs={12}>
                                    <Autocomplete
                                        multiple
                                        size="small"
                                        label="Education"
                                        fullWidth
                                        options={initData.education.sort((a, b) => (a.type === b.type ? 0 : a.type < b.type ? -1 : 1))}
                                        groupBy={(option) => option.type}
                                        getOptionLabel={(option) => option.name}
                                        id="filterEducation"
                                        value={filter.filterEducation}
                                        onChange={(_, value) => handleFilter('filterEducation', value)}
                                        renderInput={(params) => <TextField {...params} label="Education" />}
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
                                        <MenuItem value={'Active'}>Active</MenuItem>
                                        <MenuItem value={'Inactive'}>Inactive</MenuItem>
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
                <JobList
                    search={search}
                    callApi={callApi}
                    setEmployerList={setEmployerList}
                    employerList={employerList}
                    filter={filter}
                    setCallInitApi={setCallInitApi}
                />
            </MainCard>

            {openAdd && (
                <CommonDialog
                    open={openAdd}
                    title="Add Job"
                    onClose={() => {
                        setOpenAdd((prevState) => !prevState);
                        setCallInitApi((prevState) => !prevState);
                    }}
                    id="addJob"
                >
                    <AddEditJob
                        formId="addJob"
                        onSubmit={submitHandler}
                        employerList={employerList}
                        initData={initData}
                        fixedArray={fixedArray}
                    />
                </CommonDialog>
            )}
        </>
    );
};

export default Index;
