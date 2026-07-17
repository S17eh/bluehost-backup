import PropTypes from 'prop-types';
import { Box, FormControl, FormHelperText, Grid, InputLabel, MenuItem, Select, TextField, Typography } from '@mui/material';
import Required from 'views/utilities/Required';
import { useFormik } from 'formik';

import * as yup from 'yup';
import { apiErrorSnackBar, apiSuccessSnackBar, apiValidationSnackBar } from 'utils/SnackBar';
import { UpdateJobCandidatesApi } from 'apis/Job';
const validationSchema = yup.object().shape({
    status_id: yup.string().required('Status is required.'),
    is_hired: yup.string().required('Is hired is required.'),
    revenue: yup.string().when('is_hired', { is: 'Yes', then: yup.string().required('Revenue is required.') })
});

const JobCandidateStatus = ({ formID, value, onSubmit, statusList }) => {
    const initValue = value ?? false;
    const statusLists = statusList;
    const formik = useFormik({
        initialValues: {
            id: initValue ? initValue.id : '',
            status_id: initValue ? initValue.status_id : '',
            is_hired: initValue ? initValue.is_hired : 'No',
            revenue: initValue ? initValue.revenue : '0.00'
        },
        validationSchema: validationSchema,
        onSubmit: (values) => {
            UpdateJobCandidatesApi(values)
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
        }
    });

    return (
        <Box>
            <form id={formID} onSubmit={formik.handleSubmit}>
                <Grid container spacing={2}>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={3}>
                                <Typography variant="subtitle1">
                                    <Required title="Status" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={9}>
                                <FormControl size="small" fullWidth error={formik.touched.status_id && Boolean(formik.errors.status_id)}>
                                    <InputLabel id="statusLabel">Status</InputLabel>
                                    <Select
                                        fullWidth
                                        labelId="statusLabel"
                                        id="status_id"
                                        name="status_id"
                                        label="Status"
                                        value={formik.values.status_id}
                                        onChange={formik.handleChange}
                                    >
                                        {statusLists.map((item, idx) => (
                                            <MenuItem value={item.id} key={idx}>
                                                {item.name}
                                            </MenuItem>
                                        ))}
                                    </Select>
                                    <FormHelperText>{formik.touched.status_id && formik.errors.status_id}</FormHelperText>
                                </FormControl>
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={3}>
                                <Typography variant="subtitle1">
                                    <Required title="Is Hired" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={9}>
                                <FormControl size="small" fullWidth error={formik.touched.is_hired && Boolean(formik.errors.is_hired)}>
                                    <InputLabel id="IsHiredLabel">Is Hired</InputLabel>
                                    <Select
                                        fullWidth
                                        labelId="IsHiredLabel"
                                        id="is_hired"
                                        name="is_hired"
                                        label="Is Hired"
                                        value={formik.values.is_hired}
                                        onChange={formik.handleChange}
                                    >
                                        <MenuItem value="No">No</MenuItem>
                                        <MenuItem value="Yes">Yes</MenuItem>
                                    </Select>
                                    <FormHelperText>{formik.touched.is_hired && formik.errors.is_hired}</FormHelperText>
                                </FormControl>
                            </Grid>
                        </Grid>
                    </Grid>
                    {formik.values.is_hired === 'Yes' && (
                        <Grid item xs={12}>
                            <Grid container alignItems="center" spacing={2}>
                                <Grid item xs={12} sm={3}>
                                    <Typography variant="subtitle1">
                                        <Required title="Revenue" />
                                    </Typography>
                                </Grid>
                                <Grid item xs={12} sm={9}>
                                    <TextField
                                        fullWidth
                                        type="number"
                                        size="small"
                                        id="revenue"
                                        name="revenue"
                                        label="Revenue"
                                        value={formik.values.revenue}
                                        onChange={formik.handleChange}
                                        error={formik.touched.revenue && Boolean(formik.errors.revenue)}
                                        helperText={formik.touched.revenue && formik.errors.revenue}
                                    />
                                </Grid>
                            </Grid>
                        </Grid>
                    )}
                </Grid>
            </form>
        </Box>
    );
};

JobCandidateStatus.propTypes = {
    formID: PropTypes.string,
    value: PropTypes.object,
    onSubmit: PropTypes.func,
    statusList: PropTypes.array
};

export default JobCandidateStatus;
