import React, { useState, useEffect } from "react";

import Skeleton from "react-loading-skeleton";
import "react-loading-skeleton/dist/skeleton.css";
import OwlCarousel from "react-owl-carousel";
import "owl.carousel/dist/assets/owl.carousel.css";
import "owl.carousel/dist/assets/owl.theme.default.css";
import Services from "../services/Services";
import HomeTestimonial from "./HomeTestimonial";
import { NavLink } from "react-router-dom";

const Home = () => {
    const [home, setHome] = useState({});
    const [testimonial, setTestimonial] = useState([]);
    useEffect(() => {
        document.title = "!! Smart Lion - Home !!";
        getHome();
    }, []);

    function getHome() {
        Services.HomeData().then((res) => {
            setHome(res.data.home);
            setTestimonial(res.data.testimonial);
        });
    }

    return (
        <>
            <section className="banner-section">
                <div
                    id="carouselExample"
                    className="carousel slide w-100"
                    data-bs-ride="carousel"
                    data-bs-interval="3000"
                >
                    <div className="carousel-inner">
                        <div className="carousel-item active">
                            <div className="cover">
                                <img
                                    className="d-block w-100"
                                    src="images/slider-1.png"
                                    alt="First slide"
                                />
                            </div>
                            <div className="carousel-caption d-md-block">
                                <h2>We Are Hiring!</h2>
                                <p>
                                    Lorem Ipsum is simply dummy text of the
                                    printing and typesetting industry. Lorem
                                    Ipsum has been the industry's standard dummy
                                    text ever since the 1500s, when an unknown
                                    printer took a galley of type and scrambled
                                    it to make a type specimen book.
                                </p>
                                <NavLink
                                    className="big-button"
                                    to="/current-opening"
                                    title=""
                                >
                                    Learn More
                                </NavLink>
                            </div>
                        </div>
                        <div className="carousel-item">
                            <div className="cover">
                                <img
                                    className="d-block w-100"
                                    src="images/slider-2.png"
                                    alt="Second slide"
                                />
                            </div>
                            <div className="carousel-caption d-md-block">
                                <h2>We Are Hiring!</h2>
                                <p>
                                    Lorem Ipsum is simply dummy text of the
                                    printing and typesetting industry. Lorem
                                    Ipsum has been the industry's standard dummy
                                    text ever since the 1500s, when an unknown
                                    printer took a galley of type and scrambled
                                    it to make a type specimen book.
                                </p>
                                <NavLink
                                    className="big-button"
                                    to="/current-opening"
                                    title=""
                                >
                                    Learn More
                                </NavLink>
                            </div>
                        </div>
                        <div className="carousel-item">
                            <div className="cover">
                                <img
                                    className="d-block w-100"
                                    src="images/slider-3.png"
                                    alt="Second slide"
                                />
                            </div>
                            <div className="carousel-caption d-md-block">
                                <h2>We Are Hiring!</h2>
                                <p>
                                    Lorem Ipsum is simply dummy text of the
                                    printing and typesetting industry. Lorem
                                    Ipsum has been the industry's standard dummy
                                    text ever since the 1500s, when an unknown
                                    printer took a galley of type and scrambled
                                    it to make a type specimen book.
                                </p>
                                <NavLink
                                    className="big-button"
                                    to="/current-opening"
                                    title=""
                                >
                                    Learn More
                                </NavLink>
                            </div>
                        </div>
                    </div>
                    <button
                        className="carousel-control-prev"
                        data-bs-target="#carouselExample"
                        type="button"
                        data-bs-slide="prev"
                    >
                        <span
                            className="carousel-control-prev-icon"
                            aria-hidden="true"
                        ></span>
                        <span className="visually-hidden">Previous</span>
                    </button>
                    <button
                        className="carousel-control-next"
                        data-bs-target="#carouselExample"
                        type="button"
                        data-bs-slide="next"
                    >
                        <span
                            className="carousel-control-next-icon"
                            aria-hidden="true"
                        ></span>
                        <span className="visually-hidden">Next</span>
                    </button>
                </div>
            </section>

            <section className="home-about-section">
                <div className="container">
                    <div className="row">
                        <div className="content-column col-lg-6 col-md-12 col-sm-12 order-2">
                            <div className="inner-column">
                                <div className="sec-title">
                                    <span className="title">About Us</span>
                                    <h2>
                                        {Object.keys(home).length == 0 ? (
                                            <Skeleton height={50} />
                                        ) : (
                                            home.title
                                        )}
                                    </h2>
                                </div>
                                {Object.keys(home).length == 0 ? (
                                    <Skeleton
                                        height={15}
                                        count={10}
                                        style={{ marginBottom: "10px" }}
                                    />
                                ) : (
                                    <div className="text">
                                        {home.description}
                                    </div>
                                )}
                            </div>
                        </div>

                        <div className="image-column col-lg-6 col-md-12 col-sm-12">
                            <div className="inner-column wow fadeInLeft">
                                <a
                                    href="#"
                                    className="image-1"
                                    data-fancybox="images"
                                >
                                    {Object.keys(home).length == 0 ? (
                                        <Skeleton
                                            height={750}
                                            width={580}
                                            style={{ marginBottom: "10px" }}
                                        />
                                    ) : (
                                        <img title="" src={home.image} alt="" />
                                    )}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section className="testimonial-section">
                <div className="testimonial-img-sec">
                    <img src="images/testimonials.png" />
                </div>
                <div className="testimonial-content-sec">
                    <div className="smart-container">
                        <div className="row">
                            <div className="sec-title">
                                <span className="title">Testimonial</span>
                                <h2>What Client’s Say About of Us</h2>
                            </div>

                            {testimonial.length === 0 ? (
                                <OwlCarousel
                                    className="slides owl-carousel"
                                    loop
                                    margin={5}
                                    nav
                                >
                                    <>
                                        <Skeleton height={300} />
                                        <Skeleton height={300} />
                                        <Skeleton height={300} />
                                    </>
                                </OwlCarousel>
                            ) : (
                                <HomeTestimonial testimonials={testimonial} />
                            )}
                        </div>
                    </div>
                </div>
            </section>

            {/* <section className="award-section">
                <div className="smart-container">
                    <div className="row">
                        <div className="sec-title align-center">
                            <span className="title">Award</span>
                            <h2>Rewards & Achievements</h2>
                        </div>

                        <div className="col-xl-6 col-lg-6">
                            <div className="gray-bg">
                                <div className="circal">
                                    <img src="images/certificate1.png" alt="" />
                                </div>
                                Certificate of Excellence From Our Client
                            </div>
                            <div className="gray-bg1">
                                Certificate of Appreciation from collage for
                                providing placements to fresher students{" "}
                                <div className="circal1">
                                    <img src="images/certificate1.png" alt="" />
                                </div>
                            </div>
                        </div>
                        <div className="col-xl-6 col-lg-6">
                            <img src="images/award.png" alt="" />
                        </div>
                    </div>
                </div>
            </section> */}
        </>
    );
};

export default Home;
