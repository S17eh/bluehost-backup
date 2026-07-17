import propTypes from 'prop-types';
import {
    IconButton,
    MenuItem,
    Table,
    TableBody,
    TableCell,
    TableContainer,
    TableHead,
    TablePagination,
    TableRow,
    TableSortLabel
} from '@mui/material';
import { useState, useEffect } from 'react';
import CommonDialog from 'utils/CommonDialog';
import AddEditEmployer from './AddEditEmployer';
import { deleteEmployerApi, employerListApi } from 'apis/Employer';
import useAuth from 'hooks/useAuth';
import DeleteDialog from 'views/utilities/DeleteDialog';
import { apiErrorSnackBar, apiSuccessSnackBar, apiValidationSnackBar } from 'utils/SnackBar';
import Operations from 'views/utilities/Operations';
import AddEditEmployerUser from './AddEditEmployerUser';
import { useNavigate } from 'react-router-dom';
import { SELECTED_ITEM } from 'store/actions';
import { useDispatch } from 'react-redux';
import CustomTooltip from 'views/utilities/CustomTooltip';
import ViewEmployer from './ViewEmployer';
import { LaunchOutlined } from '@mui/icons-material';
import { UserViewApi } from 'apis/User';

const params = {
    search: '',
    displayLength: 10,
    displayStart: 0,
    orderDir: 'ASC',
    orderColumn: 0,
    company_name: '',
    email: '',
    mobile: '',
    status: ''
};

