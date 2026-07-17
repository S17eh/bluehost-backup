<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} | @yield('title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ mix('backend/css/font.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/toastr/toastr.css') }}">

    @stack('before-style')

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ mix('backend/css/app.css') }}">

    @stack('css_or_js')

</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <?= view('backend.components.header')->render(); ?>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <?= view('backend.components.sidebar')->render(); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021.</strong> All rights reserved.
        </footer>
    </div>
    <script src="{{ mix('backend/js/app.js')}}"></script>
    @stack('before-script')
    <script src="{{ asset('backend/plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{ mix('backend/js/theme.js')}}"></script>
    <script>
        const currentPath = '{{ url()->current() }}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @stack('script')
</body>

</html>