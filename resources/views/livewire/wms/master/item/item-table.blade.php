<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="mb-0">Items</h5>
                </div>
                <div class="col-md-12 mt-2 d-flex gap-2">
                    <div style="width: 300px;" class="input-group input-group-merge">
                        <input type="text" wire:model.live="search" class="form-control" placeholder="Search..." aria-label="Search..." />
                        <span class="input-group-text"><i class="ti ti-search"></i></span>
                    </div>
                    <button type="button" class="btn btn-success" wire:click="exportExcel">Excel</button>
                    <a href="javascript:void(0);" wire:click="$dispatch('newForm')" class="btn btn-primary" >New</a>
                    <button type="button" class="btn btn-info float-end" wire:click="$dispatch('reload')">
                        <i class="ti ti-refresh me-1"></i>
                        Refresh
                    </button>
                </div>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th>No.</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Price</th>
                        <th>UoM</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($items as $item)
                    <tr>
                        <td>{{ $loop->iteration + ($items->currentPage() - 1) * $items->perPage() }}</td>
                        <td>{{ $item->item_code }}</td>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->uom }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item waves-effect" href="javascript:void(0);" wire:click="$dispatch('edit', {id: {{ $item->id }}})"><i class="ti ti-pencil me-1"></i> Edit</a>
                                    <a class="dropdown-item waves-effect" href="javascript:void(0);" wire:click="$dispatch('showDeleteModalNow', {id : {{ $item->id }}})"><i class="ti ti-trash me-1"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $items->links() }}
        </div>
    </div>
</div>