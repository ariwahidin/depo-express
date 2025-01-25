<div class="row">
    <style>
        .card-header {
            padding: 0.9rem 1rem;
        }

        table tr td {
            padding-bottom: 5px;
        }
    </style>

    <div class="col-md-12">
        <!-- Customer Information Card -->
        <div class="card mb-3 shadow-sm">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0 text-white">Outbound Transaction</h6>
            </div>
            <div class="card-body mt-3">
                <div class="row g-2">
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <td>
                                    <label class="form-label small">Outbound No.</label>
                                </td>
                                <td> :
                                    <input type="text" class="form-control-sm" wire:model="headerData.outbound_no" readonly required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label small">Plan Pickup Date</label>
                                </td>
                                <td> :
                                    <input type="date" wire:model="headerData.plan_pickup_date" class="form-control-sm" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label small">Picking Date</label>
                                </td>
                                <td> :
                                    <input type="date" wire:model="headerData.picking_date" class="form-control-sm" required>
                                    @error('headerData.picking_date') <br> <span class="text-danger">{{ $message }}</span> @enderror
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label small">Receiving DO Date / Time</label>
                                </td>
                                <td class="d-flex gap-1"> :
                                    <input type="date" class="form-control-sm" wire:model="headerData.rec_do_date" required>
                                    <input type="time" class="form-control-sm" wire:model="headerData.rec_do_time" required>
                                    @error('headerData.rec_do_date') <br> <span class="text-danger">{{ $message }}</span> @enderror
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label small">Picker Name</label>
                                </td>
                                <td> :
                                    <input type="text" class="form-control-sm" wire:model="headerData.picker_name" required>
                                    @error('headerData.picker_name') <br> <span class="text-danger">{{ $message }}</span> @enderror
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    <label class="form-label small">Trucker</label>
                                </td>
                                <td class="d-flex"> :
                                    <div class="ms-1 input-group input-group-sm">
                                        <input style="width: 100px;" type="text" class="form-control-sm" wire:model="headerData.truck_code" readonly required>
                                        <input type="text" class="form-control-sm" wire:model="headerData.trucker_name" readonly required>
                                        <button type="button" class="btn btn-sm btn-primary" x-on:click="openModalTransporter()">
                                            <i class="ti ti-search"></i>
                                        </button>
                                        @error('headerData.truck_code') <br> <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label class="form-label small">Truck No. / Size</label>
                                </td>
                                <td class="d-flex gap-1"> :
                                    <input type="text" class="form-control-sm" wire:model="headerData.truck_no" required>
                                    <input type="text" class="form-control-sm" wire:model="headerData.truck_size" required>
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    <label class="form-label small">Driver Name</label>
                                </td>
                                <td> :
                                    <input type="text" class="form-control-sm" wire:model="headerData.driver" required>
                                    @error('headerData.driver') <br> <span class="text-danger">{{ $message }}</span> @enderror
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label small">Remarks </label>
                                </td>
                                <td> :
                                    <textarea class="form-control-sm" wire:model="headerData.remarks" rows="2" cols="50" required></textarea>
                                    @error('headerData.remarks') <br> <span class="text-danger">{{ $message }}</span> @enderror
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <td>
                                    <label class="form-label small">Destination.</label>
                                </td>
                                <td> :
                                    <select class="ms-1 form-select-sm w-50" wire:model="headerData.destination">
                                        <option value="">Select Destination</option>
                                        <option value="LOCAL">LOCAL</option>
                                        <option value="EXPORT">EXPORT</option>
                                    </select>
                                    @error('headerData.destination') <br> <span class="text-danger">{{ $message }}</span> @enderror
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label small">Customer / Dealer</label>
                                </td>
                                <td>
                                    <div class="ms-1 input-group input-group-sm d-flex">
                                        <input style="width: 100px;" type="text" class="form-control-sm" wire:model="headerData.customer_code" readonly required>
                                        <input type="text" class="form-control-sm" wire:model="headerData.customer_name" readonly required>
                                        <button type="button" class="btn btn-sm btn-primary" x-on:click="openModalCustomer()">
                                            <i class="ti ti-search"></i>
                                        </button>
                                    </div>
                                    <textarea class="form-control-sm mt-1 ms-1" wire:model="headerData.customer_address" rows="2" cols="40" required></textarea>
                                    @error('headerData.customer_code') <br> <span class="text-danger">{{ $message }}</span> @enderror

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label small">Delivery Address</label>
                                </td>
                                <td>
                                    <div class="ms-1 input-group input-group-sm d-flex">
                                        <input style="width: 100px;" type="text" class="form-control-sm" wire:model="headerData.delivery_customer_code" readonly required>
                                        <input type="text" class="form-control-sm" wire:model="headerData.delivery_customer_address" readonly required>
                                        <button type="button" class="btn btn-sm btn-primary" x-on:click="openModalCustomerDestination()">
                                            <i class="ti ti-search"></i>
                                        </button>
                                    </div>
                                    <textarea class="form-control-sm mt-1 ms-1" wire:model="headerData.delivery_customer_address" rows="2" cols="40" required></textarea>
                                    @error('headerData.delivery_customer_code') <br> <span class="text-danger">{{ $message }}</span> @enderror

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label small">Koli / Seal</label>
                                </td>
                                <td class="d-flex"> :
                                    <div class="input-group input-group-sm ms-1">
                                        <input style="width:100px;" type="number" wire:model="headerData.koli" class="form-control-sm" required>
                                        <input style="width: 100px;" type="number" wire:model="headerData.seal" class="form-control-sm" required>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>



        <!-- Order Details Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 text-white">Items</h6>
            </div>
            <div class="card-body pt-2">
                <div class="mt-2 table-responsive">
                    <table class="table table-sm table-bordered table-nowrap" style="font-size: small;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Item</th>
                                <th>Location</th>
                                <th>Req Qty</th>
                                <th>UoM</th>
                                <th>WH Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($items as $index => $item)
                            <tr wire:key="item-{{ $item['id'] }}" :key="'item-'.{{ $item['id'] }}">
                                <td>
                                    {{ $no++ }}
                                </td>
                                <td>
                                    <span style="font-size: 12px;">Item Name : {{ $item['item_name'] }}</span><br>
                                    <livewire:wms.transaction.inbound.form-select-item :itemSelected="$item['item_code']" :itemOptions="$itemPilihan" :key="$item['id']" wire:key="item-{{ $item['id'] }}" :index="$index" />
                                    <input type="text" class="form-control-sm mt-1" placeholder="remarks" wire:model="items.{{$index}}.remarks">
                                </td>
                                <td>
                                    <input style="width: 100px;" type="text" class="form-control-sm" wire:model="items.{{$index}}.location" required>
                                </td>
                                <td>
                                    <input style="width: 100px;" type="number" class="form-control-sm" wire:model="items.{{$index}}.quantity" required>
                                </td>
                                <td>
                                    <input style="width: 100px;" type="text" class="form-control-sm" wire:model="items.{{$index}}.uom" readonly required>
                                </td>
                                <td>
                                    <select style="width: 100px;" wire:model="items.{{$index}}.warehouse" class="form-select-sm">
                                        <option value="">Select</option>
                                        @foreach($whsOptions as $wh)
                                        <option value="{{ $wh->code }}">{{ $wh->code }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary" @click="$dispatch('checkStock', { index: {{ $index }}, item_code: '{{ $item['item_code'] }}' })"> <i class="ti ti-search"></i></button>
                                    <button type="button" class="btn btn-sm btn-danger" wire:click="removeItem({{ $index }})"><i class="ti ti-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                @if($status_proccess == 'open')
                <button type="button"
                    wire:click="addItem"
                    wire:loading.attr="disabled"
                    class="btn btn-sm btn-success">
                    Add line
                    <span wire:loading wire:target="addItem" class="ms-2 spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </button>
                @error('line_added') <span class="error text-danger">{{ $message }}</span> @enderror
                @endif
            </div>
        </div>




        <div class="text-end mt-3">
            @if($status_proccess == 'open')
            <button type="button"
                class="btn btn-primary"
                {{ $is_submit ? 'disabled' : '' }}
                wire:click="{{ $edit ? 'update' : 'create' }}"
                wire:loading.attr="disabled">

                {{ $edit ? 'Update' : 'Create' }}
                <span wire:loading wire:target="{{ $edit ? 'update' : 'create' }}" class="ms-2 spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </button>
            @if(session()->has('error'))
            <div class="text-danger">
                {{ session('error') }}
            </div>
            @endif
            @endif
        </div>
    </div>

    <div>
        <div class="modal fade" id="modalCustomer" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Customers</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table style="font-size: 12px;" class="table table-sm table-nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Code.</th>
                                    <th>Customer Name</th>
                                    <th>Address</th>
                                    <th>Select</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($customers as $customer)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $customer->code }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-primary" wire:click="selectCustomer('{{ $customer->code }}', '{{ $customer->name }}', '{{ $customer->address }}')" data-bs-dismiss="modal">Select</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="modal fade" id="modalCustomerDestination" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Customers</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table style="font-size: 12px;" class="table table-sm table-nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Code.</th>
                                    <th>Customer Name</th>
                                    <th>Address</th>
                                    <th>Select</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($customers as $customer)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $customer->code }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-primary" wire:click="selectDeliveryCustomer('{{ $customer->code }}', '{{ $customer->name }}', '{{ $customer->address }}')" data-bs-dismiss="modal">Select</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="modal fade" id="modalTransporter" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Transporter</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control-sm" placeholder="Search" wire:model="searchSupplier">
                        <table style="font-size: 12px;" class="table table-sm table-nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Code.</th>
                                    <th>Transporter Name</th>
                                    <th>Select</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($transporters as $transporter)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $transporter->code }}</td>
                                    <td>{{ $transporter->name }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-primary" wire:click="selectTransporter('{{ $transporter->code }}', '{{ $transporter->name }}')" data-bs-dismiss="modal">Select</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <livewire:wms.transaction.outbound.modal-stock />
</div>

@assets
<!-- <link rel="stylesheet" href="{{ asset('/') }}assets/vendor/libs/select2/select2.css" />
<script src="{{ asset('/') }}assets/vendor/libs/select2/select2.js"></script> -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endassets

@push('scripts')
<script>
    function openModalCustomer() {
        $('#modalCustomer').modal('show');
    }

    function openModalCustomerDestination() {
        $('#modalCustomerDestination').modal('show');
    }

    function openModalTransporter() {
        $('#modalTransporter').modal('show');
    }
</script>
@endpush