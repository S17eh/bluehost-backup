import React, { useState } from "react";
import { Link, NavLink } from "react-router-dom";

const Header = () => {
    const [show, setShow] = useState(false);

    const clickHandler = () => {
        // setShow((prev) => !prev);
        setShow(false);
        const a = document.getElementsByClassName("hamburger active");
        // const getLength = document.getElementsByClassName("hamburger active");
        a.length > 0 && a[0].classList.remove("active");
    };

    return (
        <section className="header-section">
            <div id="header" className="fixed-top">
                <nav className="navbar navbar-expand-lg navbar-light bg-light shadow">
                    <div className="container">
                        <Link className="navbar-brand" to="/">
                            <img src="images/Logo.png" />
                        </Link>
                        <button
                            className="navbar-toggler collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#navbar-content"
                            onClick={() => setShow((prev) => !prev)}
                        >
                            <div className="hamburger-toggle">
                                <div className="hamburger">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                        </button>
                        <div
                            // className="collapse navbar-collapse"
                            className={`collapse navbar-collapse ${
                                show ? "show" : ""
                            }`}
                            id="navbar-content"
                        >
                            <ul className="navbar-nav mr-auto mb-2 mb-lg-0 d-flex ms-auto">
                                <li className="nav-item">
                                    <NavLink
                                        className="nav-link"
                                        aria-current="page"
                                        to="/"
                                        onClick={clickHandler}
                                    >
                                        Home
                                    </NavLink>
                                </li>
                                <li className="nav-item">
                                    <NavLink
                                        className="nav-link"
                                        to="/about-us"
                                        onClick={clickHandler}
                                    >
                                        About Us
                                    </NavLink>
                                </li>
                                <li className="nav-item">
                                    <NavLink
                                        className="nav-link"
                                        to="/services"
                                        onClick={clickHandler}
                                    >
                                        Services
                                    </NavLink>
                                </li>
                                <li className="nav-item">
                                    <NavLink
                                        className="nav-link"
                                        to="/apply-for-job"
                                        onClick={clickHandler}
                                    >
                                        Apply for job
                                    </NavLink>
                                </li>
                                <li className="nav-item">
                                    <NavLink
                                        className="nav-link"
                                        to="/resume-builder"
                                        onClick={clickHandler}
                                    >
                                        Resume Builder
                                    </NavLink>
                                </li>
                                <li className="nav-item">
                                    <NavLink
                                        className="nav-link"
                                        to="/current-opening"
                                        onClick={clickHandler}
                                    >
                                        Current Opening
                                    </NavLink>
                                </li>
                                <li className="nav-item">
                                    <NavLink
                                        className="nav-link"
                                        to="/contact-us"
                                        onClick={clickHandler}
                                    >
                                        Contact Us
                                    </NavLink>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </section>
    );
};

export default Header;
