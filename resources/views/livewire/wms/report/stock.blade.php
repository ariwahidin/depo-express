<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="row">
            <div class="col-md-12">
                <h5 class="mb-0">Report Stock</h5>
            </div>
            <div class="col-md-12 mt-2 d-flex justify-content-between gap-2 align-items-center">
                <div class="input-group w-70 d-none">
                    <span class="input-group-text">Periode Date</span>
                    <input type="date" wire:model.live="periode_date" class="form-control" placeholder="Date" aria-label="Date">
                </div>
                <div class="input-group input-group-merge">
                    <input type="text" wire:model.live="search" style="width: 70px;" class="form-control" placeholder="Search..." aria-label="Search..." />
                    <span class="input-group-text"><i class="ti ti-search"></i></span>
                </div>
                <button type="button" style="width: 200px;" class="btn btn-success" wire:click="exportExcel">Excel</button>
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
                        <th>Qty IN</th>
                        <th>Total Price IN</th>
                        <th>AVG price/qty IN</th>
                        <th>Qty OUT</th>
                        <th>Qty Stock</th>
                        <th>Total Stock Value</th>
                    </tr>
                </thead>

                <tbody class="table-border-bottom-0">
                    @php $no = 1; @endphp
                    @foreach ($stocks as $stock)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $stock->item_code }}</td>
                        <td>{{ $stock->item_name }}</td>
                        <td>{{ $stock->qty_in }}</td>
                        <td>{{ Number::currency($stock->total_price, in: 'IDR') }}</td>
                        <td>{{ Number::currency($stock->avg_price_per_qty_in, in: 'IDR') }}</td>
                        <td>{{ $stock->qty_out }}</td>
                        <td>{{ $stock->qty_stock }}</td>
                        <td>{{ Number::currency($stock->total_stock_value, in: 'IDR') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>