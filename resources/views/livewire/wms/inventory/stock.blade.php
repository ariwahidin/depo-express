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
                <button type="button" style="width: 200px;" class="btn btn-success d-none" wire:click="exportExcel">Excel</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table style="font-size: 12px;" class="table table-sm">
                <thead class="table-info">
                    <tr>
                        <th>No.</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Location</th>
                        <th>Qty In</th>
                        <th>Qty Out</th>
                        <th>Qty Avail</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($stocks as $stock)
                    <tr>
                        <td>{{ $loop->iteration + ($stocks->currentPage() - 1) * $stocks->perPage() }}</td>
                        <td>{{ $stock->item_code }}</td>
                        <td>{{ $stock->item_name }}</td>
                        <td>{{ $stock->location }}</td>
                        <td>{{ $stock->total_qty_in }}</td>
                        <td>{{ $stock->total_qty_out }}</td>
                        <td>{{ $stock->total_qty_avail }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $stocks->links() }}
    </div>
</div>