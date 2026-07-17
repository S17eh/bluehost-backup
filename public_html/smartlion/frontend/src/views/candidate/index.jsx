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
import { candidateViewApi } from 'apis/Candidate';
import useAuth from 'hooks/useAuth';
import { useEffect } from 'react';
import { useState } from 'react';
import { gridSpacing } from 'store/constant';
import MainCard from 'ui-component/cards/MainCard';
import Transitions from 'ui-component/extended/Transitions';
import CommonDialog from 'utils/CommonDialog';
import { apiErrorSnackBar } from 'utils/SnackBar';
import AddEditCandidate from './AddEditCandidate';
import CandidateList from './CandidateList';

const initialFilter = {
    filterSource: '',
    filterCurrentSkill: [],
    filterNoticePeriod: '',
    filterGender: '',
    filterStatus: ''
};

const status = [{ label: 'Active' }, { label: 'Inactive' }];
const Gender = ['Male', 'Female', 'Other'];

const Index = () => {
    const theme = useTheme();
    const { checkRestriction } = useAuth();
    const [search, setSearch] = useState('');
    const [callApi, setCallApi] = useState(false);
    const [openAdd, setOpenAdd] = useState(false);
    const [initData, setInitData] = useState([]);
    const [filterOpen, setFilterOpen] = useState(false);
    const [filter, setFilter] = useState(initialFilter);

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

    useEffect(() => {
        candidateViewApi()
            .then((res) => {
                setInitData(res.data.data.initData);
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    }, []);

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
                                    <Typography variant="column">Candidate List</Typography>
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

                                {checkRestriction('CAN_ADD_CANDIDATE') && (
                                    <Grid item>
                                        <Button variant="contained" onClick={() => addData()}>
                                            <AddCircleOutlineOutlined sx={{ mr: 0.5 }} /> Add Candidate
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
                                        label="Source"
                                        fullWidth
                                        id="filterSource"
                                        select
                                        value={filter.filterSource}
                                        onChange={(e) => handleFilter('filterSource', e.target.value)}
                                    >
                                        <MenuItem key={-1} value="">
                                            All
                                        </MenuItem>
                                        {initData.sourceFromList.map((val, idx) => (
                                            <MenuItem key={idx} value={val}>
                                                {val}
                                            </MenuItem>
                                        ))}
                                    </TextField>
                                </Grid>
                                <Grid item md={3} xs={12}>
                                    <TextField
                                        size="small"
                                        label="Notice Period"
                                        fullWidth
                                        id="filterNoticePeriod"
                                        select
                                        value={filter.filterNoticePeriod}
                                        onChange={(e) => handleFilter('filterNoticePeriod', e.target.value)}
                                    >
                                        <MenuItem key={-1} value="">
                                            All
                                        </MenuItem>
                                        {initData.noticePeriodList.map((val, idx) => (
                                            <MenuItem key={idx} value={val}>
                                                {val}
                                            </MenuItem>
                                        ))}
                                    </TextField>
                                </Grid>
                                <Grid item md={3} xs={12}>
                                    <TextField
                                        size="small"
                                        label="Gender"
                                        fullWidth
                                        id="filterGender"
                                        select
                                        value={filter.filterGender}
                                        onChange={(e) => handleFilter('filterGender', e.target.value)}
                                    >
                                        <MenuItem key={-1} value="">
                                            All
                                        </MenuItem>
                                        {Gender.map((val, idx) => (
                                            <MenuItem key={idx} value={val}>
                                                {val}
                                            </MenuItem>
                                        ))}
                                    </TextField>
                                </Grid>
                                {/* <Grid item md={3} xs={12}>
                                    <TextField
                                        size="small"
                                        label="Current Skill"
                                        fullWidth
                                        id="filterCurrentSkill"
                                        value={filter.filterCurrentSkill}
                                        onChange={(e) => handleFilter('filterCurrentSkill', e.target.value)}
                                    />
                                </Grid> */}
                                <Grid item md={3} xs={12}>
                                    <Autocomplete
                                        multiple
                                        size="small"
                                        label="Current Skill"
                                        fullWidth
                                        id="filterCurrentSkill"
                                        options={initData.key_skill ?? []}
                                        getOptionLabel={(option) => option.name}
                                        value={filter.filterCurrentSkill}
                                        onChange={(_, value) => handleFilter('filterCurrentSkill', value)}
                                        renderInput={(params) => <TextField {...params} label="Current Skill" />}
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
                <CandidateList search={search} callApi={callApi} filter={filter} />
            </MainCard>

            {openAdd && (
                <CommonDialog open={openAdd} title="Add Candidate" onClose={() => setOpenAdd((prevState) => !prevState)} id="addCandidate">
                    <AddEditCandidate formId="addCandidate" onSubmit={submitHandler} initDataSet={initData} />
                </CommonDialog>
            )}
        </>
    );
};

export default Index;
