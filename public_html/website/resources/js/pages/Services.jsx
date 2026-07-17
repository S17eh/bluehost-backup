import React, { useEffect, useState } from "react";
import Banner from "../components/Banner";
import ApiServices from "../services/Services";
import Skeleton from "react-loading-skeleton";
import "react-loading-skeleton/dist/skeleton.css";
import ServiceType from "./ServiceType";

const Services = () => {
    const [loader, setLoader] = useState(false);
    const [service, setService] = useState({});
    const [serviceType, setServiceType] = useState([]);
    const [recruitment, setRecruitment] = useState([]);
    const [corporateSolution, setCorporateSolution] = useState([]);

    useEffect(() => {
        document.title = "!! Smart Lion - Service !!";
        getServices();
    }, []);

    function getServices() {
        setLoader(true);
        ApiServices.ServicesData().then((res) => {
            setService(res.data.service);
            setServiceType(res.data.serviceType);
            setCorporateSolution(res.data.corporateSolution);
            setRecruitment(res.data.recruitment);
            setLoader(false);
        });
    }

    return (
        <>
            <Banner img="images/apply-for-job-banner.png" pageName="Services" />

            <section className="about-section">
                <div className="smart-container">
                    <div className="row">
                        <div className="inner-column">
                            <div className="sec-title">
                                <span className="title">Services</span>
                                <h2>
                                    {loader ? (
                                        <Skeleton height={50} />
                                    ) : (
                                        service.title
                                    )}
                                </h2>
                            </div>

                            {loader ? (
                                <Skeleton
                                    height={20}
                                    count={10}
                                    style={{ marginBottom: "5px" }}
                                />
                            ) : (
                                <p className="text"> {service.description}</p>
                            )}
                        </div>
                        <div className="content-column col-lg-12 col-md-12 col-sm-12 order-2">
                            <div className="inner-column">
                                <div className="service-type">
                                    <div className="row">
                                        {/* Dynamic */}
                                        {serviceType.map((type, idx) => (
                                            <ServiceType
                                                key={idx}
                                                type={type}
                                            />
                                            // <div
                                            //     key={idx}
                                            //     className="d-flex flex-wrap align-content-stretch col-xxl-4 col-xl-4 col-lg-4 col-md-6"
                                            // >
                                            //     <div className="service-card">
                                            //         <h4>{type.title}</h4>
                                            //         <p>{type.description}</p>
                                            //     </div>
                                            // </div>
                                        ))}

                                        {/* Static */}
                                        {/* <div className="d-flex flex-wrap align-content-stretch col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                                            <div className="service-card">
                                                <h4>Bulk Hiring</h4>
                                                <p>
                                                    Lorem ipsum dolor sit amet,
                                                    consectetur adipisicing
                                                    elit. Recusandae nostrum
                                                    doloremque qui perferendis
                                                    quidem expedita, dolore
                                                    deleniti quae odit minima
                                                    nulla, totam officiis
                                                    reprehenderit. Voluptate
                                                    laborum totam eveniet dolore
                                                    ab!
                                                </p>
                                            </div>
                                        </div>
                                        <div className="d-flex flex-wrap align-content-stretch col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                                            <div className="service-card">
                                                <h4>Profile Search</h4>
                                                <p>
                                                    Lorem ipsum dolor sit amet,
                                                    consectetur adipisicing
                                                    elit. Recusandae nostrum
                                                    doloremque qui perferendis
                                                    quidem expedita, dolore
                                                    deleniti quae odit minima
                                                    nulla, totam officiis
                                                    reprehenderit. Voluptate
                                                    laborum totam eveniet dolore
                                                    ab!
                                                </p>
                                            </div>
                                        </div>
                                        <div className="d-flex flex-wrap align-content-stretch col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                                            <div className="service-card">
                                                <h4>Premium Profile Search</h4>
                                                <p>
                                                    Lorem ipsum dolor sit amet,
                                                    consectetur adipisicing
                                                    elit. Recusandae nostrum
                                                    doloremque qui perferendis
                                                    quidem expedita, dolore
                                                    deleniti quae odit minima
                                                    nulla, totam officiis
                                                    reprehenderit. Voluptate
                                                    laborum totam eveniet dolore
                                                    ab!
                                                </p>
                                            </div>
                                        </div>
                                        <div className="d-flex flex-wrap align-content-stretch col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                                            <div className="service-card">
                                                <h4>Temp Staffing</h4>
                                                <p>
                                                    Lorem ipsum dolor sit amet,
                                                    consectetur adipisicing
                                                    elit. Recusandae nostrum
                                                    doloremque qui perferendis
                                                    quidem expedita, dolore
                                                    deleniti quae odit minima
                                                    nulla, totam officiis
                                                    reprehenderit. Voluptate
                                                    laborum totam eveniet dolore
                                                    ab!
                                                </p>
                                            </div>
                                        </div>
                                        <div className="d-flex flex-wrap align-content-stretch col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                                            <div className="service-card">
                                                <h4>Permanent Staffing</h4>
                                                <p>
                                                    Lorem ipsum dolor sit amet,
                                                    consectetur adipisicing
                                                    elit. Recusandae nostrum
                                                    doloremque qui perferendis
                                                    quidem expedita, dolore
                                                    deleniti quae odit minima
                                                    nulla, totam officiis
                                                    reprehenderit. Voluptate
                                                    laborum totam eveniet dolore
                                                    ab!
                                                </p>
                                            </div>
                                        </div>
                                        <div className="d-flex flex-wrap align-content-stretch col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                                            <div className="service-card">
                                                <h4>Payroll</h4>
                                                <p>
                                                    Lorem ipsum dolor sit amet,
                                                    consectetur adipisicing
                                                    elit. Recusandae nostrum
                                                    doloremque qui perferendis
                                                    quidem expedita, dolore
                                                    deleniti quae odit minima
                                                    nulla, totam officiis
                                                    reprehenderit. Voluptate
                                                    laborum totam eveniet dolore
                                                    ab!
                                                </p>
                                            </div>
                                        </div> */}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section className="catering-services catering-view1-full">
                <span className="light-transparent"></span>
                <div className="container">
                    <div className="row">
                        <div className="content-column col-lg-6 col-md-12 col-sm-12">
                            <div className="inner-column">
                                <div className="sec-title">
                                    <h2>Complete Corporate Solution</h2>
                                </div>
                                <ul>
                                    {corporateSolution.map((solution, idx) => (
                                        <li key={idx}>
                                            <h3>{solution.title}</h3>
                                            <p>{solution.description}</p>
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        </div>

                        <div className="image-column col-lg-6 col-md-12 col-sm-12">
                            <div className="inner-column wow fadeInLeft">
                                <a
                                    href="#"
                                    className="image-1"
                                    data-fancybox="images"
                                >
                                    {loader ? (
                                        <Skeleton height={550} width={550} />
                                    ) : (
                                        <img
                                            title=""
                                            src={service.image}
                                            alt=""
                                        />
                                    )}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section className="process-section">
                <div className="smart-container">
                    <div className="row">
                        <div className="col-md-12">
                            <div className="sec-title align-center">
                                <span className="title">Process</span>
                                <h2>Recruitment Process We Follows</h2>
                            </div>

                            {loader ? (
                                <div className="row">
                                    <div className="col-sm-6 col-md-6 col-xl-3">
                                        <Skeleton
                                            className="categories-view1-wrap"
                                            height={150}
                                            width={400}
                                            style={{ marginTop: "15px" }}
                                        />
                                    </div>
                                    <div className="col-sm-6 col-md-6 col-xl-3">
                                        <Skeleton
                                            className="categories-view1-wrap"
                                            height={150}
                                            width={400}
                                            style={{ marginTop: "15px" }}
                                        />
                                    </div>
                                    <div className="col-sm-6 col-md-6 col-xl-3">
                                        <Skeleton
                                            className="categories-view1-wrap"
                                            height={150}
                                            width={400}
                                            style={{ marginTop: "15px" }}
                                        />
                                    </div>
                                    <div className="col-sm-6 col-md-6 col-xl-3">
                                        <Skeleton
                                            className="categories-view1-wrap"
                                            height={150}
                                            width={400}
                                            style={{ marginTop: "15px" }}
                                        />
                                    </div>
                                </div>
                            ) : (
                                <div className="categories categories-view1">
                                    <ul className="row">
                                        {recruitment.map((item, index) => (
                                            <li
                                                className="col-sm-6 col-md-6 col-xl-3 d-flex align-content-stretch"
                                                key={item.id}
                                            >
                                                <div className="categories-view1-wrap">
                                                    <small>
                                                        {item.description}
                                                    </small>
                                                    <span>{index + 1}</span>
                                                </div>
                                            </li>
                                        ))}
                                    </ul>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
};

export default Services;
