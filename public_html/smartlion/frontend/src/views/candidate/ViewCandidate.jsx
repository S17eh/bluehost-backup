import propTypes from 'prop-types';
import {
    Box,
    Card,
    CardContent,
    Chip,
    Table,
    TableBody,
    TableCell,
    tableCellClasses,
    TableContainer,
    TableRow,
    Typography
} from '@mui/material';
import moment from 'moment/moment';

const ViewCandidate = ({ data }) => (
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
                        <Typography variant="subtitle1">Source</Typography>
                    </TableCell>
                    <TableCell> {data.source_from}</TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Full Name</Typography>
                    </TableCell>
                    <TableCell> {data.full_name}</TableCell>
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
                        {data.alternate_email.length > 0 ? (
                            data.alternate_email.map((i, idx) => <Chip label={i} key={idx} sx={{ margin: '5px 5px 0 0' }} />)
                        ) : (
                            <Typography sx={{ marginLeft: '3%' }}>-</Typography>
                        )}
                    </TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Mobile Number</Typography>
                    </TableCell>
                    <TableCell>
                        {data.mobile_number.length > 0 ? (
                            data.mobile_number.map((i, idx) => <Chip label={i} key={idx} sx={{ margin: '5px 5px 0 0' }} />)
                        ) : (
                            <Typography sx={{ marginLeft: '3%' }}>-</Typography>
                        )}
                    </TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Current CTC</Typography>
                    </TableCell>
                    <TableCell>
                        {data.current_ctc_lakh}.{data.current_ctc_thousand} Lakh
                    </TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Expected CTC</Typography>
                    </TableCell>
                    <TableCell>
                        {data.expected_ctc_lakh}.{data.expected_ctc_thousand} Lakh
                    </TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Is Experience</Typography>
                    </TableCell>
                    <TableCell>
                        {data.experience == '0' ? (
                            <Chip label="Yes" color="primary" variant="outlined" />
                        ) : (
                            <>
                                <Chip label="No" color="error" variant="outlined" /> ( Fresher )
                            </>
                        )}
                    </TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Experience Details</Typography>
                    </TableCell>
                    <TableCell>
                        {data.experiences.length > 0 ? (
                            data.experiences.map((i, idx) => (
                                <Card sx={{ boxShadow: 2, marginTop: 10 }} key={idx}>
                                    <CardContent sx={{}}>
                                        <b> Company Name : {i.company_name}</b>
                                        <br />
                                        Designation : {i.designation}
                                        <br />
                                        Duration : {moment(i.start_date).format('DD MMM, YYYY')} <strong>To </strong>
                                        {i.is_default_company == 1 ? <strong>Present</strong> : moment(i.end_date).format('DD MMM, YYYY')}
                                    </CardContent>
                                </Card>
                            ))
                        ) : (
                            <Typography sx={{ marginLeft: '3%' }}>-</Typography>
                        )}
                    </TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Notice Period</Typography>
                    </TableCell>
                    <TableCell> {data.notice_period}</TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Education Details</Typography>
                    </TableCell>
                    <TableCell>
                        {data.educations.length > 0 ? (
                            data.educations.map((i, idx) => (
                                <Card sx={{ boxShadow: 2 }} key={idx}>
                                    <CardContent>
                                        <b> Institute Name : {i.institute_name}</b>
                                        <br />
                                        Education Type : {i.type}
                                        <br />
                                        Course : {i.course_name}
                                        <br />
                                        Specification : {i.specification}
                                        <br />
                                        Duration : {moment(i.start_date).format('DD MMM, YYYY')} <strong> To </strong>
                                        {moment(i.end_date).format('DD MMM, YYYY')}
                                    </CardContent>
                                </Card>
                            ))
                        ) : (
                            <Typography sx={{ marginLeft: '3%' }}>-</Typography>
                        )}
                    </TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Curren Skill</Typography>
                    </TableCell>
                    <TableCell>
                        {data.current_skill.length > 0 ? (
                            data.current_skill.map((i, idx) => <Chip label={i} key={idx} sx={{ margin: '5px 5px 0 0' }} />)
                        ) : (
                            <Typography sx={{ marginLeft: '3%' }}>-</Typography>
                        )}
                    </TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Profile Picture</Typography>
                    </TableCell>
                    <TableCell>
                        {data.profile_picture ? (
                            data.profile_picture && (
                                <Box
                                    component="img"
                                    sx={{
                                        height: 100
                                    }}
                                    alt="Profile Picture"
                                    src={data.profile_picture}
                                />
                            )
                        ) : (
                            <Typography sx={{ marginLeft: '3%' }}>-</Typography>
                        )}
                    </TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Resume</Typography>
                    </TableCell>
                    <TableCell>
                        {data.resume ? (
                            data.resume && (
                                <Box
                                    component="a"
                                    sx={{
                                        height: 100
                                    }}
                                    href={data.resume}
                                    target="_blank"
                                >
                                    View Resume
                                </Box>
                            )
                        ) : (
                            <Typography sx={{ marginLeft: '3%' }}>-</Typography>
                        )}
                    </TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Location</Typography>
                    </TableCell>
                    <TableCell>
                        {data.address}
                        <br />
                        {data.city_name} {data.post_code} ,<br />
                        {data.state_name} , {data.country_name}
                    </TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Gender</Typography>
                    </TableCell>
                    <TableCell> {data.gender}</TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Date Of Birth</Typography>
                    </TableCell>
                    <TableCell> {data.date_of_birth}</TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Marital Status</Typography>
                    </TableCell>
                    <TableCell> {data.marital_status}</TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Status</Typography>
                    </TableCell>
                    <TableCell>
                        <Chip label={data.status} variant="outlined" />
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </TableContainer>
);

ViewCandidate.propTypes = {
    data: propTypes.object
};

export default ViewCandidate;
