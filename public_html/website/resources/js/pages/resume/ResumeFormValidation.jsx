const ResumeFormValidation = (values) => {
    let errors = {};
    if (!values.name) {
        errors.name = "Name is required";
    }

    if (!values.email) {
        errors.email = "Email is required";
    } else if (!/\S+@\S+\.\S+/.test(values.email)) {
        errors.email = "Email is invalid";
    }
    return errors;
};

export default ResumeFormValidation;
