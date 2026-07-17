import React, { useEffect } from "react";
import ReactDOM from "react-dom";
import ReactRouter from "../routes/ReactRouter";

function Index() {

    const setMyLocation = () => {
        navigator.geolocation.getCurrentPosition(function (position) {
            localStorage.setItem("locationDetails", JSON.stringify({ Latitude: position.coords.latitude, Longitude: position.coords.longitude }));
        });
    }

    useEffect(() => {
        if (navigator.geolocation) {
            navigator.permissions
                .query({ name: "geolocation" })
                .then(function (result) {

                    if (result.state === "granted") {
                        setMyLocation();
                    } else if (result.state === "prompt" || result.state === "denied") {
                        setMyLocation();
                    }
                });
        } else {
            alert("Sorry Not available!");

        }
    }, [])



    return <ReactRouter />;
}

export default Index;

if (document.getElementById("root")) {
    ReactDOM.render(<Index />, document.getElementById("root"));
}
