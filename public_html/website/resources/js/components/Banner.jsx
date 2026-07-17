import React from "react";
import { Link } from "react-router-dom";

const Banner = (props) => {
    return (
        <section className="inner-banner-section">
            <div className="top-inner-section">
                <div className="top-inner-img-sec">
                    <img
                        src={props.img}
                        alt=""
                        className="img-fluid"
                    />
                </div>
                <div className="inner-header-content-sec">
                    <div className="container">
                        <h2>{props.pageName}</h2>
                        <p>
                            <Link to="/">Home</Link> / <Link to="#">{props.pageName}</Link>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    );
};

export default Banner;
