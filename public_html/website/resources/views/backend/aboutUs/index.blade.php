@extends('backend.app')

@section('title', 'About us')

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
                    <li class="breadcrumb-item active">About Us</li>
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
                        <h3 class="card-title mt-1">About Us</h3>
                        <div class="card-tools">
                            <a href="{{ route('about-us-edit')}}" class="btn btn-primary btn-sm"><i class="fas fa-pen"> </i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('backend.components._alert_msg')
                        <div class="form-group row">
                            <div class="col-sm-2"><label>Description :</label></div>
                            <div class="col-sm-10">{{$aboutUs->description}}</div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2"><label>Description Image :</label></div>
                            <div class="col-sm-10"> <img src='{{ asset("storage/uploads/aboutUs/$aboutUs->image")}}' alt="" width="300" height="300"></div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-sm-2 col-form-label">What we can do.</label>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2"><label>&nbsp;</label></div>
                            <div class="col-sm-10">
                                <?php if (!empty($aboutService)) {
                                    $count = 1;
                                    echo '<ul>';
                                    foreach ($aboutService as $service) { ?>
                                        <li>{{$service->service}}</li>
                                    <?php }
                                    echo '</ul>';
                                } else { ?>
                                    No Data Found
                                <?php  }
                                ?>
                            </div>
                        </div>
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