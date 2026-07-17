import PropTypes from 'prop-types';
import {
    Autocomplete,
    Checkbox,
    FormControlLabel,
    Grid,
    InputAdornment,
    OutlinedInput,
    Table,
    TableBody,
    TableCell,
    TableContainer,
    TableHead,
    TablePagination,
    TableRow,
    TableSortLabel,
    TextField
} from '@mui/material';
import { useState } from 'react';
import { useEffect } from 'react';
import { IconSearch } from '@tabler/icons';
import { useTransition } from 'react';
import { AddRemoveJobCandidatesApi, CandidatesForJobApi } from 'apis/Job';
import {
    apiErrorSnackBar,
    // apiSuccessSnackBar,
    apiValidationSnackBar
} from 'utils/SnackBar';

const params = {
    search: '',
    displayLength: 10,
    displayStart: 0,
    orderDir: 'ASC',
    orderColumn: 0
};
let recordsTotal = 0;
const AddRemoveCandidates = ({ jobData }) => {
    const JobID = jobData['id'];
    const JobKeySkill = jobData['skill'].split(',');

    const [page, setPage] = useState(0);
    const [rowsPerPage, setRowsPerPage] = useState(10);
    const [order, setOrder] = useState('asc');
    const [orderBy, setOrderBy] = useState('0');

    const [candidateList, setCandidateList] = useState([]);
    const [selectedCandidate, setSelectedCandidate] = useState([]);
    const [jobSkill, setJobSkill] = useState([]);

    const [, startTransition] = useTransition();
    const [callApi, setCallApi] = useState(true);
    const [skill, setSkill] = useState(JobKeySkill);
    const [currentSkill, setCurrentSkill] = useState('');
    const [search, setSearch] = useState('');
    const handleSearch = (event) => {
        startTransition(() => setSearch(event.target.value));
    };

    const handleChangePage = (event, newPage) => {
        setPage(newPage);
    };

    const handleChangeRowsPerPage = (event) => {
        setRowsPerPage(parseInt(event.target.value, 10));
        setPage(0);
    };

    const handleRequestSort = (property) => {
        const isAsc = orderBy === property && order === 'asc';
        setOrder(isAsc ? 'desc' : 'asc');
        setOrderBy(property);
    };

    useEffect(() => {
        params.search = search;
        params.displayLength = rowsPerPage;
        params.displayStart = rowsPerPage * page;
        params.orderDir = order?.toUpperCase() ?? params.orderDir;
        params.orderColumn = Number(orderBy);
        params.job_id = JobID;
        params.currentSkill = skill.map((i) => ('currentSkill[]', i));
        CandidatesForJobApi(params)
            .then((res) => {
                recordsTotal = res.data.data.candidate_list.totalCount;
                setCandidateList(res.data.data.candidate_list.data);
                const arr = selectedCandidate.concat(res.data.data.selected_candidate);
                arr.filter((item, index) => arr.indexOf(item) === index);
                setSelectedCandidate(arr);
                setJobSkill(res.data.data.key_skill);
            })
            .catch();
    }, [page, rowsPerPage, order, orderBy, search, skill, currentSkill, callApi]);

    const submitHandler = (row) => {
        AddRemoveJobCandidatesApi(row)
            .then((res) => {
                if (res.data && res.data.status === 1) {
                    // apiSuccessSnackBar(res);
                } else {
                    apiValidationSnackBar(res);
                }
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };

    const checkedHandler = (id) => {
        return selectedCandidate.includes(id.toString());
    };

    return (
        <>
            <Grid container spacing={2}>
                <Grid item xs={12} md={8}>
                    <Autocomplete
                        multiple
                        fullWidth
                        size="small"
                        id="key_skill"
                        name="key_skill"
                        options={jobSkill ?? []}
                        getOptionLabel={(option) => option.name}
                        value={jobSkill.filter((a) => skill.some((b) => b === a.name))}
                        renderInput={(params) => <TextField {...params} label="Key Skill" />}
                        onChange={(_, value) => {
                            setCallApi((prevState) => !prevState);
                            const obj = [];
                            value.map((i) => {
                                obj.push(i.name);
                            });

                            setSkill(obj);
                        }}
                    />
                </Grid>
                <Grid item xs={12} md={4}>
                    <OutlinedInput
                        fullWidth
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
                <Grid item xs={12}>
                    <TableContainer>
                        <Table size="small">
                            <EnhancedTableHead order={order} orderBy={orderBy} onRequestSort={handleRequestSort} />
                            <TableBody>
                                {candidateList.map((i, idx) => (
                                    <TableRow key={idx}>
                                        <TableCell>
                                            <FormControlLabel
                                                label={`${i.full_name} - ${i.email} | ${i.mobile_number}`}
                                                control={
                                                    <Checkbox
                                                        checked={checkedHandler(i.id)}
                                                        onClick={(e) => {
                                                            const checkObj = e.target.checked;
                                                            let apiObj = {};
                                                            if (!checkObj) {
                                                                apiObj = {
                                                                    job_id: JobID,
                                                                    candidate_id: i.id,
                                                                    action: 'remove'
                                                                };
                                                                setSelectedCandidate(selectedCandidate.filter((a) => a !== i.id));
                                                            } else {
                                                                apiObj = {
                                                                    job_id: JobID,
                                                                    candidate_id: i.id,
                                                                    action: 'add'
                                                                };
                                                                setSelectedCandidate((prev) => [...prev, i.id]);
                                                            }
                                                            submitHandler(apiObj);
                                                        }}
                                                    />
                                                }
                                            />
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    </TableContainer>
                    <TablePagination
                        rowsPerPageOptions={[10, 25, 50, 100]}
                        component="div"
                        count={Number(recordsTotal)}
                        rowsPerPage={rowsPerPage}
                        page={page}
                        onPageChange={handleChangePage}
                        onRowsPerPageChange={handleChangeRowsPerPage}
                    />
                </Grid>
            </Grid>
        </>
    );
};

AddRemoveCandidates.propTypes = {
    jobData: PropTypes.object
};

export default AddRemoveCandidates;

function EnhancedTableHead({ order, orderBy, onRequestSort }) {
    const createSortHandler = (property) => () => {
        onRequestSort(property);
    };

    return (
        <TableHead>
            <TableRow>
                <TableCell key="Candidate Name">
                    <TableSortLabel active={orderBy === '0'} direction={orderBy === '0' ? order : 'asc'} onClick={createSortHandler('0')}>
                        Candidate Names
                    </TableSortLabel>
                </TableCell>
            </TableRow>
        </TableHead>
    );
}

EnhancedTableHead.propTypes = {
    order: PropTypes.string,
    orderBy: PropTypes.string,
    onRequestSort: PropTypes.func
};
