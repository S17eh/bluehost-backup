<div class="modal-header">
    <h4 class="modal-title">Edit Testimonial</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">

    <form class="form-horizontal" id="updateTestimonial" method="POST" action="{{route('testimonial-update', $testimonial->id)}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" id="name" value="{{ $testimonial->name }}" placeholder="Name">
            </div>
        </div>
        <div class="form-group row">
            <label for="position" class="col-sm-2 col-form-label">Position</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="position" id="position" value="{{ $testimonial->position }}" placeholder="Position">
            </div>
        </div>
        <div class="form-group row">
            <label for="image" class="col-sm-2 col-form-label">Image</label>
            <div class="col-sm-10">
                <input type="file" class="form-control-file" name="image" id="image" placeholder="Image">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <img src="{{asset('storage/uploads/testimonial/' . $testimonial->image)}}" alt="" width="200" height="200">
            </div>
        </div>
        <div class="form-group row">
            <label for="comment" class="col-sm-2 col-form-label">Comment</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="comment" id="comment" cols="30" rows="10" placeholder="Comment"><?= $testimonial->comment ?></textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="status" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
                <select class="form-control" name="status" id="status">
                    <option value="Active" <?= $testimonial->status === 'Active' ? "selected" : ""; ?>>Active</option>
                    <option value="Inactive" <?= $testimonial->status === 'Inactive' ? "selected" : ""; ?>>Inactive</option>
                </select>
            </div>
        </div>

        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</div>