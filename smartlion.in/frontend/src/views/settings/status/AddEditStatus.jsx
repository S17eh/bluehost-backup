import propTypes from 'prop-types';
import {
    Autocomplete,
    Box,
    Checkbox,
    FormControl,
    FormHelperText,
    Grid,
    InputLabel,
    MenuItem,
    Select,
    TextField,
    Typography
} from '@mui/material';
import Required from 'views/utilities/Required';
import { useFormik } from 'formik';

// third party
import * as yup from 'yup';
import { addUpdateStatusApi } from 'apis/Status';
import { apiErrorSnackBar, apiSuccessSnackBar, apiValidationSnackBar } from 'utils/SnackBar';

const validationSchema = yup.object().shape({
    name: yup.string().required('Name is required.'),
    status: yup.string().required('Status is required.')
});

const status = [{ label: 'Active' }, { label: 'Inactive' }];

const AddEditStatus = ({ formId, value, onSubmit }) => {
    const initValue = value ?? false;
    const formik = useFormik({
        initialValues: {
            id: initValue ? initValue.id : '',
            name: initValue ? initValue.name : '',
            is_default: initValue ? initValue.is_default : 'No',
            status: initValue ? initValue.status : 'Active',
            formType: initValue && initValue.id ? 'edit' : 'add'
        },
        validationSchema: validationSchema,
        onSubmit: (values) => {
            addUpdateStatusApi(values)
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
                                    <Required title="Is Default ?" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <FormControl size="small" fullWidth error={formik.touched.is_default && Boolean(formik.errors.is_default)}>
                                    <InputLabel id="is_default">Is Default ?</InputLabel>
                                    <Select
                                        fullWidth
                                        labelId="is_default"
                                        id="is_default"
                                        name="is_default"
                                        label="Is Default ?"
                                        value={formik.values.is_default}
                                        onChange={formik.handleChange}
                                        disabled={initValue.has_default && formik.values.is_default === 'No'}
                                    >
                                        <MenuItem value={'No'} sx={{ height: '50' }}>
                                            No
                                        </MenuItem>
                                        <MenuItem value={'Yes'} sx={{ height: '50' }}>
                                            Yes
                                        </MenuItem>
                                    </Select>
                                    <FormHelperText>{formik.touched.is_default && formik.errors.is_default}</FormHelperText>
                                </FormControl>
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

AddEditStatus.propTypes = {
    value: propTypes.object,
    formId: propTypes.string.isRequired,
    onSubmit: propTypes.func
};

export default AddEditStatus;
