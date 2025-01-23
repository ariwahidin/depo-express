<div>
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">{{ $edit ? 'Update' : 'Create' }} Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="{{ $edit ? 'update' : 'create' }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Supplier ID</label>
                                <input type="hidden" wire:model="id">
                                <input type="text" class="form-control" wire:model="code" placeholder="Supplier ID">
                                @error('code') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label">Supplier Name</label>
                                <input type="text" class="form-control" wire:model="name" placeholder="Supplier Name">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" wire:model="address"  placeholder="Address">
                                @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" wire:model="city" placeholder="City">
                                @error('city') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" class="form-control" wire:model="country" placeholder="Country">
                                @error('country') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" wire:model="phone" placeholder="Phone">
                                @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" wire:model="email" placeholder="Email">
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="contact_person" class="form-label">Pic</label>
                                <input type="text" class="form-control" wire:model="pic" placeholder="Contact Person">
                                @error('pic') <span class="text-danger">{{ $message }}</span> @enderror
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