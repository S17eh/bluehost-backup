@extends('backend.app')

@section('title', 'Home Page')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Home</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Home</li>
                </ol>
            </div>
        </div>
    </div>
</section>
@include('backend.components._alert_msg')
<!-- Home page header -->
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Main Image Section </h3>

            <div class="card-tools">
                <a href="{{ route('home-image-section-edit')}}" type="button" class="btn btn-primary btn-sm"">
                    <i class=" fas fa-pen"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
           
            <div class="form-group row">
                <div class="col-sm-2"><label>Title :</label></div>
                <div class="col-sm-10">{{$homeImage->title}}</div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2"><label>Description :</label></div>
                <div class="col-sm-10">{{$homeImage->description}}</div>
            </div>
        </div>
    </div>
</section>

<!-- Home page -->
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Home</h3>

            <div class="card-tools">
                <a href="{{ route('home-edit')}}" type="button" class="btn btn-primary btn-sm"">
                    <i class=" fas fa-pen"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-sm-2"><label>Title :</label></div>
                <div class="col-sm-10">{{$home->title}}</div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2"><label>Description :</label></div>
                <div class="col-sm-10">{{$home->description}}</div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2"><label>Description Image :</label></div>
                <div class="col-sm-10"> <img src='{{ asset("storage/uploads/home/$home->image")}}' alt="" width="300" height="300"></div>
            </div>
        </div>
    </div>
</section>

@endsection