<!DOCTYPE html>
<html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Resume</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap');

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
                text-transform: capitalize;
                margin: 10px 0px 15px 0px;
            }

            .main-div {
                width: 100%;
                margin: 0 auto;
                color: #37393d;
            }

            .header-main {
                width: 100%;
                display: inline-block;
            }

            .header-left {
                width: 69%;
                display: inline-block;
                vertical-align: top;
            }

            .header-left h1 {
                font-size: 50px;
                font-weight: bold;
                margin: 0px;
                padding-bottom: 30px;
            }

            .header-left p {
                padding: 0px;
                margin: 0px;

            }

            .header-right {
                width: 30%;
                display: inline-block;
                vertical-align: top;
                text-align: left;
            }

            .contact p {
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

            .main-content {
                width: 100%;
                display: inline-block;
            }

            .main-content p {
                font-size: 19px;
            }


            .content-div {
                width: 100%;
                margin: 20px 0 20px 0px;
            }


            /* Education */
            .education {
                width: 100%;
            }

            .education p {
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

            .education-body p {
                font-weight: 400;
                padding: 0 0 5px 0;
                margin: 0px;
                text-align: justify;
            }

            .education-body p span {
                float: right;
            }

            .experience {
                width: 100%;
            }

            .experience-body {
                width: 100%;
                display: inline-block;
                padding-bottom: 10px;
            }

            .experience-body p {
                font-weight: 400;
                padding: 0 0 5px 0;
                margin: 0px;
                text-align: justify;
            }

            .experience-body p span {
                float: right;
            }


            .language {
                width: 100%;
            }

            .language p {
                font-weight: 400;
                padding: 0 0 5px 0;
                margin: 0px;
                text-align: justify;
            }

            .language p a {
                text-decoration: none;
            }

            .language-body {
                width: 100%;
                display: inline-block;
                padding-bottom: 30px;
            }


            /* Skills */
            .skills {
                width: 100%;
            }

            /* Additional Information  */
            .additional-information {
                width: 100%;
            }

            .additional-information-div {
                width: 100%;
                display: inline-block;
                padding-bottom: 30px;
            }

            .additional-information-div blockquote {
                border-left: 3px solid #f5f5f5;
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
                font-size: 20px;
                font-weight: 400;
                margin-right: 10px;
                display: inline-block;
                background: #f5f5f5;
                padding: 10px 20px;
                border-radius: 100px;
            }
        </style>
    </head>

    <body>
        <div class="main-div">
            <div class="header-main">
                <div class="header-left">
                    <h1>{{ $request->name }}</h1>
                    <p>{{ $request->objective }}</p>
                </div>
                <div class="header-right">
                    <div class="contact">
                        <div class="contact-div">
                            <p><b>Date of Birth</b>: {{ $request->dob }}</p>
                        </div>
                        <div class="contact-div">
                            <p><b>Marital Status</b>: {{ $request->marital_status }}</p>
                        </div>
                        <div class="contact-div">
                            <p><b>Mobile</b>: {{ $request->mobile_number }}</p>
                        </div>
                        <div class="contact-div">
                            <p><b>Email</b>: {{ $request->email }}</p>
                        </div>
                        <div class="contact-div">
                            <p><b>Address</b>: {{ $request->address }}</p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="main-content">
                <div class="content-div">
                    <div class="language">
                        <h2>Language</h2>
                        <div class="language-body">
                            <p>{{ $request->languages }}</p>
                        </div>
                    </div>
                    <div class="skills">
                        <h2>Skills</h2>
                        <div class="horizontal">
                            <ul>
                                @foreach ($request->skills as $value)
                                    <li>{{ $value['skill'] }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="education">
                        <h2>Education</h2>
                        @foreach ($request->qualification as $value)
                            <div class="education-body">
                                <p><b>{{ $value['degree'] }} &nbsp;/&nbsp;
                                        <i>({{ $value['field_of_study'] }})</i></b><span>{{ $value['start_date'] }} -
                                        {{ $value['end_date'] }}</span></p>
                                <p>{{ $value['sc_name'] }}<span>{{ $value['location'] }}</span></p>
                            </div>
                        @endforeach
                    </div>

                    <div class="experience">
                        <h2>Experience</h2>
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
                                    <p><b>{{ $value['company_name'] }}</b> <span>{{ $value['location'] }}</span></p>
                                    <p>{{ $value['description'] }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Additional Information -->
                    @if (!empty($request->additional_info))
                        <div class="additional-information">
                            <h2>Additional Information</h2>
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
                            @foreach ($request->certification as $value)
                                <div class="certifications-div">
                                    <p><b>{{ $value['certification'] }}</b><span>{{ $value['start_date'] }} -
                                            {{ $value['end_date'] }}</span></p>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Links -->
                    @if (!empty($request->link))
                        <div class="language">
                            <h2>Link</h2>
                            <div class="language-body">
                                @foreach ($request->link as $value)
                                    <p><a href="http://smart-lion.local/resume-form">{{ $value['name'] }}</a></p>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

    </body>

</html>
