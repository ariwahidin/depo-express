<div>
    @if (session()->has('success'))
    <livewire:component.alert />
    @endif
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Form Product</h5> <small class="text-muted float-end">Default form</small>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="{{ $edit ? 'update' : 'create' }}">
                <div class="mb-6">
                    <label class="form-label" for="">Category</label>
                    <select name="" class="form-control" wire:model="category_id">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
                    <label class="form-label" for="">Code</label>
                    <div class="input-group d-flex">
                        <input type="hidden" wire:model="product_id">
                        <input type="text" wire:model="code" class="form-control d-flex" minlength="13" maxlength="13" placeholder="0000000000000">
                        <button type="button" wire:click="generateCode" class="btn btn-primary waves-effect waves-light d-block"><i class="ti ti-reload"></i></button>
                    </div>

                    @error('code') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
                    <label class="form-label" for="">Name</label>
                    <input type="text" wire:model="name" class="form-control">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
                    <label class="form-label" for="">Price</label>
                    <input x-mask:dynamic="$money($input)" wire:model="price" class="form-control">
                    @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary waves-effect waves-light">{{ $edit ? 'Update' : 'Create' }}</button>
            </form>
        </div>
    </div>
</div>