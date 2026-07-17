import React, { useState } from "react";
import PhoneSVG from "../../images/svg/call.svg";
import EmailSVG from "../../images/svg/email.svg";
import MapSVG from "../../images/svg/map.svg";
import Banner from "../components/Banner";
import Services from "../services/Services";
import { useForm } from "react-hook-form";

const ContactUs = () => {
    document.title = "!! Smart Lion - Contact Us !!"
    const [loader, setLoader] = useState(false);
    const {
        register,
        handleSubmit,
        formState: { errors },
        reset,
    } = useForm();

   
    function submitForm(data,e) {
        setLoader(true);
        Services.ContactUsEmail(data).then((res) => {
            setLoader(false);
            reset();
        });
    }

    return (
        <>
            <Banner img="images/contact-banner.png" pageName="Contact Us" />

            <section className="contact-page-sec">
                <div className="smart-container">
                    <div className="row">
                        <div className="col-lg-4">
                            <div className="contact-info">
                                <div className="contact-info-item">
                                    <div className="contact-info-icon">
                                        <img src={PhoneSVG} alt="" />
                                    </div>
                                    <div className="contact-info-text">
                                        <h2>Phone Number</h2>
                                        <span>+91 777 888 4891</span>
                                        <span>+91 777 888 4892</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="col-lg-4">
                            <div className="contact-info">
                                <div className="contact-info-item">
                                    <div className="contact-info-icon">
                                        <img src={EmailSVG} alt="" />
                                    </div>
                                    <div className="contact-info-text">
                                        <h2>E-mail</h2>
                                        <span>info@smartlion.co.in</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="col-lg-4">
                            <div className="contact-info">
                                <div className="contact-info-item">
                                    <div className="contact-info-icon">
                                        <img src={MapSVG} alt="" />
                                    </div>
                                    <div className="contact-info-text">
                                        <h2>Corporate Office</h2>
                                        <span>
                                            420, 4th Floor, Iscon Emporio, Nr
                                            Star Bazar, Jodhpur Cross Roads,
                                            Satalite, Ahmedabad - 15
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="row">
                        <div className="col-md-6">
                            <div className="contact-page-map">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d13863.027668940904!2d72.52101204998017!3d23.029588483009547!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e2!4m0!4m5!1s0x395e84f35c6dd0dd%3A0xfded088b19c5ebff!2sSmart%20Lion%20Private%20Limited%2C%20Iscon%20Emporio%2C%20420%2C%204th%2C%20Jodhpur%20Cross%20Rd%2C%20nr.%20Star%20Bazar%2C%20Satellite%2C%20Ahmedabad%2C%20Gujarat%20380015!3m2!1d23.0270585!2d72.5246422!5e0!3m2!1sen!2sin!4v1648201948943!5m2!1sen!2sin"
                                    width="100%"
                                    height="640"
                                    style={{ border: "0" }}
                                    allowFullScreen=""
                                    loading="lazy"
                                    referrerPolicy="no-referrer-when-downgrade"
                                ></iframe>
                            </div>
                        </div>
                        <div className="col-md-6">
                            <div className="contact-page-form">
                                <h2>Contact With Us!</h2>
                                <form
                                    id="contactForm"
                                    onSubmit={handleSubmit(submitForm)}
                                    method="POST"
                                >
                                    <div className="row">
                                        <div className="col-md-12 col-sm-12 col-xs-12">
                                            <div className="text">
                                                Name<span>*</span> :
                                            </div>
                                            <div className="single-input-field">
                                                <input
                                                    type="text"
                                                    placeholder="Your Name"
                                                    name="name"
                                                    {...register("name", {
                                                        required:
                                                            "Please enter your name.",
                                                    })}
                                                />
                                                <span className="text-danger">
                                                    {errors.name?.message}
                                                </span>
                                            </div>
                                        </div>
                                        <div className="col-md-12 col-sm-12 col-xs-12">
                                            <div className="text">
                                                Mobile Number :
                                            </div>
                                            <div className="single-input-field">
                                                <input
                                                    type="text"
                                                    placeholder="Mobile Number"
                                                    name="mobile_number"
                                                    {...register(
                                                        "mobile_number",
                                                        {
                                                            required:
                                                                "Please enter your mobile number.",
                                                            maxLength: {
                                                                value: 10,
                                                                message:
                                                                    "Max length is 10",
                                                            },
                                                            pattern: {
                                                                value: /^[0-9.]+$/,
                                                                message:
                                                                    "Please enter a number",
                                                            },
                                                        }
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
                                        <div className="col-md-12 col-sm-12 col-xs-12">
                                            <div className="text">
                                                Email<span>*</span> :
                                            </div>
                                            <div className="single-input-field">
                                                <input
                                                    type="email"
                                                    placeholder="Email"
                                                    name="email"
                                                    {...register("email", {
                                                        required:
                                                            "Please enter your email address.",
                                                        pattern: {
                                                            value: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i,
                                                            message:
                                                                "invalid email address",
                                                        },
                                                    })}
                                                />
                                                <span className="text-danger">
                                                    {errors.email?.message}
                                                </span>
                                            </div>
                                        </div>
                                        <div className="col-md-12">
                                            <div className="text">
                                                Message<span>*</span> :
                                            </div>
                                            <div className="single-input-field">
                                                <textarea
                                                    placeholder="Write Your Message"
                                                    name="message"
                                                    {...register("message", {
                                                        required:
                                                            "Please enter your message.",
                                                    })}
                                                ></textarea>
                                                <span className="text-danger">
                                                    {errors.message?.message}
                                                </span>
                                            </div>
                                        </div>
                                        <div className="single-input-fieldsbtn btn-top-mar">
                                            <input
                                                type="submit"
                                                disabled={loader && "disabled"}
                                                value={
                                                    loader
                                                        ? "Sending..."
                                                        : "Send Now"
                                                }
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

export default ContactUs;
