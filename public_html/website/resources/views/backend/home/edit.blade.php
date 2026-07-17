@extends('backend.app')

@section('title', 'Home Page')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Home Page</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Edit</li>
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
                        <h3 class="card-title mt-1">About Us Edit</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('home-save')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @include('backend.components._alert_msg')
                            <div class="form-group row">
                                <label for="title" class="col-sm-2 col-form-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" name="title" id="title" class="form-control" value="<?= $home != null ? $home->title : old('title'); ?>" placeholder="Title">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="description" id="description" cols="30" rows="10" placeholder="About Us Description"><?= $home != null ? $home->description : old('description'); ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Description Image</label>
                                <div class="col-sm-10">
                                    <input type="file" name="image" id="">
                                </div>
                            </div>
                            @if($home != null)
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <img src='{{ asset("storage/uploads/home/$home->image")}}' alt="" width="300" height="300">
                                </div>
                            </div>
                            @endif
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection