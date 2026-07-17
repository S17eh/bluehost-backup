import React, { useEffect, useState } from "react";
import GoogleSVG from "../../images/svg/Google-logo.svg";
import { FaStar } from "react-icons/fa";
import Banner from "../components/Banner";
import Services from "../services/Services";
import Skeleton from "react-loading-skeleton";
import "react-loading-skeleton/dist/skeleton.css";

const AboutUs = () => {
    const [aboutUs, setAboutUs] = useState({});
    const [aboutService, setAboutService] = useState([]);
    const [teams, setTeams] = useState([]);
    useEffect(() => {
        document.title = "!! Smart Lion - About Us !!"
        getAboutUs();
    }, []);

    function getAboutUs() {
        Services.AboutUsData().then((res) => {
            setAboutUs(res.data.aboutUs);
            setAboutService(res.data.aboutService);
            setTeams(res.data.teams);
        });
    }

    return (
        <>
            <Banner img="images/about-banner.png" pageName="About Us"></Banner>

            <section className="about-section">
                <div className="smart-container">
                    <div className="row">
                        <div className="content-column col-lg-6 col-md-12 col-sm-12 order-2">
                            <div className="inner-column">
                                <div className="sec-title">
                                    <span className="title">About Us</span>
                                </div>
                                {Object.keys(aboutUs).length == 0 ? (
                                    <Skeleton
                                        height={15}
                                        count={10}
                                        style={{ marginBottom: "10px" }}
                                    />
                                ) : (
                                    <div className="text">
                                        {aboutUs.description}
                                    </div>
                                )}

                                <div className="google-box">
                                    <div className="google-text">
                                        REVIEW ON{" "}
                                        <div className="star">
                                            <FaStar className="star-icon-1" />
                                            <FaStar className="star-icon-1" />
                                            <FaStar className="star-icon-1" />
                                            <FaStar className="star-icon-1" />
                                            <FaStar className="star-icon-1" />
                                        </div>
                                        <span>4.6</span>
                                    </div>
                                    <div className="google-logo">
                                        <img src={GoogleSVG} alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div className="image-column col-lg-6 col-md-12 col-sm-12">
                            <div className="inner-column wow fadeInLeft">
                                <div className="image-1" data-fancybox="images">
                                    {Object.keys(aboutUs).length == 0 ? (
                                        <Skeleton
                                            height={750}
                                            width={700}
                                            style={{ marginBottom: "10px" }}
                                        />
                                    ) : (
                                        <img
                                            title=""
                                            src={aboutUs.image}
                                            alt=""
                                        />
                                    )}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section className="team" id="team">
                <div className="container text-center">
                    <div className="sec-title align-center">
                        <span className="title">Our Team</span>
                        <h2>Our Leadership Team</h2>
                    </div>
                    <div className="row justify-content-center">
                        {teams.length === 0 ? (
                            <>
                                <div className="col-lg-3 col-md-6 mb-3">
                                    <Skeleton
                                        height={300}
                                        style={{ marginBottom: "15px" }}
                                    />
                                </div>
                                <div className="col-lg-3 col-md-6 mb-3">
                                    <Skeleton
                                        height={300}
                                        style={{ marginBottom: "15px" }}
                                    />
                                </div>
                                <div className="col-lg-3 col-md-6 mb-3">
                                    <Skeleton
                                        height={300}
                                        style={{ marginBottom: "15px" }}
                                    />
                                </div>
                                <div className="col-lg-3 col-md-6 mb-3">
                                    <Skeleton
                                        height={300}
                                        style={{ marginBottom: "15px" }}
                                    />
                                </div>
                            </>
                        ) : (
                            teams.map((item) => (
                                <div
                                    className="col-md-4 mb-4"
                                    key={item.id}
                                >
                                    <div className="box">
                                        <div className="image">
                                            <img
                                                src={item.image}
                                                alt="team"
                                            />
                                        </div>
                                        <h3>{item.name}</h3>
                                        <h4>{item.position}</h4>
                                    </div>
                                </div>
                            ))
                        )}
                    </div>
                </div>
            </section>

            <section className="what-we-section">
                <div className="smart-container">
                    <div className="row">
                        <h2>What We Can Do...</h2>
                        <div className="listing align-self-center">
                            <ul>
                                {aboutService.length == 0 ? (
                                    <Skeleton
                                        height={25}
                                        count={5}
                                        style={{ marginBottom: "10px" }}
                                    />
                                ) : (
                                    aboutService.map((service) => (
                                        <li key={service.id}>
                                            {service.service}
                                        </li>
                                    ))
                                )}
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
};

export default AboutUs;
