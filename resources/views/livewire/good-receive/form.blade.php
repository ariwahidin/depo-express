<div>
    @if (session()->has('success'))
    <livewire:component.alert />
    @endif
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Form Product</h5> <small class="text-muted float-end">Default form</small>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="create">
                <div class="mb-6">
                    <label class="form-label" for="">Supplier</label>
                    <select name="" class="form-control" wire:model="supplier_id">
                        <option value="">Select Supplier</option>
                        @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                    @error('supplier_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
                    <label class="form-label" for="">Product</label>
                    <select name="" class="form-control" wire:model="product_id">
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                    @error('product_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
                    <label class="form-label" for="">Quantity</label>
                    <input type="text" wire:model="quantity" class="form-control">
                    @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Send</button>
            </form>
        </div>
    </div>
</div>