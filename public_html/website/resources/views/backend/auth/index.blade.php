<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ mix('backend/css/font.css') }}">
    <!-- icheck bootstrap -->
    <!-- <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css"> -->
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ mix('backend/css/app.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
       
        @yield('content')
    </div>

    <script src="{{ mix('backend/js/app.js')}}"></script>
    <script src="{{ mix('backend/js/theme.js')}}"></script>
</body>

</html>