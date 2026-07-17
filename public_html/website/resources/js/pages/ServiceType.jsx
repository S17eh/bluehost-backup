import React, { useState } from "react";

const maxChar = 250;
const ServiceType = ({ type }) => {
    const [showFullText, setShowFullText] = useState(false);

    const stringLength = type.description.length;
    const displayText =
        maxChar > stringLength
            ? type.description
            : type.description.slice(0, maxChar);

    const toggleReadMore = () => {
        setShowFullText(!showFullText);
    };

    return (
        <div className="d-flex flex-wrap align-content-stretch col-xxl-4 col-xl-4 col-lg-4 col-md-6">
            <div className="service-card">
                <h4>{type.title}</h4>
                <p>
                    {showFullText ? type.description : displayText}
                    {stringLength > maxChar ? (
                        showFullText ? (
                            <span
                                onClick={() => toggleReadMore()}
                                style={{
                                    color: "black",
                                    fontSize: "15px",
                                    cursor: "pointer",
                                }}
                            >
                                {" ... Read Less"}
                            </span>
                        ) : (
                            <span
                                onClick={() => toggleReadMore()}
                                style={{
                                    color: "black",
                                    fontSize: "15px",
                                    cursor: "pointer",
                                }}
                            >
                                {" ... Read More"}
                            </span>
                        )
                    ) : (
                        ""
                    )}
                </p>
            </div>
        </div>
    );
};

export default ServiceType;
