import React, { useState } from 'react';
import PropTypes from 'prop-types';
import MainCard from 'ui-component/cards/MainCard';
import {
    Button,
    CardContent,
    Grid,
    IconButton,
    Table,
    TableBody,
    TableCell,
    TableContainer,
    TableHead,
    TablePagination,
    TableRow,
    TableSortLabel,
    TextField,
    Typography
} from '@mui/material';
import { CompanyMonthlyRevenueApi } from 'apis/Dashboard';
import { useEffect } from 'react';
import { CalendarMonthTwoTone } from '@mui/icons-material';
import { DatePicker, LocalizationProvider } from '@mui/x-date-pickers';
import { AdapterMoment } from '@mui/x-date-pickers/AdapterMoment';
import moment from 'moment';

let recordsTotal = 0;
const params = {
    displayLength: 10,
    displayStart: 0,
    orderDir: 'ASC',
    orderColumn: 0
};
const MonthlyRevenue = (props) => {
    const [data, setData] = useState([]);
    const [page, setPage] = useState(0);
    const [rowsPerPage, setRowsPerPage] = useState(10);
    const [order, setOrder] = useState('asc');
    const [orderBy, setOrderBy] = useState('0');
    const [selectedDate, handleDateChange] = useState(moment());

    // ========== Table Pagination ========== //
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
        CompanyMonthlyRevenueApi(params)
            .then((res) => {
                setData(res.data.data.data);
            })
            .catch((err) => {
                console.error(err);
            });
    };

    useEffect(() => {
        // params.search = search;
        params.displayLength = rowsPerPage;
        params.displayStart = rowsPerPage * page;
        params.orderDir = order?.toUpperCase() ?? params.orderDir;
        params.orderColumn = Number(orderBy);
        params.revenueDate = moment(selectedDate).format('YYYY-MM-DD');
        getData();
        return;
    }, [page, rowsPerPage, order, orderBy, selectedDate]);

    return (
        <MainCard content={false}>
            <CardContent>
                <Grid item xs={12}>
                    {/* <Grid container alignContent="center" justifyContent="space-between"> */}
                    <Grid container alignContent="center" justifyContent="space-between">
                        <Grid item md={8} xs={12}>
                            <Typography variant="h4">Company Monthly Revenue</Typography>
                        </Grid>
                        <Grid item md={4} xs={12}>
                            <LocalizationProvider dateAdapter={AdapterMoment}>
                                <DatePicker
                                    disableFuture
                                    views={['year', 'month']}
                                    onChange={handleDateChange}
                                    value={selectedDate}
                                    renderInput={(params) => <TextField fullWidth size="small" {...params} />}
                                />
                            </LocalizationProvider>
                        </Grid>
                    </Grid>
                </Grid>
                <TableContainer>
                    <Table>
                        <EnhancedTableHead order={order} orderBy={orderBy} onRequestSort={handleRequestSort} />
                        <TableBody>
                            {data.map((i, idx) => (
                                <TableRow key={idx}>
                                    <TableCell>{i.name}</TableCell>
                                    <TableCell align="right">{i.amount}</TableCell>
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
            </CardContent>
        </MainCard>
    );
};

MonthlyRevenue.propTypes = {};

export default MonthlyRevenue;

function EnhancedTableHead({ order, orderBy, onRequestSort }) {
    const createSortHandler = (property) => () => {
        onRequestSort(property);
    };
    return (
        <TableHead>
            <TableRow>
                <TableCell key="invoice_number">
                    <TableSortLabel active={orderBy === '0'} direction={orderBy === '0' ? order : 'asc'} onClick={createSortHandler('0')}>
                        Company Name
                    </TableSortLabel>
                </TableCell>
                <TableCell key="amount" align="right">
                    <TableSortLabel active={orderBy === '1'} direction={orderBy === '1' ? order : 'asc'} onClick={createSortHandler('1')}>
                        Points
                    </TableSortLabel>
                </TableCell>
            </TableRow>
        </TableHead>
    );
}
// ========== PropTypes ========== //

EnhancedTableHead.propTypes = {
    order: PropTypes.string,
    orderBy: PropTypes.string,
    onRequestSort: PropTypes.func
};
