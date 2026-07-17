@extends('backend.app')

@section('title', 'Services')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Services</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Services</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mt-1">Services</h3>
                        <div class="card-tools">
                            <a href="{{ route('services-edit')}}" class="btn btn-primary btn-sm"><i class="fas fa-pen"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('backend.components._alert_msg')
                        <div class="form-group row">
                            <div class="col-sm-2"><label>Title :</label></div>
                            <div class="col-sm-10">{{ !empty($service) ? $service->title : ''}}</div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2"><label>Description :</label></div>
                            <div class="col-sm-10">{{ !empty($service) ? $service->description:''}}</div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2"><label>Image :</label></div>
                            <div class="col-sm-10"> <img src='{{ !empty($service) ? asset("storage/uploads/service/$service->image") : ''; }}' alt="" width="300" height="300"></div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2"><label>Services Type :</label></div>
                            <div class="col-sm-10"></div>
                        </div>

                        @foreach($serviceType as $key => $type)
                        <div class="form-group row">
                            <div class="col-sm-2"><label>&nbsp;</label></div>
                            <div class="col-sm-10">
                                <p><b>{{$key + 1}} - {{$type->title}}</b></p>
                                <p>{{$type->description}}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection