@extends('backend.app')

@section('title', 'About us Edit')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>About Us</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('about-us')}}">About Us</a></li>
                    <li class="breadcrumb-item active">About Us Edit</li>
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
                        <form action="{{route('about-us-save')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @include('backend.components._alert_msg')
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="description" id="description" cols="30" rows="10" placeholder="About Us Description"><?= $aboutUs != null ? $aboutUs->description : old('description'); ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Description Image</label>
                                <div class="col-sm-10">
                                    <input type="file" name="image" id="">
                                </div>
                            </div>
                            @if($aboutUs != null)
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <img src='{{ asset("storage/uploads/aboutUs/$aboutUs->image")}}' alt="" width="300" height="300">
                                </div>
                            </div>
                            @endif

                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">What we can do.</label>
                                <div class="col-sm-8">
                                    <button type="button" class="btn btn-primary btn-sm" id="addMoreCanDo"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <div id="cloneCanDo">
                                <?php if (!empty($aboutService)) {
                                    $count = 1;
                                    foreach ($aboutService as $service) { ?>


                                        <div class="form-group row closeCanDo">
                                            <label class="col-sm-2 col-form-label"><?= $count == 1 ? '' : '<button type="button" class="btn btn-danger btn-sm deleteCanDo">Delete</button>'; ?></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="canDo[]" value="<?= $service->service ?>" placeholder="Type Here">
                                            </div>
                                        </div>
                                    <?php
                                        $count++;
                                    }
                                } else { ?>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">&nbsp;</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="canDo[]" placeholder="Type Here">
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
        html += '<input type="text" class="form-control" name="canDo[]" placeholder="Type Here">';
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