import React from "react";
import FaceBookSVG from "../../images/svg/facebook.svg";
import BloggerSVG from "../../images/svg/Blogger-Icon.svg";
import LinkedInSVG from "../../images/svg/linkedin.svg";
import PhoneSVG from "../../images/svg/call.svg";
import EmailSVG from "../../images/svg/email.svg";
import MapSVG from "../../images/svg/map.svg";
import { Link } from "react-router-dom";

const Footer = () => {
    return (
        <footer className="footer-section">
            <div className="container">
                <div className="footer-content">
                    <div className="row">
                        <div className="col-xl-4 col-lg-4 mb-50">
                            <div className="footer-widget">
                                <div className="footer-logo">
                                    <Link to="/">
                                        <img
                                            src="images/Logo-f.png"
                                            alt="logo"
                                        />
                                    </Link>
                                </div>
                                <div className="footer-text">
                                    <p>
                                        Lorem ipsum dolor sit amet, consec tetur
                                        adipisicing elit, sed do eiusmod tempor
                                        incididuntut consec tetur adipisicing
                                        elit, Lorem ipsum dolor sit amet.
                                    </p>
                                </div>
                                <div className="footer-social-icon">
                                    <a href="#">
                                        <img src={FaceBookSVG} alt="" />
                                    </a>
                                    <a href="#">
                                        <img src={BloggerSVG} alt="" />
                                    </a>
                                    <a href="#">
                                        <img src={LinkedInSVG} alt="" />
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div className="col-xl-4 col-lg-4 col-md-6 mb-30">
                            <div className="footer-widget">
                                <div className="footer-widget-heading">
                                    <h3>Company</h3>
                                </div>
                                <ul>
                                    <li>
                                        <Link to="/about-us">About Us</Link>
                                    </li>
                                    <li>
                                        <Link to="/services">services</Link>
                                    </li>
                                    <li>
                                        <Link to="/apply-for-job">Apply for job</Link>
                                    </li>
                                    <li>
                                        <Link to="/resume-builder">Resume Builder</Link>
                                    </li>
                                    <li>
                                        <Link to="/current-opening">Current Opening</Link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div className="col-xl-4 col-lg-4 col-md-6 mb-50">
                            <div className="footer-widget">
                                <div className="footer-widget-heading">
                                    <h3>Contact Us</h3>
                                </div>
                                <div className="bottom-info-sec">
                                    <ul>
                                        <li className="d-flex">
                                            <div className="information">
                                                <span>
                                                    <img src={MapSVG} alt="" />
                                                </span>
                                            </div>
                                            <div className="office">
                                                420, 4th Floor, Iscon Emporio,
                                                Nr Star Bazar, Jodhpur Cross
                                                Road, Satellite, Ahmedabad -
                                                380015.
                                            </div>
                                        </li>
                                        <li className="d-flex">
                                            <div className="information">
                                                <span>
                                                    <img
                                                        src={EmailSVG}
                                                        alt=""
                                                    />
                                                </span>
                                            </div>
                                            <div className="office">
                                                <a href="mailto:info@smartlion.co.in">
                                                    info@smartlion.co.in
                                                </a>
                                            </div>
                                        </li>
                                        <li className="d-flex">
                                            <div className="information">
                                                <span>
                                                    <img
                                                        src={PhoneSVG}
                                                        alt=""
                                                    />
                                                </span>
                                            </div>
                                            <div className="office">
                                                <a href="tel:+917778884892">
                                                     +91 777888 4892
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div className="copyright-area">
                <div className="container">
                    <div className="row footer-border">
                        <div className="col-xl-6 col-lg-6 text-lg-left">
                            <div className="copyright-text">
                                <p>&copy; 2022 Copyrights by SmartLion</p>
                            </div>
                        </div>
                        <div className="col-xl-6 col-lg-6 d-none d-lg-block text-right">
                            <div className="copyright-text">
                                <p>All rights reserved</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    );
};

export default Footer;
