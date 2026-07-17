import React, { useState } from "react";
import { useForm } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import * as yup from "yup";
import Banner from "../components/Banner";
import Services from "../services/Services";

const schema = yup.object().shape({
    name: yup.string().required("Name is required"),
    email: yup
        .string()
        .required("Please enter your email address.")
        .matches(
            /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i,
            "invalid email address"
        ),
    current_salary: yup
        .string()
        .required("Please enter your current salary.")
        .matches(/^[0-9.]+$/, "Please enter a number"),
    expected_salary: yup
        .string()
        .required("Please enter your expected salary.")
        .matches(/^[0-9.]+$/, "Please enter a number"),
    mobile_number: yup
        .string()
        .required("Please enter your mobile number.")
        .max(10, "Max length is 10")
        .matches(/^[0-9.]+$/, "Please enter a number"),
    experience_year: yup
        .string()
        .required("Please enter your experience year.")
        .min(0, "Minimum year is 0")
        .max(50, "Maximum year is 50")
        .matches(/^[0-9.]+$/, "Please enter a number"),
    experience_month: yup
        .string()
        .required("Please enter your experience month.")
        .min(0, "Minimum month is 0")
        .max(12, "Maximum month is 12")
        .matches(/^[0-9.]+$/, "Please enter a number"),
    resume: yup
        .mixed()
        .required("Please select resume")
        .test("type", "We only support PDF", function (value) {
            return value && value[0] && value[0].type === "application/pdf";
        }),
});

const ApplyForJob = () => {
    document.title = "!! Smart Lion - Apply For Job !!"
    const [loader, setLoader] = useState(false);
    const {
        register,
        handleSubmit,
        formState: { errors },
        reset,
    } = useForm({
        resolver: yupResolver(schema),
    });
    const convertBase64 = (file) => {
        return new Promise((resolve, reject) => {
            const fileReader = new FileReader();
            fileReader.readAsDataURL(file);
            fileReader.onload = () => {
                resolve(fileReader.result);
            };
            fileReader.onerror = (error) => {
                reject(error);
            };
        });
    };

    async function sendEmail(data, event) {
        if (event) event.preventDefault();
        setLoader(true);
        const base64 = await convertBase64(data.resume[0]);
        let allData = {
            ...data,
            ["resume"]: base64,
        };

        Services.ApplyJobEmail(allData).then((res) => {
            setLoader(false);
            reset();
        });
    }

    return (
        <>
            <Banner
                img="images/apply-for-job-banner.png"
                pageName="Apply For Job"
            />
            <section className="contact-page-sec apply-sec">
                <div className="container">
                    <div className="row">
                        <div className="col-md-12">
                            <div className="contact-page-form">
                                <h3>Candidate Registration</h3>
                                <p>
                                    Let the right Employers reach you - Please
                                    fill in the form below and upload your
                                    Resume.
                                </p>
                                <form onSubmit={handleSubmit(sendEmail)}>
                                    <div className="row">
                                        <div className="col-md-6 col-sm-6">
                                            <div className="text">
                                                Name<span>*</span> :
                                            </div>
                                            <div className="single-input-field">
                                                <input
                                                    type="text"
                                                    placeholder="Name"
                                                    name="name"
                                                    {...register("name")}
                                                />
                                                <span className="text-danger">
                                                    {errors.name?.message}
                                                </span>
                                            </div>
                                        </div>
                                        <div className="col-md-6 col-sm-6">
                                            <div className="text">
                                                Email<span>*</span> :
                                            </div>
                                            <div className="single-input-field">
                                                <input
                                                    type="email"
                                                    placeholder="Email Address"
                                                    name="email"
                                                    {...register("email")}
                                                />
                                                <span className="text-danger">
                                                    {errors.email?.message}
                                                </span>
                                            </div>
                                        </div>
                                        <div className="col-md-6 col-sm-6">
                                            <div className="text">
                                                Current Salary :
                                            </div>
                                            <div className="single-input-field">
                                                <input
                                                    type="text"
                                                    placeholder="Current Salary"
                                                    name="current_salary"
                                                    {...register(
                                                        "current_salary"
                                                    )}
                                                />
                                                <span className="text-danger">
                                                    {
                                                        errors.current_salary
                                                            ?.message
                                                    }
                                                </span>
                                            </div>
                                        </div>
                                        <div className="col-md-6 col-sm-6">
                                            <div className="text">
                                                Expected Salary :
                                            </div>
                                            <div className="single-input-field">
                                                <input
                                                    type="text"
                                                    placeholder="Expected Salary"
                                                    name="expected_salary"
                                                    {...register(
                                                        "expected_salary"
                                                    )}
                                                />
                                                <span className="text-danger">
                                                    {
                                                        errors.expected_salary
                                                            ?.message
                                                    }
                                                </span>
                                            </div>
                                        </div>
                                        <div className="col-md-6 col-sm-6">
                                            <div className="text">
                                                Mobile Number :
                                            </div>
                                            <div className="single-input-field">
                                                <input
                                                    type="text"
                                                    placeholder="Mobile Number"
                                                    name="mobile_number"
                                                    {...register(
                                                        "mobile_number"
                                                    )}
                                                />
                                                <span className="text-danger">
                                                    {
                                                        errors.mobile_number
                                                            ?.message
                                                    }
                                                </span>
                                            </div>
                                        </div>
                                        <div className="col-md-6 col-sm-6">
                                            <div className="row">
                                                <div className="col-md-6">
                                                    <div className="text">
                                                        Experience Year :
                                                    </div>
                                                    <div className="single-input-field">
                                                        <input
                                                            type="text"
                                                            placeholder="Experience Year"
                                                            name="experience_year"
                                                            {...register(
                                                                "experience_year"
                                                            )}
                                                        />
                                                        <span className="text-danger">
                                                            {
                                                                errors
                                                                    .experience_year
                                                                    ?.message
                                                            }
                                                        </span>
                                                    </div>
                                                </div>
                                                <div className="col-md-6">
                                                    <div className="text">
                                                        Experience Month :
                                                    </div>
                                                    <div className="single-input-field">
                                                        <input
                                                            type="text"
                                                            placeholder="Experience Month"
                                                            name="experience_month"
                                                            {...register(
                                                                "experience_month"
                                                            )}
                                                        />
                                                        <span className="text-danger">
                                                            {
                                                                errors
                                                                    .experience_month
                                                                    ?.message
                                                            }
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="col-md-6 col-sm-6">
                                            <div className="upload-file">
                                                <span className="w-upload-file-label-span">
                                                    Upload Resume
                                                    <span>*</span> :
                                                </span>
                                                <div
                                                    className="file-upload-wrapper"
                                                    data-text="Select your file!"
                                                >
                                                    <input
                                                        name="resume"
                                                        type="file"
                                                        className="file-upload-field"
                                                        accept="application/pdf"
                                                        {...register("resume")}
                                                    />
                                                    <span className="text-danger">
                                                        {errors.resume?.message}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="col-md-6 col-sm-6">
                                            <div className="text">
                                                <div className="new">
                                                    <div className="form-group">
                                                        <input
                                                            type="checkbox"
                                                            id="html"
                                                            name="terms"
                                                            {...register(
                                                                "terms"
                                                            )}
                                                        />
                                                        <label htmlFor="html">
                                                            Agree to terms of
                                                            service
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="single-input-fieldsbtn btn-top-mar">
                                            <input
                                                type="submit"
                                                value={
                                                    loader
                                                        ? "Sending..."
                                                        : "Send Email"
                                                }
                                                disabled={loader && "disabled"}
                                            />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
};

export default ApplyForJob;
