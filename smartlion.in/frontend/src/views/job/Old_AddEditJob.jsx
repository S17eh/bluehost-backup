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
    Typography,
    useTheme
} from '@mui/material';
import { useFormik } from 'formik';
import MUIRichTextEditor from 'mui-rte';
import Required from 'views/utilities/Required';
import { useSelector } from 'react-redux';

import * as yup from 'yup';
import { addUpdateJobApi } from 'apis/Job';
import { apiErrorSnackBar, apiSuccessSnackBar, apiValidationSnackBar } from 'utils/SnackBar';

import moment from 'moment';
import { DesktopDatePicker, LocalizationProvider } from '@mui/x-date-pickers';
import { AdapterMoment } from '@mui/x-date-pickers/AdapterMoment';

const validationSchema = yup.object().shape({
    employer_id: yup.string().required('Employer is required.'),
    title: yup.string().required('Job title is required.'),
    location: yup.string().required('Job location is required.'),
    category: yup.string().required('Job category is required.'),
    position_title: yup.string().required('Position title is required.'),
    no_of_position: yup.string().required('No of position is required.'),
    start_date: yup.date().min(moment().format('YYYY/MM/DD'), 'Please select valid date.').required('Start date is required.'),
    work_experience: yup.string().required('Work experience is required.'),
    salary: yup.string().required('Salary is required.'),
    salary_type: yup.string().required('Salary type is required.'),
    status: yup.string().required('job status is required.')
});

const status = [{ label: 'Active' }, { label: 'Inactive' }];

