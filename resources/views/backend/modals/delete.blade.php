<form action="{{ $action }}" method="POST">
    @csrf
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="delete_ids" id="delete_ids" value="">
    <!-- Modal -->
    <div class="modal fade modal-super-scaled show modal-warning" id="modal_delete_{{ $modal_id }}" aria-hidden="true"
         aria-labelledby="exampleModalWarning" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Please Wait!</h4>
                </div>
                <div class="modal-body">
                    <p>Do you really want to delete {{ $name }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Proceed to Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
</form>