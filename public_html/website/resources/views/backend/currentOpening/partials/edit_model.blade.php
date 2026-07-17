<div class="modal-header">
    <h4 class="modal-title">Edit Opening</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">

    <form class="form-horizontal" id="updateCurrentOpening" method="POST" action="{{route('current-opening-update', $currentOpening->id)}}">
        @csrf
        <div class="form-group row">
            <label for="title" class="col-sm-2 col-form-label">Title</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="title" id="title" value="{{ $currentOpening->title }}" placeholder="Title">
            </div>
        </div>

        <div class="form-group row">
            <label for="description-edit" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="description" id="description-edit" cols="30" rows="10" placeholder="Description">{{ $currentOpening->description }}</textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="status" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
                <select class="form-control" name="status" id="status">
                    <option value="Active" <?= $currentOpening->status === 'Active' ? "selected" : ""; ?>>Active</option>
                    <option value="Inactive" <?= $currentOpening->status === 'Inactive' ? "selected" : ""; ?>>Inactive</option>
                </select>
            </div>
        </div>

        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</div>

@push('before-script')
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
@endpush
@push('script')
<script>
    CKEDITOR.replace('description');
</script>
@endpush