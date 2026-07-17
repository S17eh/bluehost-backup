import { useEffect, useState } from "react";

const useForm = (callback, validate, val) => {
    const [values, setValues] = useState(val);
    const [errors, setErrors] = useState({});
    const [isSubmitting, setIsSubmitting] = useState(false);

    useEffect(() => {
        if (Object.keys(errors).length === 0 && isSubmitting) {
            callback();
        }
    }, [errors]);

    const handleSubmit = (event) => {
        if (event) event.preventDefault();
        setErrors(validate(values));
        setIsSubmitting(true);
    };

    const handleChange = (event) => {
        event.persist();
        setIsSubmitting(false);

        Object.keys(errors).length != 0
            ? setErrors(
                  validate({
                      ...values,
                      [event.target.name]: event.target.value,
                  })
              )
            : null;

        setValues((values) => ({
            ...values,
            [event.target.name]: event.target.value,
        }));
    };

    const handleFileChange = (event) => {
        event.persist();
        setIsSubmitting(false);
        Object.keys(errors).length != 0
            ? setErrors(
                  validate({
                      ...values,
                      [event.target.name]: event.target.files[0],
                  })
              )
            : null;

        setValues((values) => ({
            ...values,
            [event.target.name]: event.target.files[0],
        }));
    };

    const reset = (event) => {
        // event.persist();
        setIsSubmitting(false);
        setErrors({});
        setValues({});
    };
    return {
        handleSubmit,
        handleChange,
        handleFileChange,
        values,
        errors,
        reset,
    };
};

export default useForm;
