import React from "react";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";

import Footer from "../components/Footer";
import Header from "../components/Header";
import AboutUs from "../pages/AboutUs";
import ApplyForJob from "../pages/ApplyForJob";
import ContactUs from "../pages/ContactUs";
import CurrentOpening from "../pages/CurrentOpening";
import Home from "../pages/Home";
import ResumeBuilder from "../pages/resume/ResumeBuilder";
import ResumeForm from "../pages/resume/ResumeForm";
import Services from "../pages/Services";

export default function ReactRouter() {
    function Public({ children }) {
        return (
            <>
                <Header />
                {children}
                <Footer />
            </>
        );
    }


    function Page404() {
        return (
            <p>
                404 : Page Not Found
            </p>
        );
    }

    return (
        <Router>
            <Routes>
                <Route
                    path="/"
                    element={<Public children={<Home />} />}
                ></Route>
                <Route
                    path="/about-us"
                    element={<Public children={<AboutUs />} />}
                ></Route>
                <Route path="/services" element={<Public children={<Services />} />}></Route>
                <Route path="/apply-for-job" element={<Public children={<ApplyForJob />} />}></Route>
                <Route path="/resume-builder" element={<Public children={<ResumeBuilder />} />}></Route>
                <Route path="/resume-form" element={<Public children={<ResumeForm />} />}></Route>
                <Route
                    path="/current-opening"
                    element={<Public children={<CurrentOpening />} />}
                ></Route>
                <Route path="/contact-us" element={<Public children={<ContactUs />} />}></Route>
                <Route path="*" element={<Page404 />}></Route>
            </Routes>
        </Router>
    );
}
