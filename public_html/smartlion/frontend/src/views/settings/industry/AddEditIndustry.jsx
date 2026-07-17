import propTypes from 'prop-types';
import { Autocomplete, Box, Checkbox, Grid, TextField, Typography } from '@mui/material';
import Required from 'views/utilities/Required';
import { useFormik } from 'formik';

// third party
import * as yup from 'yup';
import { addUpdateIndustryApi } from 'apis/Industry';
import { apiErrorSnackBar, apiSuccessSnackBar, apiValidationSnackBar } from 'utils/SnackBar';

const validationSchema = yup.object().shape({
    name: yup.string().required('Name is required.'),
    description: yup.string().required('Description is required.'),
    status: yup.string().required('Status is required.')
});

const status = [{ label: 'Active' }, { label: 'Inactive' }];

const AddEditIndustry = ({ formId, value, onSubmit }) => {
    const initValue = value ?? false;

    const formik = useFormik({
        initialValues: {
            id: initValue ? initValue.id : '',
            name: initValue ? initValue.name : '',
            description: initValue ? initValue.description : '',
            status: initValue ? initValue.status : 'Active',
            formType: initValue && initValue.id ? 'edit' : 'add'
        },
        validationSchema: validationSchema,
        onSubmit: (values) => {
            addUpdateIndustryApi(values)
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
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    <Required title="Name" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <TextField
                                    fullWidth
                                    size="small"
                                    id="name"
                                    name="name"
                                    label="Name"
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
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    <Required title="Description" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <TextField
                                    fullWidth
                                    multiline
                                    size="small"
                                    rows={4}
                                    id="description"
                                    name="description"
                                    label="Description"
                                    value={formik.values.description}
                                    onChange={formik.handleChange}
                                    error={formik.touched.description && Boolean(formik.errors.description)}
                                    helperText={formik.touched.description && formik.errors.description}
                                />
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    <Required title="Status" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <Autocomplete
                                    options={status ?? []}
                                    getOptionLabel={(option) => (option.label ? option.label : '')}
                                    value={formik.values.status !== '' ? status.filter((a) => a.label === formik.values.status)[0] : null}
                                    renderOption={(props, option, { selected }) => (
                                        <li {...props}>
                                            <Checkbox checked={selected} value={option.label} />
                                            {option.label}
                                        </li>
                                    )}
                                    renderInput={(params) => (
                                        <TextField
                                            {...params}
                                            size="small"
                                            id="status"
                                            name="status"
                                            label="Status"
                                            error={formik.touched.status && Boolean(formik.errors.status)}
                                            helperText={formik.touched.status && formik.errors.status}
                                        />
                                    )}
                                    onChange={(_, value) => {
                                        const val = value ? value.label : '';
                                        formik.setFieldValue('status', val);
                                    }}
                                />
                            </Grid>
                        </Grid>
                    </Grid>
                </Grid>
            </form>
        </Box>
    );
};

export default AddEditIndustry;

AddEditIndustry.propTypes = {
    value: propTypes.object,
    formId: propTypes.string,
    onSubmit: propTypes.func
};
