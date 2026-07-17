import { FormControl, Grid, InputAdornment, InputLabel, MenuItem, OutlinedInput, Select, Typography } from '@mui/material';
import { IconSearch } from '@tabler/icons';
import { useState } from 'react';
import { gridSpacing } from 'store/constant';
import MainCard from 'ui-component/cards/MainCard';
import StateList from './StateList';

const Index = () => {
    const [search, setSearch] = useState('');
    const [countryData, setCountryData] = useState([]);
    const [countryFilter, setCountryFilter] = useState('0');

    const handleSearch = (event) => {
        setSearch(event.target.value);
    };

    return (
        <>
            <MainCard
                title={
                    <Grid container alignItems="center" spacing={gridSpacing} sx={{ mb: -1, mt: -4 }}>
                        <Grid item xs={12}>
                            <Grid container alignItems="center" spacing={gridSpacing}>
                                <Grid item sx={{ flexGrow: 1 }}>
                                    <Typography variant="column">State List</Typography>
                                </Grid>
                                <Grid item>
                                    <FormControl size="small" sx={{ minWidth: '100px' }}>
                                        <InputLabel id="country">Country</InputLabel>
                                        <Select
                                            fullWidth
                                            labelId="country"
                                            id="country"
                                            label="Country"
                                            defaultValue="0"
                                            onChange={(e) => {
                                                setCountryFilter(e.target.value);
                                            }}
                                        >
                                            <MenuItem value="0">All</MenuItem>
                                            {countryData.map((item, idx) => (
                                                <MenuItem value={item.id} key={idx}>
                                                    {item.name}
                                                </MenuItem>
                                            ))}
                                        </Select>
                                    </FormControl>
                                </Grid>
                                <Grid item>
                                    <OutlinedInput
                                        id="input-search-list-style1"
                                        placeholder="Search"
                                        startAdornment={
                                            <InputAdornment position="start">
                                                <IconSearch stroke={1.5} size="1rem" />
                                            </InputAdornment>
                                        }
                                        size="small"
                                        onChange={handleSearch}
                                        autoComplete="off"
                                    />
                                </Grid>
                            </Grid>
                        </Grid>
                    </Grid>
                }
                content={true}
            >
                <StateList search={search} countryID={countryFilter} setCountryData={setCountryData} />
            </MainCard>
        </>
    );
};

export default Index;
