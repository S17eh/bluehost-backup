import PropTypes from 'prop-types';
import {
    FormControl,
    FormHelperText,
    InputLabel,
    MenuItem,
    Select,
    Table,
    TableBody,
    TableCell,
    TableContainer,
    TableHead,
    TableRow
} from '@mui/material';
import Required from 'views/utilities/Required';
import { useFormik } from 'formik';
import { useEffect } from 'react';
import * as yup from 'yup';
import { SaveImportUserApi } from 'apis/User';
import { apiErrorSnackBar, apiSuccessSnackBar, apiValidationSnackBar } from 'utils/SnackBar';

const validationSchema = yup.object().shape({
    users: yup.array().of(
        yup.object().shape({
            role_id: yup.string().required('Role is required.')
        })
    )
});

const ImportUser = ({ formId, importData, onSubmit }) => {
    const formik = useFormik({
        initialValues: {
            users: []
        },
        validationSchema: validationSchema,
        onSubmit: (values) => {
            SaveImportUserApi(values)
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

    useEffect(() => {
        const objArr = [];
        importData.data.map((i) => {
            const obj = {
                username: i[0],
                first_name: i[1],
                last_name: i[2],
                email: i[3],
                mobile_number: i[4],
                gender: i[5],
                address: i[6],
                role_id: ''
            };
            objArr.push(obj);
        });
        formik.setFieldValue('users', objArr);
    }, []);

    // CheckTouchValidation
    const checkTouchValidation = (filedName, index, columnName) => {
        if (formik.touched[filedName] && formik.touched[filedName][index] && formik.touched[filedName][index][columnName]) {
            if (formik.errors[filedName] && formik.errors[filedName][index] && formik.errors[filedName][index][columnName]) {
                return formik.touched[filedName][index][columnName] && Boolean(formik.errors[filedName][index][columnName]);
            }
            return false;
        }
        return false;
    };

    const checkErrorValidation = (filedName, index, columnName) => {
        if (formik.touched[filedName] && formik.touched[filedName][index] && formik.touched[filedName][index][columnName]) {
            if (formik.errors[filedName] && formik.errors[filedName][index] && formik.errors[filedName][index][columnName]) {
                return formik.touched[filedName][index][columnName] && formik.errors[filedName][index][columnName];
            }
            return '';
        }
        return '';
    };

    return (
        <form id={formId} onSubmit={formik.handleSubmit}>
            <TableContainer>
                <Table>
                    <TableHead>
                        <TableRow>
                            {importData.header.map((i, idx) => (
                                <TableCell key={idx}>{i}</TableCell>
                            ))}
                            <TableCell>Role</TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {formik.values.users.map((i, idx) => (
                            <TableRow key={idx}>
                                <TableCell>{i.username}</TableCell>
                                <TableCell>{i.first_name}</TableCell>
                                <TableCell>{i.last_name}</TableCell>
                                <TableCell>{i.email}</TableCell>
                                <TableCell>{i.mobile_number}</TableCell>
                                <TableCell>{i.gender}</TableCell>
                                <TableCell>{i.address}</TableCell>
                                <TableCell>
                                    <FormControl size="small" fullWidth error={checkTouchValidation('users', idx, 'role_id')}>
                                        <InputLabel id="role_id">
                                            <Required title="Role" />
                                        </InputLabel>
                                        <Select
                                            fullWidth
                                            labelId="role_id"
                                            label="Role"
                                            id={`users[${idx}][role_id]`}
                                            name={`users[${idx}][role_id]`}
                                            value={formik.values.users[idx]['role_id']}
                                            onChange={formik.handleChange}
                                        >
                                            <MenuItem value="">Select</MenuItem>
                                            {importData.roleList.map((i, idx) => (
                                                <MenuItem value={i.id} key={idx}>
                                                    {i.name}
                                                </MenuItem>
                                            ))}
                                        </Select>
                                        <FormHelperText>{checkErrorValidation('users', idx, 'role_id')}</FormHelperText>
                                    </FormControl>
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </TableContainer>
        </form>
    );
};

ImportUser.propTypes = {
    formId: PropTypes.string,
    importData: PropTypes.object,
    onSubmit: PropTypes.func
};

export default ImportUser;
