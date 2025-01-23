<?php

namespace App\Livewire\Wms\Master\Item;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Str;

class Form extends Component
{
    public $items = [];
    public $uoms  = [
        'PCS',
        'BOX',
    ];
    public $line_added = 1;
    public $is_submit = false;
    public $edit = false;

    public function mount()
    {
        $this->addItem();
    }
    public function render()
    {
        return view('livewire.wms.master.item.form');
    }

    public function addItem()
    {

        for ($i = 1; $i <= $this->line_added; $i++) {
            array_push(
                $this->items,
                [
                    'id' => Str::random(10),
                    'item_code' => '',
                    'item_name' => '',
                    'uom' => '',
                    'price' => '',
                ]
            );
        }
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
    }

    public function create()
    {
        // $this->is_submit = true;
        $this->validate([
            'items.*.item_code' => 'required | unique:items,item_code',
            'items.*.item_name' => 'required',
            'items.*.uom' => 'required',
            'items.*.price' => 'required',
        ]);

        // insert to Items
        DB::beginTransaction();
        try {
            foreach ($this->items as $item) {
                $item = \App\Models\Item::create([
                    'item_code' => $item['item_code'],
                    'barcode_ean' => $item['item_name'],
                    'area' => 'OTHER',
                    'barcode_model' => $item['item_code'],
                    'item_name' => $item['item_name'],
                    'price' => $item['price'],
                    'owner' => 'OTHER',
                    'std_pallet' => 0,

                    'width' => 0,
                    'length' => 0,
                    'height' => 0,
                    'uom' => $item['uom'],
                    'kubikasi' => 0,
                    'kubikasi_sap' => 0,
                    'gross_weight' => 0,
                    'net_weight' => 0,

                    'category' => 'OTHER',
                    'group' => 'OTHER',

                    'sap_code' => '',
                    'sap_description' => '',
                    'val_type' => '',

                    'waranty' =>  'N',
                    'manual_book' => 'N',
                    'adaptor' => 'N',
                    'sn' => 'N',
                    'remarks' => '',
                ]);
            }
            DB::commit();
            session()->flash('success', 'Data has been created successfully');
            $this->reset();
            $this->dispatch('reload');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error create item: " . $e->getMessage());
        }
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($id)
    {
        // dd($id);
        $this->edit = true;
        $this->items = \App\Models\Item::where('id', $id)->get()->toArray();

        // dd($this->items);
    }

    public function update()
    {
        $this->validate([
            'items.*.item_code' => 'required',
            'items.*.item_name' => 'required',
            'items.*.uom' => 'required',
            'items.*.price' => 'required',
        ]);

        // dd($this->items);

        DB::beginTransaction();
        try {
            foreach ($this->items as $item) {
                \App\Models\Item::where('id', $item['id'])
                    ->update([
                        'item_code' => $item['item_code'],
                        'item_name' => $item['item_name'],
                        'uom' => $item['uom'],
                        'price' => $item['price'],
                    ]);
            }
            DB::commit();
            session()->flash('success', 'Data has been updated successfully');
            $this->reset();
            $this->edit = false;
            $this->dispatch('reload');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error update item: " . $e->getMessage());
        }
    }

    #[\Livewire\Attributes\On('newForm')]
    public function newForm()
    {
        $this->reset();
        $this->edit = false;
        $this->addItem();
    }
}
