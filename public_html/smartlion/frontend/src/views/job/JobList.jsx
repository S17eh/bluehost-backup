import { AttachFile, DeleteOutline, Edit as EditIcon, LaunchOutlined } from '@mui/icons-material';
import {
    IconButton,
    // MenuItem,
    Table,
    TableBody,
    TableCell,
    TableContainer,
    TableHead,
    TablePagination,
    TableRow,
    TableSortLabel,
    Typography
} from '@mui/material';
import { deleteJobApi, jobListApi, jobViewApi, UpdateJobAssignTo } from 'apis/Job';
import propTypes from 'prop-types';
import { useEffect, useState } from 'react';
import CommonDialog from 'utils/CommonDialog';
import { apiErrorSnackBar, apiSuccessSnackBar, apiValidationSnackBar } from 'utils/SnackBar';
import CenterDialog from 'views/utilities/CenterDialog';
import CustomTooltip from 'views/utilities/CustomTooltip';
import DeleteDialog from 'views/utilities/DeleteDialog';
import InlineText from 'views/utilities/InlineText';
import AddEditJob from './AddEditJob';
import AddRemoveCandidates from './jobCandidates/AddRemoveCandidates';
import ViewJob from './ViewJob';
import JobCandidates from './jobCandidates/index';
import useAuth from 'hooks/useAuth';

const params = {
    search: '',
    displayLength: 10,
    displayStart: 0,
    orderDir: 'ASC',
    orderColumn: 0,
    employer_id: '',
    position_title: '',
    title: '',
    type: '',
    work_mode: '',
    skill: [],
    work_experience: '',
    minimum_work_experience: '',
    maximum_work_experience: '',
    education: [],
    status: ''
};
const fixedArray = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30];

let recordsTotal = 0;

