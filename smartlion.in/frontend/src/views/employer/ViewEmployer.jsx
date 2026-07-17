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
import { gridSpacing } from 'store/constant';
import { DeleteOutline } from '@mui/icons-material';
import { deleteEmployerDocumentApi } from 'apis/Employer';
import { apiErrorSnackBar, apiSuccessSnackBar, apiValidationSnackBar } from 'utils/SnackBar';

const ViewEmployer = ({ data, onSubmit }) => {
    const deleteDocument = (row, index) => {
        deleteEmployerDocumentApi({ id: row.id })
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
                                        <Typography variant="subtitle1">Company Name</Typography>
                                    </TableCell>
                                    <TableCell> {data.name}</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>
                                        <Typography variant="subtitle1">Company Register Name</Typography>
                                    </TableCell>
                                    <TableCell> {data.register_name}</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>
                                        <Typography variant="subtitle1">Company GST No.</Typography>
                                    </TableCell>
                                    <TableCell> {data.gst_no}</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>
                                        <Typography variant="subtitle1">Email</Typography>
                                    </TableCell>
                                    <TableCell> {data.email}</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>
                                        <Typography variant="subtitle1">Alternate Email</Typography>
                                    </TableCell>
                                    <TableCell>
                                        {data.alternate_email.map((i, idx) => {
                                            return idx === data.alternate_email.length - 1 ? (
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
                                        <Typography variant="subtitle1">Mobile Number</Typography>
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
                                        <Typography variant="subtitle1">Website</Typography>
                                    </TableCell>
                                    <TableCell>
                                        <a href={data.website} target="_blank" rel="noopener noreferrer">
                                            {data.website}
                                        </a>
                                    </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>
                                        <Typography variant="subtitle1">Address</Typography>
                                    </TableCell>
                                    <TableCell> {data.address}</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>
                                        <Typography variant="subtitle1">Logo</Typography>
                                    </TableCell>
                                    <TableCell>
                                        {data.logo && (
                                            <Box
                                                component="img"
                                                sx={{
                                                    height: 50
                                                }}
                                                alt="Company Logo"
                                                src={data.logo}
                                            />
                                        )}
                                    </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>
                                        <Typography variant="subtitle1">Rate</Typography>
                                    </TableCell>
                                    <TableCell> {data.rate}%</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>
                                        <Typography variant="subtitle1">Status</Typography>
                                    </TableCell>
                                    <TableCell>
                                        {data.status === 'Active' ? (
                                            <Chip label={data.status} color="primary" variant="outlined" />
                                        ) : (
                                            <Chip label={data.status} color="error" variant="outlined" />
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

ViewEmployer.propTypes = {
    data: propTypes.object,
    onSubmit: propTypes.func
};

export default ViewEmployer;
