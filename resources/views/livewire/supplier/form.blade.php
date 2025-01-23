<div>
    @if (session()->has('success'))
    <livewire:component.alert />
    @endif
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Form Supplier</h5> <small class="text-muted float-end">Default form</small>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="create">
                <div class="mb-6">
                    <label class="form-label" for="">Name</label>
                    <input type="text" wire:model="name" class="form-control">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Send</button>
            </form>
        </div>
    </div>
</div>
