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
import { AddEditCityApi, addUpdateCityApi } from 'apis/Location';
import { apiErrorSnackBar, apiSuccessSnackBar, apiValidationSnackBar } from 'utils/SnackBar';
import { useState } from 'react';

const validationSchema = yup.object().shape({
    country: yup.string().required('Country is required.'),
    state: yup.string().required('State is required.'),
    city: yup.string().required('City is required.'),
    status: yup.string().required('Status is required.')
});

const status = [{ label: 'Active' }, { label: 'Inactive' }];

const AddEditCity = ({ formId, value, onSubmit, countryData, stateList }) => {
    const initValue = value ?? false;
    const [stateData, setStateData] = useState(stateList ?? []);

    const formik = useFormik({
        initialValues: {
            id: initValue ? initValue.id : '',
            city: initValue ? initValue.name : '',
            state: initValue ? initValue.state_id : '',
            status: initValue ? initValue.status : '',
            country: initValue ? initValue.country_id : '',
            formType: initValue && initValue.id ? 'edit' : 'add'
        },
        validationSchema: validationSchema,
        onSubmit: (values) => {
            addUpdateCityApi(values)
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

    const countryChangeHandler = (countryID) => {
        formik.setFieldValue('country', countryID);
        AddEditCityApi({ type: 'state', country_id: countryID })
            .then((res) => {
                setStateData(res.data.data.stateList);
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };

    return (
        <Box>
            <form id={formId} onSubmit={formik.handleSubmit}>
                <Grid container spacing={2}>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    <Required title="Country" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <FormControl size="small" fullWidth error={formik.touched.country && Boolean(formik.errors.country)}>
                                    <InputLabel id="employer">Country</InputLabel>
                                    <Select
                                        fullWidth
                                        labelId="country"
                                        id="country"
                                        name="country"
                                        label="Country"
                                        value={formik.values.country}
                                        onChange={(e) => {
                                            countryChangeHandler(e.target.value);
                                        }}
                                    >
                                        <MenuItem value="">Select</MenuItem>
                                        {countryData.map((item, idx) => (
                                            <MenuItem value={item.id} key={idx}>
                                                {item.name}
                                            </MenuItem>
                                        ))}
                                    </Select>
                                    <FormHelperText>{formik.touched.country && formik.errors.country}</FormHelperText>
                                </FormControl>
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    <Required title="State" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <FormControl size="small" fullWidth error={formik.touched.state && Boolean(formik.errors.state)}>
                                    <InputLabel id="state">State</InputLabel>
                                    <Select
                                        labelId="state"
                                        id="state"
                                        name="state"
                                        label="state"
                                        value={formik.values.state}
                                        onChange={formik.handleChange}
                                    >
                                        <MenuItem value="">Select</MenuItem>
                                        {stateData.map((item, idx) => (
                                            <MenuItem value={item.id} key={idx}>
                                                {item.name}
                                            </MenuItem>
                                        ))}
                                    </Select>
                                    <FormHelperText>{formik.touched.state && formik.errors.state}</FormHelperText>
                                </FormControl>
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    <Required title="City" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <TextField
                                    fullWidth
                                    size="small"
                                    id="city"
                                    name="city"
                                    label="City"
                                    defaultValue={formik.values.city}
                                    onChange={formik.handleChange}
                                    error={formik.touched.city && Boolean(formik.errors.city)}
                                    helperText={formik.touched.city && formik.errors.city}
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

export default AddEditCity;

AddEditCity.propTypes = {
    value: propTypes.object,
    formId: propTypes.string,
    onSubmit: propTypes.func,
    countryData: propTypes.array,
    stateList: propTypes.array
};
