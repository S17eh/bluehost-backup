import propTypes from 'prop-types';
import { Box, FormControl, FormHelperText, Grid, InputLabel, MenuItem, Select, TextField, Typography } from '@mui/material';
import Required from 'views/utilities/Required';
import { useFormik } from 'formik';

// third party
import * as yup from 'yup';
import { apiErrorSnackBar, apiSuccessSnackBar, apiValidationSnackBar } from 'utils/SnackBar';
import { addUpdateEducationApi } from 'apis/Setting';

const validationSchema = yup.object().shape({
    name: yup.string().required('Name is required.'),
    type: yup.string().required('Type is required.'),
    status: yup.string().required('Status is required.')
});

const status = [{ label: 'Active' }, { label: 'Inactive' }];

const AddEditEducation = ({ formId, value, onSubmit, initData }) => {
    const initValue = value ?? false;

    const formik = useFormik({
        initialValues: {
            id: initValue ? initValue.id : '',
            name: initValue ? initValue.name : '',
            type: initValue ? initValue.type : '',
            parent_degree: initValue && initValue.parent_id !== null ? initValue.parent_id : '',
            status: initValue ? initValue.status : 'Active',
            formType: initValue && initValue.id ? 'edit' : 'add'
        },
        validationSchema: validationSchema,
        onSubmit: (values) => {
            addUpdateEducationApi(values)
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
            <form id={formId} onSubmit={formik.handleSubmit}>
                <Grid container spacing={2}>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={3}>
                                <Typography variant="subtitle1">
                                    <Required title="Name" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={9}>
                                <TextField
                                    fullWidth
                                    size="small"
                                    id="name"
                                    name="name"
                                    label={<Required title="Name" />}
                                    defaultValue={formik.values.name}
                                    onChange={formik.handleChange}
                                    error={formik.touched.name && Boolean(formik.errors.name)}
                                    helperText={formik.touched.name && formik.errors.name}
                                />
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={3}>
                                <Typography variant="subtitle1">
                                    <Required title="Type" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={9}>
                                <FormControl size="small" fullWidth error={formik.touched.type && Boolean(formik.errors.type)}>
                                    <InputLabel id="type">
                                        <Required title="Type" />
                                    </InputLabel>
                                    <Select
                                        fullWidth
                                        labelId="type"
                                        id="type"
                                        name="type"
                                        label={<Required title="Type" />}
                                        value={formik.values.type}
                                        onChange={formik.handleChange}
                                    >
                                        {initData.degreeType.map((item, idx) => (
                                            <MenuItem value={item} key={idx}>
                                                {item}
                                            </MenuItem>
                                        ))}
                                    </Select>
                                    <FormHelperText>{formik.touched.type && formik.errors.type}</FormHelperText>
                                </FormControl>
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={3}>
                                <Typography variant="subtitle1">Parent Degree</Typography>
                            </Grid>
                            <Grid item xs={12} sm={9}>
                                <FormControl size="small" fullWidth>
                                    <InputLabel id="parent_degree">Parent Degree</InputLabel>
                                    <Select
                                        fullWidth
                                        labelId="parent_degree"
                                        id="parent_degree"
                                        name="parent_degree"
                                        label={<Required title="Parent Degree" />}
                                        value={formik.values.parent_degree}
                                        onChange={formik.handleChange}
                                    >
                                        <MenuItem value="">Select</MenuItem>
                                        {initData.parent.map((item, idx) => (
                                            <MenuItem value={item.id} key={idx}>
                                                {item.name}
                                            </MenuItem>
                                        ))}
                                    </Select>
                                </FormControl>
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={3}>
                                <Typography variant="subtitle1">Status</Typography>
                            </Grid>
                            <Grid item xs={12} sm={9}>
                                <FormControl size="small" fullWidth>
                                    <InputLabel id="status">Status</InputLabel>
                                    <Select
                                        fullWidth
                                        labelId="status"
                                        id="status"
                                        name="status"
                                        label="status"
                                        value={formik.values.status}
                                        onChange={formik.handleChange}
                                    >
                                        {status.map((item, idx) => (
                                            <MenuItem value={item.label} key={idx}>
                                                {item.label}
                                            </MenuItem>
                                        ))}
                                    </Select>
                                </FormControl>
                            </Grid>
                        </Grid>
                    </Grid>
                </Grid>
            </form>
        </Box>
    );
};

export default AddEditEducation;

AddEditEducation.propTypes = {
    value: propTypes.object,
    formId: propTypes.string,
    onSubmit: propTypes.func,
    initData: propTypes.object
};
