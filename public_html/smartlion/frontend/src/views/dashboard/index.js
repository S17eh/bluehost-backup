import useAuth from 'hooks/useAuth';
import AdminDashboard from './adminDashboard/index';
import CompanyDashboard from './companyDashboard/index';
import CandidateDashboard from './candidateDashboard/index';
import UserDashboard from './Default/index';

const Index = () => {
    const { user } = useAuth();
    return <AdminDashboard />;
    // return (
    //     <>
    //         {user.user_type === 'SuperAdmin' && <AdminDashboard />}
    //         {user.user_type === 'Employer' && <CompanyDashboard />}
    //         {user.user_type === 'Candidate' && <CandidateDashboard />}
    //         {user.user_type === 'User' && <UserDashboard />}
    //     </>
    // );
};

export default Index;
