import propTypes from 'prop-types';
import {
    Autocomplete,
    Box,
    Checkbox,
    //  Chip,
    Grid,
    IconButton,
    TextField,
    Typography
} from '@mui/material';
import { AddCircleOutlineOutlined as AddCircleOutlineOutlinedIcon } from '@mui/icons-material';
import { useFormik } from 'formik';
import { NumericFormat } from 'react-number-format';
import Required from 'views/utilities/Required';
import * as yup from 'yup';
import { forwardRef } from 'react';
import { addUpdateEmployerApi } from 'apis/Employer';
import { apiErrorSnackBar, apiSuccessSnackBar, apiValidationSnackBar } from 'utils/SnackBar';
import { DeleteOutline } from '@mui/icons-material';
import { v4 as uuid } from 'uuid';

// Form Validation
const validationSchema = yup.object().shape({
    name: yup.string().required('Company Name is required.'),
    register_name: yup.string().required('Company Register Name is required.'),
    gst_no: yup.string().required('Company GST No is required.'),
    email: yup.string().email().required('Email is required.'),
    mobile_number: yup.string().required('Mobile Number is required.'),
    website: yup
        .string()
        .matches(
            /^((http|https):\/\/)[a-zA-Z0-9_-]+(\.[a-zA-Z]+)+(\/)?.([\w\?[a-zA-Z-_%\/@?]+)*([^\/\w\?[a-zA-Z0-9_-]+=\w+(&[a-zA-Z0-9_]+=\w+)*)?$/,
            'Invalid Website url'
        )
        .required('Website is required.'),
    rate: yup.string().required('Commercial is required.'),
    status: yup.string().required('Status is required.')
    // document: yup.array().min(1, 'Document is required.').required('Document is required')
});

const RateFormate1 = forwardRef(function RateFormate1(props, ref) {
    const { onChange, ...other } = props;
    return (
        <NumericFormat
            {...other}
            decimalScale={2}
            suffix={'%'}
            getInputRef={(inputRef) => {
                ref = inputRef;
            }}
            isAllowed={(values, sourceInfo) => {
                const { value } = values;
                return value <= 100;
            }}
            onValueChange={(values) => {
                onChange({
                    target: {
                        name: props.name,
                        value: values.value
                    }
                });
            }}
            type="input"
        />
    );
});

const status = [{ label: 'Active' }, { label: 'Inactive' }];

const AddEditEmployer = ({ value, formId, onSubmit }) => {
    const initValue = value ?? false;
    const TempID = uuid();

    const formik = useFormik({
        initialValues: {
            id: initValue ? initValue.id : '',
            name: initValue ? initValue.name : '',
            register_name: initValue ? initValue.register_name : '',
            gst_no: initValue ? initValue.gst_no : '',
            email: initValue ? initValue.email : '',
            alternate_email: initValue ? initValue.alternate_email : [],
            mobile_number: initValue ? initValue.mobile_number : '',
            alternate_mobile_number: initValue ? initValue.alternate_mobile_number : [],
            website: initValue ? initValue.website : '',
            address: initValue ? initValue.address : '',
            logo: '',
            rate: initValue ? initValue.rate : '',
            status: initValue ? initValue.status : 'Active',
            document: [],
            formType: initValue && initValue.id ? 'edit' : 'add'
        },
        validationSchema: validationSchema,
        onSubmit: (values) => {
            addUpdateEmployerApi(values)
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
            <form id={formId} onSubmit={formik.handleSubmit} autoComplete="off" encType="multipart/form-data">
                <Grid container spacing={2}>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    <Required title="Company Name" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <TextField
                                    fullWidth
                                    size="small"
                                    id="name"
                                    name="name"
                                    label="Company Name"
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
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    <Required title="Company Register Name" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <TextField
                                    fullWidth
                                    size="small"
                                    id="register_name"
                                    name="register_name"
                                    label="Company Register Name"
                                    value={formik.values.register_name}
                                    onChange={formik.handleChange}
                                    error={formik.touched.register_name && Boolean(formik.errors.register_name)}
                                    helperText={formik.touched.register_name && formik.errors.register_name}
                                />
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    <Required title="Company GST No" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <TextField
                                    fullWidth
                                    size="small"
                                    id="gst_no"
                                    name="gst_no"
                                    label="Company GST No"
                                    value={formik.values.gst_no}
                                    onChange={formik.handleChange}
                                    error={formik.touched.gst_no && Boolean(formik.errors.gst_no)}
                                    helperText={formik.touched.gst_no && formik.errors.gst_no}
                                />
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    <Required title="Email" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <TextField
                                    fullWidth
                                    size="small"
                                    id="email"
                                    name="email"
                                    label="Email"
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
                                <Typography variant="subtitle1">Alternate Email</Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <Autocomplete
                                    multiple
                                    fullWidth
                                    size="small"
                                    id="alternate_email"
                                    name="alternate_email"
                                    options={[]}
                                    value={formik.values.alternate_email}
                                    freeSolo
                                    renderInput={(params) => <TextField {...params} label="Alternate Email" />}
                                    onChange={(_, v) => {
                                        formik.setFieldValue('alternate_email', v);
                                    }}
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
                                    <Required title="Website" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <TextField
                                    fullWidth
                                    size="small"
                                    id="website"
                                    name="website"
                                    label="Website"
                                    value={formik.values.website}
                                    onChange={formik.handleChange}
                                    error={formik.touched.website && Boolean(formik.errors.website)}
                                    helperText={formik.touched.website && formik.errors.website}
                                />
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">Address</Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <TextField
                                    fullWidth
                                    multiline
                                    size="small"
                                    rows={4}
                                    id="address"
                                    name="address"
                                    label="Address"
                                    value={formik.values.address}
                                    onChange={formik.handleChange}
                                    error={formik.touched.address && Boolean(formik.errors.address)}
                                    helperText={formik.touched.address && formik.errors.address}
                                />
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1"> Logo </Typography>
                            </Grid>
                            <Grid item xs={12} sm={8}>
                                <TextField
                                    fullWidth
                                    type="file"
                                    size="small"
                                    id="logo"
                                    name="logo"
                                    onChange={(e) => {
                                        let image = e.target.files[0];
                                        formik.setFieldValue('logo', image);
                                    }}
                                    error={formik.touched.logo && Boolean(formik.errors.logo)}
                                    helperText={formik.touched.logo && formik.errors.logo}
                                    InputLabelProps={{ shrink: true }}
                                    InputProps={{
                                        inputProps: {
                                            accept: 'image/*'
                                        }
                                    }}
                                />
                            </Grid>
                        </Grid>
                    </Grid>
                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    <Required title="Commercial" />
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={4}>
                                <TextField
                                    fullWidth
                                    size="small"
                                    id="rate"
                                    name="rate"
                                    label="Commercial"
                                    placeholder="Commercial"
                                    defaultValue={formik.values.rate}
                                    onChange={(e) => {
                                        formik.setFieldValue('rate', e.target.value);
                                    }}
                                    InputProps={{
                                        inputComponent: RateFormate1
                                    }}
                                    error={formik.touched.rate && Boolean(formik.errors.rate)}
                                    helperText={formik.touched.rate && formik.errors.rate}
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
                            <Grid item xs={12} sm={4}>
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

                    <Grid item xs={12}>
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item xs={12} sm={4}>
                                <Typography variant="subtitle1">
                                    Document
                                    <IconButton
                                        onClick={() => {
                                            formik.setFieldValue('document', [
                                                ...formik.values.document,
                                                {
                                                    id: TempID,
                                                    defaultvalue: TempID
                                                }
                                            ]);
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

                    {/* User Details */}
                    {/* {formik.values.formType === 'add' && (
                        <>
                            <Grid item xs={12} sx={{ mt: 3, mb: 2 }}>
                                <Divider>
                                    <Chip label="User Details" />
                                </Divider>
                            </Grid>
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
                                            autoComplete="off"
                                            value={formik.values.username}
                                        />
                                    </Grid>
                                </Grid>
                            </Grid>
                            <Grid item xs={12}>
                                <Grid container alignItems="center" spacing={2}>
                                    <Grid item xs={12} sm={4}>
                                        <Typography variant="subtitle1">
                                            <Required title="Full name" />
                                        </Typography>
                                    </Grid>
                                    <Grid item xs={12} sm={4}>
                                        <TextField fullWidth size="small" id="first_name" name="first_name" label="First name" />
                                    </Grid>
                                    <Grid item xs={12} sm={4}>
                                        <TextField fullWidth size="small" id="last_name" name="last_name" label="Last name" />
                                    </Grid>
                                </Grid>
                            </Grid>
                            <Grid item xs={12}>
                                <Grid container alignItems="center" spacing={2}>
                                    <Grid item xs={12} sm={4}>
                                        <Typography variant="subtitle1">
                                            <Required title="Email" />
                                        </Typography>
                                    </Grid>
                                    <Grid item xs={12} sm={8}>
                                        <TextField fullWidth size="small" id="user_email" name="user_email" label="Email" />
                                    </Grid>
                                </Grid>
                            </Grid>
                            <Grid item xs={12}>
                                <Grid container alignItems="center" spacing={2}>
                                    <Grid item xs={12} sm={4}>
                                        <Typography variant="subtitle1">
                                            <Required title="Password" />
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
                                            autoComplete="new-password"
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
                                        <TextField fullWidth size="small" id="mobile_number" name="mobile_number" label="Mobile Number" />
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
                                        <RadioGroup row name="gender">
                                            <FormControlLabel value="Male" control={<Radio />} label="Male" />
                                            <FormControlLabel value="Female" control={<Radio />} label="Female" />
                                            <FormControlLabel value="Other" control={<Radio />} label="Other" />
                                        </RadioGroup>
                                    </Grid>
                                </Grid>
                            </Grid>
                        </>
                    )} */}
                </Grid>
            </form>
        </Box>
    );
};

AddEditEmployer.propTypes = {
    value: propTypes.object,
    formId: propTypes.string,
    onSubmit: propTypes.func
};

export default AddEditEmployer;
