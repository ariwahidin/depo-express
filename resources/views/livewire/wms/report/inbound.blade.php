<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="row">
            <div class="col-md-12">
                <h5 class="mb-0">Report Inbound</h5>
            </div>
            <div class="col-md-12 mt-2 d-flex justify-content-between gap-2 align-items-center">
                <div class="input-group w-70">
                    <span class="input-group-text">Start Date</span>
                    <input type="date" wire:model.live="start_date" class="form-control" placeholder="Date" aria-label="Date">
                </div>
                <div class="input-group w-70">
                    <span class="input-group-text">End Date</span>
                    <input type="date" wire:model.live="end_date" class="form-control" placeholder="Date" aria-label="Date">
                </div>
                <select class="form-select" style="width: 120px;" wire:model.change="status">
                    <option value="">All</option>
                    <option value="open">Open</option>
                    <option value="closed">Closed</option>
                </select>
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
            <table style="font-size: 12px;" class="table table-sm" id="tableInbound">
                <thead class="table-info">
                    <tr>
                        <th>No.</th>
                        <th>Inbound No.</th>
                        <th>Received Date</th>
                        <th>Status</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Qty</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @php $no = 1; @endphp
                    @foreach ($inbounds as $inbound)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $inbound->receive_id }}</td>
                        <td>{{ $inbound->receive_date }}</td>
                        <td>{{ $inbound->status_proccess }}</td>
                        <td>{{ $inbound->item_code }}</td>
                        <td>{{ $inbound->item_name }}</td>
                        <td>{{ $inbound->req_qty }}</td>
                        <td>{{ Number::currency($inbound->price, in: 'IDR') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $inbounds->links() }}
    </div>
</div>