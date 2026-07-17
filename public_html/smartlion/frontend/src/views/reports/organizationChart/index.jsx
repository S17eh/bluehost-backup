import propTypes from 'prop-types';
import { Card, CardContent, Grid, Typography } from '@mui/material';
import { useEffect, useState } from 'react';
import MainCard from 'ui-component/cards/MainCard';
import { Tree, TreeNode } from 'react-organizational-chart';
import { OrganizationChartApi } from 'apis/Report';
import { apiErrorSnackBar, apiValidationSnackBar } from 'utils/SnackBar';

const Index = () => {
    const [data, setData] = useState([]);
    useEffect(() => {
        OrganizationChartApi()
            .then((res) => {
                if (res.data && res.data.status === 1) {
                    // apiSuccessSnackBar(res);
                    setData(res.data.data);
                } else {
                    apiValidationSnackBar(res);
                }
            })
            .catch((err) => {
                apiErrorSnackBar(err);
            });
        return () => {
            setData([]);
        };
    }, []);

    return (
        <MainCard>
            <Grid container spacing={2}>
                <Grid item xs={12}>
                    <Typography variant="h4">Hierarchy Chart</Typography>
                </Grid>
                <Grid item xs={12} sx={{ marginTop: '10px' }}>
                    {data.map((i, idx) => (
                        <Tree label={<CardWrapper data={i} />} key={idx}>
                            {i.child.length > 0 && <Node value={i.child} />}
                        </Tree>
                    ))}
                </Grid>
            </Grid>
        </MainCard>
    );
};

export default Index;

function Node({ value }) {
    return (
        <>
            {value.map((i, idx) => {
                return i.child.length > 0 ? (
                    <TreeNode key={idx} label={<CardWrapper data={i} />}>
                        {i.child.length > 0 && <Node value={i.child} />}
                    </TreeNode>
                ) : (
                    <TreeNode key={idx} label={<CardWrapper data={i} />} />
                );
            })}
        </>
    );
}

Node.propTypes = {
    value: propTypes.array
};

function CardWrapper({ data }) {
    return (
        <Card variant="outlined" sx={{ boxShadow: 2, display: 'inline-block' }}>
            <CardContent>
                <Typography variant="subtitle1">{data.name}</Typography>
            </CardContent>
        </Card>
    );
}

CardWrapper.propTypes = {
    data: propTypes.object
};
