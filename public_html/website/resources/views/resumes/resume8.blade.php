<!DOCTYPE html>
<html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Resume</title>
        <style>
            @font-face {
                font-family: 'Source Sans Pro';
                font-weight: normal;
                font-style: normal;
                font-variant: normal;
                src: url('https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap');
            }

            html {
                margin: 0;
            }

            body {
                margin: 20px;
                font-family: 'Source Sans Pro', sans-serif;
            }

            img {
                max-width: 100%;
            }

            .main-div {
                width: 100%;
                margin: 0 auto;
            }

            .main-content {
                width: 100%;
                color: #474747;
                display: block;
            }

            .left-content {
                width: 70%;
                float: left;
                vertical-align: top;
                background-color: #ffffff;
            }

            .left-content-bg {
                background-color: #2d2f3a;
                width: 100%;
                vertical-align: top;
                color: #fff;
                padding: 4% 0% 3% 0%;
            }

            .left-content h2 {
                font-size: 20px;
                font-weight: 600;
                text-transform: uppercase;
                margin: 10px 0px;
                background-color: #383b45;
                border-left: 17px solid #ffca06;
                padding-left: 20px;
            }

            .left-part-detail {
                width: 100%;
                vertical-align: top;
                padding: 0% 0% 2% 0%;
            }

            .main-content p {
                font-size: 20px;
                text-align: justify;
            }

            .main-content li {
                font-size: 20px;
            }

            .top-profile {
                width: 100%;
                padding-top: 46px;
                padding-bottom: 46px;
                text-align: left;
                display: block;
                color: #292929;
            }

            .top-profile h1 {
                font-size: 45px;
                font-weight: 600;
                text-transform: uppercase;
                padding: 25px 0px;
                margin: 0px;
            }

            .top-profile span {
                font-weight: 400;
            }

            .right-content {
                width: 30%;
                float: right;
                vertical-align: top;
            }

            .right-content-bg {
                background-color: #ffffff;
                width: 100%;
                vertical-align: top;
                color: #fff;
                padding: 4% 0% 3% 0%;
            }

            .right-content h2 {
                font-size: 20px;
                font-weight: 600;
                text-transform: uppercase;
                margin: 10px 0px;
                background-color: #f2f2f2;
                border-left: 17px solid #ffca06;
                padding-left: 20px;
                color: #1b1d1e;
            }

            .right-part-detail {
                width: 100%;
                vertical-align: top;
                margin-top: 30px;
                text-align: left !important;
            }

            .main-image-div {
                width: 100%;
                height: 215px;
                display: inline-flex;
            }

            .right-part-image {
                width: 75%;
                /* border-left:20px solid #fff; */
                padding-top: 25px;
                padding-bottom: 30px;
                background-color: #ffca06;
                float: right;
            }

            .right-part-image img {
                width: 165px;
                height: 165px;
                object-fit: cover;
                margin-left: -70px;
            }

            .skills {
                width: 100%;
            }

            .skills-body {
                margin-bottom: 20px;
                width: 90%;
                display: inline-block;
                padding: 1% 3% 0% 7%;
            }

            .skills ul {
                margin: 0px;
                padding: 0px;
            }

            .skills li {
                margin: 0px;
                font-weight: 400;
                margin-right: 25px;
                display: block;
                line-height: 35px;
            }

            .contact-detail {
                width: 100%;
                vertical-align: top;
                padding: 3% 0% 3% 0%;
            }

            .contact-detail li {
                margin: 0px;
                line-height: 35px;
                color: #383b45;
            }

            .contact-detail p {
                padding: 0px;
                margin: 0px;
                color: #383b45;
            }

            .contact {
                width: 100%;
                padding-bottom: 20px;
            }

            .contact-div {
                margin-bottom: 20px;
                width: 90%;
                display: inline-block;
                padding: 1% 3% 0% 7%;
            }

            .contact-div ul {
                margin: 0px;
                padding: 0px;
            }

            .contact-div li {
                margin: 0px;
                display: inline-block;
                line-height: 35px;
                color: #383b45;
            }

            .contact-div li a {
                text-decoration: none;
            }


            .profile {
                width: 100%;
            }

            .profile p {
                margin: 0px;
                padding-bottom: 10px;
            }

            .profile-body {
                width: 94%;
                display: inline-block;
                padding: 1% 3% 0% 3%;
            }

            .education {
                width: 100%;
            }

            .education p {
                margin: 0px;
                padding-bottom: 10px;
            }

            .education p span {
                float: right;
            }

            .education-body {
                width: 94%;
                display: inline-block;
                padding: 1% 3% 0% 3%;
            }


            .experience {
                width: 100%;
            }

            .experience p {
                padding-bottom: 10px;
                margin: 0px;
            }

            .experience p span {
                float: right;
            }

            .experience-body {
                width: 94%;
                display: inline-block;
                padding: 1% 3% 0% 3%;
            }

            .additional-information {
                width: 100%;
            }

            .additional-information-div {
                width: 94%;
                display: inline-block;
                padding: 1% 3% 0% 3%;
            }

            .additional-information-div blockquote {
                border-left: 3px solid #474747;
                margin-block-start: 0.5em;
                margin-block-end: 0.5em;
                padding: 0 20px;
                margin-inline-start: 20px;
                margin-inline-end: 0px;
                text-align: justify;
                font-size: 20px;
            }

            .certifications {
                width: 100%;
            }

            .certifications p {
                margin: 0px;
                padding-bottom: 10px;
            }

            .certifications p span {
                float: right;
            }

            .certifications-body {
                width: 94%;
                display: inline-block;
                padding: 1% 3% 0% 3%;
            }
        </style>
    </head>

    <body>
        <div class="main-div">
            <div class="main-content">
                <div class="right-content">
                    <div class="main-image-div">

                        <div class="right-part-image">
                            <img src="{{ $request->image }}" alt="" />
                        </div>
                    </div>
                    <div class="right-content-bg">
                        <div class="contact-detail">
                            <div class="contact">
                                <h2>Contact</h2>
                                <div class="contact-div">
                                    <p><b>Date of Birth</b></p>
                                    <p>{{ $request->dob }}</p>
                                </div>
                                <div class="contact-div">
                                    <p><b>Marital Status</b></p>
                                    <p>{{ $request->marital_status }}</p>
                                </div>
                                <div class="contact-div">
                                    <p><b>Mobile</b></p>
                                    <p>{{ $request->mobile_number }}</p>
                                </div>
                                <div class="contact-div">
                                    <p><b>Email</b></p>
                                    <p>{{ $request->email }}</p>
                                </div>
                                <div class="contact-div">
                                    <p><b>Address</b></p>
                                    <p>{{ $request->address }}</p>
                                </div>
                            </div>
                            <div class="contact">
                                <h2>Language</h2>
                                <div class="contact-div">
                                    <p>{{ $request->languages }}</p>
                                </div>
                            </div>
                            <div class="skills">
                                <h2>Skills</h2>
                                <div class="skills-body">
                                    <ul>
                                        @foreach ($request->skills as $value)
                                            <li>{{ $value['skill'] }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @if (!empty($request->link))
                                <div class="skills">
                                    <h2>Link</h2>
                                    <div class="skills-body">
                                        <ul>
                                            @foreach ($request->link as $value)
                                                <li><a href="{{ $value['link'] }}">{{ $value['name'] }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="left-content">
                    <div class="top-profile">
                        <h1>{{ $request->name }}</h1>
                    </div>
                    <div class="left-content-bg">
                        <div class="left-part-detail">
                            <div class="profile">
                                <h2>Profile</h2>
                                <div class="profile-body">
                                    <p>{{ $request->objective }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="left-part-detail">
                            <div class="education">
                                <h2>EDUCATION</h2>
                                @foreach ($request->qualification as $value)
                                    <div class="education-body">
                                        <p><b>{{ $value['degree'] }} &nbsp;/&nbsp;
                                                <i>({{ $value['field_of_study'] }})</i> </b>
                                            <span>{{ $value['start_date'] }} - {{ $value['end_date'] }}</span></p>
                                        <p>{{ $value['sc_name'] }}<span>{{ $value['location'] }}</span></p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="left-part-detail">
                            <div class="experience">
                                <h2>EXPERIENCE</h2>
                                @if ($request->background != 'Experience')
                                    <div class="profile-body">
                                        <p>Fresher</p>
                                    </div>
                                @else
                                    @foreach ($request->experience as $value)
                                        <div class="experience-body">
                                            <p><b>{{ $value['job_title'] }}</b> <span>{{ $value['start_date'] }} -
                                                    <?= $value['current_company'] ? 'to Present' : $value['end_date'] ?></span>
                                            </p>
                                            <p><b>{{ $value['company_name'] }}</b>
                                                <span>{{ $value['location'] }}</span></p>
                                            <p>{{ $value['description'] }}</p>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                        </div>

                        @if (!empty($request->additional_info))
                            <div class="left-part-detail">
                                <div class="additional-information">
                                    <h2>Additional Information</h2>
                                    <div class="additional-information-div">
                                        @foreach ($request->additional_info as $value)
                                            <blockquote>{{ $value['description'] }}</blockquote>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (!empty($request->certification))
                            <div class="left-part-detail">
                                <div class="certifications">
                                    <h2>CERTIFICATIONS</h2>
                                    <div class="certifications-body">
                                        @foreach ($request->certification as $value)
                                            <p><b>{{ $value['certification'] }}</b> <span>{{ $value['start_date'] }} -
                                                    {{ $value['end_date'] }}</span></p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </body>

</html>
