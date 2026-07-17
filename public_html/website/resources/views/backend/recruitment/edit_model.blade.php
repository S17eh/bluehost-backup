<div class="modal-header">
    <h4 class="modal-title">Edit Recruitment</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">

    <form class="form-horizontal" id="updateRecruitment" method="POST" action="{{route('recruitment-update', $recruitment->id)}}" enctype="multipart/form-data">
        @csrf

        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="description" id="description" cols="30" rows="10" placeholder="Description">{{ $recruitment->description }}</textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="status" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
                <select class="form-control" name="status" id="status">
                    <option value="Active" <?= $recruitment->status === 'Active' ? "selected" : ""; ?>>Active</option>
                    <option value="Inactive" <?= $recruitment->status === 'Inactive' ? "selected" : ""; ?>>Inactive</option>
                </select>
            </div>
        </div>

        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</div>