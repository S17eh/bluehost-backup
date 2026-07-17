@extends('backend.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Resumes</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Resumes</li>
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
                        <h3 class="card-title mt-1">Resume List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="teamTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 2%;">#</th>
                                    <th style="width: 8%;">Image</th>
                                    <th>Name</th>
                                    <th style="width: 8%;">Status</th>
                                    <th style="width: 8%;">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('script')

@endpush