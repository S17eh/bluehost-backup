@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ $message }}
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger" role="alert">
    {{ $message }}
</div>
@endif

@foreach($errors->all() as $v)
<div class="alert alert-danger" role="alert">
    {{ $v }}
</div>
@endforeach