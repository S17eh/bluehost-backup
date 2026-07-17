@extends('backend.app')

@section('title', 'Service Edit')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Service Edit</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('services')}}">Service</a></li>
                    <li class="breadcrumb-item active">Service Edit</li>
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
                        <h3 class="card-title mt-1">Service Edit</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('services-update')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @include('backend.components._alert_msg')
                            <div class="form-group row">
                                <label for="title" class="col-sm-2 col-form-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Service Title" value="<?= $service != null ? $service->title : old('title'); ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="description" id="description" cols="30" rows="10" placeholder="Service Description"><?= $service != null ? $service->description : old('description'); ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Image</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control-file" name="image" id="">
                                </div>
                            </div>
                            @if($service != null)
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <img src='{{ asset("storage/uploads/service/$service->image")}}' alt="" width="300" height="300">
                                </div>
                            </div>
                            @endif

                            <!-- Clone Service -->
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Services</label>
                                <div class="col-sm-8">
                                    <button type="button" class="btn btn-primary btn-sm" id="addMoreCanDo"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <div id="cloneCanDo">
                                <?php if (!empty($serviceType)) {
                                    $count = 1;
                                    foreach ($serviceType as $type) { ?>
                                        <div class="form-group row closeCanDo">
                                            <label class="col-sm-2 col-form-label"><?= $count == 1 ? '' : '<button type="button" class="btn btn-danger btn-sm deleteCanDo">Delete</button>'; ?></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="serviceTitle[]" value="<?= $type->title ?>" placeholder="Enter Service Title">
                                                <textarea class="form-control mt-3" name="serviceDescription[]" placeholder="Enter Service Title"><?= $type->description ?></textarea>
                                                <hr />
                                            </div>
                                        </div>
                                    <?php
                                        $count++;
                                    }
                                } else { ?>


                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">&nbsp;</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="serviceTitle[]" placeholder="Enter Service Title">
                                            <textarea class="form-control mt-3" name="serviceDescription][]" placeholder="Enter Service Title"></textarea>
                                            <hr />
                                        </div>
                                    </div>

                                <?php } ?>
                            </div>

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


@push('script')
<script>
    $('#addMoreCanDo').click(function() {
        var html = '';
        html += '<div class="form-group row closeCanDo">';
        html += '<label class="col-sm-2 col-form-label"><button type="button" class="btn btn-danger btn-sm deleteCanDo">Delete</button></label>';
        html += '<div class="col-sm-10">';
        html += '<input type="text" class="form-control" name="serviceTitle[]" placeholder="Enter Service Title">';
        html += '<textarea class="form-control mt-3" name="serviceDescription[]" placeholder="Enter Service Description"></textarea>';
        html += '<hr />';
        html += '</div>';
        html += '</div>';
        $('#cloneCanDo').append(html);
        $('#cloneCanDo.closeCanDo').after(html);
    });

    $(document).on('click', '.deleteCanDo', function() {
        $(this).closest('.closeCanDo').remove();
    });
</script>
@endpush