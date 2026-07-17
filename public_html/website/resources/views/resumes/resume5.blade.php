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

            h2 {
                font-size: 26px;
                font-weight: 600;
                text-transform: uppercase;
                margin: 10px 0px;
            }

            .border-div {
                width: 40px;
                height: 5px;
                margin-bottom: 15px;
                border-bottom: 3px solid #ffe124;
            }

            .main-div {
                width: 100%;
                margin: 0 auto;
                color: #37393d;
            }

            .main-content {
                width: 100%;
                display: inline-block;
            }

            .left-content {
                width: 30%;
                float: left;
                color: #fff;
                vertical-align: top;
            }

            .right-content {
                width: 69%;
                float: right;
                vertical-align: top;
            }

            .main-content p {
                font-size: 18px;
            }

            .main-content li {
                font-size: 18px;
            }

            .skills-detail {
                width: 94%;
                background-color: #ebebeb;
                padding: 3% 3% 2% 3%;
                color: #4f4f4f;
                display: block;
            }

            .skills {
                width: 100%;
            }

            .skills-body {
                width: 100%;
                padding-bottom: 30px;
            }

            .skills ul {
                margin: 0px;
                padding: 0px;
            }

            .skills li {
                margin: 0px;
                font-weight: 400;
                margin-right: 40px;
                display: block;
                line-height: 35px;
            }

            .contact-detail {
                width: 94%;
                background-color: #1a1c1e;
                padding: 3% 3% 3% 3%;
                display: block;
            }

            .contact-detail img {
                width: 100%;
                height: 250px;
                object-fit: cover;
            }

            .contact-detail p {
                padding: 0px;
                margin: 0px;
            }

            .contact {
                width: 100%;
                padding-bottom: 20px;
            }

            .contact-div {
                width: 100%;
                margin-bottom: 20px;
                display: inline-block;
            }

            .contact-div ul {
                margin: 0px;
                padding: 0px;
            }

            .contact-div li {
                margin: 0px;
                margin-right: 25px;
                display: inline-block;
                line-height: 35px;
            }

            .contact-div li a {
                text-decoration: none;
            }

            .right-part-top {
                background-color: #ebebeb;
                width: 94%;
                background-color: #f7f5f6;
                padding: 3% 3% 2% 3%;
            }

            .right-part-top h1 {
                font-size: 50px;
                font-weight: bold;
                margin: 0px;
                padding-bottom: 10px
            }

            .right-part-detail {
                width: 95%;
                vertical-align: top;
                margin-top: 5px;
                padding-left: 3%;
                padding-right: 2%;
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
                width: 100%;
                display: inline-block;
                padding-bottom: 20px;
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
                width: 100%;
                display: inline-block;
                padding-bottom: 30px;
            }

            .additional-information {
                width: 100%;
            }

            .additional-information-div {
                width: 100%;
                display: inline-block;
                padding-bottom: 30px;
            }

            .additional-information-div blockquote {
                border-left: 3px solid #ffe124;
                margin-block-start: 0.5em;
                margin-block-end: 0.5em;
                padding: 0 20px;
                margin-inline-start: 10px;
                margin-inline-end: 10px;
                text-align: justify;
                font-size: 18px;
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
                width: 100%;
                display: inline-block;
                padding-bottom: 20px;
            }
        </style>
    </head>

    <body>
        <div class="main-div">
            <div class="main-content">
                <div class="left-content">
                    <div class="contact-detail">
                        <img src='{{ $request->image }}' alt='' />
                        <div class="contact">
                            <h2>Contact</h2>
                            <div class="border-div"></div>
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
                            <div class="border-div"></div>
                            <div class="contact-div">
                                <p>{{ $request->languages }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="skills-detail">

                        <div class="skills">
                            <h2>Skills</h2>
                            <div class="border-div"></div>
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
                                <div class="border-div"></div>
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

                <div class="right-content">
                    <div class="right-part-top">
                        <h1>{{ $request->name }}</h1>
                        <h2>Profile</h2>
                        <div class="border-div"></div>
                        <p>{{ $request->objective }}</p>
                    </div>
                    <div class="right-part-detail">
                        <div class="education">
                            <h2>EDUCATION</h2>
                            <div class="border-div"></div>
                            @foreach ($request->qualification as $value)
                                <div class="education-body">
                                    <p><b>{{ $value['degree'] }} &nbsp;/&nbsp; <i>({{ $value['field_of_study'] }})</i>
                                        </b> <span>{{ $value['start_date'] }} - {{ $value['end_date'] }}</span></p>
                                    <p>{{ $value['sc_name'] }}<span>{{ $value['location'] }}</span></p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="right-part-detail">
                        <div class="experience">
                            <h2>EXPERIENCE</h2>
                            <div class="border-div"></div>
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
                                        <p><b>{{ $value['company_name'] }}</b> <span>{{ $value['location'] }}</span>
                                        </p>
                                        <p>{{ $value['description'] }}</p>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                    </div>

                    @if (!empty($request->additional_info))
                        <div class="right-part-detail">
                            <div class="additional-information">
                                <h2>Additional Information</h2>
                                <div class="border-div"></div>
                                <div class="additional-information-div">
                                    @foreach ($request->additional_info as $value)
                                        <blockquote>{{ $value['description'] }}</blockquote>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (!empty($request->certification))
                        <div class="right-part-detail">
                            <div class="education">
                                <h2>CERTIFICATIONS</h2>
                                <div class="border-div"></div>
                                <div class="education-body">
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
    </body>

</html>
