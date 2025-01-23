<div>
    <div class="modal fade" id="deleteModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this product?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" x-on:click="deleteProduct()" data-bs-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        let id;
        window.addEventListener('showDeleteModalNow', event => {
            id = event.detail.id;
            $('#deleteModal').modal('show');
        })

        function deleteProduct() {
            Livewire.dispatch('delete-product', {
                id: id});
        }
    </script>
</div>