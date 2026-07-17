import {
    Autocomplete,
    Avatar,
    Box,
    Button,
    DialogActions,
    FormControl,
    FormControlLabel,
    FormHelperText,
    Grid,
    InputLabel,
    MenuItem,
    Radio,
    RadioGroup,
    Select,
    Table,
    TableBody,
    TableCell,
    tableCellClasses,
    TableContainer,
    TableRow,
    TextField,
    Typography
} from '@mui/material';
import MainCard from 'ui-component/cards/MainCard';
import { gridSpacing } from 'store/constant';
import { useRef, useState } from 'react';
import * as yup from 'yup';
import { useFormik } from 'formik';
import Required from 'views/utilities/Required';
import AnimateButton from 'ui-component/extended/AnimateButton';
import useAuth from 'hooks/useAuth';
import { useEffect } from 'react';
import { UserViewApi } from 'apis/User';
import { apiErrorSnackBar, apiSuccessSnackBar, apiValidationSnackBar } from 'utils/SnackBar';
import { JobCityApi, JobStateApi } from 'apis/Job';
import { updateProfileApi } from 'apis/Profile';
import { useDispatch, useSelector } from 'react-redux';
import { LOGIN } from 'store/actions';
import { useTheme } from '@emotion/react';

export const ProfileDetails = () => {
    const dispatch = useDispatch();
    const cart = useSelector((state) => state.account);
    const { user } = useAuth();
    const [data, setData] = useState({});
    const [updateData, setUpdateData] = useState(true);
    const [countryList, setCountryList] = useState([]);
    const [stateList, setStateList] = useState([]);
    const [cityList, setCityList] = useState([]);
    const anchorRef = useRef(null);
    const theme = useTheme();

    const SUPPORTED_FORMATS = ['image/jpg', 'image/jpeg', 'image/png'];

    const validationSchema = yup.object().shape({
        first_name: yup.string().required('First Name is required.'),
        last_name: yup.string().required('Last Name is required.'),
        personal_email: yup.string().email('Personal Email Should Be In Email Format'),
        gender: yup.string().required('Gender is required.'),
        address: yup.string().required('Address is required.'),
        country: yup.string().required('Country is required.'),
        state: yup.string().required('State is required.'),
        city: yup.string().required('City is required.'),
        postcode: yup.string().required('Postcode is required.'),
        profile_picture: yup
            .mixed()
            .test('format', 'Invalid file formate', (value) => !value || (value && SUPPORTED_FORMATS.includes(value.type)))
    });
    const formik = useFormik({
        initialValues: {
            id: '',
            first_name: '',
            last_name: '',
            personal_email: '',
            alternate_mobile_number: [],
            gender: 'Male',
            address: '',
            country: '',
            state: '',
            city: '',
            postcode: '',
            profile_picture: ''
        },
        validationSchema: validationSchema,
        onSubmit: (values) => {
            updateProfileApi(values)
                .then((res) => {
                    setData(res.data.data.user);
                    if (res.data && res.data.status === 1) {
                        apiSuccessSnackBar(res);
                        setUpdateData((prevState) => !prevState);
                        dispatch({
                            type: LOGIN,
                            payload: {
                                ...cart,
                                isLoggedIn: true,
                                user: res.data.data.user
                            }
                        });
                    } else {
                        apiValidationSnackBar(res);
                    }
                })
                .catch((err) => {
                    console.log(err);
                    apiErrorSnackBar(err);
                });
        }
    });

    useEffect(() => {
        UserViewApi({ type: 'edit', id: user.id })
            .then((res) => {
                setCountryList(res.data.data.countries);
                setStateList(res.data.data.state);
                setCityList(res.data.data.city);

                setData(res.data.data.user);
                const user = res.data.data.user;
                formik.setFieldValue('id', user.id);
                formik.setFieldValue('username', user.username);
                formik.setFieldValue('first_name', user.first_name);
                formik.setFieldValue('last_name', user.last_name);
                formik.setFieldValue('email', user.email);
                formik.setFieldValue('name', user.name);
                formik.setFieldValue('personal_email', user.personal_email);
                formik.setFieldValue('mobile_number', user.mobile_number);
                formik.setFieldValue('alternate_mobile_number', user.alternate_mobile_number);
                formik.setFieldValue('gender', user.gender);
                formik.setFieldValue('address', user.address);
                formik.setFieldValue('country', user.country);
                formik.setFieldValue('country_name', user.country_name);
                formik.setFieldValue('state', user.state);
                formik.setFieldValue('state_name', user.state_name);
                formik.setFieldValue('city', user.city);
                formik.setFieldValue('city_name', user.city_name);
                formik.setFieldValue('postcode', user.postcode);
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    }, [updateData]);

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

    return (
        <Grid container spacing={gridSpacing}>
            <Grid item xs={12} sm={12} md={4}>
                <MainCard
                    title={
                        <Grid container alignItems="center" spacing={2}>
                            <Grid item>
                                <Avatar
                                    src={user.image}
                                    sx={{
                                        ...theme.typography.mediumAvatar,
                                        margin: '8px 0 8px 8px !important',
                                        cursor: 'pointer',
                                        height: 50,
                                        width: 50,
                                        borderRadius: '50%',
                                        margin: '5px 0 5px 5px !important'
                                    }}
                                    ref={anchorRef}
                                    aria-controls={open ? 'menu-list-grow' : undefined}
                                    aria-haspopup="true"
                                    color="inherit"
                                />
                            </Grid>
                            <Grid item>
                                <Typography variant="subtitle1">
                                    {data?.first_name} {data?.last_name}
                                </Typography>
                            </Grid>
                        </Grid>
                    }
                    content={true}
                >
                    <Grid container spacing={2}>
                        <Grid item xs={12}>
                            <Grid container alignItems="center" spacing={2}>
                                <Grid item xs={12} sm={12}>
                                    <TableContainer>
                                        <Table
                                            size="small"
                                            sx={{
                                                [`& .${tableCellClasses.root}`]: {
                                                    paddingTop: '10px',
                                                    paddingBottom: '10px'
                                                }
                                            }}
                                        >
                                            <TableBody>
                                                <TableRow>
                                                    <TableCell>
                                                        <Typography variant="subtitle1">Username</Typography>
                                                    </TableCell>
                                                    <TableCell>
                                                        <Typography variant="subtitle2" sx={{ textAlign: 'end' }}>
                                                            {data?.username}
                                                        </Typography>
                                                    </TableCell>
                                                </TableRow>
                                                <TableRow>
                                                    <TableCell>
                                                        <Typography variant="subtitle1">Name</Typography>
                                                    </TableCell>
                                                    <TableCell>
                                                        <Typography variant="subtitle2" sx={{ textAlign: 'end' }}>
                                                            {data?.first_name} {data?.last_name}
                                                        </Typography>
                                                    </TableCell>
                                                </TableRow>
                                                <TableRow>
                                                    <TableCell>
                                                        <Typography variant="subtitle1">Official Email</Typography>
                                                    </TableCell>
                                                    <TableCell>
                                                        <Typography variant="subtitle2" sx={{ textAlign: 'end' }}>
                                                            {data?.email}
                                                        </Typography>
                                                    </TableCell>
                                                </TableRow>
                                                <TableRow>
                                                    <TableCell>
                                                        <Typography variant="subtitle1">Personal Email</Typography>
                                                    </TableCell>
                                                    <TableCell>
                                                        <Typography variant="subtitle2" sx={{ textAlign: 'end' }}>
                                                            {data?.personal_email ? data?.personal_email : '-'}
                                                        </Typography>
                                                    </TableCell>
                                                </TableRow>
                                                <TableRow>
                                                    <TableCell>
                                                        <Typography variant="subtitle1">Mobile number</Typography>
                                                    </TableCell>
                                                    <TableCell>
                                                        <Typography variant="subtitle2" sx={{ textAlign: 'end' }}>
                                                            {data?.mobile_number}
                                                        </Typography>
                                                    </TableCell>
                                                </TableRow>
                                                <TableRow>
                                                    <TableCell>
                                                        <Typography variant="subtitle1">Alternate Mobile Number</Typography>
                                                    </TableCell>
                                                    <TableCell>
                                                        <Typography variant="subtitle2" sx={{ textAlign: 'end' }}>
                                                            {data?.alternate_mobile_number && data.alternate_mobile_number != ''
                                                                ? data.alternate_mobile_number.map((i, idx) => {
                                                                      return idx === data?.alternate_mobile_number.length - 1 ? (
                                                                          <Box key={idx} component="div" sx={{ display: 'inline' }}>
                                                                              {i}
                                                                          </Box>
                                                                      ) : (
                                                                          <Box key={idx} component="div" sx={{ display: 'inline' }}>
                                                                              {`${i}, `}
                                                                          </Box>
                                                                      );
                                                                  })
                                                                : '-'}
                                                        </Typography>
                                                    </TableCell>
                                                </TableRow>
                                                <TableRow>
                                                    <TableCell>
                                                        <Typography variant="subtitle1">Gender</Typography>
                                                    </TableCell>
                                                    <TableCell>
                                                        <Typography variant="subtitle2" sx={{ textAlign: 'end' }}>
                                                            {data?.gender}
                                                        </Typography>
                                                    </TableCell>
                                                </TableRow>
                                                <TableRow>
                                                    <TableCell>
                                                        <Typography variant="subtitle1">Address</Typography>
                                                    </TableCell>
                                                    <TableCell>
                                                        <Typography variant="subtitle2" sx={{ textAlign: 'end' }}>
                                                            {data?.address} ,<br /> {data?.city_name} {data?.postcode} , <br />
                                                            {data?.state_name} , {data?.country_name}
                                                        </Typography>
                                                    </TableCell>
                                                </TableRow>
                                            </TableBody>
                                        </Table>
                                    </TableContainer>
                                </Grid>
                            </Grid>
                        </Grid>
                    </Grid>
                </MainCard>
            </Grid>
            <Grid item xs={12} sm={12} md={8}>
                <MainCard
                    title={
                        <Grid container spacing={gridSpacing} sx={{ mb: -1, mt: -4 }}>
                            <Grid item xs={12}>
                                <Grid container spacing={gridSpacing}>
                                    <Grid item sx={{ flexGrow: 1 }}>
                                        <Typography variant="subtitle1">Profile Details</Typography>
                                    </Grid>
                                </Grid>
                            </Grid>
                        </Grid>
                    }
                    content={true}
                >
                    <form onSubmit={formik.handleSubmit}>
                        <Grid container spacing={2}>
                            <Grid item xs={12}>
                                <Grid container alignItems="center" spacing={2}>
                                    <Grid item xs={12} sm={3}>
                                        <Typography variant="subtitle1">
                                            <Required title="Name" />
                                        </Typography>
                                    </Grid>
                                    <Grid item xs={12} sm={4.5}>
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
                                    <Grid item xs={12} sm={4.5}>
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
                                <Grid item xs={12}>
                                    <Grid container alignItems="center" spacing={2}>
                                        <Grid item xs={12} sm={3}>
                                            <Typography variant="subtitle1">Personal Email</Typography>
                                        </Grid>
                                        <Grid item xs={12} sm={9}>
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
                            </Grid>
                            <Grid item xs={12}>
                                <Grid container alignItems="center" spacing={2}>
                                    <Grid item xs={12} sm={3}>
                                        <Typography variant="subtitle1">Alternate Mobile Number</Typography>
                                    </Grid>
                                    <Grid item xs={12} sm={9}>
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
                                    <Grid item xs={12} sm={3}>
                                        <Typography variant="subtitle1">
                                            <Required title="Gender" />
                                        </Typography>
                                    </Grid>
                                    <Grid item xs={12} sm={9}>
                                        <FormControl size="small" fullWidth error={formik.touched.gender && Boolean(formik.errors.gender)}>
                                            <RadioGroup row name="gender" value={formik.values.gender} onChange={formik.handleChange}>
                                                <FormControlLabel value="Male" control={<Radio />} label="Male" />
                                                <FormControlLabel value="Female" control={<Radio />} label="Female" />
                                                <FormControlLabel value="Other" control={<Radio />} label="Other" />
                                            </RadioGroup>
                                            <FormHelperText>{formik.touched.gender && formik.errors.gender}</FormHelperText>
                                        </FormControl>
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
                                                        <MenuItem value="">Select</MenuItem>
                                                        {countryList &&
                                                            countryList.map((item, idx) => (
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
                                                <FormControl
                                                    size="small"
                                                    fullWidth
                                                    error={formik.touched.city && Boolean(formik.errors.city)}
                                                >
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
                                <Grid container alignItems="center" spacing={2} justifyContent="flex-end">
                                    <Grid item xs={12}>
                                        <DialogActions sx={{ marginTop: 1 }}>
                                            <AnimateButton>
                                                <Button variant="contained" color="primary" type="submit">
                                                    update
                                                </Button>
                                            </AnimateButton>
                                        </DialogActions>
                                    </Grid>
                                </Grid>
                            </Grid>
                        </Grid>
                    </form>
                </MainCard>
            </Grid>
        </Grid>
    );
};
