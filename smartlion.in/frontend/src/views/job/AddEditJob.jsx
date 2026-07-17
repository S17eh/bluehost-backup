import propTypes from 'prop-types';
import {
    Autocomplete,
    Box,
    Button,
    FormControl,
    FormHelperText,
    Grid,
    InputLabel,
    Link,
    MenuItem,
    Select,
    TextField,
    Typography
} from '@mui/material';
import { useFormik } from 'formik';
import Required from 'views/utilities/Required';

import * as yup from 'yup';
import { addUpdateJobApi, JobCityApi, JobStateApi } from 'apis/Job';
import { apiErrorSnackBar, apiSuccessSnackBar, apiValidationSnackBar } from 'utils/SnackBar';

import moment from 'moment';
import { DesktopDatePicker, LocalizationProvider } from '@mui/x-date-pickers';
import { AdapterMoment } from '@mui/x-date-pickers/AdapterMoment';
import { useMemo, useState } from 'react';
import { AddJobTitleFromJobApi, addUpdateFunctionalAreaFromJobApi, addUpdateKeySkillFromJobApi } from 'apis/Setting';

const validationSchema = yup.object().shape({
    employer_id: yup.string().required('Company is required.'),
    title: yup.string().required('Job Title is required.'),
    description: yup.string().required('Job Description is required.'),
    work_mode: yup.string().required('Work Mode is required.'),
    key_skill: yup.array().min(1, 'Key Skill is required.').required('Key Skill is required.'),
    work_experience_min: yup.string().required('Minimum Work Experience is required.'),
    work_experience_max: yup.string().required('Maximum Work Experience is required.'),
    city: yup.string().required('City is required.'),
    state: yup.string().required('State is required.'),
    country: yup.string().required('Country is required.'),
    post_code: yup.string().required('Post Code is required.'),
    job_type: yup.string().required('Job Type is required.'),
    industry: yup.string().required('Industry is required.'),
    functional_area: yup.array().min(1, 'Functional Area is required.').required('Functional Area is required.'),
    education: yup.array().min(1, 'Education is required.').required('Education is required.'),
    position_title: yup.string().required('Position Title is required.'),
    no_of_position: yup.string().required('No Of Position is required.'),
    start_date: yup.date().required('Start Date is required.'),
    end_date: yup.date().required('End Date is required.'),
    salary_min: yup.string().required('Minimum Annual Salary is required.'),
    salary_max: yup.string().required('Maximum Annual Salary is required.'),
    shift: yup.array().min(1, 'Shift Timing is required.').required('Shift Timing is required.'),
    status: yup.string().required('job Status is required.')
});

