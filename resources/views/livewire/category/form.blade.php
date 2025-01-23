<div>
    @if (session()->has('success'))
    <livewire:component.alert />
    @endif
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Form Category</h5> <small class="text-muted float-end">Default form</small>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="{{ $edit ? 'update' : 'create' }}">
                <div class="mb-6">
                    <label class="form-label" for="">Category Name</label>
                    <input type="text" class="form-control" wire:model="category">
                    <input type="hidden" wire:model="category_id">
                    <input type="hidden" wire:model="edit">
                    @error('category') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="button" wire:click="cancel" class="btn btn-danger waves-effect waves-light">Cancel</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light">
                    @if ($edit) Update @else Create @endif
                </button>
            </form>
        </div>
    </div>
</div>