const AddEditJob = ({ value, formId, onSubmit, employerList }) => {
    const customization = useSelector((state) => state.customization);
    const theme = useTheme();
    const bgColor = theme.palette.grey[50];
    const initValue = value ?? false;

    const formik = useFormik({
        initialValues: {
            id: initValue ? initValue.id : '',
            employer_id: initValue ? initValue.employer_id : '',
            title: initValue ? initValue.title : '',
            requirement: initValue ? initValue.requirement : '',
            location: initValue ? initValue.location : '',
            category: initValue ? initValue.category : '',
            position_title: initValue ? initValue.position_title : '',
            no_of_position: initValue ? initValue.no_of_position : '',
            start_date: initValue ? initValue.start_date : moment().format('YYYY/MM/DD'),
            end_date: initValue ? initValue.end_date : moment().format('YYYY/MM/DD'),
            work_experience: initValue ? initValue.work_experience : '',
            salary: initValue ? initValue.salary : '',
            salary_type: initValue ? initValue.salary_type : '',
            status: initValue ? initValue.status : '',
            formType: initValue && initValue.id ? 'edit' : 'add'
        },
        validationSchema: validationSchema,
        onSubmit: (values) => {
            addUpdateJobApi(values)
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
            <LocalizationProvider dateAdapter={AdapterMoment}>
                <form id={formId} onSubmit={formik.handleSubmit}>
                    <Grid container spacing={2}>
                        <Grid item xs={12}>
                            <Grid container alignItems="center" spacing={2}>
                                <Grid item xs={12} sm={3}>
                                    <Typography variant="subtitle1">
                                        <Required title="Employer" />
                                    </Typography>
                                </Grid>
                                <Grid item xs={12} sm={9}>
                                    <FormControl
                                        size="small"
                                        fullWidth
                                        error={formik.touched.employer_id && Boolean(formik.errors.employer_id)}
                                    >
                                        <InputLabel id="employer">Employer</InputLabel>
                                        <Select
                                            fullWidth
                                            labelId="employer"
                                            id="employer_id"
                                            name="employer_id"
                                            label="Employer"
                                            value={formik.values.employer_id}
                                            onChange={formik.handleChange}
                                        >
                                            {employerList.map((item, idx) => (
                                                <MenuItem value={item.id} key={idx}>
                                                    {item.name}
                                                </MenuItem>
                                            ))}
                                        </Select>
                                        <FormHelperText>{formik.touched.employer_id && formik.errors.employer_id}</FormHelperText>
                                    </FormControl>
                                </Grid>
                            </Grid>
                        </Grid>
                        <Grid item xs={12}>
                            <Grid container alignItems="center" spacing={2}>
                                <Grid item xs={12} sm={3}>
                                    <Typography variant="subtitle1">
                                        <Required title="Job title" />
                                    </Typography>
                                </Grid>
                                <Grid item xs={12} sm={9}>
                                    <TextField
                                        fullWidth
                                        size="small"
                                        id="title"
                                        name="title"
                                        label="Job title"
                                        defaultValue={formik.values.title}
                                        onChange={formik.handleChange}
                                        error={formik.touched.title && Boolean(formik.errors.title)}
                                        helperText={formik.touched.title && formik.errors.title}
                                    />
                                </Grid>
                            </Grid>
                        </Grid>
                        <Grid item xs={12}>
                            <Grid container alignItems="center" spacing={2}>
                                <Grid item xs={12} sm={3}>
                                    <Typography variant="subtitle1">
                                        <Required title="Job Requirement" />
                                    </Typography>
                                </Grid>
                                <Grid item xs={12} sm={9}>
                                    <FormControl
                                        fullWidth
                                        size="small"
                                        sx={{
                                            width: '100%',
                                            minHeight: '140px',
                                            background: bgColor,
                                            border: '1px solid #ccc',
                                            borderRadius: `${customization?.borderRadius}px`
                                        }}
                                    >
                                        <MUIRichTextEditor
                                            onSave={(val) => {
                                                formik.setFieldValue(`requirement`, val);
                                            }}
                                            defaultValue={formik.values.requirement}
                                            label="Type something here..."
                                        />
                                    </FormControl>
                                </Grid>
                            </Grid>
                        </Grid>
                        <Grid item xs={12}>
                            <Grid container alignItems="center" spacing={2}>
                                <Grid item xs={12} sm={3}>
                                    <Typography variant="subtitle1">
                                        <Required title="Job Location" />
                                    </Typography>
                                </Grid>
                                <Grid item xs={12} sm={9}>
                                    <TextField
                                        fullWidth
                                        size="small"
                                        id="location"
                                        name="location"
                                        label="Job location"
                                        defaultValue={formik.values.location}
                                        onChange={formik.handleChange}
                                        error={formik.touched.location && Boolean(formik.errors.location)}
                                        helperText={formik.touched.location && formik.errors.location}
                                    />
                                </Grid>
                            </Grid>
                        </Grid>
                        <Grid item xs={12}>
                            <Grid container alignItems="center" spacing={2}>
                                <Grid item xs={12} sm={3}>
                                    <Typography variant="subtitle1">
                                        <Required title="Job category" />
                                    </Typography>
                                </Grid>
                                <Grid item xs={12} sm={9}>
                                    <TextField
                                        fullWidth
                                        size="small"
                                        id="category"
                                        name="category"
                                        label="Job category"
                                        defaultValue={formik.values.category}
                                        onChange={formik.handleChange}
                                        error={formik.touched.category && Boolean(formik.errors.category)}
                                        helperText={formik.touched.category && formik.errors.category}
                                    />
                                </Grid>
                            </Grid>
                        </Grid>
                        <Grid item xs={12}>
                            <Grid container alignItems="center" spacing={2}>
                                <Grid item xs={12} sm={3}>
                                    <Typography variant="subtitle1">
                                        <Required title="Position" />
                                    </Typography>
                                </Grid>
                                <Grid item xs={12} sm={6}>
                                    <TextField
                                        fullWidth
                                        size="small"
                                        id="position_title"
                                        name="position_title"
                                        label="Position Title"
                                        defaultValue={formik.values.position_title}
                                        onChange={formik.handleChange}
                                        error={formik.touched.position_title && Boolean(formik.errors.position_title)}
                                        helperText={formik.touched.position_title && formik.errors.position_title}
                                    />
                                </Grid>
                                <Grid item xs={12} sm={3}>
                                    <TextField
                                        fullWidth
                                        size="small"
                                        type="number"
                                        id="no_of_position"
                                        name="no_of_position"
                                        label="No. of position"
                                        InputProps={{ inputProps: { min: 0 } }}
                                        defaultValue={formik.values.no_of_position}
                                        onChange={formik.handleChange}
                                        error={formik.touched.no_of_position && Boolean(formik.errors.no_of_position)}
                                        helperText={formik.touched.no_of_position && formik.errors.no_of_position}
                                    />
                                </Grid>
                            </Grid>
                        </Grid>
                        <Grid item xs={12}>
                            <Grid container alignItems="center" spacing={2}>
                                <Grid item xs={12} sm={3}>
                                    <Typography variant="subtitle1">
                                        <Required title="Job date" />
                                    </Typography>
                                </Grid>
                                <Grid item xs={12} sm={4.5}>
                                    <DesktopDatePicker
                                        id="start_date"
                                        name="start_date"
                                        label="Start date"
                                        inputFormat="YYYY/MM/DD"
                                        value={formik.values.start_date}
                                        minDate={moment()}
                                        onChange={(date) => {
                                            formik.setFieldValue('start_date', date);
                                        }}
                                        renderInput={(params) => (
                                            <TextField
                                                fullWidth
                                                size="small"
                                                {...params}
                                                error={formik.touched.start_date && Boolean(formik.errors.start_date)}
                                                helperText={formik.touched.start_date && formik.errors.start_date}
                                            />
                                        )}
                                    />
                                </Grid>
                                <Grid item xs={12} sm={4.5}>
                                    <DesktopDatePicker
                                        id="end_date"
                                        name="end_date"
                                        label="End date"
                                        inputFormat="YYYY/MM/DD"
                                        minDate={moment()}
                                        value={formik.values.end_date}
                                        onChange={(date) => {
                                            formik.setFieldValue('end_date', date);
                                        }}
                                        renderInput={(params) => (
                                            <TextField
                                                fullWidth
                                                size="small"
                                                {...params}
                                                error={formik.touched.end_date && Boolean(formik.errors.end_date)}
                                                helperText={formik.touched.end_date && formik.errors.end_date}
                                            />
                                        )}
                                    />
                                </Grid>
                            </Grid>
                        </Grid>
                        <Grid item xs={12}>
                            <Grid container alignItems="center" spacing={2}>
                                <Grid item xs={12} sm={3}>
                                    <Typography variant="subtitle1">
                                        <Required title="Work experience" />
                                    </Typography>
                                </Grid>
                                <Grid item xs={12} sm={9}>
                                    <TextField
                                        fullWidth
                                        size="small"
                                        id="work_experience"
                                        name="work_experience"
                                        label="Work experience"
                                        defaultValue={formik.values.work_experience}
                                        onChange={formik.handleChange}
                                        error={formik.touched.work_experience && Boolean(formik.errors.work_experience)}
                                        helperText={formik.touched.work_experience && formik.errors.work_experience}
                                    />
                                </Grid>
                            </Grid>
                        </Grid>
                        <Grid item xs={12}>
                            <Grid container alignItems="center" spacing={2}>
                                <Grid item xs={12} sm={3}>
                                    <Typography variant="subtitle1">
                                        <Required title="Salary" />
                                    </Typography>
                                </Grid>
                                <Grid item xs={12} sm={5.5}>
                                    <TextField
                                        fullWidth
                                        size="small"
                                        id="salary"
                                        name="salary"
                                        label="Salary"
                                        defaultValue={formik.values.salary}
                                        onChange={formik.handleChange}
                                        error={formik.touched.salary && Boolean(formik.errors.salary)}
                                        helperText={formik.touched.salary && formik.errors.salary}
                                    />
                                </Grid>
                                <Grid item xs={12} sm={3.5}>
                                    <TextField
                                        fullWidth
                                        size="small"
                                        id="salary_type"
                                        name="salary_type"
                                        label="Salary type"
                                        defaultValue={formik.values.salary_type}
                                        onChange={formik.handleChange}
                                        error={formik.touched.salary_type && Boolean(formik.errors.salary_type)}
                                        helperText={formik.touched.salary_type && formik.errors.salary_type}
                                    />
                                </Grid>
                            </Grid>
                        </Grid>
                        <Grid item xs={12}>
                            <Grid container alignItems="center" spacing={2}>
                                <Grid item xs={12} sm={3}>
                                    <Typography variant="subtitle1">
                                        <Required title="Job status" />
                                    </Typography>
                                </Grid>
                                <Grid item xs={12} sm={9}>
                                    <Autocomplete
                                        options={status ?? []}
                                        getOptionLabel={(option) => (option.label ? option.label : '')}
                                        value={
                                            formik.values.status !== '' ? status.filter((a) => a.label === formik.values.status)[0] : null
                                        }
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
                                                label="Job status"
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
                        {/* <FormControl fullWidth> */}
                        {/* <MUIRichTextEditor controls={[]} defaultValue={formik.values.description} readOnly={true} /> */}
                        {/* </FormControl> */}
                    </Grid>
                </form>
            </LocalizationProvider>
        </Box>
    );
};

AddEditJob.propTypes = {
    value: propTypes.object,
    formId: propTypes.string.isRequired,
    onSubmit: propTypes.func,
    employerList: propTypes.array
};

export default AddEditJob;
