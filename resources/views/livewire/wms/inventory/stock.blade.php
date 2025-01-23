<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="row">
            <div class="col-md-12">
                <h5 class="mb-0">Inventory Stock</h5>
            </div>
            <div class="col-md-12 mt-2 d-flex justify-content-between gap-2 align-items-center">
                <div class="input-group input-group-merge">
                    <input type="text" wire:model.live="search" style="width: 70px;" class="form-control" placeholder="Search..." aria-label="Search..." />
                    <span class="input-group-text"><i class="ti ti-search"></i></span>
                </div>
                <button type="button" class="btn btn-success" wire:click="exportExcel">Excel</button>
                <button type="button" class="btn btn-info" style="width: 150px;" wire:click="$dispatch('reload')">
                    <i class="ti ti-refresh me-1"></i>
                    Refresh
                </button>
            </div>
        </div>
    </div>
    <div class="table-responsive text-nowrap">
        <table style="font-size: 12px;" class="table table-sm">
            <thead class="table-dark">
                <tr>
                    <th>No.</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Location</th>
                    <th>Qty Avail</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($stocks as $stock)
                <tr>
                    <td>{{ $loop->iteration + ($stocks->currentPage() - 1) * $stocks->perPage() }}</td>
                    <td>{{ $stock->item_code }}</td>
                    <td>{{ $stock->item_name }}</td>
                    <td>{{ $stock->location }}</td>
                    <td>{{ $stock->qty_avail }}</td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item waves-effect" href="javascript:void(0);" wire:click="detail({{ $stock->id }})" wire:navigate.hover><i class="ti ti-eye me-1"></i> Detail</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $stocks->links() }}
    </div>
</div>