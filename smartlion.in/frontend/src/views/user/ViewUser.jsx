import propTypes from 'prop-types';
import {
    Box,
    Chip,
    Divider,
    Grid,
    IconButton,
    Table,
    TableBody,
    TableCell,
    tableCellClasses,
    TableContainer,
    TableHead,
    TableRow,
    Typography
} from '@mui/material';
import { DeleteOutline } from '@mui/icons-material';
import { gridSpacing } from 'store/constant';
import { deleteUserDocumentApi } from 'apis/User';
import { apiErrorSnackBar, apiSuccessSnackBar, apiValidationSnackBar } from 'utils/SnackBar';

const ViewUser = ({ data, onSubmit }) => {
    const deleteDocument = (row, index) => {
        deleteUserDocumentApi({ id: row.id })
            .then((res) => {
                if (res.data && res.data.status === 1) {
                    if (onSubmit) onSubmit();
                    apiSuccessSnackBar(res);
                } else {
                    apiValidationSnackBar(res);
                }
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });

        const arr = data.documents;
        arr.splice(index, 1);
    };
    return (
        <>
            <Grid container spacing={gridSpacing}>
                <Grid item xs={12} sm={12} md={12}>
                    <TableContainer>
                        <Table
                            size="small"
                            sx={{
                                [`& .${tableCellClasses.root}`]: {
                                    borderBottom: 'none'
                                }
                            }}
                        >
                            <TableBody>
                                <TableRow>
                                    <TableCell>
                                        <Typography variant="subtitle1">Username</Typography>
                                    </TableCell>
                                    <TableCell> {data.username}</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>
                                        <Typography variant="subtitle1">Name</Typography>
                                    </TableCell>
                                    <TableCell>
                                        {data.first_name} {data.last_name}
                                    </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>
                                        <Typography variant="subtitle1">Official Email</Typography>
                                    </TableCell>
                                    <TableCell> {data.email}</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>
                                        <Typography variant="subtitle1">Personal Email</Typography>
                                    </TableCell>
                                    <TableCell> {data.personal_email}</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>
                                        <Typography variant="subtitle1">Mobile number</Typography>
                                    </TableCell>
                                    <TableCell> {data.mobile_number}</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>
                                        <Typography variant="subtitle1">Alternate Mobile Number</Typography>
                                    </TableCell>
                                    <TableCell>
                                        {data.alternate_mobile_number.map((i, idx) => {
                                            return idx === data.alternate_mobile_number.length - 1 ? (
                                                <Box key={idx} component="div" sx={{ display: 'inline' }}>
                                                    {i}
                                                </Box>
                                            ) : (
                                                <Box key={idx} component="div" sx={{ display: 'inline' }}>
                                                    {`${i}, `}
                                                </Box>
                                            );
                                        })}
                                    </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>
                                        <Typography variant="subtitle1">Gender</Typography>
                                    </TableCell>
                                    <TableCell>{data.gender}</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>
                                        <Typography variant="subtitle1">Address</Typography>
                                    </TableCell>
                                    <TableCell>
                                        {data.address} ,<br /> {data.city_name} {data.postcode} , <br />
                                        {data.state_name} , {data.country_name}
                                    </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>
                                        <Typography variant="subtitle1">Role</Typography>
                                    </TableCell>
                                    <TableCell> {data.role}</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>
                                        <Typography variant="subtitle1">Profile Picture</Typography>
                                    </TableCell>
                                    <TableCell>
                                        {data.image && (
                                            <Box
                                                component="img"
                                                sx={{
                                                    height: 50
                                                }}
                                                alt="Company Logo"
                                                src={data.image}
                                            />
                                        )}
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </TableContainer>
                </Grid>

                <Grid item xs={12} sm={12} md={12}>
                    <Divider>
                        <Chip label="Documents" />
                    </Divider>
                </Grid>

                <Grid item xs={12} sm={12}>
                    <TableContainer>
                        <Table size="small">
                            <TableHead>
                                <TableRow>
                                    <TableCell sx={{ width: '80%' }}>File Name</TableCell>
                                    <TableCell align="right" sx={{ width: '20%' }}>
                                        Action
                                    </TableCell>
                                </TableRow>
                            </TableHead>
                            <TableBody>
                                {data.documents.map((i, idx) => (
                                    <TableRow key={idx}>
                                        <TableCell>{i.document}</TableCell>
                                        <TableCell align="right">
                                            <IconButton color="error" component="label" onClick={() => deleteDocument(i, idx)}>
                                                <DeleteOutline fontSize="small" />
                                            </IconButton>
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    </TableContainer>
                </Grid>
            </Grid>
        </>
    );
};

ViewUser.propTypes = {
    data: propTypes.object,
    onSubmit: propTypes.func
};

export default ViewUser;
