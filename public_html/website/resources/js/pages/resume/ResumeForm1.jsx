import React, { useState, useEffect } from "react";
import { useLocation, useNavigate } from "react-router-dom";
import Banner from "../../components/Banner";
import Validation from "./ResumeFormValidation";
import AddPlusSVG from "../../../images/svg/add-plus.svg";
import useForm from "../../hooks/useForm";
import Services from "../../services/Services";

import {AiOutlinePlusSquare , AiOutlineCloseSquare} from 'react-icons/ai';

const ResumeForm = () => {
    const location = useLocation();
    const navigate = useNavigate();
    const resume = location.state;
    document.title = "!! Smart Lion - Resume Details Form !!"
    useEffect(() => {
        if (resume === null) {
            navigate("/resume-builder");
        }
    }, []);

    const ExpObj = {
        company_name: "",
        duration: "",
        role_responsibilities: "",
    };

    const QuaObj = { course: "", year: "", result: "" };
    const [experienceList, setExperienceList] = useState([ExpObj]);
    const [qualificationList, setQualificationList] = useState([QuaObj]);
    const { handleSubmit, handleChange, handleFileChange, values, errors } =
        useForm(submitForm, Validation, {});

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

    const [loader, setLoader] = useState(false);
    async function submitForm(event) {
        if (event) event.preventDefault();
        setLoader(true);
        console.log(values);
        const base64 = await convertBase64(values.image);
        let allData = {
            ...values,
            ["image"]: base64,
            ["experience"]: experienceList,
            ["qualification"]: qualificationList,
            ["resumeID"]: resume,
        };

        Services.GenerateResume(allData).then((res) => {
            if (res.data.status == 1) {
                const link = document.createElement("a");
                link.href = res.data.data;
                link.setAttribute("download", `resume.pdf`);
                document.body.appendChild(link);
                link.click();
                link.parentNode.removeChild(link);
            }
            setLoader(false);
        });
        // navigate("/resume-preview", { state: allData });
    }

    // Experience
    const handleExperienceAdd = () => {
        setExperienceList([...experienceList, {}]);
    };
    const handleExperienceRemove = (index) => {
        const ExpList = [...experienceList];
        ExpList.splice(index, 1);
        setExperienceList(ExpList);
    };
    const handleExperienceCloneChange = (event, index) => {
        const { name, value } = event.target;
        const list = [...experienceList];
        list[index][name] = value;
        setExperienceList(list);
    };

    // Education Qualification
    const handleQualificationAdd = () => {
        setQualificationList([...qualificationList, {}]);
    };

    const handleQualificationRemove = (index) => {
        const QuaList = [...qualificationList];
        QuaList.splice(index, 1);
        setQualificationList(QuaList);
    };

    const handleQualificationCloneChange = (event, index) => {
        const { name, value } = event.target;
        const list = [...qualificationList];
        list[index][name] = value;
        setQualificationList(list);
    };

    return (
        <>
            <Banner
                img="images/current-opening-banner.png"
                pageName="Resume Details Form"
            />
            <section className="resume-builder-section">
                <div className="container">
                    <div className="tab-teaser">
                        <div className="resume-details-heading">
                            <h3>Enter your resume details</h3>
                            <p>
                                Let the right Employers reach you - Please fill
                                in the form below and upload your Resume
                                details.
                            </p>
                        </div>
                        <div className="resume-detail-form">
                            <form
                                onSubmit={handleSubmit}
                                method="POST"
                                encType="multipart/form-data"
                            >
                                <div className="row">
                                    <div className="col-md-6 col-sm-6">
                                        <div className="text">
                                            Upload Photo<span>*</span> :
                                        </div>
                                        <div
                                            className="file-upload-wrapper"
                                            data-text="Select your photo"
                                        >
                                            <input
                                                name="image"
                                                id="image"
                                                type="file"
                                                className="file-upload-field"
                                                onChange={handleFileChange}
                                            />
                                        </div>
                                    </div>
                                    <div className="col-md-6 col-sm-6">
                                        <div className="text">
                                            Name<span>*</span> :{" "}
                                            {errors.name && (
                                                <small className="text-danger">
                                                    {errors.name}
                                                </small>
                                            )}
                                        </div>
                                        <div className="single-input-field">
                                            <input
                                                type="text"
                                                placeholder=""
                                                name="name"
                                                id="name"
                                                onChange={handleChange}
                                                value={values.name || ""}
                                            />
                                        </div>
                                    </div>
                                    <div className="col-md-6 col-sm-6">
                                        <div className="text">
                                            Email<span>*</span> :{" "}
                                            {errors.email && (
                                                <small className="text-danger">
                                                    {errors.email}
                                                </small>
                                            )}
                                        </div>
                                        <div className="single-input-field">
                                            <input
                                                type="email"
                                                placeholder=""
                                                name="email"
                                                required=""
                                                onChange={handleChange}
                                                value={values.email || ""}
                                            />
                                        </div>
                                    </div>
                                    <div className="col-md-6 col-sm-6">
                                        <div className="text">
                                            Mobile Number<span>*</span> :{" "}
                                            {errors.mobile_number && (
                                                <small className="text-danger">
                                                    {errors.mobile_number}
                                                </small>
                                            )}
                                        </div>
                                        <div className="single-input-field">
                                            <input
                                                type="text"
                                                placeholder=""
                                                name="mobile_number"
                                                required=""
                                                onChange={handleChange}
                                                value={
                                                    values.mobile_number || ""
                                                }
                                            />
                                        </div>
                                    </div>
                                    <div className="col-md-6 col-sm-6">
                                        <div className="text">
                                            Professional Skills
                                            <span>*</span> :
                                        </div>
                                        <div className="single-input-field">
                                            <textarea
                                                placeholder=""
                                                name="professional_skills"
                                                onChange={handleChange}
                                            ></textarea>
                                        </div>
                                    </div>
                                    <div className="col-md-6 col-sm-6">
                                        <div className="text">
                                            Objective<span>*</span> :
                                        </div>
                                        <div className="single-input-field">
                                            <textarea
                                                placeholder=""
                                                name="objective"
                                                onChange={handleChange}
                                            ></textarea>
                                        </div>
                                    </div>

                                    <div className="col-md-12 col-sm-12">
                                        <div className="text">
                                            Experience<span>*</span> :
                                        </div>
                                        <div className="experience-filed">
                                            {experienceList.map(
                                                (singleExperience, index) => (
                                                    <div
                                                        className="row"
                                                        key={index}
                                                    >
                                                        <div className="col-lg-4 col-md-6 col-sm-4">
                                                            <div className="row">
                                                                <div className="col-lg-5 col-md-6 col-sm-5">
                                                                    <div className="company-name">
                                                                        Company
                                                                        Name:
                                                                    </div>
                                                                </div>
                                                                <div className="col-lg-7 col-md-6 col-sm-7">
                                                                    <div className="single-input-field">
                                                                        <input
                                                                            type="text"
                                                                            placeholder=""
                                                                            name="company_name"
                                                                            required=""
                                                                            onChange={(
                                                                                event
                                                                            ) =>
                                                                                handleExperienceCloneChange(
                                                                                    event,
                                                                                    index
                                                                                )
                                                                            }
                                                                            value={
                                                                                singleExperience.company_name ||
                                                                                ""
                                                                            }
                                                                        />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div className="col-lg-2 col-md-6 col-sm-2">
                                                            <div className="row">
                                                                <div className="col-md-5 col-sm-5">
                                                                    <div className="company-name">
                                                                        Duration:
                                                                    </div>
                                                                </div>
                                                                <div className="col-lg-7 col-md-7 col-sm-7">
                                                                    <div className="single-input-field">
                                                                        <input
                                                                            type="text"
                                                                            placeholder=""
                                                                            name="duration"
                                                                            required=""
                                                                            onChange={(
                                                                                event
                                                                            ) =>
                                                                                handleExperienceCloneChange(
                                                                                    event,
                                                                                    index
                                                                                )
                                                                            }
                                                                            value={
                                                                                singleExperience.duration ||
                                                                                ""
                                                                            }
                                                                        />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div className="col-lg-6 col-md-12 col-sm-6">
                                                            <div className="row">
                                                                <div className="col-lg-4 col-md-4 col-sm-4">
                                                                    <div className="company-name">
                                                                        Role &
                                                                        Responsibilities:
                                                                    </div>
                                                                </div>
                                                                <div className="col-lg-7 col-md-7 col-sm-7 role-custom-colum">
                                                                    <div className="single-input-field">
                                                                        <input
                                                                            type="text"
                                                                            placeholder=""
                                                                            name="role_responsibilities"
                                                                            required=""
                                                                            onChange={(
                                                                                event
                                                                            ) =>
                                                                                handleExperienceCloneChange(
                                                                                    event,
                                                                                    index
                                                                                )
                                                                            }
                                                                            value={
                                                                                singleExperience.role_responsibilities ||
                                                                                ""
                                                                            }
                                                                        />
                                                                    </div>
                                                                </div>
                                                                <div className="col-lg-1 col-md-1 col-sm-1">
                                                                    <div className="single-input-field add-icon-l-r">
                                                                        {experienceList.length -
                                                                            1 ===
                                                                        index ? (
                                                                            <AiOutlinePlusSquare size={46} color="#E4A823" onClick={
                                                                                        handleExperienceAdd
                                                                                    }/>
                                                                        ) : (
                                                                            <AiOutlineCloseSquare  size={46} color="#e42323" onClick={() =>
                                                                                handleExperienceRemove(
                                                                                    index
                                                                                )
                                                                            }/>
                                                                        )}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                )
                                            )}
                                        </div>
                                    </div>
                                    <div className="col-md-12 col-sm-12">
                                        <div className="text">
                                            Education Qualification
                                            <span>*</span> :
                                        </div>
                                        <div className="experience-filed">
                                            {qualificationList.map(
                                                (
                                                    singleQualification,
                                                    index
                                                ) => (
                                                    <div
                                                        className="row"
                                                        key={index}
                                                    >
                                                        <div className="col-lg-4 col-md-6 col-sm-4">
                                                            <div className="row">
                                                                <div className="col-lg-3 col-md-3 col-sm-3">
                                                                    <div className="company-name">
                                                                        Course:
                                                                    </div>
                                                                </div>
                                                                <div className="col-lg-9 col-md-9 col-sm-9">
                                                                    <div className="single-input-field">
                                                                        <input
                                                                            type="text"
                                                                            placeholder=""
                                                                            name="course"
                                                                            required=""
                                                                            onChange={(
                                                                                event
                                                                            ) =>
                                                                                handleQualificationCloneChange(
                                                                                    event,
                                                                                    index
                                                                                )
                                                                            }
                                                                            value={
                                                                                singleQualification.course ||
                                                                                ""
                                                                            }
                                                                        />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div className="col-lg-3 col-md-6 col-sm-3">
                                                            <div className="row">
                                                                <div className="col-md-3 col-sm-3">
                                                                    <div className="company-name">
                                                                        Year:
                                                                    </div>
                                                                </div>
                                                                <div className="col-md-9 col-sm-9">
                                                                    <div className="single-input-field">
                                                                        <input
                                                                            type="text"
                                                                            placeholder=""
                                                                            name="year"
                                                                            required=""
                                                                            onChange={(
                                                                                event
                                                                            ) =>
                                                                                handleQualificationCloneChange(
                                                                                    event,
                                                                                    index
                                                                                )
                                                                            }
                                                                            value={
                                                                                singleQualification.year ||
                                                                                ""
                                                                            }
                                                                        />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div className="col-lg-5 col-md-12 col-sm-5">
                                                            <div className="row">
                                                                <div className="col-lg-3 col-md-3 col-sm-3">
                                                                    <div className="company-name">
                                                                        Result:
                                                                    </div>
                                                                </div>
                                                                <div className="col-lg-7 col-md-7 col-sm-7 result-custom-colum">
                                                                    <div className="single-input-field">
                                                                        <input
                                                                            type="text"
                                                                            placeholder=""
                                                                            name="result"
                                                                            required=""
                                                                            onChange={(
                                                                                event
                                                                            ) =>
                                                                                handleQualificationCloneChange(
                                                                                    event,
                                                                                    index
                                                                                )
                                                                            }
                                                                            value={
                                                                                singleQualification.result ||
                                                                                ""
                                                                            }
                                                                        />
                                                                    </div>
                                                                </div>
                                                                <div className="col-lg-1 col-md-1 col-sm-1">
                                                                    <div className="single-input-field add-icon-l-p">
                                                                        {qualificationList.length -
                                                                            1 ===
                                                                        index ? (
                                                                            <AiOutlinePlusSquare size={46} color="#E4A823" onClick={
                                                                                        handleQualificationAdd
                                                                                    }/>
                                                                        ) : (
                                                                            <AiOutlineCloseSquare  size={46} color="#e42323"   onClick={() =>
                                                                                handleQualificationRemove(
                                                                                    index
                                                                                )
                                                                            }/>
                                                                           
                                                                        )}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                )
                                            )}
                                        </div>
                                    </div>
                                    <div className="col-md-6 col-sm-6">
                                        <div className="text">
                                            Other Qualifications or Skills
                                            <span>*</span> :
                                        </div>
                                        <div className="single-input-field">
                                            <textarea
                                                placeholder=""
                                                name="other_skills"
                                                onChange={handleChange}
                                                value={
                                                    values.other_skills || ""
                                                }
                                            ></textarea>
                                        </div>
                                    </div>
                                    <div className="col-md-6 col-sm-6">
                                        <div className="text">
                                            Residence Address
                                            <span>*</span> :
                                        </div>
                                        <div className="single-input-field">
                                            <textarea
                                                placeholder=""
                                                name="address"
                                                onChange={handleChange}
                                                value={values.address || ""}
                                            ></textarea>
                                        </div>
                                    </div>
                                    <div className="col-md-6 col-sm-6">
                                        <div className="text">
                                            Date of Birth<span>*</span> :
                                        </div>
                                        <div className="single-input-field">
                                            <input
                                                type="date"
                                                placeholder=""
                                                name="dob"
                                                required=""
                                                onChange={handleChange}
                                                value={values.dob || ""}
                                            />
                                        </div>
                                    </div>

                                    <div className="col-md-6 col-sm-6">
                                        <div className="text">
                                            Languages<span>*</span> :
                                        </div>
                                        <div className="single-input-field">
                                            <input
                                                type="text"
                                                placeholder=""
                                                name="languages"
                                                required=""
                                                onChange={handleChange}
                                                value={values.languages || ""}
                                            />
                                        </div>
                                    </div>
                                    <div className="col-md-6 col-sm-6">
                                        <div className="text">
                                            Marital Status<span>*</span> :
                                        </div>
                                        <div className="single-input-field">
                                            <input
                                                type="text"
                                                placeholder=""
                                                name="marital_status"
                                                required=""
                                                onChange={handleChange}
                                                value={
                                                    values.marital_status || ""
                                                }
                                            />
                                        </div>
                                    </div>
                                    <div className="col-md-6 col-sm-6">
                                        <div className="text"></div>
                                        <div className="text">
                                            <div className="new">
                                                <div className="form-group">
                                                    <input
                                                        type="checkbox"
                                                        id="html"
                                                    />
                                                    <label htmlFor="html">
                                                        Are You Looking For Job?
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div className="single-input-fieldsbtn btn-top-mar">
                                        <input
                                            type="submit"
                                            disabled={loader && "disabled"}
                                            value={
                                                loader
                                                    ? "Loading ..."
                                                    : "Submit"
                                            }
                                        />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
};

export default ResumeForm;
