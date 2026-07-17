@extends('backend.app')

@section('title', 'Contact us Edit')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Contact Us</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('contact-us')}}">Contact Us</a></li>
                    <li class="breadcrumb-item active">Contact Us Edit</li>
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
                        <h3 class="card-title mt-1">Contact Us Edit</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('contact-us-save')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @include('backend.components._alert_msg')
                            @foreach($contactUs as $key => $value)
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">{{$key}}</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="contact[{{$key}}]" id="description" placeholder="About Us Description"><?= $value ?></textarea>
                                </div>
                            </div>
                            @endforeach

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