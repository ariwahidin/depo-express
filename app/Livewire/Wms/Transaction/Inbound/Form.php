<?php

namespace App\Livewire\Wms\Transaction\Inbound;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public $headerData = [];
    public $items = [];
    public $itemPilihan = [];
    public $whsOptions = [];
    public $line_added = 1;
    public $inbound_id;
    public $edit = false;
    public $status_proccess = 'open';
    public $inbound;
    public $suppliers, $transporters, $truck_sizes, $origins;
    public $is_submit = false;


    public function mount(Request $request)
    {

        if ($request->query('id')) {
            $this->inbound_id = $request->query('id');
            \App\Models\InboundHeader::findOrFail($this->inbound_id); // cek apakah id ada di database atau tidak jika tidak ada akan error 404
            $this->edit = true;
        }

        if ($this->edit) {

            $header = \App\Models\InboundHeader::with(['suppliers', 'transporters'])
                ->where('id', $this->inbound_id)
                ->first();

            $this->inbound = $header;
            $this->status_proccess = $header->status_proccess;
            $this->headerData = [
                'receive_id' => $header->receive_id,
                'received_date' => date('Y-m-d'),
                'truck_time_arrival' => date('H:i'),
                'start_unloading' => $header->start_unloading,
                'end_unloading' => $header->end_unloading,
                'doc_no' => $header->doc_no,
                'sj_no' => $header->sj_no,
                'po_date' => $header->po_date,
                'original_country' => '',
                'remarks' => $header->remarks,
                'invoice_no' => $header->invoice_no,
                'supplier' => $header->supplier_code,
                'supplier_name' => $header->suppliers->name,
                'transporter' => $header->truck_code,
                'transporter_name' => $header->transporters->name,
                'driver' => $header->driver,
                'truck_no' => $header->truck_no,
                'truck_size' => $header->size_id,
                'container_no' => $header->container_no,
                'bl_no' => $header->bl,
                'ib_status' => $header->ib_type,
                'koli' => $header->koli,
                'seal' => $header->seal,
                'original_country' => $header->country,
            ];

            $detail = \App\Models\InboundDetail::where('inbound_id', $this->inbound_id)->get();

            foreach ($detail as $d) {
                $item = \App\Models\Item::where('item_code', $d->item_code)->first();
                $this->items[] =
                    [
                        'id' => $d->id,
                        'item_code' => $d->item_code,
                        'item_name' => $item->item_name,
                        'barcode_ean' => $item->barcode_ean,
                        'waranty' => $item->waranty,
                        'location' => $d->location,
                        'received_date' => $d->receive_date,
                        'adaptor' => $item->adaptor,
                        'price' => $d->price,
                        'manual_book' => $item->manual_book,
                        'sn' => $item->sn,
                        'warehouse' => $d->wh_code,
                        'quantity' => $d->req_qty,
                        'remarks' => $d->remarks
                    ];
            }
        } else {
            $transporter = \App\Models\Transporter::where('code', 'EXP-0001')->first();
            $supplier = \App\Models\Supplier::where('code', 'SUP-0001')->first();

            // dd($supplier, $transporter);
            $this->headerData = [
                'receive_id' => 'Auto Generate',
                'received_date' => date('Y-m-d'),
                'truck_time_arrival' => date('H:i'),
                'start_unloading' => date('H:i'),
                'end_unloading' => date('H:i'),
                'doc_no' => '',
                'sj_no' => '',
                'po_date' => date('Y-m-d'),
                'original_country' => '',
                'remarks' => '',
                'invoice_no' => 'OTHER',
                'supplier' => $supplier->code,
                'supplier_name' => $supplier->name,
                'transporter' => $transporter->code,
                'transporter_name' => $transporter->name,
                'driver' => 'OTHER',
                'truck_no' => 'B 1234 ABC',
                'truck_size' => '',
                'container_no' => '',
                'bl_no' => '',
                'ib_status' => '',
                'koli' => 0,
                'seal' => 0,
                'container_no' => '',
                'size_id' => 0,
            ];
            $this->addItem();
        }

        $this->itemPilihan = \App\Models\Item::all();
        $this->whsOptions = \App\Models\Warehouse::all();
        $this->suppliers = \App\Models\Supplier::where('delete_status', 'no')->orderByDesc('created_at')->get();
        $this->transporters = \App\Models\Transporter::where('delete_status', 'no')->orderByDesc('created_at')->get();
        $this->truck_sizes = \App\Models\TruckSize::where('delete_status', 'no')->orderByDesc('created_at')->get();
        $this->origins = \App\Models\Origin::where('delete_status', 'no')->orderByDesc('created_at')->get();
    }

    public function selectSupplier($code, $name)
    {
        $this->headerData['supplier'] = $code;
        $this->headerData['supplier_name'] = $name;
    }

    public function selectTransporter($code, $name)
    {
        $this->headerData['transporter'] = $code;
        $this->headerData['transporter_name'] = $name;
    }

    public function render()
    {
        return view('livewire.wms.transaction.inbound.form');
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->dispatch('livewire-update');
    }

    private function validateInput(): bool
    {
        $this->validate([
            'headerData.received_date' => 'required',
            // 'headerData.start_unloading' => 'required',
            // 'headerData.end_unloading' => 'required',
            'headerData.doc_no' => 'required',
            'headerData.sj_no' => 'required',
            'headerData.po_date' => 'required',
            // 'headerData.original_country' => 'required',
            // 'headerData.remarks' => 'required',
            'headerData.invoice_no' => 'required',
            'headerData.supplier' => 'required',
            'headerData.transporter' => 'required',
            'headerData.driver' => 'required',
            'headerData.truck_no' => 'required',
            // 'headerData.truck_size' => 'required',
            // 'headerData.container_no' => 'required',
            // 'headerData.bl_no' => 'required',
            // 'headerData.ib_status' => 'required',
            // 'headerData.koli' => 'required', 
            // 'headerData.seal' => 'required',
        ]);


        if (empty($this->items)) {
            session()->flash('error', 'Items cannot be empty');
            return false;
        }

        foreach ($this->items as $item) {
            if (empty($item['item_code']) || $item['item_code'] == '') {
                session()->flash('error', 'Item code cannot must be filled');
                return false;
            }

            if (empty($item['quantity']) || $item['quantity'] < 1) {
                session()->flash('error', 'Quantity cannot must be filled');
                return false;
            }

            if (empty($item['price']) || $item['price'] < 1) {
                session()->flash('error', 'Price cannot must be filled');
                return false;
            }

            if (empty($item['warehouse'])) {
                session()->flash('error', 'Warehouse cannot must be filled');
                return false;
            }
        }

        return true;
    }

    public function create()
    {

        // dd($this->headerData, $this->items);

        if ($this->is_submit) {
            session()->flash('error', 'Please wait...');
            return;
        }

        // validasi tidak boleh ada item_code yang kosong
        if (!$this->validateInput()) {
            return;
        }

        try {
            DB::beginTransaction();

            $newReceivedId = \App\Models\InboundHeader::generateReceivedId();
            $transNo = \App\Models\Trans::getTransNo();

            $dataInboundHeader = [
                'received_date' => $this->headerData['received_date'],
                'receive_id' => $newReceivedId,
                'trans_no' => $transNo,
                'supplier_code' => $this->headerData['supplier'],
                'truck_code' => $this->headerData['transporter'],
                'location' => '',
                'start_time' => $this->headerData['start_unloading'],
                'end_time' => $this->headerData['end_unloading'],
                'sj_no' => $this->headerData['sj_no'],
                'doc_no' => $this->headerData['doc_no'],
                'invoice_no' => $this->headerData['invoice_no'],
                'container_no' => $this->headerData['container_no'],
                'po_date' => $this->headerData['po_date'],
                'site' => 0,
                'truck_no' => $this->headerData['truck_no'],
                'remarks' => $this->headerData['remarks'],
                'driver' => $this->headerData['driver'],
                'stat' => 0,
                'bl' => $this->headerData['bl_no'],
                'aju' => 0,
                'size_id' => $this->headerData['truck_size'],
                'start_unloading' => $this->headerData['start_unloading'],
                'end_unloading' => $this->headerData['end_unloading'],
                'dos' => '',
                'ib_type' => $this->headerData['ib_status'],
                'status_proccess' => 'open',
                'koli' => $this->headerData['koli'],
                'seal' => $this->headerData['seal'],
                'wh_code' => '',
                'country' => $this->headerData['original_country'],
                'created_by' => Auth::id(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            // dd($dataInboundHeader);

            $inboundHeader = \App\Models\InboundHeader::create($dataInboundHeader);
            $inbound_id = $inboundHeader->id;
            $receive_id = $inboundHeader->receive_id;

            foreach ($this->items as $item) {
                $dataItemDetail = [
                    'inbound_id' => $inbound_id,
                    'receive_id' => $receive_id,
                    'item_code' => $item['item_code'],
                    'location' => $item['location'],
                    'price' => (float)str_replace(',', '', $item['price']),
                    'receive_date' => $item['received_date'],
                    'req_qty' => $item['quantity'],
                    'scan_qty' => 0,
                    'wh_code' => $item['warehouse'],
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id()
                ];

                // dd($dataItemDetail);
                \App\Models\InboundDetail::create($dataItemDetail);
            }

            DB::commit();
            $this->is_submit = true;
            session()->flash('success', 'Inbound created successfully');
            return redirect()->route('inbound');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', $th->getMessage());
            return;
        }
    }

    public function update()
    {

        // dd($this->headerData, $this->items);

        // check if receive_id is exist and status is open
        $inbound = \App\Models\InboundHeader::where('receive_id', $this->headerData['receive_id'])
            ->where('status_proccess', 'open')
            ->firstOrFail();

        if (!$this->validateInput()) {
            return;
        }


        try {
            DB::beginTransaction();

            $inbound->received_date = $this->headerData['received_date'];
            $inbound->supplier_code = $this->headerData['supplier'];
            $inbound->truck_code = $this->headerData['transporter'];
            $inbound->start_time = $this->headerData['start_unloading'];
            $inbound->end_time = $this->headerData['end_unloading'];
            $inbound->sj_no = $this->headerData['sj_no'];
            $inbound->doc_no = $this->headerData['doc_no'];
            $inbound->invoice_no = $this->headerData['invoice_no'];
            $inbound->container_no = $this->headerData['container_no'];
            $inbound->po_date = $this->headerData['po_date'];
            $inbound->site = 0;
            $inbound->truck_no = $this->headerData['truck_no'];
            $inbound->remarks = $this->headerData['remarks'];
            $inbound->driver = $this->headerData['driver'];
            $inbound->bl = $this->headerData['bl_no'];
            $inbound->size_id = $this->headerData['truck_size'];
            $inbound->start_unloading = $this->headerData['start_unloading'];
            $inbound->end_unloading = $this->headerData['end_unloading'];
            $inbound->dos = '';
            $inbound->ib_type = $this->headerData['ib_status'];
            $inbound->koli = $this->headerData['koli'];
            $inbound->seal = $this->headerData['seal'];
            $inbound->country = $this->headerData['original_country'];
            $inbound->updated_by = Auth::id();
            $inbound->updated_at = date('Y-m-d H:i:s');
            $inbound->save();

            // delete all item detail
            \App\Models\InboundDetail::where('inbound_id', $inbound->id)->delete();

            foreach ($this->items as $item) {
                $dataItemDetail = [
                    'inbound_id' => $inbound->id,
                    'receive_id' => $inbound->receive_id,
                    'item_code' => $item['item_code'],
                    'location' => $item['location'],
                    'price' => (float)str_replace(',', '', $item['price']),
                    'receive_date' => $item['received_date'],
                    'req_qty' => $item['quantity'],
                    'scan_qty' => 0,
                    'wh_code' => $item['warehouse'],
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id()
                ];
                \App\Models\InboundDetail::create($dataItemDetail);
            }

            DB::commit();
            session()->flash('success', 'Inbound updated successfully');
            return redirect()->route('inbound');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', $th->getMessage());
            return;
        }
    }

    public function addItem()
    {

        $this->validate([
            'line_added' => 'required | numeric | min:1 | max:50',
        ]);

        for ($i = 1; $i <= $this->line_added; $i++) {
            array_push(
                $this->items,
                [
                    'id' => Str::random(10),
                    'item_code' => '',
                    'item_name' => '',
                    'barcode_ean' => '',
                    'waranty' => '',
                    'location' => 'STAGING',
                    'received_date' => date('Y-m-d'),
                    'adaptor' => '',
                    'manual_book' => '',
                    'sn' => '',
                    'warehouse' => '',
                    'quantity' => 1,
                    'remarks' => ''
                ]
            );
        }
    }

    #[\Livewire\Attributes\On('updateSelectItem')]
    public function updateSelectItem($index, $value)
    {
        // dd($index, $value);
        $this->items[$index]['item_code'] = $value;
        $item_code = $value;
        $item = \App\Models\Item::where('item_code', $item_code)->firstOrFail();
        $this->items[$index]['item_name'] = $item->item_name;
        $this->items[$index]['barcode_ean'] = $item->barcode_ean;
        $this->items[$index]['waranty'] = $item->waranty;
        $this->items[$index]['manual_book'] = $item->manual_book;
        $this->items[$index]['adaptor'] = $item->adaptor;
        $this->items[$index]['sn'] = $item->sn;
    }
}
