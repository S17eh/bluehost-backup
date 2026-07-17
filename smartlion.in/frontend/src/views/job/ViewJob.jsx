import propTypes from 'prop-types';
import { Chip, Table, TableBody, TableCell, tableCellClasses, TableContainer, TableRow, Typography } from '@mui/material';

const ViewJob = ({ data }) => (
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
                    <TableCell sx={{ width: '35%' }}>
                        <Typography variant="subtitle1">Job Code</Typography>
                    </TableCell>
                    <TableCell> {data.job_code}</TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Company</Typography>
                    </TableCell>
                    <TableCell> {data.employer_name}</TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Title</Typography>
                    </TableCell>
                    <TableCell> {data.title}</TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Job Type</Typography>
                    </TableCell>
                    <TableCell> {data.job_type_name}</TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Work Mode</Typography>
                    </TableCell>
                    <TableCell> {data.work_mode}</TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Position</Typography>
                    </TableCell>
                    <TableCell>
                        {data.position_title} | {data.no_of_position} Position
                    </TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Description</Typography>
                    </TableCell>
                    <TableCell>{data.description}</TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Candidate Profile</Typography>
                    </TableCell>
                    <TableCell>{data.candidate_profile}</TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Key Skill</Typography>
                    </TableCell>
                    <TableCell>
                        {data.skill.map((i, idx) => (
                            <Chip label={i} sx={{ margin: '5px 5px 0 0' }} key={idx} />
                        ))}
                    </TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Work Experience</Typography>
                    </TableCell>
                    <TableCell>
                        {data.work_experience_min} To {data.work_experience_max} (Years)
                    </TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Annual Salary</Typography>
                    </TableCell>
                    <TableCell>
                        {data.salary_min} To {data.salary_max}
                    </TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Perks & Benefits</Typography>
                    </TableCell>
                    <TableCell>{data.perks_benefits}</TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Location</Typography>
                    </TableCell>
                    <TableCell>
                        {data.city_name} {data.post_code} ,<br />
                        {data.state_name} , {data.country_name}
                    </TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Industry</Typography>
                    </TableCell>
                    <TableCell> {data.industry_name}</TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Preferred Industry</Typography>
                    </TableCell>
                    <TableCell>
                        {data.preferred_industry.map((i, idx) => (
                            <Chip label={i} sx={{ margin: '5px 5px 0 0' }} key={idx} />
                        ))}
                    </TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Functional Area</Typography>
                    </TableCell>
                    <TableCell>
                        {data.functional_area.map((i, idx) => (
                            <Chip label={i} sx={{ margin: '5px 5px 0 0' }} key={idx} />
                        ))}
                    </TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">education</Typography>
                    </TableCell>
                    <TableCell>
                        {data.education.map((i, idx) => (
                            <Chip label={i} sx={{ margin: '5px 5px 0 0' }} key={idx} />
                        ))}
                    </TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Date</Typography>
                    </TableCell>
                    <TableCell>
                        {data.start_date} | To | {data.end_date}
                    </TableCell>
                </TableRow>
                <TableRow>
                    <TableCell>
                        <Typography variant="subtitle1">Shift Timing</Typography>
                    </TableCell>
                    <TableCell>
                        {data.shift.map((i, idx) => (
                            <Chip label={i} sx={{ margin: '5px 5px 0 0' }} key={idx} />
                        ))}
                    </TableCell>
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

ViewJob.propTypes = {
    data: propTypes.object
};

export default ViewJob;
