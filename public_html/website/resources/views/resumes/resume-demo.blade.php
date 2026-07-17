<!DOCTYPE html>
<html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="IE=edge; text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Resume 01</title>
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
                font-size: 20px;
                margin: 20px;
                font-family: 'Source Sans Pro', sans-serif;
            }

            .main-div {
                width: 100%;
                margin: 0 auto;
            }

            .color-belt {
                width: 100%;
                height: 80px;
                background-color: #10657E;
            }

            .skill-pills {
                display: inline-block;
                background-color: #ebebeb;
                margin: 10px 5px 0 0;
                padding: 7px 15px;
                border: 1px solid #d5d5d5;
                border-radius: 20px;
            }

            .extra-info {
                margin: 0;
                line-height: 1.5;
            }

            /* Left Div */
            .left-div {
                width: 63%;
                background: aliceblue;
                margin: 20px 0 0;
                float: left;
            }

            .left-div h1 {
                margin: 0;
                padding: 0px 0;
                font-weight: 400;
                background-color: #10657E;
                height: 20px;
            }

            .left-div h1 .section-title {
                display: inline-block;
                font-size: 25px;
                font-weight: 600;
                background-color: #004a60;
                padding: 8px 11px;
                color: #fff;
            }

            .sub-section {
                margin: 20px 0 0 0;
            }

            .section-body {
                margin: 15px 0 0 0;
                padding: 10px;
            }

            .section-body blockquote {
                border-left: 4px solid #10657E;
                margin-block-start: 0.5em;
                margin-block-end: 0.5em;
                padding: 0 20px;
                margin-inline-start: 10px;
                margin-inline-end: 10px;
            }

            /* Right */
            .right-div {
                width: 35%;
                vertical-align: top;
                background: aliceblue;
                float: left;
                margin: 20px 0 0 20px;
            }

            .right-div h1 {
                margin: 0;
                padding: 0px 0;
                font-weight: 400;
                background-color: #10657E;
                height: 20px;
            }

            .right-div h1 .section-title {
                display: inline-block;
                font-size: 22px;
                font-weight: 600;
                background-color: #004a60;
                padding: 8px 11px;
                color: #fff;
            }
        </style>
    </head>

    <body>
        <div class="main-div">
            <!-- Color Belt -->
            <div class="color-belt">
                <h1 style="color:#fff; margin:0; padding:10px; font-size: 2.0rem;">{{ $request->name }}
                    <div style="float:right; font-size:25px; text-align:right; ">
                        {{ $request->email }}<br>{{ $request->mobile_number }}</div>
                </h1>
            </div>

            <!-- Left -->
            <div class="left-div">
                <div id="skill">
                    <h1>
                        <div class="section-title">Objective</div>
                    </h1>
                    <div class="sub-section">
                        <div class="section-body">
                            <p class="extra-info">{{ $request->objective }}</p>
                        </div>
                    </div>
                </div>
                <div id="skill">
                    <h1>
                        <div class="section-title">Skills</div>
                    </h1>
                    <div class="sub-section">
                        <div class="section-body">
                            @foreach ($request->skills as $value)
                                <div class="skill-pills">{{ $value['skill'] }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div id="experience">
                    <h1>
                        <div class="section-title">Experience</div>
                    </h1>
                    <div class="sub-section">
                        @if ($request->background != 'Experience')
                            <div class="profile-body">
                                <p>Fresher</p>
                            </div>
                        @else
                            @foreach ($request->experience as $value)
                                <div class="section-body">
                                    <h3 style="margin:0;">{{ $value['company_name'] }}</h3>
                                    <h4 style="margin:0; font-size: 18px; padding: 5px 0; font-weight: 400;">
                                        {{ $value['job_title'] }}<span style="float: right;">{{ $value['start_date'] }}
                                            - <?= $value['current_company'] ? 'to Present' : $value['end_date'] ?>
                                        </span></h4>
                                    <p class="extra-info">Location : {{ $value['location'] }}</p>
                                    <p class="extra-info">{{ $value['description'] }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>

                </div>
                <!-- qualifications -->
                <div style="padding: 10px 0;"></div>
                <div id="qualifications">
                    <h1 class="section-title">
                        <div class="section-title">Education Qualifications</div>
                    </h1>
                    <div class="sub-section">
                        @foreach ($request->qualification as $value)
                            <div class="section-body">
                                <h3 style="margin:0;">{{ $value['degree'] }} <span>&nbsp;/&nbsp;</span>
                                    <span><i>({{ $value['field_of_study'] }})</i></span>
                                </h3>
                                <h4 style="margin:0; font-size: 18px; padding: 5px 0; font-weight: 400;">
                                    {{ $value['sc_name'] }} <span style="float: right;">{{ $value['start_date'] }} -
                                        {{ $value['end_date'] }}</span></h4>
                                <p style="margin: 0; line-height: 1.5;">Location: {{ $value['location'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Additional Info -->
                @if (!empty($request->additional_info))
                    <div style="padding: 10px 0;"></div>
                    <div id="experience">
                        <h1>
                            <div class="section-title">Additional Information</div>
                        </h1>
                        <div class="sub-section">
                            <div class="section-body">
                                @foreach ($request->additional_info as $value)
                                    <blockquote>{{ $value['description'] }}</blockquote>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right -->
            <div class="right-div">
                <!-- Personal Information -->
                <div id="personalInfo">
                    <h1>
                        <div class="section-title">Personal Information</div>
                    </h1>
                    <div class="sub-section">
                        <div class="section-body">
                            @if ($request->image)
                                <div style="width: 100%; display:block; padding: 10px;">
                                    <div style="width: 100%; display: block;  margin: 0 auto;">
                                        <img src="{{ $request->image }}"
                                            style="width: 150px; height: 150px; border-radius: 10px; object-fit:cover;" />
                                    </div>
                                </div>
                            @endif
                            <div class="address-right">
                                <ul style="margin: 10px; padding: 0;">
                                    <li style="list-style: none; padding-bottom: 10px;">
                                        <div style="padding-left: 5px;"><b>Address :</b></div>
                                        <span style="display: inline-block;width: 240px; padding-left: 5px;">
                                            {{ $request->address }}
                                        </span>
                                    </li>
                                    <li style="list-style: none; padding-bottom: 10px;">
                                        <div style="padding-left: 5px;"><b>Language :</b></div>
                                        <span style="width: 240px; padding-left: 5px; display: inline-block;">
                                            {{ $request->languages }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Links / url : -->
                @if (!empty($request->link))
                    <div style="padding: 10px 0;"></div>
                    <div id="links">
                        <h1>
                            <div class="section-title"> Links / Url </div>
                        </h1>
                        <div class="sub-section">
                            <div class="section-body">
                                @foreach ($request->link as $value)
                                    <h5 style="margin: 0; font-size: 20px; padding: 5px 15px 0; font-weight: 400;">
                                        <i class="fa3 fa-camera-retro" aria-hidden="true"></i> <span><a
                                                href="{{ $value['link'] }}">{{ $value['name'] }}</a></span>
                                    </h5>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Certifications & Licenses : -->
                @if (!empty($request->certification))
                    <div style="padding: 10px 0;"></div>
                    <div id="certifications">
                        <h1>
                            <div class="section-title">Certifications & Licenses</div>
                        </h1>
                        <div class="sub-section">
                            <div class="section-body">
                                @foreach ($request->certification as $value)
                                    <div style="margin:0; padding: 0 20px 20px;">
                                        <h3 style="margin:0;">{{ $value['certification'] }}</h3>
                                        <h6 style="margin: 0; font-size: 16px; padding: 0 0 10px 0; font-weight: 400;">
                                            {{ $value['start_date'] }} - {{ $value['end_date'] }} </h6>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>

    </body>

</html>
