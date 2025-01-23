<div class="card">
    <h5 class="card-header">Table Product</h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Code</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($products as $product)
                <tr>
                    <td><i class="ti ti-brand-angular ti-md text-danger me-4"></i> <span class="fw-medium">{{ $product->category->name }}</span></td>
                    <td><i class="ti ti-brand-angular ti-md text-danger me-4"></i> <span class="fw-medium">{{ $product->code }}</span></td>
                    <td><i class="ti ti-brand-angular ti-md text-danger me-4"></i> <span class="fw-medium">{{ $product->name }}</span></td>
                    <td><i class="ti ti-brand-angular ti-md text-danger me-4"></i> <span class="fw-medium">{{ Illuminate\Support\Number::currency($product->price, 'IDR') }}</span></td>
                    <td>
                        @if ($product->status == 'active')
                        <span class="badge bg-label-success me-1">Active</span>
                        @else
                        <span class="badge bg-label-danger me-1">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item waves-effect" href="javascript:void(0);" wire:click="$dispatch('editProduct', {product_id: {{ $product->id }}})"><i class="ti ti-pencil me-1"></i> Edit</a>
                                <a class="dropdown-item waves-effect" href="javascript:void(0);" wire:click="$dispatch('showDeleteModalNow', {id : {{ $product->id }}})"><i class="ti ti-trash me-1"></i> Delete</a>
                                @if ($product->status == 'active')
                                <a class="dropdown-item waves-effect" href="javascript:void(0);" wire:click="deactivate({{ $product->id }})"><i class="ti ti-toggle-left me-1"></i> Deactivate</a>
                                @else
                                <a class="dropdown-item waves-effect" href="javascript:void(0);" wire:click="activate({{ $product->id }})"><i class="ti ti-toggle-right me-1"></i> Activate</a>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>