import propTypes from 'prop-types';
import {
    Autocomplete,
    Box,
    Button,
    Checkbox,
    createFilterOptions,
    FormControl,
    FormControlLabel,
    FormGroup,
    FormHelperText,
    Grid,
    IconButton,
    InputAdornment,
    InputLabel,
    MenuItem,
    Paper,
    Radio,
    RadioGroup,
    Select,
    Stack,
    Switch,
    TextField,
    Typography
} from '@mui/material';
import { useFormik } from 'formik';
import { AddCircleOutlineOutlined, DeleteOutline } from '@mui/icons-material';
import { gridSpacing } from 'store/constant';
import { apiErrorSnackBar, apiSuccessSnackBar, apiValidationSnackBar } from 'utils/SnackBar';
import Required from 'views/utilities/Required';
import * as yup from 'yup';
import { DesktopDatePicker, LocalizationProvider } from '@mui/x-date-pickers';
import { AdapterMoment } from '@mui/x-date-pickers/AdapterMoment';
import moment from 'moment';
import { useEffect, useState } from 'react';
import { addUpdateCandidateApi, candidateCityApi, candidateCourseListApi, candidateStateApi } from 'apis/Candidate';
import { useMemo } from 'react';

const status = [{ label: 'Active' }, { label: 'Inactive' }];

const initExp = {
    company_name: '',
    designation: '',
    start_date: '',
    end_date: '',
    is_default_company: 0
};

const initEducation = {
    type: '',
    courseList: [],
    course_id: '',
    specification: '',
    institute_name: '',
    start_date: '',
    end_date: ''
};

const SUPPORTED_FORMATS = ['image/jpg', 'image/jpeg', 'image/gif', 'image/png'];
const ALPHA_NUMERIC_DASH_REGEX = /^[aA-zZ\s]+$/;

const validationSchema = yup.object().shape({
    source_from: yup.string().required('Source From is required.'),
    name: yup.string().required('Full Name is required.'),
    email: yup.string().required('Email is required.'),
    mobile_number: yup.array().of(yup.string().required('Mobile Number is required.')),
    current_ctc_lakh: yup.string().required('Current CTC Lakh Amount is required.'),
    current_ctc_thousand: yup.string().required('Current CTC Thousand Amount is required.'),
    expected_ctc_lakh: yup.string().required('Expected CTC Lakh Amount is required.'),
    expected_ctc_thousand: yup.string().required('Expected CTC Thousand Amount is required.'),
    experience: yup.array().when('experience_fresher', {
        is: '0',
        then: yup.array().of(
            yup.object().shape({
                company_name: yup.string().required('Company Name is required.'),
                start_date: yup.string().required('Start Date is required.'),
                end_date: yup.string().required('End Date is required.')
            })
        )
    }),
    education: yup.array().of(
        yup.object().shape({
            type: yup.string().required('Education Type is required.'),
            course_id: yup.string().required('Type of Course is required.'),
            specification: yup.string().required('Course Specification is required.'),
            institute_name: yup.string().required('Institute Name is required.'),
            start_date: yup.string().required('Start Date is required.'),
            end_date: yup.string().required('End Date is required.')
        })
    ),
    // current_skill: yup.string().required('Current Skill is required.').matches(ALPHA_NUMERIC_DASH_REGEX, 'Only alphabets are allowed'),
    current_skill: yup.array().min(1, 'Current Skill is required.').required('Current Skill is required.'),
    profile_picture: yup
        .mixed()
        .when('formType', {
            is: 'add',
            then: yup.mixed().required('Profile picture is required.')
        })
        .test(5000000, 'File size is too big put under 5 MB', (value) => (value ? value.size <= 5000000 : true))
        .test('format', 'Invalid file formate', (value) => (value ? SUPPORTED_FORMATS.includes(value.type) : true)),
    address: yup.string().required('Address is required.'),
    country: yup.string().required('Country is required.'),
    state: yup.string().required('State is required.'),
    city: yup.string().required('City is required.'),
    postcode: yup.string().required('Postcode is required.'),
    dob: yup.date().required('Birth Date is required.'),
    notice_period: yup.string().nullable().required('Notice Period is required.'),
    marital_status: yup.string().nullable().required('Marital Status is required.'),
    // assign: yup.string().nullable().required('Assign To is required.'),
    upload_resume: yup
        .mixed()
        .when('formType', {
            is: 'add',
            then: yup.mixed().required('Upload Resume is required.')
        })
        .test(5000000, 'File size is too big put under 5 MB', (value) => (value ? value.size <= 5000000 : true))
});

