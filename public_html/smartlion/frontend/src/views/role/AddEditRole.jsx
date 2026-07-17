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
import { addUpdateRoleApi } from 'apis/Role';
import { useFormik } from 'formik';
import { apiErrorSnackBar, apiSuccessSnackBar, apiValidationSnackBar } from 'utils/SnackBar';
import Required from 'views/utilities/Required';

// third party
import * as yup from 'yup';

const validationSchema = yup.object().shape({
    name: yup.string().required('Role name is required.'),
    permission_group: yup.string().required('Permission group is required.'),
    role_level: yup.string().required('Role level is required.'),
    status: yup.string().required('Role status is required.')
});

const status = [{ label: 'Active' }, { label: 'Inactive' }];

const AddEditRole = ({ RoleValue, formId, onSubmit, initList }) => {
    const initValue = RoleValue ?? false;
    const can = initValue && initValue.can_delete === 'No' && true;

    const formik = useFormik({
        initialValues: {
            id: initValue ? initValue.id : '',
            name: initValue ? initValue.name : '',
            permission_group: initValue ? initValue.group_id : '',
            role_level: initValue ? initValue.level_id : '',
            status: initValue ? initValue.status : '',
            formType: initValue && initValue.id ? 'edit' : 'add'
        },
        validationSchema: validationSchema,
        onSubmit: (values) => {
            addUpdateRoleApi(values)
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
                                    <Required title="Role name" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <TextField
                                    fullWidth
                                    size="small"
                                    id="name"
                                    name="name"
                                    label="Role name"
                                    defaultValue={formik.values.name}
                                    onChange={formik.handleChange}
                                    error={formik.touched.name && Boolean(formik.errors.name)}
                                    helperText={formik.touched.name && formik.errors.name}
                                    disabled={can}
                                />
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    <Required title="Permission group" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <FormControl
                                    size="small"
                                    fullWidth
                                    error={formik.touched.permission_group && Boolean(formik.errors.permission_group)}
                                >
                                    <InputLabel id="permission_group">
                                        <Required title="Permission group" />
                                    </InputLabel>
                                    <Select
                                        fullWidth
                                        labelId="permission_group"
                                        id="permission_group"
                                        name="permission_group"
                                        label="Permission group"
                                        value={formik.values.permission_group}
                                        onChange={formik.handleChange}
                                    >
                                        {initList.permissionGroupData.map((item, idx) => (
                                            <MenuItem value={item.id} key={idx}>
                                                {item.name}
                                            </MenuItem>
                                        ))}
                                    </Select>
                                    <FormHelperText>{formik.touched.permission_group && formik.errors.permission_group}</FormHelperText>
                                </FormControl>
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    <Required title="Role Level" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <FormControl size="small" fullWidth error={formik.touched.role_level && Boolean(formik.errors.role_level)}>
                                    <InputLabel id="role_level">
                                        <Required title="Role Level" />
                                    </InputLabel>
                                    <Select
                                        fullWidth
                                        labelId="role_level"
                                        id="role_level"
                                        name="role_level"
                                        label="Role Level"
                                        value={formik.values.role_level}
                                        onChange={formik.handleChange}
                                    >
                                        {/* <MenuItem value="" disabled>
                                            Select
                                        </MenuItem> */}
                                        {initList.roleLevelData.map((item, idx) => (
                                            <MenuItem value={item.id} key={idx}>
                                                {item.level_name}
                                            </MenuItem>
                                        ))}
                                    </Select>
                                    <FormHelperText>{formik.touched.role_level && formik.errors.role_level}</FormHelperText>
                                </FormControl>
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    <Required title="Role status" />
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
                                    disabled={can}
                                    renderInput={(params) => (
                                        <TextField
                                            {...params}
                                            size="small"
                                            id="status"
                                            name="status"
                                            label="Role status"
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

AddEditRole.propTypes = {
    RoleValue: propTypes.object,
    formId: propTypes.string.isRequired,
    onSubmit: propTypes.func,
    initList: propTypes.object
};

export default AddEditRole;
