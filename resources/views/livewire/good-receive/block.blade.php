<div class="card">
    <h5 class="card-header">Table Product
        <button class="btn btn-primary float-end" wire:click="confirm">Confirm</button>
    </h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Supplier</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($receipts as $receipt)
                <tr>
                    <td><i class="ti ti-brand-angular ti-md text-danger me-4"></i> <span class="fw-medium">{{ $receipt->supplier->name }}</span></td>
                    <td><i class="ti ti-brand-angular ti-md text-danger me-4"></i> <span class="fw-medium">{{ $receipt->product->name }}</span></td>
                    <td>{{ $receipt->quantity }}</td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item waves-effect" href="javascript:void(0);" wire:click="edit({{ $receipt->id }})"><i class="ti ti-pencil me-1"></i> Edit</a>
                                <a class="dropdown-item waves-effect" href="javascript:void(0);" @click="$dispatch('showDeleteModalNow', {id : {{ $receipt->id }}})"><i class="ti ti-trash me-1"></i> Delete</a>
                                @if ($receipt->status == 'active')
                                <a class="dropdown-item waves-effect" href="javascript:void(0);" wire:click="deactivate({{ $receipt->id }})"><i class="ti ti-toggle-left me-1"></i> Deactivate</a>
                                @else
                                <a class="dropdown-item waves-effect" href="javascript:void(0);" wire:click="activate({{ $receipt->id }})"><i class="ti ti-toggle-right me-1"></i> Activate</a>
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