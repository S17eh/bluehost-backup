import { MenuItem, Stack, TextField, Typography } from '@mui/material';
import { useState, useEffect } from 'react';
import propTypes from 'prop-types';

const InlineText = ({ selectedValue, list, width, changeValue, disabled = false }) => {
    const user = list ? list.filter((a) => a.id.toString() === selectedValue.toString())[0] : { id: '', name: '' };
    const [showChip, setChip] = useState(true);
    const [value, setValue] = useState({ id: selectedValue, name: user ? user.name : 'select' });

    useEffect(() => {
        setValue({ id: selectedValue, name: user ? user.name : 'select' });
    }, [selectedValue]);

    return (
        <Stack direction="row" spacing={1} sx={{ height: '30px', width: { sm: width || '100px' } }} alignItems="center">
            {showChip ? (
                <Typography
                    onClick={(event) => {
                        if (disabled) event.preventDefault();
                        else setChip(false);
                    }}
                    sx={{ cursor: 'pointer' }}
                >
                    {value.name}
                </Typography>
            ) : (
                <TextField
                    size="small"
                    select
                    id="assign-to"
                    value={value.id}
                    onChange={(event) => {
                        const val = event.target.value;
                        const user = list ? list.filter((a) => a.id.toString() === val.toString())[0] : { id: '', name: '' };
                        setValue({ id: val, name: user ? user.name : 'select' });
                        if (changeValue) changeValue(user);
                    }}
                    onBlur={() => {
                        setChip(true);
                    }}
                    onClick={() => setChip(true)}
                >
                    {list.map((i, idx) => (
                        <MenuItem value={i.id} key={idx}>
                            {i.name}
                        </MenuItem>
                    ))}
                </TextField>
            )}
        </Stack>
    );
};

InlineText.propTypes = {
    list: propTypes.array,
    width: propTypes.string,
    selectedValue: propTypes.string,
    changeValue: propTypes.func,
    disabled: propTypes.bool
};

export default InlineText;
