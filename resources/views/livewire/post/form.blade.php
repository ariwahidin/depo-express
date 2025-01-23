<div class="card">
    @if (session()->has('success'))
    <livewire:component.alert />
    @endif
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Form Post</h5> <small class="text-muted float-end">Default form</small>
    </div>
    <div class="card-body">
        <form wire:submit.prevent="create">
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
                <label class="form-label" for="">Title</label>
                <input type="text" wire:model="title" class="form-control">
                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="mb-6">
                <label class="form-label" for="">Body</label>
                <textarea class="form-control" wire:model="body"></textarea>
                @error('body') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="btn btn-primary waves-effect waves-light">Send</button>
        </form>
    </div>
</div>