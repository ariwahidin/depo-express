<div>
    @if(session()->has('error'))
    <div class="text-danger">
        {{ session('error') }}
    </div>
    @endif
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="mb-0">List Outbound</h5>
                </div>
                <div class="col-md-12 mt-2 d-flex justify-content-between gap-2 align-items-center">
                    <div class="input-group input-group-merge">
                        <input type="text" wire:model.live="search" style="width: 70px;" class="form-control" placeholder="Search..." aria-label="Search..." />
                        <span class="input-group-text"><i class="ti ti-search"></i></span>
                    </div>
                    <select name="" id="" class="form-select" style="width: 120px;" wire:model.change="status">
                        <option value="all">All</option>
                        <option value="open">Open</option>
                        <option value="completed">Completed</option>
                    </select>
                    <button type="button" class="btn btn-success d-none" wire:click="exportExcel">Excel</button>
                    <a href="{{ route('outbound-create') }}" class="btn btn-primary">New</a>
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
                        <th>Outbound No.</th>
                        <th>Picking Date</th>
                        <th>Status</th>
                        <th>Total Item</th>
                        <th>Total Qty</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($outbounds as $outbound)
                    <tr>
                        <td>{{ $loop->iteration + ($outbounds->currentPage() - 1) * $outbounds->perPage() }}</td>
                        <td>{{ $outbound->outbound_no }}</td>
                        <td>{{ $outbound->picking_date }}</td>
                        <td>
                            @if ($outbound->status_proccess == 'open')
                            <span class="badge bg-label-warning">Open</span>
                            @else
                            <span class="badge bg-label-success">Completed</span>
                            @endif
                        </td>
                        <td>{{ $outbound->total_items }}</td>
                        <td>{{ $outbound->total_qty }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                <div class="dropdown-menu">
                                    @if ($outbound->status_proccess == 'open')
                                    <a class="dropdown-item waves-effect" href="javascript:void(0);" wire:click="close({{ $outbound->id }})"><i class="ti ti-check me-1"></i> Close</a>
                                    @endif
                                    <a class="dropdown-item waves-effect" href="{{ route('outbound-create', ['id' => $outbound->id]) }}" wire:navigate.hover><i class="ti ti-pencil me-1"></i> Edit</a>
                                    <a class="dropdown-item waves-effect" href="javascript:void(0);" wire:click="$dispatch('showDeleteModalNow', {id : {{ $outbound->id }}})"><i class="ti ti-trash me-1"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $outbounds->links() }}
        </div>
    </div>

    <livewire:component.error-toast />
</div>