const AddEditJob = ({ value, formId, onSubmit, employerList, initData, fixedArray }) => {
    const initValue = value ?? false;
    const [candidateProfilePop, setCandidateProfilePop] = useState(false);
    const [PerksPopup, setPerksPopup] = useState(false);
    const [maxExperienceArray, setMaxExperienceArray] = useState([]);
    const [maxSalaryArray, setMaxSalaryArray] = useState([]);
    const [stateList, setStateList] = useState(initData.state_list);
    const [cityList, setCityList] = useState(initData.city_list);
    const [jobTitleList, setJobTitleList] = useState(initData.job_title);
    const [keySkillList, setKeySkillList] = useState(initData.key_skill);
    const [funAreaList, setFunAreaList] = useState(initData.functional_area);
    const [customTitle, setCustomTitle] = useState('');
    const [customKeySkill, setCustomKeySkill] = useState('');
    const [customKeyFunArea, setCustomFunArea] = useState('');
    const [parentDegreeList, setParentDegreeList] = useState([]);
    const [degreeList, setDegreeList] = useState([]);

    const formik = useFormik({
        initialValues: {
            id: initValue ? initValue.id : '',
            job_code: initValue ? initValue.job_code : initData.job_code,
            employer_id: initValue ? initValue.employer_id : '',
            title: initValue ? initValue.title : '',
            description: initValue ? initValue.description : '',
            work_mode: initValue ? initValue.work_mode : '',
            candidate_profile: initValue ? initValue.candidate_profile : '',
            key_skill: initValue ? initValue.skill : [],
            work_experience_min: initValue ? initValue.work_experience_min : '',
            work_experience_max: initValue ? initValue.work_experience_max : '',
            perks_benefits: initValue ? initValue.perks_benefits : '',
            preferred_industry: initValue ? initValue.preferred_industry : [],
            city: initValue ? initValue.city_id : '',
            state: initValue ? initValue.state_id : '',
            country: initValue ? initValue.country_id : '',
            post_code: initValue ? initValue.post_code : '',
            job_type: initValue ? initValue.job_type_id : '',
            industry: initValue ? initValue.industry_id : 0,
            functional_area: initValue ? initValue.functional_area : [],
            type: '',
            parent_degree: '',
            degree: '',
            education: initValue ? initValue.education : [],
            position_title: initValue ? initValue.position_title : '',
            no_of_position: initValue ? initValue.no_of_position : '',
            start_date: initValue ? moment(initValue.start_date) : moment(),
            end_date: initValue ? moment(initValue.end_date) : moment(),
            salary_min: initValue ? initValue.salary_min : '',
            salary_max: initValue ? initValue.salary_max : '',
            shift: initValue ? initValue.shift : [],
            status: initValue ? initValue.status : 'Active',
            formType: initValue && initValue.id ? 'edit' : 'add'
        },
        validationSchema: validationSchema,
        onSubmit: (values) => {
            values.start_date = moment(values.start_date).format('YYYY-MM-DD');
            values.end_date = moment(values.end_date).format('YYYY-MM-DD');
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

    // Education
    const typeChangeHandler = (val) => {
        formik.setFieldValue('type', val);
        formik.setFieldValue('parent_degree', '');
        formik.setFieldValue('degree', '');

        const getParents = initData.new_education.filter((a) => a.type === val)[0];
        getParents != undefined && setParentDegreeList(getParents.parents);
    };

    const degreeChangeHandler = (val) => {
        formik.setFieldValue('parent_degree', val);
        formik.setFieldValue('degree', '');

        parentDegreeList &&
            parentDegreeList.map((item) => {
                item.name == val && setDegreeList(item.degree);
            });
    };
    // === //

    const countryChangeHandler = (countryID) => {
        formik.setFieldValue('country', countryID);
        formik.setFieldValue('state', '');
        formik.setFieldValue('city', '');
        formik.setFieldValue('country', countryID);
        JobStateApi({ country_id: countryID })
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
        JobCityApi({ state_id: ID })
            .then((res) => {
                setCityList(res.data.data);
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };

    const addCandidateProfile = () => {
        setCandidateProfilePop(true);
    };

    const addPerks = () => {
        setPerksPopup(true);
    };

    useMemo(() => {
        setMaxExperienceArray(fixedArray.filter((i) => formik.values.work_experience_min < i));
    }, [formik.values.work_experience_min]);

    useMemo(() => {
        setMaxSalaryArray(initData.salaryChart.filter((i) => formik.values.salary_min < i.amount));
    }, [formik.values.salary_min]);

    const arrayColumn = (arr, n) => arr.map((x) => x[n]);

    // Set Job Title
    const setTitle = () => {
        AddJobTitleFromJobApi({ name: customTitle })
            .then((res) => {
                if (res.data && res.data.status === 1) {
                    setJobTitleList(res.data.data);
                    formik.setFieldValue('title', customTitle);
                } else {
                    apiValidationSnackBar(res);
                }
            })
            .catch((err) => apiErrorSnackBar(err));
    };

    const setKeySkill = () => {
        addUpdateKeySkillFromJobApi({ name: customKeySkill })
            .then((res) => {
                if (res.data && res.data.status === 1) {
                    setKeySkillList((prevState) => [...prevState, res.data.data]);
                    formik.setFieldValue('key_skill', [...formik.values.key_skill, customKeySkill]);
                } else {
                    apiValidationSnackBar(res);
                }
            })
            .catch((err) => apiErrorSnackBar(err));
    };

    const setFunctionalArea = () => {
        addUpdateFunctionalAreaFromJobApi({ name: customKeyFunArea })
            .then((res) => {
                if (res.data && res.data.status === 1) {
                    setFunAreaList((prevState) => [...prevState, res.data.data]);
                    formik.setFieldValue('functional_area', [...formik.values.functional_area, customKeyFunArea]);
                } else {
                    apiValidationSnackBar(res);
                }
            })
            .catch((err) => apiErrorSnackBar(err));
    };
    return (
        <Box>
            <LocalizationProvider dateAdapter={AdapterMoment}>
                <form id={formId} onSubmit={formik.handleSubmit}>
                    <Grid container spacing={2}>
                        <Grid item xs={12}>
                            <Grid container alignItems="center" spacing={2}>
                                <Grid item xs={12} sm={3}>
                                    <Typography variant="subtitle1">Job Code</Typography>
                                </Grid>
                                <Grid item xs={12} sm={9}>
                                    <TextField
                                        fullWidth
                                        size="small"
                                        id="job_code"
                                        name="job_code"
                                        label="Job Code"
                                        value={formik.values.job_code}
                                        disabled
                                        // value={formik.values.job_code ? formik.values.job_code : initData.job_code}
                                        onChange={formik.handleChange}
                                        error={formik.touched.job_code && Boolean(formik.errors.job_code)}
                                        helperText={formik.touched.job_code && formik.errors.job_code}
                                    />
                                </Grid>
                            </Grid>
                        </Grid>
                        <Grid item xs={12}>
                            <Grid container alignItems="center" spacing={2}>
                                <Grid item xs={12} sm={3}>
                                    <Typography variant="subtitle1">
                                        <Required title="Company" />
                                    </Typography>
                                </Grid>
                                <Grid item xs={12} sm={9}>
                                    <FormControl
                                        size="small"
                                        fullWidth
                                        error={formik.touched.employer_id && Boolean(formik.errors.employer_id)}
                                    >
                                        <InputLabel id="employer">Company</InputLabel>
                                        <Select
                                            fullWidth
                                            labelId="employer"
                                            id="employer_id"
                                            name="employer_id"
                                            label="Company"
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
                                        <Required title="Job Title" />
                                    </Typography>
                                </Grid>

                                <Grid item xs={12} sm={9}>
                                    <Autocomplete
                                        fullWidth
                                        size="small"
                                        id="title"
                                        name="title"
                                        options={jobTitleList ? jobTitleList.map((option) => option.name) : []}
                                        onKeyUp={(e) => {
                                            setCustomTitle(e.target.value);
                                        }}
                                        onChange={(_, value) => {
                                            formik.setFieldValue('title', value);
                                        }}
                                        value={formik.values.title ? formik.values.title : null}
                                        noOptionsText={
                                            <>
                                                <Typography sx={{ p: 1 }}>
                                                    {` No job title found, if you want to add in the job title list click in the 'Add In Job List' button ?`}
                                                </Typography>
                                                <Button
                                                    variant="outlined"
                                                    onClick={() => {
                                                        // setShowAddForm(true);
                                                        // setAddTechnology(false);
                                                        setTitle();
                                                    }}
                                                >
                                                    Add In Job Title List
                                                </Button>
                                            </>
                                        }
                                        renderInput={(params) => (
                                            <TextField
                                                {...params}
                                                label="Job Title"
                                                error={formik.touched.title && Boolean(formik.errors.title)}
                                                helperText={formik.touched.title && formik.errors.title}
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
                                        <Required title="Job Type" />
                                    </Typography>
                                </Grid>
                                <Grid item xs={12} sm={9}>
                                    <FormControl size="small" fullWidth error={formik.touched.job_type && Boolean(formik.errors.job_type)}>
                                        <InputLabel id="employer">Job Type</InputLabel>
                                        <Select
                                            fullWidth
                                            labelId="employer"
                                            id="job_type"
                                            name="job_type"
                                            label="Job Type"
                                            value={formik.values.job_type}
                                            onChange={formik.handleChange}
                                        >
                                            {initData.job_type.map((item, idx) => (
                                                <MenuItem value={item.id} key={idx}>
                                                    {item.name}
                                                </MenuItem>
                                            ))}
                                        </Select>
                                        <FormHelperText>{formik.touched.job_type && formik.errors.job_type}</FormHelperText>
                                    </FormControl>
                                </Grid>
                            </Grid>
                        </Grid>
                        <Grid item xs={12}>
                            <Grid container alignItems="center" spacing={2}>
                                <Grid item xs={12} sm={3}>
                                    <Typography variant="subtitle1">
                                        <Required title="Work Mode" />
                                    </Typography>
                                </Grid>
                                <Grid item xs={12} sm={9}>
                                    <FormControl
                                        size="small"
                                        fullWidth
                                        error={formik.touched.work_mode && Boolean(formik.errors.work_mode)}
                                    >
                                        <InputLabel id="work_mode_">Work Mode</InputLabel>
                                        <Select
                                            fullWidth
                                            labelId="work_mode_"
                                            id="work_mode"
                                            name="work_mode"
                                            label="Work Mode"
                                            value={formik.values.work_mode}
                                            onChange={formik.handleChange}
                                        >
                                            {initData.work_mode.map((item, idx) => (
                                                <MenuItem value={item} key={idx}>
                                                    {item}
                                                </MenuItem>
                                            ))}
                                        </Select>
                                        <FormHelperText>{formik.touched.work_mode && formik.errors.work_mode}</FormHelperText>
                                    </FormControl>
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
                                        label="No. Of Position"
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
                                        <Required title="Job Description" />
                                    </Typography>
                                </Grid>
                                <Grid item xs={12} sm={9}>
                                    <TextField
                                        fullWidth
                                        multiline
                                        size="small"
                                        rows={4}
                                        id="description"
                                        name="description"
                                        label="Job Description"
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
                                <Grid item xs={12} sm={3}>
                                    <Typography variant="subtitle1">Candidate Profile</Typography>
                                </Grid>
                                <Grid item xs={12} sm={9}>
                                    {candidateProfilePop == true || formik.values.candidate_profile ? (
                                        <TextField
                                            fullWidth
                                            multiline
                                            size="small"
                                            rows={4}
                                            id="candidate_profile"
                                            name="candidate_profile"
                                            label="Candidate Profile"
                                            value={formik.values.candidate_profile}
                                            onChange={formik.handleChange}
                                        />
                                    ) : (
                                        <Link
                                            underline="none"
                                            onClick={() => {
                                                addCandidateProfile();
                                            }}
                                            sx={{
                                                cursor: 'pointer'
                                            }}
                                        >
                                            + Add Candidate Profile
                                        </Link>
                                    )}
                                </Grid>
                            </Grid>
                        </Grid>
                        <Grid item xs={12}>
                            <Grid container alignItems="center" spacing={2}>
                                <Grid item xs={12} sm={3}>
                                    <Typography variant="subtitle1">
                                        <Required title="Key Skill" />
                                    </Typography>
                                </Grid>
                                <Grid item xs={12} sm={9}>
                                    <Autocomplete
                                        multiple
                                        fullWidth
                                        size="small"
                                        id="key_skill"
                                        name="key_skill"
                                        options={keySkillList.map((o) => o.name)}
                                        value={formik.values.key_skill}
                                        onKeyUp={(e) => setCustomKeySkill(e.target.value)}
                                        onChange={(_, value) => formik.setFieldValue('key_skill', value)}
                                        noOptionsText={
                                            <>
                                                <Typography sx={{ p: 1 }}>
                                                    {` No key skill found, if you want to add in the key skill list click in the 'Add In Key Skill List' button ?`}
                                                </Typography>
                                                <Button
                                                    variant="outlined"
                                                    onClick={() => {
                                                        setKeySkill();
                                                    }}
                                                >
                                                    Add In Key Skill List
                                                </Button>
                                            </>
                                        }
                                        renderInput={(params) => (
                                            <TextField
                                                {...params}
                                                label="Key Skill"
                                                error={formik.touched.key_skill && Boolean(formik.errors.key_skill)}
                                                helperText={formik.touched.key_skill && formik.errors.key_skill}
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
                                        <Required title="Work Experience" />
                                    </Typography>
                                </Grid>
                                <Grid item xs={12} sm={4.3}>
                                    <FormControl
                                        size="small"
                                        fullWidth
                                        error={formik.touched.work_experience_min && Boolean(formik.errors.work_experience_min)}
                                    >
                                        <InputLabel id="work_experience_min">Minimum Work Experience</InputLabel>
                                        <Select
                                            fullWidth
                                            labelId="work_experience_min"
                                            id="work_experience_min"
                                            name="work_experience_min"
                                            label="Minimum Work Experience"
                                            value={formik.values.work_experience_min}
                                            onChange={(e) => {
                                                formik.setFieldValue('work_experience_min', e.target.value);
                                            }}
                                        >
                                            {fixedArray.map((item, idx) => (
                                                <MenuItem value={idx} key={idx} sx={{ height: '50' }}>
                                                    {idx}
                                                </MenuItem>
                                            ))}
                                        </Select>
                                        <FormHelperText>
                                            {formik.touched.work_experience_min && formik.errors.work_experience_min}
                                        </FormHelperText>
                                    </FormControl>
                                </Grid>
                                <Grid item xs={12} sm={0.4}>
                                    To
                                </Grid>
                                <Grid item xs={12} sm={4.3}>
                                    <FormControl
                                        size="small"
                                        fullWidth
                                        error={formik.touched.work_experience_max && Boolean(formik.errors.work_experience_max)}
                                    >
                                        <InputLabel id="work_experience_max">Maximum Work Experience</InputLabel>
                                        <Select
                                            fullWidth
                                            disabled={maxExperienceArray.length < 1 ? true : false}
                                            labelId="work_experience_max"
                                            id="work_experience_max"
                                            name="work_experience_max"
                                            label="Maximum Work Experience"
                                            value={formik.values.work_experience_max}
                                            onChange={formik.handleChange}
                                        >
                                            {maxExperienceArray.map((item, idx) => (
                                                <MenuItem value={item} key={idx}>
                                                    {item}
                                                </MenuItem>
                                            ))}
                                        </Select>
                                        <FormHelperText>
                                            {formik.touched.work_experience_max && formik.errors.work_experience_max}
                                        </FormHelperText>
                                    </FormControl>
                                </Grid>
                            </Grid>
                        </Grid>
                        <Grid item xs={12}>
                            <Grid container alignItems="center" spacing={2}>
                                <Grid item xs={12} sm={3}>
                                    <Typography variant="subtitle1">
                                        <Required title="Annual Salary" />
                                    </Typography>
                                </Grid>
                                <Grid item xs={12} sm={4.3}>
                                    <FormControl
                                        size="small"
                                        fullWidth
                                        error={formik.touched.salary_min && Boolean(formik.errors.salary_min)}
                                    >
                                        <InputLabel id="salary_min">Minimum Annual Salary</InputLabel>
                                        <Select
                                            fullWidth
                                            labelId="salary_min"
                                            id="salary_min"
                                            name="salary_min"
                                            label="Minimum Annual Salary"
                                            value={formik.values.salary_min}
                                            onChange={formik.handleChange}
                                        >
                                            {initData.salaryChart.map((item, index) => (
                                                <MenuItem value={item.amount} key={index}>
                                                    {item.name}
                                                </MenuItem>
                                            ))}
                                        </Select>
                                        <FormHelperText>{formik.touched.salary_min && formik.errors.salary_min}</FormHelperText>
                                    </FormControl>
                                </Grid>
                                <Grid item xs={12} sm={0.4}>
                                    To
                                </Grid>
                                <Grid item xs={12} sm={4.3}>
                                    <FormControl
                                        size="small"
                                        fullWidth
                                        error={formik.touched.salary_max && Boolean(formik.errors.salary_max)}
                                    >
                                        <InputLabel id="salary_max">Maximum Annual Salary</InputLabel>
                                        <Select
                                            fullWidth
                                            disabled={formik.values.salary_min ? false : true}
                                            labelId="salary_max"
                                            id="salary_max"
                                            name="salary_max"
                                            label="Maximum Annual Salary"
                                            value={formik.values.salary_max}
                                            onChange={formik.handleChange}
                                        >
                                            {maxSalaryArray.map((item, idx) => (
                                                <MenuItem value={item.amount} key={idx}>
                                                    {item.name}
                                                </MenuItem>
                                            ))}
                                        </Select>
                                        <FormHelperText>{formik.touched.salary_max && formik.errors.salary_max}</FormHelperText>
                                    </FormControl>
                                </Grid>
                            </Grid>
                        </Grid>
                        <Grid item xs={12}>
                            <Grid container alignItems="center" spacing={2}>
                                <Grid item xs={12} sm={3}>
                                    <Typography variant="subtitle1">Perks & Benefits</Typography>
                                </Grid>
                                <Grid item xs={12} sm={9}>
                                    {PerksPopup == true || formik.values.perks_benefits ? (
                                        <TextField
                                            fullWidth
                                            multiline
                                            size="small"
                                            rows={4}
                                            id="perks_benefits"
                                            name="perks_benefits"
                                            label="Perks & Benefits"
                                            value={formik.values.perks_benefits}
                                            onChange={formik.handleChange}
                                            error={formik.touched.perks_benefits && Boolean(formik.errors.perks_benefits)}
                                            helperText={formik.touched.perks_benefits && formik.errors.perks_benefits}
                                        />
                                    ) : (
                                        <Link
                                            underline="none"
                                            onClick={() => {
                                                addPerks();
                                            }}
                                            sx={{
                                                cursor: 'pointer'
                                            }}
                                        >
                                            + Add Perks & Benefits
                                        </Link>
                                    )}
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
                                    <Grid container alignItems="center" spacing={2}>
                                        <Grid item xs={12} sm={6}>
                                            <FormControl
                                                size="small"
                                                fullWidth
                                                error={formik.touched.country && Boolean(formik.errors.country)}
                                            >
                                                <InputLabel id="country">Country</InputLabel>
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
                                                    {initData.countries.map((item, idx) => (
                                                        <MenuItem value={item.id} key={idx}>
                                                            {item.name}
                                                        </MenuItem>
                                                    ))}
                                                </Select>
                                                <FormHelperText>{formik.touched.country && formik.errors.country}</FormHelperText>
                                            </FormControl>
                                        </Grid>
                                        <Grid item xs={12} sm={6}>
                                            <FormControl
                                                size="small"
                                                fullWidth
                                                error={formik.touched.state && Boolean(formik.errors.state)}
                                            >
                                                <InputLabel id="state">State</InputLabel>
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
                                                    <MenuItem value="">Select</MenuItem>
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
                                                <InputLabel id="city">city</InputLabel>
                                                <Select
                                                    labelId="city"
                                                    id="city"
                                                    name="city"
                                                    label="city"
                                                    value={formik.values.city}
                                                    onChange={formik.handleChange}
                                                >
                                                    <MenuItem value="">Select</MenuItem>
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
                                                id="post_code"
                                                name="post_code"
                                                label="Post Code"
                                                onChange={formik.handleChange}
                                                error={formik.touched.post_code && Boolean(formik.errors.post_code)}
                                                helperText={formik.touched.post_code && formik.errors.post_code}
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
                                        <Required title="Industry" />
                                    </Typography>
                                </Grid>
                                <Grid item xs={12} sm={9}>
                                    <Autocomplete
                                        fullWidth
                                        size="small"
                                        id="industry"
                                        name="industry"
                                        label="Industry"
                                        value={initData.industries.filter((a) => a.id === formik.values.industry)[0] || null}
                                        options={initData.industries}
                                        getOptionLabel={(option) => option.name}
                                        onChange={(_, value) => {
                                            value ? formik.setFieldValue('industry', value.id) : formik.setFieldValue('industry', 0);
                                        }}
                                        renderInput={(params) => (
                                            <TextField
                                                {...params}
                                                label="Industry"
                                                error={formik.touched.industry && Boolean(formik.errors.industry)}
                                                helperText={formik.touched.industry && formik.errors.industry}
                                            />
                                        )}
                                    />
                                </Grid>
                            </Grid>
                        </Grid>
                        <Grid item xs={12}>
                            <Grid container alignItems="center" spacing={2}>
                                <Grid item xs={12} sm={3}>
                                    <Typography variant="subtitle1">Preferred Industry</Typography>
                                </Grid>
                                <Grid item xs={12} sm={9}>
                                    <Autocomplete
                                        multiple
                                        fullWidth
                                        size="small"
                                        id="preferred_industry"
                                        name="preferred_industry"
                                        label="Preferred Industry"
                                        options={initData.industries}
                                        getOptionLabel={(option) => option.name}
                                        value={
                                            initData.industries.length > 0
                                                ? initData.industries.filter((i) => formik.values.preferred_industry.some((a) => a == i.id))
                                                : []
                                        }
                                        onChange={(_, value) => formik.setFieldValue('preferred_industry', arrayColumn(value, 'id'))}
                                        renderInput={(params) => (
                                            <TextField
                                                {...params}
                                                label="Preferred Industry"
                                                error={formik.touched.preferred_industry && Boolean(formik.errors.preferred_industry)}
                                                helperText={formik.touched.preferred_industry && formik.errors.preferred_industry}
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
                                        <Required title="Functional Area" />
                                    </Typography>
                                </Grid>
                                <Grid item xs={12} sm={9}>
                                    <Autocomplete
                                        fullWidth
                                        multiple
                                        size="small"
                                        id="functional_area"
                                        name="functional_area"
                                        label="Functional Area"
                                        value={formik.values.functional_area}
                                        options={funAreaList.map((o) => o.name)}
                                        onChange={(_, value) => formik.setFieldValue('functional_area', value)}
                                        onKeyUp={(e) => setCustomFunArea(e.target.value)}
                                        noOptionsText={
                                            <>
                                                <Typography sx={{ p: 1 }}>
                                                    {` No functional area found, if you want to add in the functional area list click in the 'Add In Functional Area List' button ?`}
                                                </Typography>
                                                <Button
                                                    variant="outlined"
                                                    onClick={() => {
                                                        setFunctionalArea();
                                                    }}
                                                >
                                                    Add In Functional Area List
                                                </Button>
                                            </>
                                        }
                                        renderInput={(params) => (
                                            <TextField
                                                {...params}
                                                label="Functional Area"
                                                error={formik.touched.functional_area && Boolean(formik.errors.functional_area)}
                                                helperText={formik.touched.functional_area && formik.errors.functional_area}
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
                                <Grid item xs={12} sm={9}>
                                    <Grid container alignItems="center" spacing={1.5}>
                                        <Grid item xs={12} sm={4}>
                                            <FormControl size="small" fullWidth error={formik.touched.type && Boolean(formik.errors.type)}>
                                                <InputLabel id="type">Type</InputLabel>
                                                <Select
                                                    fullWidth
                                                    labelId="type"
                                                    id="type"
                                                    name="type"
                                                    label="Type"
                                                    value={formik.values.type}
                                                    onChange={(e) => {
                                                        typeChangeHandler(e.target.value);
                                                    }}
                                                >
                                                    <MenuItem value="">Select</MenuItem>
                                                    {initData.new_education.map((item, idx) => (
                                                        <MenuItem value={item.type} key={idx}>
                                                            {item.type}
                                                        </MenuItem>
                                                    ))}
                                                </Select>
                                                <FormHelperText>{formik.touched.type && formik.errors.type}</FormHelperText>
                                            </FormControl>
                                        </Grid>
                                        <Grid item xs={12} sm={4}>
                                            <FormControl
                                                size="small"
                                                fullWidth
                                                error={formik.touched.parent_degree && Boolean(formik.errors.parent_degree)}
                                            >
                                                <InputLabel id="parent_degree">Parent Degree</InputLabel>
                                                <Select
                                                    fullWidth
                                                    labelId="parent_degree"
                                                    id="parent_degree"
                                                    name="parent_degree"
                                                    label="Parent Degree"
                                                    value={formik.values.parent_degree}
                                                    onChange={(e) => {
                                                        degreeChangeHandler(e.target.value);
                                                    }}
                                                >
                                                    <MenuItem value="">Select</MenuItem>
                                                    {parentDegreeList != '' &&
                                                        parentDegreeList?.map((item, idx) => (
                                                            <MenuItem value={item.name} key={idx}>
                                                                {item.name}
                                                            </MenuItem>
                                                        ))}
                                                </Select>
                                                <FormHelperText>
                                                    {formik.touched.parent_degree && formik.errors.parent_degree}
                                                </FormHelperText>
                                            </FormControl>
                                        </Grid>
                                        <Grid item xs={12} sm={4}>
                                            <FormControl
                                                size="small"
                                                fullWidth
                                                error={formik.touched.degree && Boolean(formik.errors.degree)}
                                            >
                                                <InputLabel id="degree">Degree</InputLabel>
                                                <Select
                                                    fullWidth
                                                    labelId="degree"
                                                    id="degree"
                                                    name="degree"
                                                    label="Degree"
                                                    value={formik.values.degree}
                                                    onChange={(e) => {
                                                        formik.setFieldValue('degree', e.target.value);
                                                        formik.setFieldValue('education', [...formik.values.education, e.target.value]);
                                                    }}
                                                >
                                                    <MenuItem value="">Select</MenuItem>
                                                    {degreeList &&
                                                        degreeList.map((item, idx) => (
                                                            <MenuItem value={item.id} key={idx}>
                                                                {item.name}
                                                            </MenuItem>
                                                        ))}
                                                </Select>
                                                <FormHelperText>{formik.touched.degree && formik.errors.degree}</FormHelperText>
                                            </FormControl>
                                        </Grid>
                                        <Grid item xs={12} sm={12}>
                                            <Autocomplete
                                                fullWidth
                                                multiple
                                                size="small"
                                                id="education"
                                                name="education"
                                                label="Education"
                                                open={false}
                                                options={initData.education.sort((a, b) =>
                                                    a.type === b.type ? 0 : a.type < b.type ? -1 : 1
                                                )}
                                                groupBy={(option) => option.type}
                                                getOptionLabel={(option) => option.name}
                                                value={
                                                    initData.education.length > 0
                                                        ? initData.education.filter((i) => formik.values.education.some((b) => b == i.id))
                                                        : []
                                                }
                                                onChange={(_, value) => {
                                                    formik.setFieldValue('education', arrayColumn(value, 'id'));
                                                }}
                                                renderInput={(params) => (
                                                    <TextField
                                                        {...params}
                                                        label="Education"
                                                        error={formik.touched.education && Boolean(formik.errors.education)}
                                                        helperText={formik.touched.education && formik.errors.education}
                                                    />
                                                )}
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
                                        <Required title="Job Date" />
                                    </Typography>
                                </Grid>
                                <Grid item xs={12} sm={4.5}>
                                    <DesktopDatePicker
                                        id="start_date"
                                        name="start_date"
                                        label="Start Date"
                                        inputFormat="YYYY/MM/DD"
                                        value={formik.values.start_date}
                                        minDate={moment()}
                                        onChange={(date) => {
                                            formik.setFieldValue('start_date', date);
                                            formik.setFieldValue('end_date', date);
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
                                        label="End Date"
                                        inputFormat="YYYY/MM/DD"
                                        minDate={formik.values.start_date}
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
                                        <Required title="Shift Timing" />
                                    </Typography>
                                </Grid>
                                <Grid item xs={12} sm={9}>
                                    <Autocomplete
                                        fullWidth
                                        multiple
                                        size="small"
                                        id="shift"
                                        name="shift"
                                        label="Shift Timing"
                                        value={
                                            formik.values.shift.length > 0
                                                ? initData.shift_timing.filter((a) => formik.values.shift.some((b) => b === a.id))
                                                : []
                                        }
                                        options={initData.shift_timing}
                                        onChange={(_, value) => {
                                            formik.setFieldValue('shift', arrayColumn(value, 'id'));
                                        }}
                                        getOptionLabel={(option) => option.name}
                                        renderInput={(params) => (
                                            <TextField
                                                {...params}
                                                label="Shift Timing"
                                                error={formik.touched.shift && Boolean(formik.errors.shift)}
                                                helperText={formik.touched.shift && formik.errors.shift}
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
                                        <Required title="Job Status" />
                                    </Typography>
                                </Grid>
                                <Grid item xs={12} sm={9}>
                                    <FormControl size="small" fullWidth error={formik.touched.status && Boolean(formik.errors.status)}>
                                        <InputLabel id="status">Job Status</InputLabel>
                                        <Select
                                            fullWidth
                                            labelId="status"
                                            id="status"
                                            name="status"
                                            label="Job Status"
                                            value={formik.values.status}
                                            onChange={formik.handleChange}
                                        >
                                            <MenuItem value={'Active'}>Active</MenuItem>
                                            <MenuItem value={'Inactive'}>Inactive</MenuItem>
                                        </Select>
                                        <FormHelperText>{formik.touched.status && formik.errors.status}</FormHelperText>
                                    </FormControl>
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
    employerList: propTypes.array,
    initData: propTypes.object,
    fixedArray: propTypes.array
};

export default AddEditJob;
