import { Button, Grid, IconButton, Table, TableBody, TableCell, TableContainer, TableHead, TableRow, TextField } from '@mui/material';
import { AddCircleOutlineOutlined as AddCircleOutlineOutlinedIcon } from '@mui/icons-material';
import { DownloadOutlined } from '@mui/icons-material';
import MainCard from 'ui-component/cards/MainCard';
import { gridSpacing } from 'store/constant';
import { useState } from 'react';
import CenterDialog from 'views/utilities/CenterDialog';
import { DeleteOutline } from '@mui/icons-material';
import { useFormik } from 'formik';
import * as yup from 'yup';
import DeleteDialog from 'views/utilities/DeleteDialog';
import { addDocumentApi, deleteDocumentApi, documentListApi } from 'apis/Profile';
import useAuth from 'hooks/useAuth';
import { apiErrorSnackBar, apiSuccessSnackBar, apiValidationSnackBar } from 'utils/SnackBar';
import { useEffect } from 'react';

const SUPPORTED_FORMATS = [
    'image/jpg',
    'image/jpeg',
    'image/png',
    'image/webp',
    'image/gif',
    'image/bmp',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/pdf',
    'text/csv',
    'application/vnd.ms-excel',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'text/plain'
];

const validationSchema = yup.object().shape({
    documents: yup
        .mixed()
        .required('Document is required.')
        .test(2000000, 'File size is too big', (value) => !value || (value && value.size <= 2000000))
        .test('format', 'Invalid file formate', (value) => !value || (value && SUPPORTED_FORMATS.includes(value.type)))
});

const Documents = () => {
    const { user } = useAuth();
    const [openAdd, setOpenAdd] = useState(false);
    const [data, setData] = useState([]);
    const [documentData, setDocumentData] = useState([]);
    const [openDelete, setOpenDelete] = useState(false);

    const params = {
        id: user.id
    };

    const formik = useFormik({
        initialValues: {
            documents: ''
        },
        validationSchema: validationSchema,
        onSubmit: (values, { resetForm }) => {
            setOpenAdd((prevState) => !prevState);
            addDocumentApi({ id: user.id, documents: values.documents })
                .then((res) => {
                    if (res.data && res.data.status === 1) {
                        apiSuccessSnackBar(res);
                        getData();
                    } else {
                        apiValidationSnackBar(res);
                    }
                    resetForm();
                })
                .catch((err) => {
                    apiErrorSnackBar(err);
                });
        }
    });

    const addData = () => {
        setOpenAdd((prevState) => !prevState);
    };

    const DialogClose = () => {
        setOpenAdd((prevState) => !prevState);
        formik.setFieldValue('documents', '');
    };

    const deleteData = (row) => {
        setOpenDelete(true);
        setDocumentData(row);
    };

    const deleteHandler = () => {
        deleteDocumentApi({ id: documentData.id })
            .then((res) => {
                if (res.data && res.data.status === 1) {
                    setOpenDelete(false);
                    getData();
                    apiSuccessSnackBar(res);
                } else {
                    apiValidationSnackBar(res);
                }
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };

    const downloadAttachment = (row) => {
        const a = document.createElement('a');
        a.href = row.document_link;
        a.download = row.document;
        a.click();
    };

    const getData = () => {
        documentListApi(params)
            .then((res) => {
                setData(res.data.data);
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
    };

    useEffect(() => {
        getData();
    }, []);

    return (
        <div>
            <MainCard
                title={
                    <Grid container alignItems="center" spacing={gridSpacing} sx={{ mb: -1, mt: -4 }}>
                        <Grid item sx={{ flexGrow: 1 }}>
                            Documents
                        </Grid>
                        <Grid item>
                            <Button variant="contained" onClick={() => addData()}>
                                <AddCircleOutlineOutlinedIcon sx={{ mr: 0.5 }} /> Add Document
                            </Button>
                        </Grid>
                    </Grid>
                }
                content={true}
            >
                <TableContainer>
                    <Table>
                        <EnhancedTableHead />
                        <TableBody>
                            {data.map((item, index) => (
                                <TableRow hover role="checkbox" key={index}>
                                    <TableCell align="left">{item.document}</TableCell>
                                    <TableCell align="right">
                                        <IconButton color="primary" component="label" onClick={() => downloadAttachment(item)}>
                                            <DownloadOutlined fontSize="small" />
                                        </IconButton>
                                        <IconButton color="error" component="label" onClick={() => deleteData(item)}>
                                            <DeleteOutline fontSize="small" />
                                        </IconButton>
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </TableContainer>
            </MainCard>
            {openAdd && (
                <CenterDialog open={openAdd} title="Add Document" onClose={() => DialogClose()} id="addDocument">
                    <form id="addDocument" onSubmit={formik.handleSubmit}>
                        <Grid item xs={12} sm={12}>
                            <TextField
                                fullWidth
                                type="file"
                                size="small"
                                id="documents"
                                name="documents"
                                onChange={(e) => {
                                    let image = e.target.files[0];
                                    formik.setFieldValue('documents', image);
                                }}
                                error={formik.touched.documents && Boolean(formik.errors.documents)}
                                helperText={formik.touched.documents && formik.errors.documents}
                                InputLabelProps={{ shrink: true }}
                                InputProps={{
                                    inputProps: {
                                        accept: 'image/*'
                                    }
                                }}
                            />
                        </Grid>
                    </form>
                </CenterDialog>
            )}
            {openDelete && (
                <DeleteDialog
                    onDeleteHandler={deleteHandler}
                    onClose={() => setOpenDelete(false)}
                    open={openDelete}
                    dept="Document"
                    name={documentData['document']}
                />
            )}
        </div>
    );
};

export default Documents;
function EnhancedTableHead() {
    return (
        <TableHead>
            <TableRow>
                <TableCell key="documents" align="left" sx={{ width: '40%' }}>
                    Name
                </TableCell>
                <TableCell align="right" sx={{ width: '10%' }}>
                    Action
                </TableCell>
            </TableRow>
        </TableHead>
    );
}
