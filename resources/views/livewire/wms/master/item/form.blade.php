<div>
    <!-- Order Details Card -->
    <div class="card shadow-sm">
        <div style="height: 50px;" class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0 text-white"> {{ $edit ? 'Form Edit Items' : 'Form Create Items' }} </h6>
        </div>
        <div class="card-body pt-2">
            <div class="mt-2 table-responsive">
                <table class="table table-sm table-bordered table-nowrap" style="font-size: small;">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Item Code</th>
                            <th>Item Name</th>
                            <th>UoM</th>
                            <th>Price</th>
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
                                <input type="text" class="form-control-sm" wire:model="items.{{$index}}.item_code" required>
                                @error('items.'.$index.'.item_code') <br> <span class="text-danger">{{ $message }}</span> @enderror
                            </td>
                            <td>
                                <input type="text" class="form-control-sm" wire:model="items.{{$index}}.item_name" required>
                                @error('items.'.$index.'.item_name') <br> <span class="text-danger">{{ $message }}</span> @enderror
                            </td>
                            <td>
                                <select class="form-select-sm" wire:model="items.{{$index}}.uom">
                                    <option value="">-- Select UoM --</option>
                                    @foreach($uoms as $uom)
                                    <option value="{{ $uom }}">{{ $uom }}</option>
                                    @endforeach
                                </select>
                                @error('items.'.$index.'.uom') <br> <span class="text-danger">{{ $message }}</span> @enderror
                            </td>
                            <td>
                                <input type="number" class="form-control-sm" wire:model="items.{{$index}}.price" required>
                                @error('items.'.$index.'.price') <br> <span class="text-danger">{{ $message }}</span> @enderror
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-danger" wire:click="removeItem({{ $index }})">x</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            @if(!$edit)
            <button type="button"
                wire:click="addItem"
                wire:loading.attr="disabled"
                class="btn btn-sm btn-success">
                Add line
                <span wire:loading wire:target="addItem" class="ms-2 spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </button>
            @endif
        </div>
    </div>

    <div class="text-end mt-3 mb-3">
        @if(session()->has('success'))
        <livewire:component.alert />
        @endif
        <button type="button"
            class="btn btn-primary"
            {{ $is_submit ? 'disabled' : '' }}
            wire:click="{{ $edit ? 'update' : 'create' }}"
            wire:loading.attr="disabled">

            {{ $edit ? 'Update' : 'Create' }}
            <span wire:loading wire:target="{{ $edit ? 'update' : 'create' }}" class="ms-2 spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        </button>
    </div>
</div>