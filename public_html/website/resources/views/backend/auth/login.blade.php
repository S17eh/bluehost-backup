@extends('backend.auth.index')

@section('title', 'Login')

@section('content')
<div class="card">
    <div class="card-body login-card-body">
        <div class="login-logo">
            <a href="{{ route('frontend') }}"><img src="{{ asset('images/Logo.png')}}" alt=""></a>
        </div>
        <p class="login-box-msg">Sign in to start your session</p>
        @include('backend.components._alert_msg')
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="input-group mb-3">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ old('email') }}" autofocus required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" id="remember">
                        <label for="remember">
                            Remember Me
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.login-card-body -->
</div>
@endsection