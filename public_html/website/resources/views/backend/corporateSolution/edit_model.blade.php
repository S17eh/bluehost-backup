<div class="modal-header">
    <h4 class="modal-title">Edit Corporate Solution</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">

    <form class="form-horizontal" id="updateCorporation" method="POST" action="{{route('corporate-solution-update', $corporation->id)}}" enctype="multipart/form-data">
        @csrf

        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Title</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="title" id="title" value="{{$corporation->title}}" placeholder="Corporate Solution title" />
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="description" id="description" cols="30" rows="10" placeholder="Description">{{ $corporation->description }}</textarea>
            </div>
        </div>

        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</div>