const AddEditCandidate = ({ value, formId, onSubmit, initDataSet }) => {
    const filter = createFilterOptions();
    const [noticeValue, setNoticeValue] = useState(null);
    const [keySkill, setKeySkill] = useState(initDataSet.key_skill);
    const [stateList, setStateList] = useState(initDataSet.stateList);
    const [cityList, setCityList] = useState(initDataSet.cityList);
    const [lakhList, setLakhList] = useState([]);
    const [thousandList, setThousandList] = useState([]);

    const initValue = value ?? false;
    const formik = useFormik({
        initialValues: {
            id: initValue ? initValue.id : '',
            name: initValue ? initValue.full_name : '',
            source_from: initValue ? initValue.source_from : '',
            alternate_email: initValue ? initValue.alternate_email : [''],
            email: initValue ? initValue.email : '',
            mobile_number: initValue ? initValue.mobile_number : [''],
            current_ctc_lakh: initValue ? initValue.current_ctc_lakh : '',
            current_ctc_thousand: initValue ? initValue.current_ctc_thousand : '',
            expected_ctc_lakh: initValue ? initValue.expected_ctc_lakh : '',
            expected_ctc_thousand: initValue ? initValue.expected_ctc_thousand : '',
            experience_fresher: initValue ? initValue.experience : '0',
            experience: initValue ? (initValue.experiences.length > 0 ? initValue.experiences : [initExp]) : [initExp],
            education: initValue ? initValue.educations : [initEducation],
            notice_period: initValue ? initValue.notice_period : '',
            // current_skill: initValue ? initValue.current_skill : [],
            current_skill: [],
            // profile_picture: initValue ? initValue.profile_picture : '',
            profile_picture: '',
            address: initValue ? initValue.address : '',
            country: initValue ? initValue.country_id : '',
            state: initValue ? initValue.state_id : '',
            city: initValue ? initValue.city_id : '',
            postcode: initValue ? initValue.post_code : '',
            dob: initValue ? moment(initValue.date_of_birth) : '',
            gender: initValue ? initValue.gender : 'Male',
            status: initValue ? initValue.status : 'Active',
            marital_status: initValue ? initValue.marital_status : '',
            assign: '',
            upload_resume: initValue ? initValue.upload_resume : '',
            formType: initValue && initValue.id ? 'edit' : 'add'
        },
        validationSchema: validationSchema,
        onSubmit: (values, { resetForm }) => {
            values.dob = moment(values.dob).format('YYYY-MM-DD');
            addUpdateCandidateApi(values)
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

    useEffect(() => {
        let skillData = [];
        initValue != false && (skillData = keySkill.filter((a) => initValue.current_skill.some((b) => b === a.name)));
        formik.setFieldValue('current_skill', skillData);
    }, []);

    const DegreeTypeChange = (val, id) => {
        formik.setFieldValue(`education[${id}].type`, val.target.value);
        candidateCourseListApi({ type: val.target.value })
            .then((res) => {
                formik.setFieldValue(`education[${id}].courseList`, res.data.data);
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };

    const countryChangeHandler = (countryID) => {
        formik.setFieldValue('country', countryID);
        formik.setFieldValue('state', '');
        formik.setFieldValue('city', '');
        formik.setFieldValue('country', countryID);
        candidateStateApi({ country_id: countryID })
            .then((res) => {
                setStateList(res.data.data);
                setCityList([]);
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };

    const stateChangeHandler = (ID) => {
        formik.setFieldValue('state', ID);
        candidateCityApi({ state_id: ID })
            .then((res) => {
                setCityList(res.data.data);
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };

    const CTCLakhData = [];
    useMemo(() => {
        for (let index = 0; index <= 200; index++) {
            CTCLakhData.push({ id: index, Amount: `${index} Lakh` });
        }
        setLakhList(CTCLakhData);
    }, []);

    const CTCThousandData = [];
    useMemo(() => {
        for (let index = 0; index <= 95; index++) {
            if (index % 5 == 0) {
                CTCThousandData.push({ id: index, Amount: `${index} Thousand` });
            }
        }
        setThousandList(CTCThousandData);
    }, []);

    // CheckTouchValidation
    const checkTouchValidation = (filedName, index, columnName) => {
        if (formik.touched[filedName] && formik.touched[filedName][0] && formik.touched[filedName][0][columnName]) {
            if (formik.errors[filedName] && formik.errors[filedName][index] && formik.errors[filedName][index][columnName]) {
                return Boolean(formik.errors[filedName][index][columnName]);
            }
            return false;
        }
        return false;
    };

    const checkErrorValidation = (filedName, index, columnName) => {
        if (
            formik.touched[filedName] &&
            formik.errors[filedName] &&
            formik.errors[filedName][index] &&
            formik.errors[filedName][index][columnName]
        ) {
            return formik.errors[filedName][index][columnName];
        }
        return '';
    };

    return (
        <LocalizationProvider dateAdapter={AdapterMoment}>
            <form id={formId} onSubmit={formik.handleSubmit}>
                <Grid container spacing={2}>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={3}>
                                <Typography variant="subtitle1">
                                    <Required title="Source" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={9}>
                                <FormControl
                                    size="small"
                                    fullWidth
                                    error={formik.touched.source_from && Boolean(formik.errors.source_from)}
                                >
                                    <InputLabel id="source_from">
                                        <Required title="Source" />
                                    </InputLabel>
                                    <Select
                                        fullWidth
                                        labelId="source_from"
                                        id="source_from"
                                        name="source_from"
                                        label="Source"
                                        value={formik.values.source_from}
                                        onChange={formik.handleChange}
                                    >
                                        <MenuItem value="" disabled>
                                            Select
                                        </MenuItem>
                                        {initDataSet.sourceFromList.map((item, idx) => (
                                            <MenuItem value={item} key={idx}>
                                                {item}
                                            </MenuItem>
                                        ))}
                                    </Select>
                                    <FormHelperText>{formik.touched.source_from && formik.errors.source_from}</FormHelperText>
                                </FormControl>
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={3}>
                                <Typography variant="subtitle1">
                                    <Required title="Full Name" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={9}>
                                <TextField
                                    fullWidth
                                    size="small"
                                    id="name"
                                    name="name"
                                    label={<Required title="Full Name" />}
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
                            <Grid item xs={12} sm={3}>
                                <Typography variant="subtitle1">
                                    <Required title="Email" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={9}>
                                <TextField
                                    fullWidth
                                    size="small"
                                    id="email"
                                    name="email"
                                    label={<Required title="Email" />}
                                    value={formik.values.email}
                                    onChange={formik.handleChange}
                                    error={formik.touched.email && Boolean(formik.errors.email)}
                                    helperText={formik.touched.email && formik.errors.email}
                                />
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={3}>
                                <Typography variant="subtitle1">Alternate Email</Typography>
                            </Grid>
                            <Grid item xs={12} sm={9}>
                                {formik.values.alternate_email.map((v, idx) => (
                                    <Grid container alignItems="center" spacing={1} mt={idx < 1 ? '' : 1} key={idx}>
                                        <Grid item xs={12} sm={12}>
                                            <TextField
                                                fullWidth
                                                size="small"
                                                id={`alternate_email.${idx}`}
                                                name={`alternate_email.${idx}`}
                                                label="Alternate Email"
                                                value={v}
                                                onChange={formik.handleChange}
                                                InputProps={{
                                                    endAdornment:
                                                        idx < 1 ? (
                                                            <InputAdornment position="end">
                                                                <IconButton
                                                                    edge="end"
                                                                    color="primary"
                                                                    component="label"
                                                                    onClick={() => {
                                                                        const currentExp = formik.values.alternate_email;
                                                                        formik.setFieldValue('alternate_email', [...currentExp, '']);
                                                                    }}
                                                                >
                                                                    <AddCircleOutlineOutlined fontSize="medium" />
                                                                </IconButton>
                                                            </InputAdornment>
                                                        ) : (
                                                            <InputAdornment position="end">
                                                                <IconButton
                                                                    edge="end"
                                                                    color="error"
                                                                    component="label"
                                                                    onClick={() => {
                                                                        const currentExp = formik.values.alternate_email;
                                                                        formik.setFieldValue(
                                                                            'alternate_email',
                                                                            currentExp.filter((i, ck) => ck !== idx)
                                                                        );
                                                                    }}
                                                                >
                                                                    <DeleteOutline fontSize="medium" />
                                                                </IconButton>
                                                            </InputAdornment>
                                                        )
                                                }}
                                            />
                                        </Grid>
                                    </Grid>
                                ))}
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={3}>
                                <Typography variant="subtitle1">
                                    <Required title="Mobile Number" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={9}>
                                {formik.values.mobile_number.map((v, idx) => (
                                    <Grid container alignItems="center" spacing={1} mt={idx < 1 ? '' : 1} key={idx}>
                                        <Grid item xs={12} sm={12}>
                                            <TextField
                                                fullWidth
                                                size="small"
                                                id={`mobile_number.${idx}`}
                                                name={`mobile_number.${idx}`}
                                                label={<Required title="Mobile Number" />}
                                                value={v}
                                                onChange={formik.handleChange}
                                                error={
                                                    formik.touched.mobile_number &&
                                                    formik.errors.mobile_number &&
                                                    formik.touched.mobile_number[idx] &&
                                                    Boolean(formik.errors.mobile_number[idx])
                                                }
                                                helperText={
                                                    formik.touched.mobile_number &&
                                                    formik.errors.mobile_number &&
                                                    formik.touched.mobile_number[idx] &&
                                                    formik.errors.mobile_number[idx]
                                                }
                                                InputProps={{
                                                    endAdornment:
                                                        idx < 1 ? (
                                                            <InputAdornment position="end">
                                                                <IconButton
                                                                    edge="end"
                                                                    color="primary"
                                                                    component="label"
                                                                    onClick={() => {
                                                                        const currentExp = formik.values.mobile_number;
                                                                        formik.setFieldValue('mobile_number', [...currentExp, '']);
                                                                    }}
                                                                >
                                                                    <AddCircleOutlineOutlined fontSize="medium" />
                                                                </IconButton>
                                                            </InputAdornment>
                                                        ) : (
                                                            <InputAdornment position="end">
                                                                <IconButton
                                                                    edge="end"
                                                                    color="error"
                                                                    component="label"
                                                                    onClick={() => {
                                                                        const currentExp = formik.values.mobile_number;
                                                                        formik.setFieldValue(
                                                                            'mobile_number',
                                                                            currentExp.filter((i, ck) => ck !== idx)
                                                                        );
                                                                    }}
                                                                >
                                                                    <DeleteOutline fontSize="medium" />
                                                                </IconButton>
                                                            </InputAdornment>
                                                        )
                                                }}
                                            />
                                        </Grid>
                                    </Grid>
                                ))}
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={3}>
                                <Typography variant="subtitle1">
                                    <Required title="Current CTC" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={4.5}>
                                <FormControl
                                    size="small"
                                    fullWidth
                                    error={formik.touched.current_ctc_lakh && Boolean(formik.errors.current_ctc_lakh)}
                                >
                                    <InputLabel id="current_ctc_lakh">
                                        <Required title="Lakhs" />
                                    </InputLabel>
                                    <Select
                                        fullWidth
                                        labelId="current_ctc_lakh"
                                        id="current_ctc_lakh"
                                        name="current_ctc_lakh"
                                        label="Lakhs"
                                        value={formik.values.current_ctc_lakh}
                                        onChange={formik.handleChange}
                                    >
                                        <MenuItem value="" disabled>
                                            Select
                                        </MenuItem>
                                        {lakhList.map((item, idx) => (
                                            <MenuItem value={item.id} key={idx}>
                                                {item.Amount}
                                            </MenuItem>
                                        ))}
                                    </Select>
                                    <FormHelperText>{formik.touched.current_ctc_lakh && formik.errors.current_ctc_lakh}</FormHelperText>
                                </FormControl>
                            </Grid>
                            <Grid item xs={12} sm={4.5}>
                                <FormControl
                                    size="small"
                                    fullWidth
                                    error={formik.touched.current_ctc_thousand && Boolean(formik.errors.current_ctc_thousand)}
                                >
                                    <InputLabel id="current_ctc_thousand">
                                        <Required title="Thousands" />
                                    </InputLabel>
                                    <Select
                                        fullWidth
                                        labelId="current_ctc_thousand"
                                        id="current_ctc_thousand"
                                        name="current_ctc_thousand"
                                        label="Thousands"
                                        value={formik.values.current_ctc_thousand}
                                        onChange={formik.handleChange}
                                    >
                                        <MenuItem value="" disabled>
                                            Select
                                        </MenuItem>
                                        {thousandList.map((item, idx) => (
                                            <MenuItem value={item.id} key={idx}>
                                                {item.Amount}
                                            </MenuItem>
                                        ))}
                                    </Select>
                                    <FormHelperText>
                                        {formik.touched.current_ctc_thousand && formik.errors.current_ctc_thousand}
                                    </FormHelperText>
                                </FormControl>
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={3}>
                                <Typography variant="subtitle1">
                                    <Required title="Expected CTC" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={4.5}>
                                <FormControl
                                    size="small"
                                    fullWidth
                                    error={formik.touched.expected_ctc_lakh && Boolean(formik.errors.expected_ctc_lakh)}
                                >
                                    <InputLabel id="expected_ctc_lakh">
                                        <Required title="Lakhs" />
                                    </InputLabel>
                                    <Select
                                        fullWidth
                                        labelId="expected_ctc_lakh"
                                        id="expected_ctc_lakh"
                                        name="expected_ctc_lakh"
                                        label="Lakhs"
                                        value={formik.values.expected_ctc_lakh}
                                        onChange={formik.handleChange}
                                    >
                                        <MenuItem value="" disabled>
                                            Select
                                        </MenuItem>
                                        {lakhList.map((item, idx) => (
                                            <MenuItem value={item.id} key={idx}>
                                                {item.Amount}
                                            </MenuItem>
                                        ))}
                                    </Select>
                                    <FormHelperText>{formik.touched.expected_ctc_lakh && formik.errors.expected_ctc_lakh}</FormHelperText>
                                </FormControl>
                            </Grid>
                            <Grid item xs={12} sm={4.5}>
                                <FormControl
                                    size="small"
                                    fullWidth
                                    error={formik.touched.expected_ctc_thousand && Boolean(formik.errors.expected_ctc_thousand)}
                                >
                                    <InputLabel id="expected_ctc_thousand">
                                        <Required title="Thousands" />
                                    </InputLabel>
                                    <Select
                                        fullWidth
                                        labelId="expected_ctc_thousand"
                                        id="expected_ctc_thousand"
                                        name="expected_ctc_thousand"
                                        label="Thousands"
                                        value={formik.values.expected_ctc_thousand}
                                        onChange={formik.handleChange}
                                    >
                                        <MenuItem value="" disabled>
                                            Select
                                        </MenuItem>
                                        {thousandList.map((item, idx) => (
                                            <MenuItem value={item.id} key={idx}>
                                                {item.Amount}
                                            </MenuItem>
                                        ))}
                                    </Select>
                                    <FormHelperText>
                                        {formik.touched.expected_ctc_thousand && formik.errors.expected_ctc_thousand}
                                    </FormHelperText>
                                </FormControl>
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={3}>
                                <Typography variant="subtitle1">
                                    <Required title="Experience" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={9}>
                                <Grid container alignItems="center" spacing={2}>
                                    <Grid item xs={12} sm={9.5}>
                                        <Stack direction="row" spacing={1} alignItems="center">
                                            <Typography>Experience</Typography>
                                            <Switch
                                                name="experience_fresher"
                                                id="experience_fresher"
                                                checked={Boolean(Number(formik.values.experience_fresher))}
                                                onChange={(e) => {
                                                    const val = e.target.checked;
                                                    formik.setFieldValue('experience_fresher', val === true ? '1' : '0');
                                                }}
                                            />
                                            <Typography>Fresher</Typography>
                                        </Stack>
                                    </Grid>
                                    {Boolean(Number(formik.values.experience_fresher)) == false && (
                                        <Grid item xs={12} sm={2.5} mt={1}>
                                            <Grid container alignItems="center" spacing={gridSpacing} justifyContent="flex-end">
                                                <Button
                                                    onClick={() => {
                                                        const currentExp = formik.values.experience;
                                                        formik.setFieldValue('experience', [...currentExp, initExp]);
                                                    }}
                                                >
                                                    + Add Experience
                                                </Button>
                                            </Grid>
                                        </Grid>
                                    )}
                                </Grid>
                            </Grid>
                            {Boolean(Number(formik.values.experience_fresher)) == false && (
                                <Grid container alignItems="center" spacing={gridSpacing} justifyContent="flex-end">
                                    <Grid item xs={12} sm={9}>
                                        {formik.values.experience.map((_, idx) => (
                                            <Box sx={{ m: 2 }} key={idx}>
                                                <Paper
                                                    style={{
                                                        padding: 10,
                                                        borderRadius: 6
                                                    }}
                                                    variant="outlined"
                                                >
                                                    <Grid container spacing={2}>
                                                        <Grid item xs={12}>
                                                            <Grid container alignItems="center" spacing={2}>
                                                                <Grid item xs={12} sm={12}>
                                                                    <TextField
                                                                        fullWidth
                                                                        size="small"
                                                                        name={`experience[${idx}].company_name`}
                                                                        id={`experience[${idx}].company_name`}
                                                                        label={<Required title="Company Name" />}
                                                                        value={formik.values.experience[idx].company_name}
                                                                        onChange={formik.handleChange}
                                                                        error={checkTouchValidation('experience', idx, 'company_name')}
                                                                        helperText={checkErrorValidation('experience', idx, 'company_name')}
                                                                    />
                                                                </Grid>
                                                            </Grid>
                                                        </Grid>
                                                        <Grid item xs={12}>
                                                            <Grid container alignItems="center" spacing={2}>
                                                                <Grid item xs={12} sm={12}>
                                                                    <TextField
                                                                        fullWidth
                                                                        multiline
                                                                        size="small"
                                                                        rows={4}
                                                                        name={`experience[${idx}].designation`}
                                                                        id={`experience[${idx}].designation`}
                                                                        label="Designation"
                                                                        value={formik.values.experience[idx].designation}
                                                                        onChange={formik.handleChange}
                                                                    />
                                                                </Grid>
                                                            </Grid>
                                                        </Grid>
                                                        <Grid item xs={12}>
                                                            <Grid container alignItems="center" spacing={2}>
                                                                <Grid item xs={12} sm={6}>
                                                                    <DesktopDatePicker
                                                                        name={`experience[${idx}].start_date`}
                                                                        id={`experience[${idx}].start_date`}
                                                                        value={formik.values.experience[idx].start_date}
                                                                        label={<Required title="Start Date" />}
                                                                        inputFormat="YYYY/MM/DD"
                                                                        maxDate={moment()}
                                                                        onChange={(date) => {
                                                                            formik.setFieldValue(
                                                                                `experience[${idx}].start_date`,
                                                                                moment(date).format('YYYY-MM-DD')
                                                                            );
                                                                        }}
                                                                        renderInput={(params) => (
                                                                            <TextField
                                                                                fullWidth
                                                                                size="small"
                                                                                {...params}
                                                                                error={checkTouchValidation(
                                                                                    'experience',
                                                                                    idx,
                                                                                    'start_date'
                                                                                )}
                                                                                helperText={checkErrorValidation(
                                                                                    'experience',
                                                                                    idx,
                                                                                    'start_date'
                                                                                )}
                                                                            />
                                                                        )}
                                                                    />
                                                                </Grid>
                                                                {formik.values.experience[idx].is_default_company === 0 ? (
                                                                    <Grid item xs={12} sm={6} key="key">
                                                                        <DesktopDatePicker
                                                                            name={`experience[${idx}].end_date`}
                                                                            id={`experience[${idx}].end_date`}
                                                                            value={formik.values.experience[idx].end_date}
                                                                            label={<Required title="End Date" />}
                                                                            inputFormat="YYYY/MM/DD"
                                                                            minDate={formik.values.experience[idx].start_date}
                                                                            maxDate={moment()}
                                                                            onChange={(date) => {
                                                                                formik.setFieldValue(
                                                                                    `experience[${idx}].end_date`,
                                                                                    moment(date).format('YYYY-MM-DD')
                                                                                );
                                                                            }}
                                                                            renderInput={(params) => (
                                                                                <TextField
                                                                                    fullWidth
                                                                                    size="small"
                                                                                    {...params}
                                                                                    error={checkTouchValidation(
                                                                                        'experience',
                                                                                        idx,
                                                                                        'end_date'
                                                                                    )}
                                                                                    helperText={checkErrorValidation(
                                                                                        'experience',
                                                                                        idx,
                                                                                        'end_date'
                                                                                    )}
                                                                                />
                                                                            )}
                                                                        />
                                                                    </Grid>
                                                                ) : (
                                                                    <Grid item xs={12} sm={6} key="key">
                                                                        To Present
                                                                    </Grid>
                                                                )}
                                                            </Grid>
                                                        </Grid>
                                                        <Grid item xs={12}>
                                                            <FormGroup>
                                                                <FormControlLabel
                                                                    control={
                                                                        <Checkbox
                                                                            name={`experience[${idx}].is_default_company`}
                                                                            id={`experience[${idx}].is_default_company`}
                                                                            checked={Boolean(
                                                                                Number(formik.values.experience[idx].is_default_company)
                                                                            )}
                                                                            onChange={(e) => {
                                                                                const val = e.target.checked;
                                                                                formik.setFieldValue(
                                                                                    `experience[${idx}].is_default_company`,
                                                                                    val === true ? 1 : 0
                                                                                );
                                                                                formik.setFieldValue(
                                                                                    `experience[${idx}].end_date`,
                                                                                    moment().format('YYYY-MM-DD')
                                                                                );
                                                                            }}
                                                                        />
                                                                    }
                                                                    label="Is your current company?"
                                                                />
                                                            </FormGroup>
                                                        </Grid>
                                                        <Grid item xs={12}>
                                                            <Grid
                                                                container
                                                                alignItems="center"
                                                                spacing={gridSpacing}
                                                                justifyContent="flex-end"
                                                            >
                                                                {idx > 0 && (
                                                                    <Button
                                                                        type="reset"
                                                                        variant="text"
                                                                        color="error"
                                                                        onClick={() => {
                                                                            const currentExp = formik.values.experience;
                                                                            formik.setFieldValue(
                                                                                'experience',
                                                                                currentExp.filter((i, ck) => ck !== idx)
                                                                            );
                                                                        }}
                                                                    >
                                                                        Delete
                                                                    </Button>
                                                                )}
                                                            </Grid>
                                                        </Grid>
                                                    </Grid>
                                                </Paper>
                                            </Box>
                                        ))}
                                    </Grid>
                                </Grid>
                            )}
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={3}>
                                <Typography variant="subtitle1">
                                    <Required title="Notice Period" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={9}>
                                <Autocomplete
                                    fullWidth
                                    size="small"
                                    id="notice_period"
                                    name="notice_period"
                                    value={formik.values.notice_period}
                                    onChange={(event, newValue) => {
                                        if (typeof newValue === 'string') {
                                            setNoticeValue(newValue);
                                            formik.setFieldValue('notice_period', newValue);
                                        } else if (newValue && newValue.inputValue) {
                                            setNoticeValue(newValue.inputValue);
                                            formik.setFieldValue('notice_period', newValue.inputValue);
                                        } else {
                                            setNoticeValue(newValue);
                                            newValue && newValue.name
                                                ? formik.setFieldValue('notice_period', newValue.name)
                                                : formik.setFieldValue('notice_period', newValue);
                                        }
                                    }}
                                    filterOptions={(options, params) => {
                                        const filtered = filter(options, params);

                                        const { inputValue } = params;
                                        const isExisting = options.some((option) => inputValue === option);
                                        if (inputValue !== '' && !isExisting) {
                                            filtered.push(`${inputValue}`);
                                        }
                                        return filtered;
                                    }}
                                    selectOnFocus
                                    clearOnBlur
                                    handleHomeEndKeys
                                    options={initDataSet.noticePeriodList}
                                    getOptionLabel={(option) => {
                                        if (typeof option === 'string') {
                                            return option;
                                        }
                                        if (option.inputValue) {
                                            return option.inputValue;
                                        }
                                        return option;
                                    }}
                                    renderOption={(props, option) => <li {...props}>{option}</li>}
                                    freeSolo
                                    renderInput={(params) => (
                                        <TextField
                                            {...params}
                                            label={<Required title="Notice Period" />}
                                            error={formik.touched.notice_period && Boolean(formik.errors.notice_period)}
                                            helperText={formik.touched.notice_period && formik.errors.notice_period}
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
                                    <Required title="Education" />
                                </Typography>
                            </Grid>
                            <Grid container alignItems="center" spacing={gridSpacing} justifyContent="flex-end">
                                <Button
                                    onClick={() => {
                                        const currentExp = formik.values.education;
                                        formik.setFieldValue('education', [...currentExp, initEducation]);
                                    }}
                                >
                                    + Add Education
                                </Button>
                            </Grid>
                            <Grid container alignItems="center" spacing={gridSpacing} justifyContent="flex-end">
                                <Grid item xs={12} sm={9}>
                                    {formik.values.education.map((_, idx) => (
                                        <Box sx={{ m: 2 }} key={idx}>
                                            <Paper
                                                style={{
                                                    padding: 10,
                                                    borderRadius: 6
                                                }}
                                                variant="outlined"
                                            >
                                                <Grid item xs={12} sm={12}>
                                                    <Grid container alignItems="center" spacing={2}>
                                                        <Grid item xs={12} sm={6}>
                                                            <FormControl
                                                                size="small"
                                                                fullWidth
                                                                error={checkTouchValidation('education', idx, 'type')}
                                                            >
                                                                <InputLabel id="type">
                                                                    <Required title="Type" />
                                                                </InputLabel>
                                                                <Select
                                                                    fullWidth
                                                                    labelId="type"
                                                                    name={`education[${idx}].type`}
                                                                    id={`education[${idx}].type`}
                                                                    label={<Required title="Type" />}
                                                                    value={formik.values.education[idx].type}
                                                                    onChange={(e) => DegreeTypeChange(e, idx)}
                                                                >
                                                                    {initDataSet.degreeTypeList.map((item, idx) => (
                                                                        <MenuItem value={item} key={idx}>
                                                                            {item}
                                                                        </MenuItem>
                                                                    ))}
                                                                </Select>
                                                                <FormHelperText>
                                                                    {checkErrorValidation('education', idx, 'type')}
                                                                </FormHelperText>
                                                            </FormControl>
                                                        </Grid>
                                                        <Grid item xs={12} sm={6}>
                                                            <FormControl
                                                                size="small"
                                                                fullWidth
                                                                error={checkTouchValidation('education', idx, 'course_id')}
                                                            >
                                                                <InputLabel id="course">
                                                                    <Required title="Course" />
                                                                </InputLabel>
                                                                <Select
                                                                    fullWidth
                                                                    labelId="course"
                                                                    name={`education[${idx}].course_id`}
                                                                    id={`education[${idx}].course_id`}
                                                                    label={<Required title="Course" />}
                                                                    value={formik.values.education[idx].course_id}
                                                                    onChange={formik.handleChange}
                                                                >
                                                                    <MenuItem value="" disabled>
                                                                        Select
                                                                    </MenuItem>
                                                                    {formik.values.education &&
                                                                        formik.values.education[idx].courseList.map((item, idx) => (
                                                                            <MenuItem value={item.id} key={idx}>
                                                                                {item.name}
                                                                            </MenuItem>
                                                                        ))}
                                                                </Select>
                                                                <FormHelperText>
                                                                    {checkErrorValidation('education', idx, 'course_id')}
                                                                </FormHelperText>
                                                            </FormControl>
                                                        </Grid>
                                                        <Grid item xs={12} sm={12}>
                                                            <TextField
                                                                fullWidth
                                                                size="small"
                                                                name={`education[${idx}].specification`}
                                                                id={`education[${idx}].specification`}
                                                                label={<Required title="Specification" />}
                                                                value={formik.values.education[idx].specification}
                                                                onChange={formik.handleChange}
                                                                error={checkTouchValidation('education', idx, 'specification')}
                                                                helperText={checkErrorValidation('education', idx, 'specification')}
                                                            />
                                                        </Grid>
                                                        <Grid item xs={12} sm={12}>
                                                            <TextField
                                                                fullWidth
                                                                size="small"
                                                                name={`education[${idx}].institute_name`}
                                                                id={`education[${idx}].institute_name`}
                                                                label={<Required title="Institute Name" />}
                                                                value={formik.values.education[idx].institute_name}
                                                                onChange={formik.handleChange}
                                                                error={checkTouchValidation('education', idx, 'institute_name')}
                                                                helperText={checkErrorValidation('education', idx, 'institute_name')}
                                                            />
                                                        </Grid>
                                                        <Grid item xs={12}>
                                                            <Grid container alignItems="center" spacing={2}>
                                                                <Grid item xs={12} sm={6}>
                                                                    <DesktopDatePicker
                                                                        name={`education[${idx}].start_date`}
                                                                        id={`education[${idx}].start_date`}
                                                                        label={<Required title="Start Date" />}
                                                                        value={formik.values.education[idx].start_date}
                                                                        inputFormat="YYYY/MM/DD"
                                                                        maxDate={moment()}
                                                                        onChange={(date) => {
                                                                            formik.setFieldValue(
                                                                                `education[${idx}].start_date`,
                                                                                moment(date).format('YYYY-MM-DD')
                                                                            );
                                                                        }}
                                                                        renderInput={(params) => (
                                                                            <TextField
                                                                                fullWidth
                                                                                size="small"
                                                                                {...params}
                                                                                error={checkTouchValidation('education', idx, 'start_date')}
                                                                                helperText={checkErrorValidation(
                                                                                    'education',
                                                                                    idx,
                                                                                    'start_date'
                                                                                )}
                                                                            />
                                                                        )}
                                                                    />
                                                                </Grid>
                                                                <Grid item xs={12} sm={6} key="key">
                                                                    <DesktopDatePicker
                                                                        name={`education[${idx}].end_date`}
                                                                        id={`education[${idx}].end_date`}
                                                                        label={<Required title="End Date" />}
                                                                        inputFormat="YYYY/MM/DD"
                                                                        minDate={formik.values.education[idx].start_date}
                                                                        maxDate={moment()}
                                                                        value={formik.values.education[idx].end_date}
                                                                        onChange={(date) => {
                                                                            formik.setFieldValue(
                                                                                `education[${idx}].end_date`,
                                                                                moment(date).format('YYYY-MM-DD')
                                                                            );
                                                                        }}
                                                                        renderInput={(params) => (
                                                                            <TextField
                                                                                fullWidth
                                                                                size="small"
                                                                                {...params}
                                                                                error={checkTouchValidation('education', idx, 'end_date')}
                                                                                helperText={checkErrorValidation(
                                                                                    'education',
                                                                                    idx,
                                                                                    'end_date'
                                                                                )}
                                                                            />
                                                                        )}
                                                                    />
                                                                </Grid>
                                                            </Grid>
                                                        </Grid>
                                                        <Grid item xs={12} mt={2}>
                                                            <Grid
                                                                container
                                                                alignItems="center"
                                                                spacing={gridSpacing}
                                                                justifyContent="flex-end"
                                                            >
                                                                {idx > 0 && (
                                                                    <Button
                                                                        type="reset"
                                                                        variant="text"
                                                                        color="error"
                                                                        onClick={() => {
                                                                            const currentExp = formik.values.education;
                                                                            formik.setFieldValue(
                                                                                'education',
                                                                                currentExp.filter((i, ck) => ck !== idx)
                                                                            );
                                                                        }}
                                                                    >
                                                                        Delete
                                                                    </Button>
                                                                )}
                                                            </Grid>
                                                        </Grid>
                                                    </Grid>
                                                </Grid>
                                            </Paper>
                                        </Box>
                                    ))}
                                </Grid>
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={3}>
                                <Typography variant="subtitle1">{<Required title="Current Skill" />}</Typography>
                            </Grid>
                            <Grid item xs={12} sm={9}>
                                <Autocomplete
                                    multiple
                                    fullWidth
                                    size="small"
                                    id="current_skill"
                                    name="current_skill"
                                    value={formik.values.current_skill}
                                    options={keySkill ?? []}
                                    getOptionLabel={(option) => option.name}
                                    onChange={(_, value) => formik.setFieldValue('current_skill', value)}
                                    renderInput={(params) => (
                                        <TextField
                                            {...params}
                                            label="Current Skill"
                                            error={formik.touched.current_skill && Boolean(formik.errors.current_skill)}
                                            helperText={formik.touched.current_skill && formik.errors.current_skill}
                                        />
                                    )}
                                />
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={3}>
                                <Typography variant="subtitle1">Profile Picture</Typography>
                            </Grid>
                            <Grid item xs={12} sm={9}>
                                <TextField
                                    fullWidth
                                    type="file"
                                    size="small"
                                    id="profile_picture"
                                    name="profile_picture"
                                    inputProps={{ accept: 'image/png, image/jpeg, image/jpg' }}
                                    onChange={(event) => {
                                        formik.setFieldValue('profile_picture', event.currentTarget.files[0]);
                                    }}
                                    error={formik.touched.profile_picture && Boolean(formik.errors.profile_picture)}
                                    helperText={formik.touched.profile_picture && formik.errors.profile_picture}
                                />
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={3}>
                                <Typography variant="subtitle1">
                                    <Required title="Address" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={9}>
                                <Grid container alignItems="center" spacing={2}>
                                    <Grid item xs={12} sm={12}>
                                        <TextField
                                            fullWidth
                                            multiline
                                            size="small"
                                            rows={4}
                                            id="address"
                                            name="address"
                                            label={<Required title="Address" />}
                                            value={formik.values.address}
                                            onChange={formik.handleChange}
                                            error={formik.touched.address && Boolean(formik.errors.address)}
                                            helperText={formik.touched.address && formik.errors.address}
                                        />
                                    </Grid>
                                    <Grid item xs={12} sm={6}>
                                        <FormControl
                                            size="small"
                                            fullWidth
                                            error={formik.touched.country && Boolean(formik.errors.country)}
                                        >
                                            <InputLabel id="country">
                                                <Required title="Country" />
                                            </InputLabel>
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
                                                <MenuItem value="" disabled>
                                                    Select
                                                </MenuItem>
                                                {initDataSet.countryList.map((item, idx) => (
                                                    <MenuItem value={item.id} key={idx}>
                                                        {item.name}
                                                    </MenuItem>
                                                ))}
                                            </Select>
                                            <FormHelperText>{formik.touched.country && formik.errors.country}</FormHelperText>
                                        </FormControl>
                                    </Grid>
                                    <Grid item xs={12} sm={6}>
                                        <FormControl size="small" fullWidth error={formik.touched.state && Boolean(formik.errors.state)}>
                                            <InputLabel id="state">
                                                <Required title="State" />
                                            </InputLabel>
                                            <Select
                                                labelId="state"
                                                id="state"
                                                name="state"
                                                label="state"
                                                value={formik.values.state}
                                                onChange={(e) => {
                                                    stateChangeHandler(e.target.value);
                                                }}
                                            >
                                                <MenuItem value="" disabled>
                                                    Select
                                                </MenuItem>
                                                {stateList &&
                                                    stateList.map((item, idx) => (
                                                        <MenuItem value={item.id} key={idx}>
                                                            {item.name}
                                                        </MenuItem>
                                                    ))}
                                            </Select>
                                            <FormHelperText>{formik.touched.state && formik.errors.state}</FormHelperText>
                                        </FormControl>
                                    </Grid>
                                    <Grid item xs={12} sm={6}>
                                        <FormControl size="small" fullWidth error={formik.touched.city && Boolean(formik.errors.city)}>
                                            <InputLabel id="city">
                                                <Required title="City" />
                                            </InputLabel>
                                            <Select
                                                labelId="city"
                                                id="city"
                                                name="city"
                                                label="city"
                                                value={formik.values.city}
                                                onChange={formik.handleChange}
                                            >
                                                <MenuItem value="" disabled>
                                                    Select
                                                </MenuItem>
                                                {cityList &&
                                                    cityList.map((item, idx) => (
                                                        <MenuItem value={item.id} key={idx}>
                                                            {item.name}
                                                        </MenuItem>
                                                    ))}
                                            </Select>
                                            <FormHelperText>{formik.touched.city && formik.errors.city}</FormHelperText>
                                        </FormControl>
                                    </Grid>
                                    <Grid item xs={12} sm={6}>
                                        <TextField
                                            fullWidth
                                            size="small"
                                            id="postcode"
                                            name="postcode"
                                            label={<Required title="Postcode" />}
                                            value={formik.values.postcode}
                                            onChange={formik.handleChange}
                                            error={formik.touched.postcode && Boolean(formik.errors.postcode)}
                                            helperText={formik.touched.postcode && formik.errors.postcode}
                                        />
                                    </Grid>
                                </Grid>
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={3}>
                                <Typography variant="subtitle1">
                                    <Required title="Gender" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={9}>
                                <RadioGroup row name="gender" value={formik.values.gender} onChange={formik.handleChange}>
                                    <FormControlLabel value="Male" control={<Radio />} label="Male" />
                                    <FormControlLabel value="Female" control={<Radio />} label="Female" />
                                    <FormControlLabel value="Other" control={<Radio />} label="Other" />
                                </RadioGroup>
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={3}>
                                <Typography variant="subtitle1">
                                    <Required title="Date Of Birth" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={4.5}>
                                <DesktopDatePicker
                                    fullWidth
                                    id="dob"
                                    name="dob"
                                    label={<Required title="Date Of Birth" />}
                                    inputFormat="YYYY/MM/DD"
                                    value={formik.values.dob}
                                    maxDate={moment()}
                                    onChange={(date) => {
                                        formik.setFieldValue('dob', moment(date).format('YYYY-MM-DD'));
                                    }}
                                    renderInput={(params) => (
                                        <TextField
                                            fullWidth
                                            size="small"
                                            {...params}
                                            error={formik.touched.dob && Boolean(formik.errors.dob)}
                                            helperText={formik.touched.dob && formik.errors.dob}
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
                                    <Required title="Marital Status" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={9}>
                                <FormControl
                                    size="small"
                                    fullWidth
                                    error={formik.touched.marital_status && Boolean(formik.errors.marital_status)}
                                >
                                    <InputLabel id="marital_status">
                                        <Required title="Marital Status" />
                                    </InputLabel>
                                    <Select
                                        fullWidth
                                        labelId="marital_status"
                                        id="marital_status"
                                        name="marital_status"
                                        label="Marital Status"
                                        value={formik.values.marital_status}
                                        onChange={formik.handleChange}
                                    >
                                        <MenuItem value="" disabled>
                                            Select
                                        </MenuItem>
                                        {initDataSet.maritalList.map((item, idx) => (
                                            <MenuItem value={item} key={idx}>
                                                {item}
                                            </MenuItem>
                                        ))}
                                    </Select>
                                    <FormHelperText>{formik.touched.marital_status && formik.errors.marital_status}</FormHelperText>
                                </FormControl>
                            </Grid>
                        </Grid>
                    </Grid>
                    {/* <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={3}>
                                <Typography variant="subtitle1">
                                    <Required title="Assign To" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={9}>
                                <FormControl size="small" fullWidth error={formik.touched.assign && Boolean(formik.errors.assign)}>
                                    <InputLabel id="assign">
                                        <Required title="Assign To" />
                                    </InputLabel>
                                    <Select
                                        fullWidth
                                        labelId="assign"
                                        id="assign"
                                        name="assign"
                                        label={<Required title="Assign To" />}
                                        value={formik.values.assign}
                                        onChange={formik.handleChange}
                                    >
                                        <MenuItem value="" disabled>
                                            Select
                                        </MenuItem>
                                        <MenuItem value="Parth">Parth</MenuItem>
                                        <MenuItem value="Rohit">Rohit</MenuItem>
                                        {initDataSet.sourceFromList.map((item, idx) => (
                                            <MenuItem value={item} key={idx}>
                                                {item}
                                            </MenuItem>
                                        ))}
                                    </Select>
                                    <FormHelperText>{formik.touched.assign && formik.errors.assign}</FormHelperText>
                                </FormControl>
                            </Grid>
                        </Grid>
                    </Grid> */}
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={3}>
                                <Typography variant="subtitle1">
                                    <Required title="Upload Resume" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={9}>
                                <TextField
                                    fullWidth
                                    type="file"
                                    size="small"
                                    id="upload_resume"
                                    name="upload_resume"
                                    onChange={(event) => {
                                        formik.setFieldValue('upload_resume', event.currentTarget.files[0]);
                                    }}
                                    error={formik.touched.upload_resume && Boolean(formik.errors.upload_resume)}
                                    helperText={formik.touched.upload_resume && formik.errors.upload_resume}
                                />
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
        </LocalizationProvider>
    );
};

AddEditCandidate.propTypes = {
    value: propTypes.object,
    formId: propTypes.string,
    onSubmit: propTypes.func
};

export default AddEditCandidate;