const JobList = ({ search, callApi, setEmployerList, employerList, filter, setCallInitApi }) => {
    const { checkRestriction } = useAuth();
    const [data, setData] = useState([]);
    const [page, setPage] = useState(0);
    const [rowsPerPage, setRowsPerPage] = useState(10);
    const [order, setOrder] = useState('asc');
    const [orderBy, setOrderBy] = useState('0');
    const [openView, setOpenView] = useState(false);
    const [openEdit, setOpenEdit] = useState(false);
    const [openDelete, setOpenDelete] = useState(false);
    const [jobData, setJobData] = useState({});
    const [initData, setInitData] = useState([]);
    const [userList, setUserList] = useState([]);
    const [openHire, setOpenHire] = useState(false);
    const [openList, setOpenList] = useState(false);

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

    const getData = () => {
        jobListApi(params)
            .then((res) => {
                recordsTotal = res.data.data.totalCount;
                setData(res.data.data.data);
                setEmployerList(res.data.data.employerList);
                setUserList(res.data.data.userList);
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };

    useEffect(() => {
        params.search = search;
        params.displayLength = rowsPerPage;
        params.displayStart = rowsPerPage * page;
        params.orderDir = order?.toUpperCase() ?? params.orderDir;
        params.orderColumn = Number(orderBy);
        params.employer_id = filter.employerFilter ?? params.employer_id;
        params.title = filter.filterTitle ?? params.title;
        params.type = filter.jobTypeFilter ?? params.type;
        params.work_mode = filter.filterWorkMode ?? params.work_mode;
        params.position_title = filter.filterPosition ?? params.position_title;
        params.skill = filter.filterKeySkill.map((i) => ('skill[]', i)) ?? params.skill;
        params.work_experience = filter.filterWorkExperience ?? params.work_experience;
        params.minimum_work_experience = filter.filterMinimumWorkExperience ?? params.minimum_work_experience;
        params.maximum_work_experience = filter.filterMaximumWorkExperience ?? params.maximum_work_experience;
        params.education = filter.filterEducation.map((i) => ('education[]', i.id)) ?? params.education;
        params.status = filter.filterStatus ?? params.status;
        getData();
    }, [page, rowsPerPage, order, orderBy, search, callApi, filter]);

    // ========== View ========== //
    const viewData = (row) => {
        jobViewApi({ type: 'view', id: row.id })
            .then((res) => {
                setInitData(res.data.data.job);
                setOpenView((prevState) => !prevState);
                setJobData(row);
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };

    // ========== Edit ========== //
    const editData = (row) => {
        jobViewApi({ type: 'edit', id: row.id })
            .then((res) => {
                setInitData(res.data.data);
                setJobData(res.data.data.job);
                setOpenEdit((prevState) => !prevState);
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };

    const submitHandler = () => {
        setOpenEdit((prevState) => !prevState);
        setCallInitApi((prevState) => !prevState);
        getData();
    };

    // ========== Delete ========== //
    const deleteData = (row) => {
        setOpenDelete(true);
        setJobData(row);
    };

    const deleteHandler = () => {
        deleteJobApi({ id: jobData.id })
            .then((res) => {
                if (res.data && res.data.status === 1) {
                    setPage(0);
                    getData();
                    setOpenDelete(false);
                    apiSuccessSnackBar(res);
                } else {
                    apiValidationSnackBar(res);
                }
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };

    // ========== Open Hire ========== //
    const hireHandler = (row) => {
        setJobData(row);
        if (row.has_candidate) {
            setOpenList(true);
        } else {
            setOpenHire(true);
        }
    };

    const changeAssign = (userData, row) => {
        UpdateJobAssignTo({ id: row.id, user_id: userData.id })
            .then((res) => {
                if (res.data && res.data.status === 1) {
                    getData();
                    apiSuccessSnackBar(res);
                } else {
                    apiValidationSnackBar(res);
                }
            })
            .catch((err) => apiErrorSnackBar(err));
    };

    return (
        <>
            <TableContainer>
                <Table>
                    <EnhancedTableHead order={order} orderBy={orderBy} onRequestSort={handleRequestSort} />
                    <TableBody>
                        {data.map((item, index) => (
                            <TableRow key={index}>
                                <TableCell align="left">
                                    {item.title}
                                    <Typography variant="body2">
                                        {item.job_type}
                                        <CustomTooltip
                                            title={`View Job`}
                                            Icon={
                                                <IconButton color="inherit" sx={{ p: '0 5px' }} onClick={() => viewData(item)}>
                                                    <LaunchOutlined sx={{ p: 0, width: 30 }} color="inherit" fontSize="small" />
                                                </IconButton>
                                            }
                                        />
                                    </Typography>
                                </TableCell>
                                <TableCell align="left">{item.employer_name}</TableCell>
                                <TableCell align="left">
                                    {item.start_date} To {item.end_date}
                                </TableCell>
                                <TableCell align="left">
                                    {item.position_title} : {item.no_of_position}
                                </TableCell>
                                <TableCell align="left">{item.status}</TableCell>
                                <TableCell align="left">
                                    <InlineText
                                        list={userList}
                                        selectedValue={item.assign_to == null ? '' : item.assign_to}
                                        width="90px"
                                        changeValue={(obj) => changeAssign(obj, item)}
                                    />
                                </TableCell>
                                <TableCell align="right">
                                    {checkRestriction('CAN_EDIT_JOB') && (
                                        <IconButton color="primary" component="label" onClick={() => editData(item)}>
                                            <EditIcon fontSize="small" />
                                        </IconButton>
                                    )}
                                    {checkRestriction('CAN_DELETE_JOB') && (
                                        <IconButton color="error" component="label" onClick={() => deleteData(item)}>
                                            <DeleteOutline fontSize="small" />
                                        </IconButton>
                                    )}
                                    {checkRestriction('CAN_VIEW_JOB_CANDIDATE_LIST') && (
                                        <IconButton color="secondary" component="label" onClick={() => hireHandler(item)}>
                                            <AttachFile fontSize="small" />
                                        </IconButton>
                                    )}
                                    {/* <Operations>
                                        <MenuItem>Assign Candidates</MenuItem>
                                    </Operations> */}
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

            {openView && (
                <CommonDialog
                    open={openView}
                    title={jobData['title']}
                    onClose={() => setOpenView((prevState) => !prevState)}
                    saveButton={true}
                >
                    <ViewJob data={initData} />
                </CommonDialog>
            )}

            {openEdit && (
                <CommonDialog
                    open={openEdit}
                    title="Edit Job"
                    onClose={() => {
                        setOpenEdit((prevState) => !prevState);
                        setCallInitApi((prevState) => !prevState);
                    }}
                    id="editJob"
                >
                    <AddEditJob
                        value={jobData}
                        formId="editJob"
                        employerList={employerList}
                        onSubmit={submitHandler}
                        initData={initData}
                        fixedArray={fixedArray}
                    />
                </CommonDialog>
            )}

            {openDelete && (
                <DeleteDialog
                    onDeleteHandler={deleteHandler}
                    onClose={() => setOpenDelete(false)}
                    open={openDelete}
                    dept="Job"
                    name={jobData['title']}
                />
            )}

            {openList && (
                <CenterDialog
                    title="Job Candidate List"
                    subTitle={`Job Code : ${jobData['job_code']} | ${jobData['title']}`}
                    open={openList}
                    onClose={() => {
                        setOpenList((prevState) => !prevState);
                        getData();
                    }}
                    saveButton={true}
                    sx={{
                        '&>div:nth-of-type(3)': {
                            '&>div': {
                                minWidth: { md: '60%', sm: '90%', xs: '90%' }
                            }
                        }
                    }}
                >
                    <JobCandidates jobData={jobData} />
                </CenterDialog>
            )}

            {openHire && (
                <CenterDialog
                    title="Select Job Candidates"
                    subTitle={`Job Code : ${jobData['job_code']} | ${jobData['title']}`}
                    open={openHire}
                    onClose={() => {
                        setOpenHire((prevState) => !prevState);
                        getData();
                    }}
                    saveButton={true}
                    sx={{
                        '&>div:nth-of-type(3)': {
                            '&>div': {
                                minWidth: { md: '60%', sm: '90%', xs: '90%' }
                            }
                        }
                    }}
                >
                    <AddRemoveCandidates jobData={jobData} />
                </CenterDialog>
            )}
        </>
    );
};

JobList.propTypes = {
    search: propTypes.string,
    callApi: propTypes.bool,
    setEmployerList: propTypes.func,
    employerList: propTypes.array,
    filter: propTypes.object
};

export default JobList;

function EnhancedTableHead({ order, orderBy, onRequestSort }) {
    const createSortHandler = (property) => () => {
        onRequestSort(property);
    };

    return (
        <TableHead>
            <TableRow>
                <TableCell key="Job Title">
                    <TableSortLabel active={orderBy === '0'} direction={orderBy === '0' ? order : 'asc'} onClick={createSortHandler('0')}>
                        Job Title
                    </TableSortLabel>
                </TableCell>
                <TableCell key="Employer">
                    <TableSortLabel active={orderBy === '1'} direction={orderBy === '1' ? order : 'asc'} onClick={createSortHandler('1')}>
                        Company
                    </TableSortLabel>
                </TableCell>
                <TableCell key="start_date">
                    <TableSortLabel active={orderBy === '2'} direction={orderBy === '2' ? order : 'asc'} onClick={createSortHandler('2')}>
                        Job Date
                    </TableSortLabel>
                </TableCell>
                <TableCell key="Position">
                    <TableSortLabel active={orderBy === '3'} direction={orderBy === '3' ? order : 'asc'} onClick={createSortHandler('3')}>
                        Position
                    </TableSortLabel>
                </TableCell>
                <TableCell key="status">
                    <TableSortLabel active={orderBy === '4'} direction={orderBy === '4' ? order : 'asc'} onClick={createSortHandler('4')}>
                        Status
                    </TableSortLabel>
                </TableCell>
                <TableCell>Assign To</TableCell>
                <TableCell align="right">Action</TableCell>
            </TableRow>
        </TableHead>
    );
}

EnhancedTableHead.propTypes = {
    order: propTypes.string,
    orderBy: propTypes.string,
    onRequestSort: propTypes.func
};
