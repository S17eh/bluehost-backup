import { useState } from 'react';
import PropTypes from 'prop-types';
import JobCandidateList from './JobCandidateList';
import {
    Button,
    Grid,
    InputAdornment,
    OutlinedInput
    //  Typography
} from '@mui/material';
import { gridSpacing } from 'store/constant';
import { AddCircleOutlineOutlined } from '@mui/icons-material';
import { IconSearch } from '@tabler/icons';
import { useTransition } from 'react';
import AddRemoveCandidates from './AddRemoveCandidates';
import CenterDialog from 'views/utilities/CenterDialog';
import useAuth from 'hooks/useAuth';

const Index = ({ jobData }) => {
    const { checkRestriction } = useAuth();
    const [, startTransition] = useTransition();
    const [search, setSearch] = useState('');
    const [callApi, setCallApi] = useState(false);
    const [openAdd, setOpenAdd] = useState(false);

    const addData = () => {
        setOpenAdd((prevState) => !prevState);
    };

    const handleSearch = (event) => {
        startTransition(() => setSearch(event.target.value));
    };
    return (
        <>
            <Grid container alignItems="center" spacing={gridSpacing}>
                <Grid item xs={12}>
                    <Grid container alignItems="center" spacing={gridSpacing}>
                        <Grid item sx={{ flexGrow: 1 }}>
                            {/* <Typography variant="column">Job List</Typography> */}
                        </Grid>
                        {checkRestriction('CAN_ADD_JOB_CANDIDATES') && (
                            <Grid item>
                                <Button variant="contained" onClick={() => addData()}>
                                    <AddCircleOutlineOutlined sx={{ mr: 0.5 }} /> Add Job Candidates
                                </Button>
                            </Grid>
                        )}
                        <Grid item>
                            <OutlinedInput
                                id="input-search-list-style1"
                                placeholder="Search"
                                startAdornment={
                                    <InputAdornment position="start">
                                        <IconSearch stroke={1.5} size="1rem" />
                                    </InputAdornment>
                                }
                                size="small"
                                onChange={handleSearch}
                                autoComplete="off"
                            />
                        </Grid>
                    </Grid>
                </Grid>
                <Grid item xs={12}>
                    <JobCandidateList search={search} callApi={callApi} jobData={jobData} />
                </Grid>
            </Grid>

            {openAdd && (
                <CenterDialog
                    title="Select Job Candidates"
                    subTitle={`Job Code : ${jobData['job_code']} | ${jobData['title']}`}
                    open={openAdd}
                    onClose={() => {
                        setOpenAdd((prevState) => !prevState);
                        setCallApi((prevState) => !prevState);
                    }}
                    saveButton={true}
                    sx={{
                        '&>div:nth-of-type(3)': {
                            '&>div': {
                                minWidth: { md: '60%', sm: '90%', xs: '90%' }
                            }
                        }
                    }}
                >
                    <AddRemoveCandidates jobData={jobData} />
                </CenterDialog>
            )}
        </>
    );
};

Index.propTypes = {
    jobData: PropTypes.object
};

export default Index;
