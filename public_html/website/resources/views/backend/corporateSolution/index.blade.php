@extends('backend.app')
@include('backend.load.dataTable')

@section('title', 'Corporate Solution')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Corporate Solution</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Corporate Solution</li>
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
                        <h3 class="card-title mt-1">Solution List</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModel" data-backdrop="static" data-keyboard="false">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="teamTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 2%;">#</th>
                                    <th>Title</th>
                                    <th>Description</th>
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
@include('backend.recruitment.add_model')
<!-- Start Model -->
<div class="modal fade" id="editModel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="modelBody">
        </div>
    </div>
</div>
<!-- End Model -->
@endsection

@push('script')
<script>
    var table = $('#teamTable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        responsive: true,
        ajax: "{{ route('corporate-solution') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'title',
                name: 'title'
            },
            {
                data: 'description',
                name: 'description'
            },
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            },
        ]
    });



    $(document).on('click', '.edit', function(e) {
        e.preventDefault();
        const model = $(this),
            action = model.data('action');
        $.ajax({
            url: action,
            type: "GET",
            success: function(response) {
                if (response) {
                    $("#modelBody").html(response);
                }
            },
        });
    });


    /* Update Company Type */
    $(document).on('submit', '#updateCorporation', function(e) {
        e.preventDefault();
        var fd = new FormData(this);
        var obj = $(this),
            action = obj.attr("name");
        e.preventDefault();
        $.ajax({
            url: e.target.action,
            type: "POST",
            data: fd,
            contentType: false,
            cache: false,
            processData: false,
            success: function(JSON) {
                if (JSON.success) {
                    table.ajax.reload(function() {
                        toastr.success(JSON.success)
                    });
                    $("#editModel .close").click();
                } else if (JSON.error) {
                    toastr.error(JSON.error);
                }
                $.each(JSON.errors, function(k, v) {
                    toastr.error(v)
                });
            },
        });
    });
</script>
@endpush