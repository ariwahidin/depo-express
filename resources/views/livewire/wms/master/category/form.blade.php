<div>
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">{{ $edit ? 'Update' : 'Create' }} Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="{{ $edit ? 'update' : 'create' }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Category Name</label>
                                <input type="hidden" wire:model="id">
                                <input type="text" class="form-control" wire:model="name" placeholder="Category Name">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">{{ $edit ? 'Update' : 'Create' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('showCreateModalNow', event => {
            $('#createModal').modal('show');
        });

        window.addEventListener('hideCreateModalNow', event => {
            $('#createModal').modal('hide');
        })
    </script>
</div>
