<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="mb-0">List Inbound</h5>
                </div>
                <div class="col-md-12 mt-2 d-flex justify-content-between gap-2 align-items-center">
                    <div class="input-group input-group-merge">
                        <input type="text" wire:model.live="search" style="width: 70px;" class="form-control" placeholder="Search..." aria-label="Search..." />
                        <span class="input-group-text"><i class="ti ti-search"></i></span>
                    </div>
                    <select name="" id="" class="form-select" style="width: 120px;" wire:model.change="status">
                        <option value="all">All</option>
                        <option value="open">Open</option>
                        <option value="closed">Closed</option>
                    </select>
                    <button type="button" class="btn btn-success d-none" wire:click="exportExcel">Excel</button>
                    <a href="{{ route('inbound-create') }}" class="btn btn-primary">New</a>
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
                        <th>Inbound No.</th>
                        <th>Received Date</th>
                        <th>Status</th>
                        <th>Total Item</th>
                        <th>Total Qty</th>
                        <th>Total Price</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($inbounds as $inbound)
                    <tr>
                        <td>{{ $loop->iteration + ($inbounds->currentPage() - 1) * $inbounds->perPage() }}</td>
                        <td>{{ $inbound->receive_id }}</td>
                        <td>{{ $inbound->received_date }}</td>
                        <td>
                            @if ($inbound->status_proccess == 'closed')
                            <span class="badge bg-label-success me-1">
                                {{ $inbound->status_proccess }}
                            </span>
                            @else
                            <span class="badge bg-label-danger me-1">
                                {{ $inbound->status_proccess }}
                            </span>
                            @endif
                        </td>
                        <td>{{ $inbound->total_items }}</td>
                        <td>{{ $inbound->total_qty }}</td>
                        <td>{{ Number::currency($inbound->total_price, in: 'IDR') }}</td>
                        <td>{{ $inbound->remarks }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                <div class="dropdown-menu">
                                    @if ($inbound->status_proccess == 'open')
                                    <a class="dropdown-item waves-effect" href="javascript:void(0);" wire:click="close({{ $inbound->id }})"><i class="ti ti-check me-1"></i> Close</a>
                                    @endif
                                    <a class="dropdown-item waves-effect" href="{{ route('inbound-create', ['id' => $inbound->id]) }}" wire:navigate.hover><i class="ti {{ $inbound->status_proccess == 'open' ? 'ti-pencil' : 'ti-eye' }} me-1"></i> {{ $inbound->status_proccess == 'open' ? 'Edit' : 'View' }}</a>
                                    @if ($inbound->status_proccess == 'open')
                                    <a class="dropdown-item waves-effect" href="javascript:void(0);" wire:click="$dispatch('showDeleteModalNow', {id : {{ $inbound->id }}})"><i class="ti ti-trash me-1"></i> Delete</a>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $inbounds->links() }}
        </div>
    </div>
    <livewire:wms.transaction.inbound.delete />
</div>