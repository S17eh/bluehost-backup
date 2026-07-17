import React from "react";
import { useLocation } from "react-router-dom";
import ReactDOMServer from "react-dom/server";
import Banner from "../../components/Banner";
import Resume2 from "../../resumes/resume-2/Resume2";

// import jsPDF from "jspdf";
// import html2canvas from "html2canvas";

const ResumePreview = () => {
    const location = useLocation();
    const userDetails = location.state;
    console.log(userDetails);

    function handleClick(event) {
        event.preventDefault();
        let box = document.querySelector("#resume");
        let width = box.offsetWidth;
        let height = box.offsetHeight;
        // html2canvas(box).then((canvas) => {
        //     document.body.appendChild(canvas); // if you want see your screenshot in body.
        //     const imgData = canvas.toDataURL("image/png");
        //     const pdf = new jsPDF("p", "px");
        //     pdf.addImage(imgData, "PNG", 0, 0);
        //     pdf.save("download.pdf");
        // });
    }

    return (
        <>
            <Banner img="images/about-banner.png" pageName="Resume Preview" />
            <Resume2 allData={userDetails} />
        </>
    );
};

export default ResumePreview;
