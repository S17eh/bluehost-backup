import React from "react";
import Banner from "../../components/Banner";

import { Link } from "react-router-dom";

const ResumeBuilder = () => {
    document.title = "!! Smart Lion - Resume Builder !!"
    return (
        <>
            <Banner
                img="images/current-opening-banner.png"
                pageName="Resume Builder"
            />
            <section className="resume-builder-section">
                <div className="container">
                    <div className="tab-teaser">
                        <div className="tab-main-box">
                            <div className="resume-details-heading">
                                <h3>Choose your resume template</h3>
                                <p>
                                    Let the right Employers reach you - Please
                                    select the template below and download your
                                    Resume.
                                </p>
                            </div>
                            <div className="resume-template-section">
                                <div className="row">
                                    <div className="col-lg-4">
                                        <div className="bg-m">
                                            <div className="resum-box-bg">
                                                <div className="resume-inner-bg">
                                                    <img
                                                        src="images/resume-1.png"
                                                        alt=""
                                                    />
                                                </div>
                                            </div>
                                            <div className="resume-bottom-select-btn">
                                                <div className="resume-left-title">
                                                    Resume 1
                                                </div>
                                                <div className="resume-right-btn">
                                                    <Link
                                                        to="/resume-form"
                                                        state="1"
                                                    >
                                                        Select
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-lg-4">
                                        <div className="bg-m">
                                            <div className="resum-box-bg">
                                                <div className="resume-inner-bg">
                                                    <img
                                                        src="images/resume-2.png"
                                                        alt=""
                                                    />
                                                </div>
                                            </div>
                                            <div className="resume-bottom-select-btn">
                                                <div className="resume-left-title">
                                                    Resume 2
                                                </div>
                                                <div className="resume-right-btn">
                                                    <Link
                                                        to="/resume-form"
                                                        state="2"
                                                    >
                                                        Select
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-lg-4">
                                        <div className="bg-m">
                                            <div className="resum-box-bg">
                                                <div className="resume-inner-bg">
                                                    <img
                                                        src="images/resume-3.png"
                                                        alt=""
                                                    />
                                                </div>
                                            </div>
                                            <div className="resume-bottom-select-btn">
                                                <div className="resume-left-title">
                                                    Resume 3
                                                </div>
                                                <div className="resume-right-btn">
                                                    <Link
                                                        to="/resume-form"
                                                        state="3"
                                                    >
                                                        Select
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-lg-4">
                                        <div className="bg-m">
                                            <div className="resum-box-bg">
                                                <div className="resume-inner-bg">
                                                    <img
                                                        src="images/resume-4.png"
                                                        alt=""
                                                    />
                                                </div>
                                            </div>
                                            <div className="resume-bottom-select-btn">
                                                <div className="resume-left-title">
                                                    Resume 4
                                                </div>
                                                <div className="resume-right-btn">
                                                    <Link
                                                        to="/resume-form"
                                                        state="4"
                                                    >
                                                        Select
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-lg-4">
                                        <div className="bg-m">
                                            <div className="resum-box-bg">
                                                <div className="resume-inner-bg">
                                                    <img
                                                        src="images/resume-5.png"
                                                        alt=""
                                                    />
                                                </div>
                                            </div>
                                            <div className="resume-bottom-select-btn">
                                                <div className="resume-left-title">
                                                    Resume 5
                                                </div>
                                                <div className="resume-right-btn">
                                                    <Link
                                                        to="/resume-form"
                                                        state="5"
                                                    >
                                                        Select
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-lg-4">
                                        <div className="bg-m">
                                            <div className="resum-box-bg">
                                                <div className="resume-inner-bg">
                                                    <img
                                                        src="images/resume-6.png"
                                                        alt=""
                                                    />
                                                </div>
                                            </div>
                                            <div className="resume-bottom-select-btn">
                                                <div className="resume-left-title">
                                                    Resume 6
                                                </div>
                                                <div className="resume-right-btn">
                                                    <Link
                                                        to="/resume-form"
                                                        state="6"
                                                    >
                                                        Select
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-lg-4">
                                        <div className="bg-m">
                                            <div className="resum-box-bg">
                                                <div className="resume-inner-bg">
                                                    <img
                                                        src="images/resume-7.png"
                                                        alt=""
                                                    />
                                                </div>
                                            </div>
                                            <div className="resume-bottom-select-btn">
                                                <div className="resume-left-title">
                                                    Resume 7
                                                </div>
                                                <div className="resume-right-btn">
                                                    <Link
                                                        to="/resume-form"
                                                        state="7"
                                                    >
                                                        Select
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-lg-4">
                                        <div className="bg-m">
                                            <div className="resum-box-bg">
                                                <div className="resume-inner-bg">
                                                    <img
                                                        src="images/resume-8.png"
                                                        alt=""
                                                    />
                                                </div>
                                            </div>
                                            <div className="resume-bottom-select-btn">
                                                <div className="resume-left-title">
                                                    Resume 8
                                                </div>
                                                <div className="resume-right-btn">
                                                    <Link
                                                        to="/resume-form"
                                                        state="8"
                                                    >
                                                        Select
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-lg-4">
                                        <div className="bg-m">
                                            <div className="resum-box-bg">
                                                <div className="resume-inner-bg">
                                                    <img
                                                        src="images/resume-9.png"
                                                        alt=""
                                                    />
                                                </div>
                                            </div>
                                            <div className="resume-bottom-select-btn">
                                                <div className="resume-left-title">
                                                    Resume 9
                                                </div>
                                                <div className="resume-right-btn">
                                                    <Link
                                                        to="/resume-form"
                                                        state="9"
                                                    >
                                                        Select
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
};

export default ResumeBuilder;
