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
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0 text-white">Inbound Transaction</h6>
            </div>
            <div class="card-body mt-3">
                <div class="row g-2">
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <td>
                                    <label class="form-label small">Receive ID</label>
                                </td>
                                <td> :
                                    <input type="text" class="form-control-sm" wire:model="headerData.receive_id" readonly required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label small">Receive Date</label>
                                </td>
                                <td> :
                                    <input type="date" wire:model="headerData.received_date" class="form-control-sm" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label small">Truck Time Arrival</label>
                                </td>
                                <td> :
                                    <input type="time" class="form-control-sm" wire:model="headerData.truck_time_arrival" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label small">Unloading Time</label>
                                </td>
                                <td>
                                    <label class="form-label small">Start : </label>
                                    <input type="time" class="form-control-sm" wire:model="headerData.start_unloading" required>
                                    <label class="form-label small">End : </label>
                                    <input type="time" class="form-control-sm" wire:model="headerData.end_unloading" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label small">PO/Doc. No.</label>
                                </td>
                                <td> :
                                    <input type="text" class="form-control-sm" wire:model="headerData.doc_no" required>
                                    @error('headerData.doc_no') <br> <span class="text-danger">{{ $message }}</span> @enderror
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label small">PO Date</label>
                                </td>
                                <td> :
                                    <input type="date" class="form-control-sm" wire:model="headerData.po_date" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label small">SJ No.</label>
                                </td>
                                <td> :
                                    <input type="text" wire:model="headerData.sj_no" class="form-control-sm" required>
                                    @error('headerData.sj_no') <br> <span class="text-danger">{{ $message }}</span> @enderror
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label small">Original Country</label>
                                </td>
                                <td class="d-flex"> :
                                    <select class="ms-1 form-select-sm w-50 border-2 border-dark" wire:model="headerData.original_country">
                                        <option value="">Select Country</option>
                                        @foreach($origins as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('headerData.original_country') <br> <span class="text-danger">{{ $message }}</span> @enderror
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label small">Remarks </label>
                                </td>
                                <td> :
                                    <textarea class="form-control-sm" wire:model="headerData.remarks" rows="2" cols="50" required></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <td>
                                    <label class="form-label small">Invoice No</label>
                                </td>
                                <td> :
                                    <input type="text" class="form-control-sm" wire:model="headerData.invoice_no" required>
                                    @error('headerData.invoice_no') <br> <span class="text-danger">{{ $message }}</span> @enderror
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label small">Supplier</label>
                                </td>
                                <td class="d-flex"> :
                                    <div class="ms-1 input-group input-group-sm">
                                        <input style="width: 100px;" type="text" class="form-control-sm" wire:model="headerData.supplier" readonly required>
                                        <input type="text" class="form-control-sm" wire:model="headerData.supplier_name" readonly required>
                                        <button type="button" class="btn btn-sm btn-primary" x-on:click="openModalSupplier()">
                                            <i class="ti ti-search"></i>
                                        </button>
                                        @error('headerData.supplier') <br> <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label small">Transporter</label>
                                </td>
                                <td class="d-flex"> :
                                    <div class="ms-1 input-group input-group-sm">
                                        <input style="width: 100px;" type="text" class="form-control-sm" readonly wire:model="headerData.transporter"
                                            required>
                                        <input type="text" class="form-control-sm" wire:model="headerData.transporter_name" readonly required>
                                        <button type="button" class="btn btn-sm btn-primary" x-on:click="openModalTransporter()">
                                            <i class="ti ti-search"></i>
                                        </button>
                                        @error('headerData.transporter') <br> <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label small">Driver Name</label>
                                </td>
                                <td> :
                                    <input type="text" class="form-control-sm" wire:model="headerData.driver" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label small">Truck No. / Truck Size</label>
                                </td>
                                <td class="d-flex"> :
                                    <div class="ms-1 input-group input-group-sm">
                                        <input style="width: 100px;" type="text" class="form-control-sm" wire:model="headerData.truck_no" required>
                                        <select class="form-select border-2 border-dark" wire:model="headerData.truck_size">
                                            @foreach($truck_sizes as $truckSize)
                                            <option value="{{ $truckSize->id }}">{{ $truckSize->code }}</option>
                                            @endforeach
                                        </select>
                                        @error('headerData.truck_no') <br> <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label small">Container No.</label>
                                </td>
                                <td> :
                                    <input type="text" class="form-control-sm" wire:model="headerData.container_no" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label small">BL No.</label>
                                </td>
                                <td> :
                                    <input type="text" class="form-control-sm" wire:model="headerData.bl_no" required>
                                    @error('headerData.bl_no') <br> <span class="text-danger">{{ $message }}</span> @enderror
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="form-label small">IB Status.</label>
                                </td>
                                <td class="d-flex"> :
                                    <select class="ms-1 form-select-sm w-50" wire:model="headerData.ib_status">
                                        <option value="">Select Status</option>
                                        <option value="NORMAL">NORMAL</option>
                                        <option value="RETURN">RETURN</option>
                                        <option value="GATSU">GATSU</option>
                                    </select>
                                    @error('headerData.ib_status') <br> <span class="text-danger">{{ $message }}</span> @enderror
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
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 text-white">Items</h6>
            </div>
            <div class="card-body pt-2">
                <div class="mt-2 table-responsive">
                    <table class="table table-sm table-bordered table-nowrap" style="font-size: small;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>UoM</th>
                                <th>Location</th>
                                <th>Rec .Date</th>
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
                                    <input style="width: 100px;" type="number" class="form-control-sm" wire:model="items.{{$index}}.quantity" required>
                                </td>
                                <td>
                                    <input style="width: 150px;" type="text" class="form-control-sm" x-mask:dynamic="$money($input)" wire:model="items.{{$index}}.price" required>
                                </td>
                                <td>
                                    <input style="width: 100px;" type="text" class="form-control-sm" wire:model="items.{{$index}}.uom" readonly required>
                                </td>
                                <td>
                                    <input style="width: 100px;" type="text" class="form-control-sm" wire:model="items.{{$index}}.location" required>
                                </td>
                                <td>
                                    <input type="date" class="form-control-sm" wire:model="items.{{$index}}.received_date" required>
                                </td>

                                <td>
                                    <select wire:model="items.{{$index}}.warehouse" class="form-select-sm">
                                        <option value="">Select</option>
                                        @foreach($whsOptions as $wh)
                                        <option value="{{ $wh->code }}">{{ $wh->code }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="text-center">
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
        <div class="modal fade" id="modalSupplier" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Supplier</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control-sm" placeholder="Search" wire:model="searchSupplier">
                        <table class="table table-sm table-nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Code.</th>
                                    <th>Supplier</th>
                                    <th>Select</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($suppliers as $supplier)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $supplier->code }}</td>
                                    <td>{{ $supplier->name }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-primary" wire:click="selectSupplier('{{ $supplier->code }}', '{{ $supplier->name }}')" data-bs-dismiss="modal">Select</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" x-on:click="$wire.deleteCategory(id)" data-bs-dismiss="modal">Delete</button>
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
                        <table class="table table-sm table-nowrap">
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
                        <button type="button" class="btn btn-danger" x-on:click="$wire.deleteCategory(id)" data-bs-dismiss="modal">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    function openModalSupplier() {
        $('#modalSupplier').modal('show');
    }

    function openModalTransporter() {
        $('#modalTransporter').modal('show');
    }
</script>
@endpush