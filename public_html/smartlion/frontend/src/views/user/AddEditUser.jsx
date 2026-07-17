import propTypes from 'prop-types';
import { AddCircleOutlineOutlined as AddCircleOutlineOutlinedIcon } from '@mui/icons-material';
import {
    Autocomplete,
    Box,
    Checkbox,
    FormControl,
    FormControlLabel,
    FormHelperText,
    Grid,
    IconButton,
    InputLabel,
    MenuItem,
    Radio,
    RadioGroup,
    Select,
    TextField,
    Typography
} from '@mui/material';
import Required from 'views/utilities/Required';
import { useFormik } from 'formik';

import * as yup from 'yup';
import { AddUpdateUserApi, roleUserApi } from 'apis/User';
import { apiErrorSnackBar, apiSuccessSnackBar, apiValidationSnackBar } from 'utils/SnackBar';
import { useState } from 'react';
import { DeleteOutline } from '@mui/icons-material';
import { JobCityApi, JobStateApi } from 'apis/Job';

const SUPPORTED_FORMATS = ['image/jpg', 'image/jpeg', 'image/webp', 'image/png'];

const validationSchema = yup.object().shape({
    username: yup.string().required('Username is required.'),
    first_name: yup.string().required('First Name is required.'),
    last_name: yup.string().required('Last Name is required.'),
    email: yup.string().email().required('Official Email is required.'),
    password: yup.string().when('formType', { is: 'add', then: yup.string().required('Password is required.') }),
    mobile_number: yup.string().required('Mobile Number is required.'),
    gender: yup.string().required('Gender is required.'),
    address: yup.string().required('Address is required.'),
    country: yup.string().required('Country is required.'),
    state: yup.string().required('State is required.'),
    city: yup.string().required('City is required.'),
    postcode: yup.string().required('Postcode is required.'),
    role_id: yup.string().required('Role is required.'),
    // assign_to: yup.string().required('Assign to is required.'),
    status: yup.string().required('Status is required.'),
    profile_picture: yup.mixed().when('formType', {
        is: 'add',
        then: yup
            .mixed()
            .nullable()
            .test(2097152, 'File size is too big', (value) => !value || (value && value.size <= 2097152))
            .test('format', 'Invalid file formate', (value) => !value || (value && SUPPORTED_FORMATS.includes(value.type)))
            .required('Profile Picture is required.')
    })
    // document: yup.array().min(1, 'Document is required.').required('Document is required')
});

const status = [{ label: 'Active' }, { label: 'Inactive' }];

