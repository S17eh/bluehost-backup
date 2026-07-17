import propTypes from 'prop-types';
import { Button, DialogActions, FormControl, FormHelperText, Grid, InputLabel, MenuItem, Select, TextField } from '@mui/material';
import { useFormik } from 'formik';
import AnimateButton from 'ui-component/extended/AnimateButton';
import { apiErrorSnackBar, apiSuccessSnackBar, apiValidationSnackBar } from 'utils/SnackBar';
import Required from 'views/utilities/Required';
import * as yup from 'yup';
import { addUpdateRoleLevelApi } from 'apis/RoleLevel';

const validationSchema = yup.object().shape({
    name: yup.string().required('Name is required.'),
    parent_level: yup.string().required('Parent Level is required.')
});

const AddEditRoleLevel = ({ value, formID, onSubmit, parentLevelList }) => {
    const initValue = value ?? false;
    const formik = useFormik({
        initialValues: {
            id: initValue ? initValue.id : '',
            name: initValue ? initValue.level_name : '',
            parent_level: initValue ? initValue.parent_level : '',
            description: initValue ? initValue.description : '',
            formType: initValue && initValue.id ? 'edit' : 'add'
        },
        validationSchema: validationSchema,
        onSubmit: (values, { resetForm }) => {
            addUpdateRoleLevelApi(values)
                .then((res) => {
                    if (res.data && res.data.status === 1) {
                        if (onSubmit) onSubmit();
                        resetForm();
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
        <form id={formID} onSubmit={formik.handleSubmit}>
            <Grid container spacing={2}>
                <Grid item xs={12}>
                    <Grid container alignItems="center" spacing={2}>
                        <Grid item xs={12} sm={12}>
                            <TextField
                                fullWidth
                                size="small"
                                id="name"
                                name="name"
                                label={<Required title="Name" />}
                                value={formik.values.name}
                                onChange={formik.handleChange}
                                error={formik.touched.name && Boolean(formik.errors.name)}
                                helperText={formik.touched.name && formik.errors.name}
                            />
                        </Grid>
                    </Grid>
                </Grid>
                <Grid item xs={12}>
                    <Grid container alignItems="center" spacing={2}>
                        <Grid item xs={12} sm={12}>
                            <FormControl size="small" fullWidth error={formik.touched.parent_level && Boolean(formik.errors.parent_level)}>
                                <InputLabel id="parent_level">
                                    <Required title="Parent Level" />
                                </InputLabel>
                                <Select
                                    fullWidth
                                    labelId="parent_level"
                                    id="parent_level"
                                    name="parent_level"
                                    label={<Required title="Parent Level" />}
                                    value={formik.values.parent_level}
                                    onChange={formik.handleChange}
                                >
                                    {parentLevelList.map((item, idx) => (
                                        <MenuItem value={Number(item.id)} key={idx}>
                                            {item.level_name}
                                        </MenuItem>
                                    ))}
                                </Select>
                                <FormHelperText>{formik.touched.parent_level && formik.errors.parent_level}</FormHelperText>
                            </FormControl>
                        </Grid>
                    </Grid>
                </Grid>
                <Grid item xs={12}>
                    <Grid container alignItems="center" spacing={2}>
                        <Grid item xs={12} sm={12}>
                            <TextField
                                fullWidth
                                multiline
                                rows={4}
                                size="small"
                                id="description"
                                name="description"
                                label="Description"
                                value={formik.values.description}
                                onChange={formik.handleChange}
                            />
                        </Grid>
                    </Grid>
                </Grid>
                {formik.values.formType === 'add' && (
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2} justifyContent="flex-end">
                            <Grid item xs={12}>
                                <DialogActions>
                                    <AnimateButton>
                                        <Button variant="contained" color="primary" type="submit">
                                            save
                                        </Button>
                                    </AnimateButton>
                                    <Button variant="text" color="error" onClick={() => formik.resetForm()}>
                                        clear
                                    </Button>
                                </DialogActions>
                            </Grid>
                        </Grid>
                    </Grid>
                )}
            </Grid>
        </form>
    );
};

AddEditRoleLevel.propTypes = {
    value: propTypes.object,
    formID: propTypes.string,
    onSubmit: propTypes.func,
    parentLevelList: propTypes.array
};

export default AddEditRoleLevel;
