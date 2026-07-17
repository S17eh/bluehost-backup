import propTypes from 'prop-types';
import { Chip, Table, TableBody, TableCell, tableCellClasses, TableContainer, TableRow, Typography } from '@mui/material';

const ViewIndustry = ({ data }) => (
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
                        <Typography variant="subtitle1">Name</Typography>
                    </TableCell>
                    <TableCell> {data.name}</TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Description</Typography>
                    </TableCell>
                    <TableCell> {data.description}</TableCell>
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
);

ViewIndustry.propTypes = {
    data: propTypes.object
};
export default ViewIndustry;