const AddEditUser = ({ value, formId, onSubmit, roleList, initData }) => {
    const initValue = value ?? false;
    // const [addDocument, setAddDocument] = useState([{ name: 'add' }]);
    const [stateList, setStateList] = useState(initData.state);
    const [cityList, setCityList] = useState(initData.city);
    const [assignee, setAssignee] = useState(initData.assign_to);

    const formik = useFormik({
        initialValues: {
            id: initValue ? initValue.id : '',
            username: initValue ? initValue.username : '',
            first_name: initValue ? initValue.first_name : '',
            last_name: initValue ? initValue.last_name : '',
            email: initValue ? initValue.email : '',
            personal_email: initValue ? initValue.personal_email : '',
            password: '',
            mobile_number: initValue ? initValue.mobile_number : '',
            alternate_mobile_number: initValue ? initValue.alternate_mobile_number : [],
            gender: initValue ? initValue.gender : 'Male',
            address: initValue ? initValue.address : '',
            country: initValue ? initValue.country : '',
            state: initValue ? initValue.state : '',
            city: initValue ? initValue.city : '',
            postcode: initValue ? initValue.postcode : '',
            role_id: initValue ? initValue.role_id : '',
            assign_to: initValue ? (initValue.assign_to === null ? '' : initValue.assign_to) : '',
            status: initValue ? initValue.status : 'Active',
            profile_picture: '',
            document: [],
            formType: initValue && initValue.id ? 'edit' : 'add'
        },
        validationSchema: validationSchema,
        onSubmit: (values) => {
            AddUpdateUserApi(values)
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
        formik.setFieldValue('state', '');
        formik.setFieldValue('city', '');
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

    const RoleUsers = (id) => {
        const obj = {
            id: id
        };
        roleUserApi(obj)
            .then((res) => {
                setAssignee(res.data.data);
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };

    return (
        <Box>
            <form id={formId} onSubmit={formik.handleSubmit}>
                <Grid container justifyContent="space-between" spacing={2} sx={{ mb: 2 }}>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    <Required title="Username" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <TextField
                                    fullWidth
                                    size="small"
                                    id="username"
                                    name="username"
                                    label="Username"
                                    value={formik.values.username}
                                    onChange={formik.handleChange}
                                    error={formik.touched.username && Boolean(formik.errors.username)}
                                    helperText={formik.touched.username && formik.errors.username}
                                />
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    <Required title="Name" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={4}>
                                <TextField
                                    fullWidth
                                    size="small"
                                    id="first_name"
                                    name="first_name"
                                    label="First Name"
                                    value={formik.values.first_name}
                                    onChange={formik.handleChange}
                                    error={formik.touched.first_name && Boolean(formik.errors.first_name)}
                                    helperText={formik.touched.first_name && formik.errors.first_name}
                                />
                            </Grid>
                            <Grid item xs={12} sm={4}>
                                <TextField
                                    fullWidth
                                    size="small"
                                    id="last_name"
                                    name="last_name"
                                    label="Last Name"
                                    value={formik.values.last_name}
                                    onChange={formik.handleChange}
                                    error={formik.touched.last_name && Boolean(formik.errors.last_name)}
                                    helperText={formik.touched.last_name && formik.errors.last_name}
                                />
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    <Required title="Official Email" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <TextField
                                    fullWidth
                                    size="small"
                                    id="email"
                                    name="email"
                                    label="Official Email"
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
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">Personal Email</Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <TextField
                                    fullWidth
                                    size="small"
                                    id="personal_email"
                                    name="personal_email"
                                    label="Personal Email"
                                    value={formik.values.personal_email}
                                    onChange={formik.handleChange}
                                    error={formik.touched.personal_email && Boolean(formik.errors.personal_email)}
                                    helperText={formik.touched.personal_email && formik.errors.personal_email}
                                />
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    {formik.values.formType === 'add' ? <Required title="Password" /> : 'Password'}
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <TextField
                                    fullWidth
                                    size="small"
                                    type="password"
                                    id="password"
                                    name="password"
                                    label="Password"
                                    value={formik.values.password}
                                    onChange={formik.handleChange}
                                    error={formik.touched.password && Boolean(formik.errors.password)}
                                    helperText={formik.touched.password && formik.errors.password}
                                />
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    <Required title="Mobile Number" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <TextField
                                    fullWidth
                                    size="small"
                                    id="mobile_number"
                                    name="mobile_number"
                                    label="Mobile Number"
                                    value={formik.values.mobile_number}
                                    onChange={formik.handleChange}
                                    error={formik.touched.mobile_number && Boolean(formik.errors.mobile_number)}
                                    helperText={formik.touched.mobile_number && formik.errors.mobile_number}
                                />
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">Alternate Mobile Number</Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <Autocomplete
                                    multiple
                                    fullWidth
                                    size="small"
                                    id="alternate_mobile_number"
                                    name="alternate_mobile_number"
                                    options={[]}
                                    value={formik.values.alternate_mobile_number}
                                    freeSolo
                                    renderInput={(params) => <TextField {...params} label="Alternate Mobile Number" />}
                                    // onChange={formik.handleChange}
                                    onChange={(_, v) => {
                                        formik.setFieldValue('alternate_mobile_number', v);
                                    }}
                                />
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    <Required title="Gender" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
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
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    <Required title="Address" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
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
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    {formik.values.formType === 'add' ? <Required title="Profile Picture" /> : 'Profile Picture'}
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <TextField
                                    fullWidth
                                    type="file"
                                    size="small"
                                    id="profile_picture"
                                    name="profile_picture"
                                    inputProps={{ accept: 'image/png, image/jpeg, image/jpg,  image/webp' }}
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
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    <Required title="Role" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <FormControl size="small" fullWidth error={formik.touched.role_id && Boolean(formik.errors.role_id)}>
                                    <InputLabel id="role_id">
                                        <Required title="Role" />
                                    </InputLabel>
                                    <Select
                                        fullWidth
                                        labelId="role_id"
                                        id="role_id"
                                        name="role_id"
                                        label="Role"
                                        value={formik.values.role_id}
                                        onChange={(e) => {
                                            RoleUsers(e.target.value);
                                            formik.handleChange(e);
                                        }}
                                    >
                                        <MenuItem value="">Select</MenuItem>
                                        {roleList.map((i, idx) => (
                                            <MenuItem value={i.id} key={idx}>
                                                {i.name}
                                            </MenuItem>
                                        ))}
                                    </Select>
                                    <FormHelperText>{formik.touched.role_id && formik.errors.role_id}</FormHelperText>
                                </FormControl>
                            </Grid>
                        </Grid>
                    </Grid>

                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    Assign To
                                    {/* <Required title="Assign To" /> */}
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <FormControl size="small" fullWidth error={formik.touched.assign_to && Boolean(formik.errors.assign_to)}>
                                    <InputLabel id="assign_to">
                                        Assign To
                                        {/* <Required title="Assign To" /> */}
                                    </InputLabel>
                                    <Select
                                        fullWidth
                                        labelId="assign_to"
                                        id="assign_to"
                                        name="assign_to"
                                        label="Assign To"
                                        value={formik.values.assign_to}
                                        onChange={formik.handleChange}
                                    >
                                        <MenuItem value="">Select</MenuItem>
                                        {assignee.map((i, idx) => (
                                            <MenuItem value={i.id} key={idx}>
                                                {`${i.first_name} ${i.last_name}`}
                                            </MenuItem>
                                        ))}
                                    </Select>
                                    <FormHelperText>{formik.touched.assign_to && formik.errors.assign_to}</FormHelperText>
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
                            <Grid item xs={12}>
                                <Grid container alignItems="center" spacing={2}>
                                    <Grid item xs={12} sm={4}>
                                        <Typography variant="subtitle1">
                                            <Required title="Document" />
                                            <IconButton
                                                onClick={() => {
                                                    formik.setFieldValue('document', [...formik.values.document, {}]);
                                                }}
                                            >
                                                <AddCircleOutlineOutlinedIcon sx={{ mr: 0.5 }} />
                                            </IconButton>
                                        </Typography>
                                    </Grid>
                                    <Grid item xs={12} sm={8}>
                                        <Grid container alignItems="center" spacing={2}>
                                            {formik.values.document.map((i, idx) => (
                                                <Grid item xs={12} sm={12} key={idx}>
                                                    <Grid container alignItems="center" spacing={2}>
                                                        <Grid item xs={10} sm={10}>
                                                            <TextField
                                                                fullWidth
                                                                type="file"
                                                                size="small"
                                                                id={`document.${idx}`}
                                                                name={`document.${idx}`}
                                                                // value={formik.values?.document[idx]}
                                                                onChange={(e) => {
                                                                    let image = e.target.files[0];
                                                                    formik.setFieldValue(`document[${idx}]`, image);
                                                                }}
                                                                error={formik.touched.document && Boolean(formik.errors.document)}
                                                                helperText={formik.touched.document && formik.errors.document}
                                                            />
                                                        </Grid>
                                                        <Grid item xs={1} sm={1}>
                                                            <IconButton
                                                                color="error"
                                                                component="label"
                                                                onClick={() => {
                                                                    const arr = formik.values.document;
                                                                    arr.splice(idx, 1);
                                                                    formik.setFieldValue('document', arr);
                                                                }}
                                                            >
                                                                <DeleteOutline fontSize="small" />
                                                            </IconButton>
                                                        </Grid>
                                                    </Grid>
                                                </Grid>
                                            ))}
                                        </Grid>
                                    </Grid>
                                </Grid>
                            </Grid>
                        </Grid>
                    </Grid>
                </Grid>
            </form>
        </Box>
    );
};

AddEditUser.propTypes = {
    value: propTypes.object,
    formId: propTypes.string.isRequired,
    onSubmit: propTypes.func,
    roleList: propTypes.array,
    initData: propTypes.object
};

export default AddEditUser;
