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
import { useEffect, useState } from 'react';
import useAuth from 'hooks/useAuth';
import { DeleteOutline, Edit as EditIcon } from '@mui/icons-material';
import CommonDialog from 'utils/CommonDialog';
import DeleteDialog from 'views/utilities/DeleteDialog';
import AddEditCity from './AddEditCity';
import { AddEditCityApi, changeStatusApi, CityListApi, deleteCityApi } from 'apis/Location';
import { apiErrorSnackBar, apiSuccessSnackBar, apiValidationSnackBar } from 'utils/SnackBar';
import InlineStatus from 'views/utilities/InlineStatus';

const params = {
    search: '',
    displayLength: 10,
    displayStart: 0,
    orderDir: 'ASC',
    orderColumn: 0
};

let recordsTotal = 0;

const IndustryList = ({ search, callApi }) => {
    const [data, setData] = useState([]);
    const [order, setOrder] = useState('asc');
    const [orderBy, setOrderBy] = useState('0');
    const [rowsPerPage, setRowsPerPage] = useState(10);
    const [page, setPage] = useState(0);
    const [openEdit, setOpenEdit] = useState(false);
    const [openDelete, setOpenDelete] = useState(false);
    const [cityData, setCityData] = useState({});
    const [countryData, setCountryData] = useState([]);
    const [stateData, setStateData] = useState([]);

    const { checkRestriction } = useAuth();

    const submitHandler = (row) => {
        setOpenEdit((prevState) => !prevState);
        getData(row);
    };

    const editData = (row) => {
        setCityData(row);
        AddEditCityApi({ type: 'edit', id: row.id, country_id: row.country_id })
            .then((res) => {
                setCountryData(res.data.data.countryList);
                setStateData(res.data.data.stateList);
                setOpenEdit((prevState) => !prevState);
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };

    const deleteData = (row) => {
        setOpenDelete((prevState) => !prevState);
        setCityData(row);
    };

    const deleteHandler = () => {
        deleteCityApi({ id: cityData.id })
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

    const statusHandler = (value, rowID) => {
        const obj = {
            id: rowID,
            status: value,
            module: 'city'
        };
        changeStatusApi(obj)
            .then((res) => {
                if (res.data && res.data.status === 1) {
                    getData();
                    apiSuccessSnackBar(res);
                } else {
                    apiValidationSnackBar(res);
                }
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };

    const getData = () => {
        CityListApi(params)
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

    return (
        <>
            <TableContainer>
                <Table>
                    <EnhancedTableHead order={order} orderBy={orderBy} onRequestSort={handleRequestSort} />
                    <TableBody>
                        {data.map((item, index) => (
                            <TableRow hover role="checkbox" key={index}>
                                <TableCell align="left">{item.name}</TableCell>
                                <TableCell align="left">{item.state_name}</TableCell>
                                <TableCell align="left">
                                    <InlineStatus selectedValue={item.status} changeValue={(ev) => statusHandler(ev, item.id)} />
                                </TableCell>
                                <TableCell align="right">
                                    {checkRestriction('CAN_EDIT_STATUS') && (
                                        <IconButton color="primary" component="label" onClick={() => editData(item)}>
                                            <EditIcon fontSize="small" />
                                        </IconButton>
                                    )}
                                    {checkRestriction('CAN_DELETE_STATUS') && (
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
                <CommonDialog open={openEdit} title="Edit City" onClose={() => setOpenEdit((prevState) => !prevState)} id="editCity">
                    <AddEditCity
                        value={cityData}
                        formId="editCity"
                        onSubmit={submitHandler}
                        countryData={countryData}
                        stateList={stateData}
                    />
                </CommonDialog>
            )}

            {openDelete && (
                <DeleteDialog
                    onDeleteHandler={deleteHandler}
                    onClose={() => setOpenDelete(false)}
                    open={openDelete}
                    dept="City"
                    name={cityData['name']}
                />
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
                <TableCell key="state_name" sx={{ width: '25%' }}>
                    <TableSortLabel active={orderBy === '1'} direction={orderBy === '1' ? order : 'asc'} onClick={createSortHandler('1')}>
                        State Name
                    </TableSortLabel>
                </TableCell>
                <TableCell key="status" sx={{ width: '25%' }}>
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
