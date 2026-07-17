import React, { useEffect, useState } from "react";
import Banner from "../components/Banner";
import Services from "../services/Services";
import Skeleton from "react-loading-skeleton";
import "react-loading-skeleton/dist/skeleton.css";
import { NavLink } from "react-router-dom";
import parse from 'html-react-parser';

const CurrentOpening = () => {
    const [loader, setLoader] = useState(false);
    const [openingList, setOpeningList] = useState([]);

    useEffect(() => {
        document.title = "!! Smart Lion - Current Opening !!";
        getCurrentOpeningList();
    }, []);

    function getCurrentOpeningList(event) {
        setLoader(true);
        Services.CurrentOpeningList().then((res) => {
            setLoader(false);
            setOpeningList(res.data);
        });
    }

    function accordionToggle(event) {
        event.preventDefault();
        if (event.target.classList.contains("active")) {
            event.target.classList.remove("active");
            event.target.nextElementSibling.style.display = "none";
        } else {
            var boxes = document.querySelectorAll(".accordion__title.active");
            boxes.forEach((box) => {
                box.classList.remove("active");
                box.nextElementSibling.style.display = "none";
            });
            event.target.classList.add("active");
            event.target.nextElementSibling.style.display = "block";
        }
    }

    return (
        <>
            <Banner
                img="images/current-opening-banner.png"
                pageName="Current Opening"
            />
            <section className="contact-page-sec">
                <div className="container">
                    <div className="row">
                        {openingList.length === 0 ? (
                            <>
                                <Skeleton
                                    height={60}
                                    count={5}
                                    style={{ marginBottom: "15px" }}
                                />
                            </>
                        ) : (
                            <>
                                <div className="accordion">
                                    {openingList.map((item) => (
                                        <div
                                            className="accordion__item"
                                            onClick={accordionToggle}
                                            key={item.id}
                                        >
                                            <h2 className="accordion__title ">
                                                {item.title}
                                            </h2>
                                            <div className="accordion__body">
                                                <p>{parse(item.description)}</p>
                                                <span className="justify-content-right">
                                                    <NavLink
                                                        className="big-button"
                                                        to="/apply-for-job"
                                                        title=""
                                                    >
                                                        Apply for job
                                                    </NavLink>
                                                </span>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </>
                        )}
                    </div>
                </div>
            </section>
        </>
    );
};

export default CurrentOpening;
