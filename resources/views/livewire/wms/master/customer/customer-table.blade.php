<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="mb-0">Customer</h5>
                </div>
                <div class="col-md-6 mt-2">
                    <div class="input-group input-group-merge">
                        <input type="text" wire:model.live="search" class="form-control" placeholder="Search..." aria-label="Search..." />
                        <span class="input-group-text"><i class="ti ti-search"></i></span>
                    </div>
                </div>
                <!-- Button for excel convert -->
                <div class="col-md-2 mt-2">
                    <button type="button" class="btn btn-success" wire:click="exportExcel">Excel</button>
                </div>
                <!-- Button create new -->
                <div class="col-md-2 mt-2">
                    <button type="button" class="btn btn-primary" wire:click="$dispatch('showCreateModalNow')">New</button>
                </div>
                <!-- button to refresh table on end page -->
                <div class="col-md-2 mt-2">
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
                        <th>Customer ID</th>
                        <th>Customer Name</th>
                        <th>Address</th>
                        <th>Area</th>
                        <th>City</th>
                        <th>Country</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($customers as $customer)
                    <tr>
                        <td>{{ $loop->iteration + ($customers->currentPage() - 1) * $customers->perPage() }}</td>
                        <td>{{ $customer->code }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->address }}</td>
                        <td>{{ $customer->area }}</td>
                        <td>{{ $customer->city }}</td>
                        <td>{{ $customer->country }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item waves-effect" href="javascript:void(0);" wire:click="$dispatch('edit', {id: {{ $customer->id }}})"><i class="ti ti-pencil me-1"></i> Edit</a>
                                    <a class="dropdown-item waves-effect" href="javascript:void(0);" wire:click="$dispatch('showDeleteModalNow', {id : {{ $customer->id }}})"><i class="ti ti-trash me-1"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $customers->links() }}
        </div>
    </div>
</div>