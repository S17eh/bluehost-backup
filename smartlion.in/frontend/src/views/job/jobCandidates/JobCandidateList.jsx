import { useState } from 'react';
import PropTypes from 'prop-types';
import {
    IconButton,
    Table,
    TableBody,
    TableCell,
    TableContainer,
    TableHead,
    TablePagination,
    TableRow,
    TableSortLabel
} from '@mui/material';
import { useEffect } from 'react';
import { AddRemoveJobCandidatesApi, JobCandidateListApi } from 'apis/Job';
import { DeleteOutline, Edit as EditIcon } from '@mui/icons-material';
import { apiErrorSnackBar, apiValidationSnackBar } from 'utils/SnackBar';
import DeleteDialog from 'views/utilities/DeleteDialog';
import CenterDialog from 'views/utilities/CenterDialog';
import JobCandidateStatus from './JobCandidateStatus';
import useAuth from 'hooks/useAuth';

const params = {
    search: '',
    job_id: '',
    displayLength: 10,
    displayStart: 0,
    orderDir: 'ASC',
    orderColumn: 0
};
let recordsTotal = 0;
const JobCandidateList = ({ search, callApi, jobData }) => {
    const JobID = jobData['id'];
    const { checkRestriction } = useAuth();
    const [data, setData] = useState([]);
    const [callListApi, setCallListApi] = useState(false);
    const [page, setPage] = useState(0);
    const [rowsPerPage, setRowsPerPage] = useState(10);
    const [order, setOrder] = useState('asc');
    const [orderBy, setOrderBy] = useState('0');
    const [openEdit, setOpenEdit] = useState(false);
    const [openDelete, setOpenDelete] = useState(false);
    const [jobCandidate, setJobCandidate] = useState({});
    const [jobStatus, setJobStatus] = useState([]);

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
        params.job_id = JobID;
        params.displayLength = rowsPerPage;
        params.displayStart = rowsPerPage * page;
        params.orderDir = order?.toUpperCase() ?? params.orderDir;
        params.orderColumn = Number(orderBy);
        JobCandidateListApi(params)
            .then((res) => {
                recordsTotal = res.data.data.totalCount;
                setData(res.data.data.data);
                setJobStatus(res.data.data.statusList);
            })
            .catch((err) => {
                console.error(err);
            });
    }, [page, rowsPerPage, order, orderBy, callListApi, search, callApi]);

    const editData = (row) => {
        setJobCandidate(row);
        setOpenEdit((prevState) => !prevState);
    };

    const submitHandler = () => {
        setOpenEdit((prevState) => !prevState);
        setCallListApi((prevState) => !prevState);
    };

    const deleteData = (row) => {
        setJobCandidate(row);
        setOpenDelete((prevState) => !prevState);
    };

    const deleteHandler = () => {
        const apiObj = {
            job_id: jobCandidate.job_id,
            candidate_id: jobCandidate.candidate_id,
            action: 'remove'
        };
        AddRemoveJobCandidatesApi(apiObj)
            .then((res) => {
                if (res.data && res.data.status === 1) {
                    setCallListApi((prevState) => !prevState);
                    setOpenDelete((prevState) => !prevState);
                } else {
                    apiValidationSnackBar(res);
                }
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };

    return (
        <>
            <TableContainer>
                <Table>
                    <EnhancedTableHead order={order} orderBy={orderBy} onRequestSort={handleRequestSort} />
                    <TableBody>
                        {data.map((i, idx) => (
                            <TableRow key={idx}>
                                <TableCell>{i.candidate_name}</TableCell>
                                <TableCell>{i.assignee_name}</TableCell>
                                <TableCell>{i.status_name}</TableCell>
                                <TableCell align="right">
                                    {checkRestriction('CAN_EDIT_JOB_CANDIDATE') && (
                                        <IconButton color="primary" component="label" onClick={() => editData(i)}>
                                            <EditIcon fontSize="small" />
                                        </IconButton>
                                    )}
                                    {checkRestriction('CAN_DELETE_JOB_CANDIDATE') && (
                                        <IconButton color="error" component="label" onClick={() => deleteData(i)}>
                                            <DeleteOutline fontSize="small" />
                                        </IconButton>
                                    )}
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

            {openEdit && (
                <CenterDialog
                    title={`Edit Job Candidates : ${jobCandidate['candidate_name']}`}
                    subTitle={`Job Code : ${jobData['job_code']} | ${jobData['title']}`}
                    open={openEdit}
                    onClose={() => {
                        setOpenEdit((prevState) => !prevState);
                        setCallListApi((prevState) => !prevState);
                    }}
                    sx={{
                        '&>div:nth-of-type(3)': {
                            '&>div': {
                                minWidth: { md: '50%', sm: '90%', xs: '90%' }
                            }
                        }
                    }}
                    id="editJobCandidate"
                >
                    <JobCandidateStatus formID={'editJobCandidate'} onSubmit={submitHandler} value={jobCandidate} statusList={jobStatus} />
                </CenterDialog>
            )}
            {openDelete && (
                <DeleteDialog
                    onDeleteHandler={deleteHandler}
                    onClose={() => setOpenDelete(false)}
                    open={openDelete}
                    dept="Job Candidate"
                    name={jobCandidate['candidate_name']}
                />
            )}
        </>
    );
};

JobCandidateList.propTypes = {
    search: PropTypes.string,
    callApi: PropTypes.bool,
    jobData: PropTypes.object
};

export default JobCandidateList;

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
                <TableCell key="Assigned By">
                    <TableSortLabel active={orderBy === '1'} direction={orderBy === '1' ? order : 'asc'} onClick={createSortHandler('1')}>
                        Assigned By
                    </TableSortLabel>
                </TableCell>
                <TableCell key="Status Name">
                    <TableSortLabel active={orderBy === '2'} direction={orderBy === '2' ? order : 'asc'} onClick={createSortHandler('2')}>
                        Status
                    </TableSortLabel>
                </TableCell>
                <TableCell key="Action" align="right">
                    Action
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
