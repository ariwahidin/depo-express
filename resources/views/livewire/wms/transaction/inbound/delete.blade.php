<div>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this inbound?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" x-on:click="$wire.delete(id)" data-bs-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        let id;
        window.addEventListener('showDeleteModalNow', event => {
            $('#deleteModal').modal('show');
            id = event.detail.id;
        });

        window.addEventListener('hideDeleteModalNow', event => {
            $('#deleteModal').modal('hide');
        })
    </script>
</div>