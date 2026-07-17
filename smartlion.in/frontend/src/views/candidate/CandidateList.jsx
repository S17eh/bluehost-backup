import { DeleteOutline, Edit as EditIcon, LaunchOutlined } from '@mui/icons-material';
import {
    Avatar,
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
import { candidateEditDataApi, candidateListApi, deleteCandidateApi } from 'apis/Candidate';
import useAuth from 'hooks/useAuth';
import propTypes from 'prop-types';
import { useEffect, useState } from 'react';
import CommonDialog from 'utils/CommonDialog';
import { apiErrorSnackBar } from 'utils/SnackBar';
import CustomTooltip from 'views/utilities/CustomTooltip';
import DeleteDialog from 'views/utilities/DeleteDialog';
import AddEditCandidate from './AddEditCandidate';
import ViewCandidate from './ViewCandidate';

const params = {
    search: '',
    displayLength: 10,
    displayStart: 0,
    orderDir: 'ASC',
    orderColumn: 0,
    current_skill: [],
    source: '',
    notice_period: '',
    gender: '',
    status: ''
};
let recordsTotal = 0;
const CandidateList = ({ search, callApi, filter }) => {
    const { checkRestriction } = useAuth();
    const [data, setData] = useState([]);
    const [page, setPage] = useState(0);
    const [rowsPerPage, setRowsPerPage] = useState(10);
    const [order, setOrder] = useState('asc');
    const [orderBy, setOrderBy] = useState('0');
    const [openEdit, setOpenEdit] = useState(false);
    const [openDelete, setOpenDelete] = useState(false);
    const [openView, setOpenView] = useState(false);
    const [candidateData, setCandidateData] = useState({});
    const [candidateViewData, setCandidateViewData] = useState({});
    const [initData, setInitData] = useState([]);

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

    // ========== List ========== //
    const getData = () => {
        candidateListApi(params)
            .then((res) => {
                recordsTotal = res.data.data.totalCount;
                setData(res.data.data.data);
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
        params.current_skill = filter.filterCurrentSkill.map((i) => ('current_skill[]', i.name)) ?? params.current_skill;
        params.source = filter.filterSource ?? params.source;
        params.notice_period = filter.filterNoticePeriod ?? params.notice_period;
        params.gender = filter.filterGender ?? params.gender;
        params.status = filter.filterStatus ?? params.status;
        getData();
    }, [page, rowsPerPage, order, orderBy, search, callApi]);

    // ========== Edit ========== //

    const editData = (row) => {
        candidateEditDataApi({ id: row.id })
            .then((res) => {
                setCandidateData(res.data.data.candidateData);
                setInitData(res.data.data.initData);
                setOpenEdit((prevState) => !prevState);
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };

    const submitHandler = () => {
        setOpenEdit((prevState) => !prevState);
        getData();
    };

    // ========== Delete ========== //
    const deleteData = (row) => {
        setOpenDelete(true);
        setCandidateData(row);
    };

    const deleteHandler = () => {
        deleteCandidateApi({ id: candidateData.id })
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

    // ===== view Data ===== //
    const viewData = (row) => {
        candidateEditDataApi({ id: row.id })
            .then((res) => {
                setCandidateViewData(res.data.data.candidateData);
                setOpenView((prevState) => !prevState);
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
                        {data.length > 0 &&
                            data.map((item, idx) => (
                                <TableRow hover key={idx}>
                                    <TableCell align="left">
                                        <div style={{ display: 'flex', alignItems: 'center' }}>
                                            <Avatar alt={item.full_name} src={item.profile_picture} sx={{ mr: '7px' }} />
                                            {item.full_name}
                                            <CustomTooltip
                                                title={`View Candidate`}
                                                Icon={
                                                    <IconButton color="inherit" onClick={() => viewData(item)}>
                                                        <LaunchOutlined sx={{ p: 0, width: 20 }} color="inherit" fontSize="small" />
                                                    </IconButton>
                                                }
                                            />
                                        </div>
                                    </TableCell>
                                    <TableCell align="left">{item.email}</TableCell>
                                    <TableCell align="left">{item.status}</TableCell>
                                    <TableCell align="right">
                                        {checkRestriction('CAN_EDIT_CANDIDATE') && (
                                            <IconButton color="primary" component="label" onClick={() => editData(item)}>
                                                <EditIcon fontSize="small" />
                                            </IconButton>
                                        )}
                                        {checkRestriction('CAN_DELETE_CANDIDATE') && (
                                            <IconButton color="error" component="label" onClick={() => deleteData(item)}>
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

            {openView && (
                <CommonDialog
                    open={openView}
                    title={candidateViewData['full_name']}
                    onClose={() => setOpenView((prevState) => !prevState)}
                    saveButton={true}
                >
                    <ViewCandidate data={candidateViewData} />
                </CommonDialog>
            )}

            {openEdit && (
                <CommonDialog
                    open={openEdit}
                    title="Edit Candidate"
                    onClose={() => setOpenEdit((prevState) => !prevState)}
                    id="editCandidate"
                >
                    <AddEditCandidate value={candidateData} formId="editCandidate" onSubmit={submitHandler} initDataSet={initData} />
                </CommonDialog>
            )}

            {openDelete && (
                <DeleteDialog
                    onDeleteHandler={deleteHandler}
                    onClose={() => setOpenDelete(false)}
                    open={openDelete}
                    dept="Candidate"
                    name={candidateData['full_name']}
                />
            )}
        </>
    );
};

CandidateList.propTypes = {
    search: propTypes.string,
    callApi: propTypes.bool
};

export default CandidateList;

function EnhancedTableHead({ order, orderBy, onRequestSort }) {
    const createSortHandler = (property) => () => {
        onRequestSort(property);
    };

    return (
        <TableHead>
            <TableRow>
                <TableCell key="full_name">
                    <TableSortLabel active={orderBy === '0'} direction={orderBy === '0' ? order : 'asc'} onClick={createSortHandler('0')}>
                        Name
                    </TableSortLabel>
                </TableCell>
                <TableCell key="email">
                    <TableSortLabel active={orderBy === '1'} direction={orderBy === '1' ? order : 'asc'} onClick={createSortHandler('1')}>
                        Email
                    </TableSortLabel>
                </TableCell>
                <TableCell key="status">
                    <TableSortLabel active={orderBy === '2'} direction={orderBy === '2' ? order : 'asc'} onClick={createSortHandler('2')}>
                        Status
                    </TableSortLabel>
                </TableCell>
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
