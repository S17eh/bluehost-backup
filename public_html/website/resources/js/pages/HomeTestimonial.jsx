import React from "react";
import { FaStar, FaStarHalfAlt } from "react-icons/fa";
import QuoteSVG from "../../images/svg/quote.svg";
import OwlCarousel from "react-owl-carousel";
import "owl.carousel/dist/assets/owl.carousel.css";
import "owl.carousel/dist/assets/owl.theme.default.css";

const options = {
    margin:16,
    responsiveClass:true,
    responsive: {
        0: {
            items: 1,
        },
        400: {
            items: 1,
        },
        680: {
            items: 2,
        },
        1024: {
            items: 3,
        }
    },
};

const HomeTestimonial = (props) => {
    return (
        <OwlCarousel className="slides owl-carousel" loop margin={5} nav {...options}>
            {props.testimonials.map((testimonial) => (
                <div className="testimonial" key={testimonial.id}>
                    <div className="test-info">
                        <img
                            className="test-pic"
                            src={testimonial.image}
                            alt=""
                        />
                        <div className="test-name">
                            <span>{testimonial.name}</span>
                            {testimonial.position}
                        </div>
                        <div className="quote flex-fill">
                            <img
                                src={QuoteSVG}
                                alt=""
                                width="77.823"
                                height="42.923"
                            />
                        </div>
                    </div>

                    <p>{testimonial.comment}</p>
                    <div className="star">
                        <FaStar className="star-icon-1" />
                        <FaStar className="star-icon-1" />
                        <FaStar className="star-icon-1" />
                        <FaStar className="star-icon-1" />
                        <FaStarHalfAlt className="star-icon-1" />
                    </div>
                </div>
            ))}
        </OwlCarousel>
    );
};

export default HomeTestimonial;
