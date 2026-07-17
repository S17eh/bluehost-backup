<!DOCTYPE html>
<html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Resume</title>
        <style>
            /* @import url('https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap'); */

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
                font-size: 30px;
                font-weight: 600;
                text-transform: uppercase;
                margin: 10px 0px;
            }

            .main-div {
                width: 100%;
                margin: 0 auto;
                color: #37393d;
            }

            .border-div {
                width: 40px;
                height: 5px;
                margin-bottom: 15px;
                border-bottom: 3px solid #ffe124;
            }

            .left-div {
                width: 28%;
                margin: 20px 0 0;
                float: left;
            }

            .left-part {
                width: 90%;
            }

            .left-part img {
                width: 200px;
                border-radius: 100%;
                height: 200px;
                object-fit: cover;
            }

            /* Contact */
            .contact {
                width: 100%;
                padding-top: 20px;
            }

            .contact p {
                font-size: 22px;
                font-weight: 400;
                padding: 0px;
                margin: 0px;
            }

            .contact-div {
                width: 100%;
                margin-bottom: 20px;
            }

            .contact-div ul {
                margin: 0px;
                padding: 0px;
            }

            .contact-div li {
                margin: 0px;
                font-size: 22px;
                font-weight: 400;
                margin-right: 40px;
                display: block;
                line-height: 35px;
            }

            .contact-div li a {
                text-decoration: none;
            }

            /* Right Div */
            .right-div {
                width: 70%;
                float: right;
                margin: 20px 0 0 20px;
            }

            .right-part {
                width: 99%;
            }

            .right-part h1 {
                font-size: 50px;
                font-weight: bold;
                margin: 0px;
                padding-bottom: 100px
            }

            /* Profile */

            .profile {
                width: 100%;
            }

            .profile p {
                font-size: 22px;
                font-weight: 400;
                padding: 0px;
                margin: 0px;
                text-align: justify;
            }

            .profile-div {
                width: 100%;
                margin-bottom: 20px;
            }

            /* Education */
            .education {
                width: 100%;
            }

            .education p {
                font-size: 22px;
                font-weight: 400;
                padding: 0 0 5px 0;
                margin: 0px;
                text-align: justify;
            }

            .education-body {
                width: 100%;
                display: inline-block;
                padding-bottom: 30px;
            }

            /* Experience */
            .experience {
                width: 100%;
            }

            .experience p {
                font-size: 22px;
                font-weight: 400;
                padding: 0 0 5px 0;
                margin: 0px;
                text-align: justify;
            }

            .experience-body {
                width: 100%;
                display: inline-block;
                padding-bottom: 30px;
            }

            /* Skills */
            .skills {
                width: 100%;
            }

            /* Additional Information */
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
            }

            /* Certifications & Licenses  */
            .certifications {
                width: 100%;
            }

            .certifications-div {
                width: 100%;
                display: inline-block;
                padding-bottom: 10px;
            }

            .certifications-div p {
                font-size: 22px;
                font-weight: 400;
                padding: 0 0 5px 0;
                margin: 0px;
                text-align: justify;
            }

            .certifications-div p span {
                float: right;
            }

            .horizontal {
                width: 100%;
                display: inline-block;
                padding-bottom: 30px;
            }

            .horizontal ul {
                margin: 0px;
                padding: 0px;
            }

            .horizontal li {
                margin: 0px;
                font-size: 22px;
                font-weight: 400;
                margin-right: 40px;
                display: inline-block;
            }
        </style>
    </head>

    <body>
        <div class="main-div">
            <div class="left-div">
                <div class="left-part">
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
                        <div class="horizontal">
                            {{ $request->languages }}
                        </div>
                    </div>

                    @if (!empty($request->link))
                        <div class="contact">
                            <h2>Links</h2>
                            <div class="border-div"></div>
                            <div class="contact-div">
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
            <div class="right-div">
                <div class="right-part">
                    <h1>{{ $request->name }}</h1>
                    <div class="profile">
                        <h2>Objective</h2>
                        <div class="border-div"></div>
                        <div class="profile-div">
                            <p>{{ $request->objective }}</p>
                        </div>
                    </div>

                    <div class="education">
                        <h2>Education</h2>
                        <div class="border-div"></div>
                        @foreach ($request->qualification as $value)
                            <div class="education-body">
                                <p style="font-size: 22px;"><b>{{ $value['sc_name'] }}</b> <span
                                        style="font-size: 22px;float: right;">{{ $value['location'] }}</span></p>
                                <p style="font-size: 24px;">{{ $value['degree'] }} &nbsp;/&nbsp;
                                    <i>({{ $value['field_of_study'] }})</i> <span
                                        style="font-size: 22px;float: right;">{{ $value['start_date'] }} -
                                        {{ $value['end_date'] }}</span>
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <div class="experience">
                        <h2>Experience</h2>
                        <div class="border-div"></div>
                        @if ($request->background != 'Experience')
                            <div class="profile-body">
                                <p>Fresher</p>
                            </div>
                        @else
                            @foreach ($request->experience as $value)
                                <div class="experience-body">
                                    <p style="font-size: 22px;"><b>{{ $value['job_title'] }}</b> <span
                                            style="font-size: 22px;float: right;">{{ $value['start_date'] }} -
                                            <?= $value['current_company'] ? 'to Present' : $value['end_date'] ?></span>
                                    </p>
                                    <p style="font-size: 24px;">{{ $value['company_name'] }} <span
                                            style="float: right;">{{ $value['location'] }}</span></p>
                                    <p>{{ $value['description'] }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="skills">
                        <h2>Skills</h2>
                        <div class="border-div"></div>
                        <div class="horizontal">
                            <ul>
                                @foreach ($request->skills as $value)
                                    <li>{{ $value['skill'] }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    @if (!empty($request->additional_info))
                        <div class="additional-information">
                            <h2>Additional Information</h2>
                            <div class="border-div"></div>
                            <div class="additional-information-div">
                                @foreach ($request->additional_info as $value)
                                    <blockquote>{{ $value['description'] }}</blockquote>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Certifications & Licenses -->
                    @if (!empty($request->certification))
                        <div class="certifications">
                            <h2>Certifications</h2>
                            <div class="border-div"></div>
                            @foreach ($request->certification as $value)
                                <div class="certifications-div">
                                    <p><b>{{ $value['certification'] }}</b><span>{{ $value['start_date'] }} -
                                            {{ $value['end_date'] }}</span></p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </body>

</html>
