import propTypes from 'prop-types';
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
import { DeleteOutline, Edit as EditIcon, LaunchOutlined } from '@mui/icons-material';
import { useEffect, useState } from 'react';
import useAuth from 'hooks/useAuth';
import CommonDialog from 'utils/CommonDialog';
import DeleteDialog from 'views/utilities/DeleteDialog';
import AddEditIndustry from './AddEditIndustry';
import CustomTooltip from 'views/utilities/CustomTooltip';
import ViewIndustry from './ViewIndustry';
import { deleteIndustryApi, IndustryListApi } from 'apis/Industry';
import { apiErrorSnackBar, apiSuccessSnackBar, apiValidationSnackBar } from 'utils/SnackBar';

const params = {
    search: '',
    displayLength: 10,
    displayStart: 0,
    orderDir: 'ASC',
    orderColumn: 0
};

const IndustryList = ({ search, callApi }) => {
    const [order, setOrder] = useState('asc');
    const [orderBy, setOrderBy] = useState('0');
    const [rowsPerPage, setRowsPerPage] = useState(10);
    const [page, setPage] = useState(0);
    const [openEdit, setOpenEdit] = useState(false);
    const [openDelete, setOpenDelete] = useState(false);
    const [openView, setOpenView] = useState(false);
    const [industryData, setIndustryData] = useState({});
    const [data, setData] = useState([]);
    const { checkRestriction } = useAuth();

    let recordsTotal = 0;

    const submitHandler = (row) => {
        setOpenEdit((prevState) => !prevState);
        getData(row);
    };

    const getData = () => {
        IndustryListApi(params)
            .then((res) => {
                recordsTotal = res.data.data.totalCount;
                setData(res.data.data.data);
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };

    const handleChangeRowsPerPage = (event) => {
        setRowsPerPage(parseInt(event.target.value, 10));
        setPage(0);
    };

    const handleChangePage = (event, newPage) => {
        setPage(newPage);
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
        getData();
    }, [page, rowsPerPage, order, orderBy, search, callApi]);

    // ========= View ========== //
    const viewData = (row) => {
        setIndustryData(row);
        setOpenView((prevState) => !prevState);
    };

    // ========= Edit ========== //
    const editData = (row) => {
        setOpenEdit((prevState) => !prevState);
        setIndustryData(row);
    };

    // ========= Delete ========== //
    const deleteData = (row) => {
        setOpenDelete((prevState) => !prevState);
        setIndustryData(row);
    };

    const deleteHandler = () => {
        deleteIndustryApi({ id: industryData.id })
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

    return (
        <>
            <TableContainer>
                <Table>
                    <EnhancedTableHead order={order} orderBy={orderBy} onRequestSort={handleRequestSort} />
                    <TableBody>
                        {data.map((item, index) => (
                            <TableRow hover role="checkbox" key={index}>
                                <TableCell align="left">
                                    {item.name}
                                    <CustomTooltip
                                        title={`View Industry`}
                                        Icon={
                                            <IconButton color="inherit" sx={{ p: '0 5px' }} onClick={() => viewData(item)}>
                                                <LaunchOutlined sx={{ p: 0, width: 30 }} color="inherit" fontSize="small" />
                                            </IconButton>
                                        }
                                    />
                                </TableCell>
                                <TableCell align="left">{item.status}</TableCell>
                                <TableCell align="right">
                                    {checkRestriction('CAN_EDIT_INDUSTRY') && (
                                        <IconButton color="primary" component="label" onClick={() => editData(item)}>
                                            <EditIcon fontSize="small" />
                                        </IconButton>
                                    )}
                                    {checkRestriction('CAN_DELETE_INDUSTRY') && (
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
            {openEdit && (
                <CommonDialog
                    open={openEdit}
                    title="Edit Industry"
                    onClose={() => setOpenEdit((prevState) => !prevState)}
                    id="editIndustry"
                >
                    <AddEditIndustry value={industryData} formId="editIndustry" onSubmit={submitHandler} />
                </CommonDialog>
            )}

            {openDelete && (
                <DeleteDialog
                    onDeleteHandler={deleteHandler}
                    onClose={() => setOpenDelete(false)}
                    open={openDelete}
                    dept="Industry"
                    name={industryData['name']}
                />
            )}

            {openView && (
                <CommonDialog
                    open={openView}
                    title={industryData['name']}
                    onClose={() => setOpenView((prevState) => !prevState)}
                    saveButton={true}
                >
                    <ViewIndustry data={industryData} />
                </CommonDialog>
            )}
        </>
    );
};

export default IndustryList;

IndustryList.propTypes = {
    search: propTypes.string,
    callApi: propTypes.bool
};

function EnhancedTableHead({ order, orderBy, onRequestSort }) {
    const createSortHandler = (property) => () => {
        onRequestSort(property);
    };

    return (
        <TableHead>
            <TableRow>
                <TableCell key="name" sx={{ width: '40%' }}>
                    <TableSortLabel active={orderBy === '0'} direction={orderBy === '0' ? order : 'asc'} onClick={createSortHandler('0')}>
                        Name
                    </TableSortLabel>
                </TableCell>
                <TableCell key="status" sx={{ width: '25%' }}>
                    <TableSortLabel active={orderBy === '1'} direction={orderBy === '1' ? order : 'asc'} onClick={createSortHandler('1')}>
                        Status
                    </TableSortLabel>
                </TableCell>
                <TableCell align="right" sx={{ width: '10%' }}>
                    Action
                </TableCell>
            </TableRow>
        </TableHead>
    );
}

EnhancedTableHead.propTypes = {
    order: propTypes.string,
    orderBy: propTypes.string,
    onRequestSort: propTypes.func
};
