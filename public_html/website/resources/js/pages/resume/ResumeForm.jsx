import React, { useState, useEffect, Fragment } from "react";
import { Link, useLocation, useNavigate } from "react-router-dom";
import { AiOutlineCloseSquare } from "react-icons/ai";
import { useForm } from "react-hook-form";
import Banner from "../../components/Banner";
import Services from "../../services/Services";
import moment from "moment";

const ResumeForm = () => {
    const location = useLocation();
    const navigate = useNavigate();
    const resume = location.state;
    const {
        register,
        watch,
        handleSubmit,
        formState: { errors },
        reset,
        getValues,
        setValue,
    } = useForm({
        defaultValues: {
            resumeID: resume,
            // image:'',
            name: '',
            dob: '',
            marital_status: '',
            languages: '',
            experience: [{
                company_name: "", current_company: false, description: "", job_title: "", location: "", start_date: "", end_date: ""
            }],
            qualification: [{ sc_name: "", start_date: "", end_date: "", degree: "", field_of_study: "", location: "" }],
            skills: [{ skill: "" }],
            additional_info: [],
            certification: [],
            link: []
        }
    });

    useEffect(() => {
        document.title = "!! Smart Lion - Resume Details Form !!";
        if (resume === null) {
            navigate("/resume-builder");
        }
    }, []);

    const [additionalInfoList, setAdditionalInfoList] = useState([]);
    // Experience
    const handleExperienceAdd = () => {
        setValue('experience', [...getValues('experience'), {
            company_name: "",
            current_company: false,
            description: "",
            job_title: "",
            location: "",
            start_date: "",
            end_date: "",
        }])
    };
    const handleExperienceRemove = (index) => {
        const ExpList = getValues('experience');
        ExpList.splice(index, 1);
        setValue('experience', ExpList);
    };

    // Education Qualification
    const handleQualificationAdd = () => {
        setValue('qualification', [...getValues('qualification'), {
            sc_name: "",
            start_date: "",
            end_date: "",
            degree: "",
            field_of_study: "",
            location: "",
        }])
    };
    const handleQualificationRemove = (index) => {
        const QuaList = getValues('qualification');
        QuaList.splice(index, 1);
        setValue('qualification', QuaList);
    };

    // Additional Information
    const handleSkillsAdd = () => {
        setValue('skills', [...getValues('skills'), {
            skill: ""
        }]);
    }
    const handleSkillsRemove = (index) => {
        const SkillList = getValues('skills');
        SkillList.splice(index, 1);
        setValue('skills', SkillList);
    };

    // Additional Information
    const handleAdditionalInfoAdd = () => {
        setValue('additional_info', [...getValues('additional_info'), {
            description: ""
        }]);
    }
    const handleAdditionalInfoRemove = (index) => {
        const AdditionalInfoList = getValues('additional_info');
        AdditionalInfoList.splice(index, 1);
        setValue('additional_info', AdditionalInfoList);
    };

    // Certifications / Licenses
    const handleCertificationAdd = () => {
        setValue('certification', [...getValues('certification'), {
            certification: "",
            start_date: "",
            end_date: "",
        }])
    }
    const handleCertificationRemove = (index) => {
        const CertificationList = getValues('certification');
        CertificationList.splice(index, 1);
        setValue('certification', CertificationList);
    };

    // Link
    const handleLinkAdd = () => {
        setValue('link', [...getValues('link'), {
            name: "",
            link: "",
        }])
    }
    const handleLinkRemove = (index) => {
        const LinkList = getValues('link');
        LinkList.splice(index, 1);
        setValue('link', LinkList);
    };

    const [loader, setLoader] = useState(false);

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

    async function submitForm(data) {
        setLoader(true);
        let base64 = "";
        if (data.image[0]) {
            base64 = await convertBase64(data.image[0]);
        }

        const latLong = JSON.parse(localStorage.getItem("locationDetails"));
        let allData = {
            ...data,
            ["image"]: base64,
            ["lat"]: latLong ? latLong.Latitude : '',
            ["long"]: latLong ? latLong.Longitude : '',
        };
        Services.GenerateResume(allData).then((res) => {
            if (res.data.status == 1) {
                const link = document.createElement("a");
                link.href = res.data.data;
                link.setAttribute("download", `resume.pdf`);
                document.body.appendChild(link);
                link.click();
                link.parentNode.removeChild(link);
                reset();
            }
            setLoader(false);
        });
    }

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
                            <form onSubmit={handleSubmit(submitForm)} method="POST" encType="multipart/form-data">
                                <div className="row">
                                    <div className="col-md-12 col-sm-12">
                                        <div className="text"> Personal Information : </div>
                                        <div className="experience-filed">
                                            <div className="row">
                                                <div className="col-md-6 col-sm-6">
                                                    <div className="text"> Upload Photo :</div>
                                                    <div className="file-upload-wrapper" data-text="Select your photo">
                                                        <input name="image" type="file" className="file-upload-field"
                                                            {...register("image")}
                                                        />
                                                        {errors.image && (<span className="text-danger">{errors.image.message}</span>)}
                                                    </div>
                                                </div>
                                                <div className="col-md-6 col-sm-6">
                                                    <div className="text">Name<span>*</span> :</div>
                                                    <div className="single-input-field">
                                                        <input type="text" name="name" placeholder="Name"
                                                            {...register("name", { required: "Please enter your name." })}
                                                        />
                                                        {errors.name && (<span className="text-danger">{errors.name.message}</span>)}
                                                    </div>
                                                </div>
                                                <div className="col-md-6 col-sm-6">
                                                    <div className="text">Email<span>*</span> :</div>
                                                    <div className="single-input-field">
                                                        <input type="email" placeholder="Email"
                                                            {...register("email", {
                                                                required: "Please enter your email address.",
                                                                pattern: {
                                                                    value: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i,
                                                                    message: "invalid email address",
                                                                },
                                                            })}
                                                        />
                                                        {errors.email && (<span className="text-danger">{errors.email.message}</span>)}
                                                    </div>
                                                </div>

                                                <div className="col-md-6 col-sm-6">
                                                    <div className="text">Mobile Number<span>*</span> :</div>
                                                    <div className="single-input-field">
                                                        <input type="text" placeholder="Mobile Number" name="mobile_number"
                                                            {...register("mobile_number", {
                                                                required: "Please enter your mobile number.",
                                                                maxLength: {
                                                                    value: 10,
                                                                    message: "Max length is 10",
                                                                },
                                                                pattern: {
                                                                    value: /^[0-9.]+$/,
                                                                    message: "Please enter a number",
                                                                },
                                                            })}
                                                        />
                                                        {errors.mobile_number && (<span className="text-danger">{errors.mobile_number.message}</span>)}
                                                    </div>
                                                </div>
                                                <div className="col-md-6 col-sm-6">
                                                    <div className="text">
                                                        Date of Birth<span>*</span> :
                                                    </div>
                                                    <div className="single-input-field">
                                                        <input
                                                            type="date"
                                                            placeholder="Date of Birth"
                                                            name="dob"
                                                            max={moment().format("YYYY-MM-DD")}
                                                            {...register("dob", {
                                                                required:
                                                                    "Please enter your date of birth.",
                                                            })}
                                                        />
                                                        {errors.dob && (
                                                            <span className="text-danger">
                                                                {errors.dob.message}
                                                            </span>
                                                        )}
                                                    </div>
                                                </div>

                                                <div className="col-md-6 col-sm-6">
                                                    <div className="text">
                                                        Marital Status<span>*</span> :
                                                    </div>
                                                    <div className="single-input-field">
                                                        <input
                                                            type="text"
                                                            placeholder="Marital Status"
                                                            name="marital_status"
                                                            {...register("marital_status", {
                                                                required:
                                                                    "Please enter your marital status.",
                                                            })}
                                                        />
                                                        {errors.marital_status && (
                                                            <span className="text-danger">
                                                                {
                                                                    errors.marital_status
                                                                        .message
                                                                }
                                                            </span>
                                                        )}
                                                    </div>
                                                </div>
                                                <div className="col-md-6 col-sm-6">
                                                    <div className="text">
                                                        Languages<span>*</span> :
                                                    </div>
                                                    <div className="single-input-field">
                                                        <textarea
                                                            type="text"
                                                            placeholder="Languages"
                                                            name="languages"
                                                            {...register("languages", {
                                                                required:
                                                                    "Please enter your languages.",
                                                            })}
                                                        ></textarea>
                                                        {errors.languages && (
                                                            <span className="text-danger">
                                                                {errors.languages.message}
                                                            </span>
                                                        )}
                                                    </div>
                                                </div>
                                                <div className="col-md-6 col-sm-6">
                                                    <div className="text">
                                                        Residence Address
                                                        <span>*</span> :
                                                    </div>
                                                    <div className="single-input-field">
                                                        <textarea
                                                            placeholder="Residence Address"
                                                            name="address"
                                                            {...register("address", {
                                                                required:
                                                                    "Please enter your address.",
                                                            })}
                                                        ></textarea>
                                                        {errors.address && (
                                                            <span className="text-danger">
                                                                {errors.address.message}
                                                            </span>
                                                        )}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div className="col-md-12 col-sm-12">
                                        <div className="text"> Objective <span>*</span> :</div>
                                        <div className="single-input-field">
                                            <textarea placeholder="Objective" name="objective"
                                                {...register(
                                                    "objective",
                                                    { required: "Please enter your objective." }
                                                )}
                                            ></textarea>
                                            {errors.objective && (<span className="text-danger">{errors.objective.message}</span>)}
                                        </div>
                                    </div>

                                    <div className="col-md-12 col-sm-12">
                                        <div className="text">Experience<span>*</span> :</div>
                                        <div className="experience-filed">
                                            {watch('experience').map(
                                                (singleExperience, index) => (
                                                    <div key={index}>
                                                        <div className="row">
                                                            <div className="col-md-11 col-sm-11">
                                                                <div className="text">
                                                                    <div className="new">
                                                                        <div className="form-group">
                                                                            <input type="checkbox" id={`html${index}`} name={`experience.${index}.current_company`} checked={getValues(`experience.${index}.current_company`)}  {...register(`experience.${index}.current_company`)}
                                                                            />
                                                                            <label htmlFor={`html${index}`}>
                                                                                Is your current company ?
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {index !== 0 && (<div className="col-md-1 col-sm-1 text-right">
                                                                <AiOutlineCloseSquare size={30} color="#e42323" onClick={() => handleExperienceRemove(index)} />
                                                            </div>)}

                                                            <div className="col-md-12 col-sm-12">
                                                                <div className="company-name"> Job Title :</div>
                                                                <div className="single-input-field">
                                                                    <input type="text" placeholder="Job Title"
                                                                        {...register(`experience.${index}.job_title`, { required: "Please enter your job title." })}
                                                                    />
                                                                    {errors.experience?.[index] && (<span className="text-danger">{errors.experience?.[index].job_title?.message}</span>)}
                                                                </div>
                                                            </div>

                                                            <div className="col-md-6 col-sm-6">
                                                                <div className="company-name"> Company Name :</div>
                                                                <div className="single-input-field">
                                                                    <input type="text" placeholder="Company Name"
                                                                        {...register(`experience.${index}.company_name`, { required: "Please enter your company name." })}
                                                                    />
                                                                    {errors.experience?.[index] && (<span className="text-danger">{errors.experience?.[index].company_name?.message}</span>)}
                                                                </div>
                                                            </div>
                                                            <div className="col-md-3 col-sm-3">
                                                                <div className="company-name"> Start Date :</div>
                                                                <div className="single-input-field">
                                                                    <input type="date" placeholder="Start Date" max={moment().format("YYYY-MM-DD")}
                                                                        {...register(`experience.${index}.start_date`, { required: "Please select start date." })}
                                                                    />
                                                                    {errors.experience?.[index] && (<span className="text-danger">{errors.experience?.[index].start_date?.message}</span>)}
                                                                </div>
                                                            </div>
                                                            <div className="col-md-3 col-sm-3">
                                                                <div className="company-name"> End Date :</div>
                                                                <div className="single-input-field">
                                                                    {watch(`experience.${index}.current_company`) ? <h6 style={{ marginTop: "15px" }}>To Present</h6> : (<>
                                                                        <input type="date" placeholder="End Date" min={watch(`experience.${index}.start_date`)} max={moment().format("YYYY-MM-DD")}
                                                                            {...register(`experience.${index}.end_date`, { required: "Please select end date." })}
                                                                        />
                                                                        {errors.experience?.[index] && (<span className="text-danger">{errors.experience?.[index].end_date?.message}</span>)}</>
                                                                    )}

                                                                </div>
                                                            </div>
                                                            <div className="col-md-12 col-sm-12">
                                                                <div className="company-name"> Location :</div>
                                                                <div className="single-input-field">
                                                                    <textarea name="" id="" cols="30" rows="10" placeholder="Location"
                                                                        {...register(`experience.${index}.location`)}></textarea>
                                                                    {errors.experience?.[index] && (<span className="text-danger">{errors.experience?.[index].location?.message}</span>)}
                                                                </div>
                                                            </div>
                                                            <div className="col-md-12 col-sm-12">
                                                                <div className="company-name">
                                                                    Description :
                                                                </div>
                                                                <div className="single-input-field">
                                                                    <textarea name="" id="" cols="30" rows="10" placeholder="Description"
                                                                        {...register(`experience.${index}.description`)}></textarea>
                                                                    {errors.experience?.[index] && (<span className="text-danger">{errors.experience?.[index].description?.message}</span>)}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr />
                                                    </div>
                                                )
                                            )}
                                            <Link to="#" className="mb-5" onClick={handleExperienceAdd} >Add More Experience</Link>
                                        </div>
                                    </div>

                                    <div className="col-md-12 col-sm-12">
                                        <div className="text"> Education Qualification <span>*</span> : </div>
                                        <div className="experience-filed">
                                            {watch('qualification').map(
                                                (singleQualification, index) => (
                                                    <div key={index}>
                                                        <div className="row">
                                                            {index !== 0 && (<div className="col-md-12 col-sm-12 text-right">
                                                                <AiOutlineCloseSquare size={30} color="#e42323" onClick={() => handleQualificationRemove(index)} />
                                                            </div>)}

                                                            <div className="col-md-6 col-sm-6">
                                                                <div className="company-name"> School / Collage :</div>
                                                                <div className="single-input-field">
                                                                    <input type="text" placeholder="School / Collage" {...register(`qualification.${index}.sc_name`, { required: "Please enter your school or collage name." })} />
                                                                    {errors.qualification?.[index] && (<span className="text-danger">{errors.qualification?.[index].sc_name?.message}</span>)}
                                                                </div>
                                                            </div>

                                                            <div className="col-md-3 col-sm-3">
                                                                <div className="company-name"> Start Date :</div>
                                                                <div className="single-input-field">
                                                                    <input type="date" placeholder="Start Date" max={moment().format("YYYY-MM-DD")}
                                                                        {...register(`qualification.${index}.start_date`, { required: "Please select start date." })}
                                                                    />
                                                                    {errors.qualification?.[index] && (<span className="text-danger">{errors.qualification?.[index].start_date?.message}</span>)}
                                                                </div>
                                                            </div>
                                                            <div className="col-md-3 col-sm-3">
                                                                <div className="company-name"> End Date :</div>
                                                                <div className="single-input-field">
                                                                    <input type="date" placeholder="End Date" min={watch(`qualification.${index}.start_date`)} max={moment().format("YYYY-MM-DD")}
                                                                        {...register(`qualification.${index}.end_date`, { required: "Please select end date." })}
                                                                    />
                                                                    {errors.qualification?.[index] && (<span className="text-danger">{errors.qualification?.[index].end_date?.message}</span>)}
                                                                </div>
                                                            </div>
                                                            <div className="col-md-6 col-sm-6">
                                                                <div className="company-name"> Degree :</div>
                                                                <div className="single-input-field">
                                                                    <input type="text" placeholder="degree" name="degree" {...register(`qualification.${index}.degree`, { required: "Please enter your degree." })} />
                                                                    {errors.qualification?.[index] && (<span className="text-danger">{errors.qualification?.[index].degree?.message}</span>)}
                                                                </div>
                                                            </div>
                                                            <div className="col-md-6 col-sm-6">
                                                                <div className="company-name"> Field of study :</div>
                                                                <div className="single-input-field">
                                                                    <input type="text" placeholder="Field of study" name="field_of_study" {...register(`qualification.${index}.field_of_study`, { required: "Please enter your field of study." })} />
                                                                    {errors.qualification?.[index] && (<span className="text-danger">{errors.qualification?.[index].field_of_study?.message}</span>)}
                                                                </div>
                                                            </div>
                                                            <div className="col-md-12 col-sm-12">
                                                                <div className="company-name"> Location :</div>
                                                                <div className="single-input-field">
                                                                    <textarea name="location" id="" cols="30" rows="10" placeholder="Location"
                                                                        {...register(`qualification.${index}.location`)}></textarea>
                                                                    {errors.qualification?.[index] && (<span className="text-danger">{errors.qualification?.[index].location?.message}</span>)}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr />
                                                    </div>
                                                )
                                            )}
                                            <Link to="#" className="mb-5" onClick={handleQualificationAdd} >Add More Eduction Qualification</Link>
                                        </div>
                                    </div>

                                    {/* Skills */}
                                    <div className="col-md-12 col-sm-12">
                                        <div className="text"> Skills : </div>
                                        <div className="experience-filed">
                                            <div className="row">
                                                {watch('skills').map((item, index) => (
                                                    <Fragment key={index}>
                                                        <div className="col-md-6 col-sm-6">
                                                            <div className="company-name">
                                                                Skill :
                                                                {index !== 0 && (<span style={{ float: 'right' }}>
                                                                    <AiOutlineCloseSquare size={30} color="#e42323" onClick={() => handleSkillsRemove(index)} />
                                                                </span>)}

                                                            </div>
                                                            <div className="single-input-field">
                                                                <input type="text" name="skill" placeholder="Skill"
                                                                    {...register(`skills.${index}.skill`, { required: "Please enter your skill." })}
                                                                />
                                                                {errors.skills?.[index] && (<span className="text-danger">{errors.skills?.[index].skill?.message}</span>)}
                                                            </div>
                                                        </div>
                                                    </Fragment>
                                                ))}
                                            </div>
                                            <hr />
                                            <Link to="#" className="mb-5" onClick={handleSkillsAdd} >Add Skills</Link>
                                        </div>
                                    </div>

                                    {/* Additional Information */}
                                    <div className="col-md-12 col-sm-12">
                                        <div className="text"> Additional Information : </div>
                                        <div className="experience-filed">
                                            {watch('additional_info').map((item, index) => (
                                                <Fragment key={index}>
                                                    <div className="col-md-12 col-sm-12">
                                                        <div className="company-name">
                                                            Description :
                                                            <span style={{ float: 'right' }}>
                                                                <AiOutlineCloseSquare size={30} color="#e42323" onClick={() => handleAdditionalInfoRemove(index)} />
                                                            </span>
                                                        </div>
                                                        <div className="single-input-field">
                                                            <textarea name="" id="" cols="30" rows="10" placeholder="Description"
                                                                {...register(`additional_info.${index}.description`, { required: "Please enter description." })}></textarea>
                                                            {errors.additional_info?.[index] && (<span className="text-danger">{errors.additional_info?.[index].description?.message}</span>)}
                                                        </div>
                                                    </div>
                                                    <hr />
                                                </Fragment>
                                            ))}
                                            <Link to="#" className="mb-5" onClick={handleAdditionalInfoAdd} >Add More Additional Information</Link>
                                        </div>
                                    </div>

                                    {/* Certifications / Licenses  */}
                                    <div className="col-md-12 col-sm-12">
                                        <div className="text"> Certifications & Licenses : </div>
                                        <div className="experience-filed">
                                            {watch('certification').map((item, index) => (
                                                <Fragment key={index}>
                                                    <div className="row">
                                                        <div className="col-md-12 col-sm-12">
                                                            <div className="company-name"> Certification & License :
                                                                <span style={{ float: 'right' }}>
                                                                    <AiOutlineCloseSquare size={30} color="#e42323" onClick={() => handleCertificationRemove(index)} />
                                                                </span>
                                                            </div>
                                                            <div className="single-input-field">
                                                                <input type="text" placeholder=" Certification & License"
                                                                    {...register(`certification.${index}.certification`, { required: "Please enter your job title." })}
                                                                />
                                                                {errors.certification?.[index] && (<span className="text-danger">{errors.certification?.[index].certification?.message}</span>)}
                                                            </div>
                                                        </div>
                                                        <div className="col-md-4 col-sm-4">
                                                            <div className="company-name"> Start Date :</div>
                                                            <div className="single-input-field">
                                                                <input type="month" placeholder="Start Date" max={moment().format("YYYY-MM")}
                                                                    {...register(`certification.${index}.start_date`, { required: "Please select start date." })}
                                                                />
                                                                {errors.certification?.[index] && (<span className="text-danger">{errors.certification?.[index].start_date?.message}</span>)}
                                                            </div>
                                                        </div>
                                                        <div className="col-md-4 col-sm-4">
                                                            <div className="company-name"> End Date :</div>
                                                            <div className="single-input-field">
                                                                <input type="month" placeholder="End Date" min={watch(`certification.${index}.start_date`)}
                                                                    {...register(`certification.${index}.end_date`, { required: "Please select end date." })}
                                                                />
                                                                {errors.certification?.[index] && (<span className="text-danger">{errors.certification?.[index].end_date?.message}</span>)}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr />
                                                </Fragment>
                                            ))}
                                            <Link to="#" className="mb-5" onClick={handleCertificationAdd} >Add More Certifications & Licenses</Link>
                                        </div>
                                    </div>
                                    {/* Link */}
                                    <div className="col-md-12 col-sm-12">
                                        <div className="text"> Links : </div>
                                        <div className="experience-filed">
                                            {watch('link').map((item, index) => (
                                                <Fragment key={index}>
                                                    <div className="row">
                                                        <div className="col-md-4 col-sm-4">
                                                            <div className="company-name">
                                                                Link Name :
                                                            </div>
                                                            <div className="single-input-field">
                                                                <input type="text" name="name" placeholder="Link Name"
                                                                    {...register(`link.${index}.name`, { required: "Please enter link name." })} />
                                                                {errors.link?.[index] && (<span className="text-danger">{errors.link?.[index].name?.message}</span>)}
                                                            </div>
                                                        </div>
                                                        <div className="col-md-8 col-sm-8">
                                                            <div className="company-name">
                                                                Link (URL) :
                                                                <span style={{ float: 'right' }}>
                                                                    <AiOutlineCloseSquare size={30} color="#e42323" onClick={() => handleLinkRemove(index)} />
                                                                </span>
                                                            </div>
                                                            <div className="single-input-field">
                                                                <input type="text" name="link" placeholder="Link (URL)"
                                                                    {...register(`link.${index}.link`, {
                                                                        required: "Please enter url.",
                                                                        pattern: {
                                                                            value: /^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i,
                                                                            message: "Please enter valid url",
                                                                        }
                                                                    })} />
                                                                {errors.link?.[index] && (<span className="text-danger">{errors.link?.[index].link?.message}</span>)}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr />
                                                </Fragment>
                                            ))}
                                            <Link to="#" className="mb-5" onClick={handleLinkAdd} >Add More Links</Link>
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
            </section >
        </>
    );
};

export default ResumeForm;