let recordsTotal = 0;
const EmployerList = ({ search, callApi, filter }) => {
    const navigate = useNavigate();
    const dispatch = useDispatch();
    const { checkRestriction } = useAuth();
    const [data, setData] = useState([]);
    const [initData, setInitData] = useState([]);
    const [page, setPage] = useState(0);
    const [rowsPerPage, setRowsPerPage] = useState(10);
    const [order, setOrder] = useState('asc');
    const [orderBy, setOrderBy] = useState('0');
    const [openAddUser, setOpenAddUser] = useState(false);
    const [openEdit, setOpenEdit] = useState(false);
    const [openDelete, setOpenDelete] = useState(false);
    const [openView, setOpenView] = useState(false);
    const [employerData, setEmployerData] = useState({});

    // check Restriction
    const canEdit = checkRestriction('CAN_EDIT_EMPLOYER');
    const canDelete = checkRestriction('CAN_DELETE_EMPLOYER');
    const canAddUser = checkRestriction('CAN_ADD_EMPLOYER_USER');
    const canViewUsers = checkRestriction('CAN_VIEW_EMPLOYER_USER');

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

    const addUser = (row) => {
        UserViewApi({ type: 'add' })
            .then((res) => {
                setInitData(res.data.data);
                setOpenAddUser((prevState) => !prevState);
                setEmployerData(row);
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };

    const userSubmitHandler = () => {
        setOpenAddUser((prevState) => !prevState);
        // getData();
    };

    const viewUsers = (row) => {
        navigate('/user', {
            replace: true,
            state: {
                employerData: {
                    id: row.id,
                    name: row.name
                }
            }
        });
        dispatch({ type: SELECTED_ITEM, selectedItem: 'user' });
    };

    const editData = (row) => {
        setOpenEdit((prevState) => !prevState);
        setEmployerData(row);
    };

    const submitHandler = () => {
        setOpenEdit((prevState) => !prevState);
        getData();
    };

    // ========= View ========== //
    const viewData = (row) => {
        setEmployerData(row);
        setOpenView((prevState) => !prevState);
    };

    // ========= Delete ========== //
    const deleteData = (row) => {
        setOpenDelete(true);
        setEmployerData(row);
    };

    const deleteHandler = () => {
        deleteEmployerApi({ id: employerData.id })
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

    const deleteDocumentHandler = () => {
        setPage(0);
        getData();
    };

    const getData = () => {
        employerListApi(params)
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
        params.company_name = filter.filterCompanyName ?? params.company_name;
        params.email = filter.filterEmail ?? params.email;
        params.mobile = filter.filterNumber ?? params.mobile;
        params.status = filter.filterStatus ?? params.status;
        getData();
    }, [page, rowsPerPage, order, orderBy, search, callApi]);

    return (
        <>
            <TableContainer>
                <Table>
                    <EnhancedTableHead
                        order={order}
                        orderBy={orderBy}
                        onRequestSort={handleRequestSort}
                        canEdit={canEdit}
                        canDelete={canDelete}
                        canAddUser={canAddUser}
                        canViewUsers={canViewUsers}
                    />
                    <TableBody>
                        {data.map((item, index) => (
                            <TableRow hover role="checkbox" key={index}>
                                <TableCell>
                                    {item.name}
                                    <CustomTooltip
                                        title={`View Employer`}
                                        Icon={
                                            <IconButton color="inherit" sx={{ p: '0 5px' }} onClick={() => viewData(item)}>
                                                <LaunchOutlined sx={{ p: 0, width: 30 }} color="inherit" fontSize="small" />
                                            </IconButton>
                                        }
                                    />
                                </TableCell>
                                <TableCell>{item.email}</TableCell>
                                <TableCell>{item.mobile_number}</TableCell>
                                <TableCell>{item.status}</TableCell>
                                {(canEdit || canDelete || canAddUser || canViewUsers) && (
                                    <TableCell align={'right'}>
                                        {/* <IconButton color="primary" component="label" onClick={() => editData(item)}>
                                        <EditIcon fontSize="small" />
                                    </IconButton>
                                    <IconButton color="error" component="label" onClick={() => deleteData(item)}>
                                        <DeleteOutline fontSize="small" />
                                    </IconButton> */}
                                        <Operations>
                                            {canEdit && <MenuItem onClick={() => editData(item)}>Edit</MenuItem>}
                                            {canDelete && <MenuItem onClick={() => deleteData(item)}>Delete</MenuItem>}
                                            {/* {canAddUser && <MenuItem onClick={() => addUser(item)}>Add User</MenuItem>} */}
                                            {canViewUsers && <MenuItem onClick={() => viewUsers(item)}>View Users</MenuItem>}
                                        </Operations>
                                    </TableCell>
                                )}
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
                    title={employerData['name']}
                    onClose={() => setOpenView((prevState) => !prevState)}
                    saveButton={true}
                >
                    <ViewEmployer data={employerData} onSubmit={deleteDocumentHandler} />
                </CommonDialog>
            )}

            {openEdit && (
                <CommonDialog open={openEdit} title="Edit Company" onClose={() => setOpenEdit((prevState) => !prevState)} id="editEmployer">
                    <AddEditEmployer formId="editEmployer" value={employerData} onSubmit={submitHandler} />
                </CommonDialog>
            )}

            {openAddUser && (
                <CommonDialog
                    open={openAddUser}
                    title="Add Company User"
                    onClose={() => setOpenAddUser((prevState) => !prevState)}
                    id="addEmployerUser"
                >
                    <AddEditEmployerUser
                        formId="addEmployerUser"
                        employerId={employerData['id']}
                        onSubmit={userSubmitHandler}
                        initData={initData}
                    />
                </CommonDialog>
            )}

            {openDelete && (
                <DeleteDialog
                    onDeleteHandler={deleteHandler}
                    onClose={() => setOpenDelete(false)}
                    open={openDelete}
                    dept="Employer"
                    name={employerData['name']}
                />
            )}
        </>
    );
};

EmployerList.propTypes = {
    search: propTypes.string,
    callApi: propTypes.bool,
    filter: propTypes.object
};

export default EmployerList;

function EnhancedTableHead({ order, orderBy, onRequestSort, canEdit, canDelete, canAddUser, canViewUsers }) {
    const createSortHandler = (property) => () => {
        onRequestSort(property);
    };

    return (
        <TableHead>
            <TableRow>
                <TableCell key="name">
                    <TableSortLabel active={orderBy === '0'} direction={orderBy === '0' ? order : 'asc'} onClick={createSortHandler('0')}>
                        Name
                    </TableSortLabel>
                </TableCell>
                <TableCell key="email">
                    <TableSortLabel active={orderBy === '1'} direction={orderBy === '1' ? order : 'asc'} onClick={createSortHandler('1')}>
                        Email
                    </TableSortLabel>
                </TableCell>
                <TableCell key="mobile">
                    <TableSortLabel active={orderBy === '2'} direction={orderBy === '2' ? order : 'asc'} onClick={createSortHandler('2')}>
                        Mobile
                    </TableSortLabel>
                </TableCell>
                <TableCell key="status">
                    <TableSortLabel active={orderBy === '3'} direction={orderBy === '3' ? order : 'asc'} onClick={createSortHandler('3')}>
                        Status
                    </TableSortLabel>
                </TableCell>
                {(canEdit || canDelete || canAddUser || canViewUsers) && <TableCell align="right">Action</TableCell>}
            </TableRow>
        </TableHead>
    );
}

EnhancedTableHead.propTypes = {
    order: propTypes.string,
    orderBy: propTypes.string,
    onRequestSort: propTypes.func,
    canEdit: propTypes.bool,
    canDelete: propTypes.bool,
    canAddUser: propTypes.bool,
    canViewUsers: propTypes.bool
};
