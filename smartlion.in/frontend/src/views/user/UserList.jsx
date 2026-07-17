import propTypes from 'prop-types';
import { DeleteOutline, Edit as EditIcon, LaunchOutlined } from '@mui/icons-material';
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
import { deleteUserApi, userListApi, UserViewApi } from 'apis/User';
import { useEffect, useState } from 'react';
import CommonDialog from 'utils/CommonDialog';
import AddEditUser from './AddEditUser';
import DeleteDialog from 'views/utilities/DeleteDialog';
import { apiErrorSnackBar, apiSuccessSnackBar, apiValidationSnackBar } from 'utils/SnackBar';
import useAuth from 'hooks/useAuth';
import CustomTooltip from 'views/utilities/CustomTooltip';
import ViewUser from './ViewUser';

const params = {
    search: '',
    displayLength: 10,
    displayStart: 0,
    orderDir: 'ASC',
    orderColumn: 0,
    employer_id: '',
    name: '',
    username: '',
    email: '',
    country: '',
    status: ''
};
let recordsTotal = 0;
const UserList = ({ search, callApi, setRoleList, roleList, employerId, filter, setInitData, initData }) => {
    const { checkRestriction } = useAuth();
    const [data, setData] = useState([]); // set UserList in the state
    const [rowData, setRowData] = useState({});
    const [page, setPage] = useState(0);
    const [rowsPerPage, setRowsPerPage] = useState(10);
    const [order, setOrder] = useState('asc');
    const [orderBy, setOrderBy] = useState('0');
    const [openEdit, setOpenEdit] = useState(false);
    const [openDelete, setOpenDelete] = useState(false);
    const [openView, setOpenView] = useState(false);

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

    // ========= View ========== //
    const viewData = (itemData) => {
        setRowData(itemData);
        setOpenView((prevState) => !prevState);
    };

    const editData = (itemData) => {
        UserViewApi({ type: 'edit', id: itemData.id })
            .then((res) => {
                setInitData(res.data.data);
                setOpenEdit((prevState) => !prevState);
                setRowData(itemData);
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };
    const submitHandler = () => {
        setOpenEdit((prevState) => !prevState);
        getData();
    };

    const deleteData = (itemData) => {
        setOpenDelete(true);
        setRowData(itemData);
    };

    const deleteHandler = () => {
        deleteUserApi({ id: rowData.id })
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
        userListApi(params)
            .then((res) => {
                recordsTotal = res.data.data.totalCount;
                setData(res.data.data.data);
                setRoleList(res.data.data.roleList);
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };

    useEffect(() => {
        params.search = search;
        params.orderColumn = 0;
        params.displayLength = rowsPerPage;
        params.displayStart = rowsPerPage * page;
        params.orderDir = order?.toUpperCase() ?? params.orderDir;
        params.orderColumn = Number(orderBy);
        params.employer_id = employerId ?? params.employer_id;
        params.name = filter.filterName ?? params.name;
        params.username = filter.filterUserName ?? params.username;
        params.email = filter.filterEmail ?? params.email;
        params.country = filter.filterCountry ?? params.country;
        params.status = filter.filterStatus ?? params.status;
        getData();
        checkRestriction();
    }, [page, rowsPerPage, order, orderBy, search, callApi, employerId, filter]);

    return (
        <>
            <TableContainer>
                <Table>
                    <EnhancedTableHead order={order} orderBy={orderBy} onRequestSort={handleRequestSort} />
                    <TableBody>
                        {data.map((item, index) => (
                            <TableRow hover role="checkbox" key={index}>
                                <TableCell>
                                    {item.first_name + ' ' + item.last_name}
                                    <CustomTooltip
                                        title={`View Users`}
                                        Icon={
                                            <IconButton color="inherit" sx={{ p: '0 5px' }} onClick={() => viewData(item)}>
                                                <LaunchOutlined sx={{ p: 0, width: 30 }} color="inherit" fontSize="small" />
                                            </IconButton>
                                        }
                                    />
                                </TableCell>
                                <TableCell>{item.username}</TableCell>
                                <TableCell>{item.email}</TableCell>
                                <TableCell>{item.mobile_number}</TableCell>
                                <TableCell>{item.country_name}</TableCell>
                                <TableCell>{item.status}</TableCell>
                                <TableCell align={'right'}>
                                    {checkRestriction('CAN_EDIT_USER') && (
                                        <IconButton color="primary" component="label" onClick={() => editData(item)}>
                                            <EditIcon fontSize="small" />
                                        </IconButton>
                                    )}
                                    {checkRestriction('CAN_DELETE_USER') && (
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
                    title={rowData['first_name'] + ' ' + rowData['last_name']}
                    onClose={() => setOpenView((prevState) => !prevState)}
                    saveButton={true}
                >
                    <ViewUser data={rowData} onSubmit={deleteDocumentHandler} />
                </CommonDialog>
            )}

            {openEdit && (
                <CommonDialog open={openEdit} title="Edit User" onClose={() => setOpenEdit((prevState) => !prevState)} id="editUser">
                    <AddEditUser formId="editUser" value={rowData} onSubmit={submitHandler} roleList={roleList} initData={initData} />
                </CommonDialog>
            )}

            {openDelete && (
                <DeleteDialog
                    onDeleteHandler={deleteHandler}
                    onClose={() => setOpenDelete(false)}
                    open={openDelete}
                    dept="User"
                    name={rowData['first_name'] + ' ' + rowData['last_name']}
                />
            )}
        </>
    );
};

UserList.propTypes = {
    search: propTypes.string,
    callApi: propTypes.bool,
    setRoleList: propTypes.func,
    roleList: propTypes.array,
    employerId: propTypes.string,
    filter: propTypes.object,
    setInitData: propTypes.func,
    initData: propTypes.object
};

export default UserList;

function EnhancedTableHead({ order, orderBy, onRequestSort }) {
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
                <TableCell key="username">
                    <TableSortLabel active={orderBy === '1'} direction={orderBy === '1' ? order : 'asc'} onClick={createSortHandler('1')}>
                        Username
                    </TableSortLabel>
                </TableCell>
                <TableCell key="email">
                    <TableSortLabel active={orderBy === '2'} direction={orderBy === '2' ? order : 'asc'} onClick={createSortHandler('2')}>
                        Email
                    </TableSortLabel>
                </TableCell>
                <TableCell key="mobile_number">
                    <TableSortLabel active={orderBy === '3'} direction={orderBy === '3' ? order : 'asc'} onClick={createSortHandler('3')}>
                        Mobile Number
                    </TableSortLabel>
                </TableCell>
                <TableCell key="country_name">
                    <TableSortLabel active={orderBy === '4'} direction={orderBy === '4' ? order : 'asc'} onClick={createSortHandler('4')}>
                        Country
                    </TableSortLabel>
                </TableCell>
                <TableCell key="status">
                    <TableSortLabel active={orderBy === '5'} direction={orderBy === '5' ? order : 'asc'} onClick={createSortHandler('5')}>
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
