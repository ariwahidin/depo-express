<?php

namespace App\Livewire\Wms\Transaction\Outbound;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Form extends Component
{
    public $headerData = [];
    public $items = [];
    public $itemPilihan = [];
    public $whsOptions = [];
    public $line_added = 1;
    public $outbound_id;
    public $edit = false;
    public $status_proccess = 'open';
    public $outbound;
    public $customers, $transporters, $truck_sizes, $origins;

    public $is_submit = false;
    public function render()
    {
        return view('livewire.wms.transaction.outbound.form');
    }

    public function mount(Request $request)
    {

        if ($request->query('id')) {
            $this->outbound_id = $request->query('id');

            // dd($this->outbound_id);
            \App\Models\OutboundHeader::findOrFail($this->outbound_id); // cek apakah id ada di database atau tidak jika tidak ada akan error 404
            $this->edit = true;
        }

        if ($this->edit) {

            $header = \App\Models\OutboundHeader::with(['customers', 'delivery_customers','transporters'])
                ->where('id', $this->outbound_id)
                ->first();

            $this->outbound = $header;
            $this->status_proccess = $header->status_proccess;
            $this->headerData = [
                'outbound_no' => $header->outbound_no,
                'plan_pickup_date' => $header->plan_pickup_date,
                'picking_date' => $header->picking_date,
                'rec_do_date' => $header->rec_do_date,
                'rec_do_time' => $header->rec_do_time,
                'customer_code' => $header->customer_code,
                'customer_name' => $header->customers->name,
                'customer_address' => $header->customers->address,
                'delivery_customer_code' => $header->delivery_customer_code,
                'delivery_customer_name' => $header->delivery_customers->name,
                'delivery_customer_address' => $header->delivery_customers->address,
                'start_picking' => $header->start_picking,
                'end_picking' => $header->end_picking,
                'picker_name' => $header->picker_name,
                'truck_code' => $header->truck_code,
                'trucker_name' => $header->transporters->name,
                'truck_no' => $header->truck_no,
                'truck_size' => $header->truck_size,
                'driver' => $header->driver,
                'remarks' => $header->remarks,
                'destination' => $header->destination,
                'customer_code' => $header->customer_code,
                'delivery_customer_code' => $header->delivery_customer_code,
                'koli' => $header->koli,
                'seal' => $header->seal,
            ];

            $detail = \App\Models\OutboundDetail::where('outbound_id', $this->outbound_id)->get();

            foreach ($detail as $d) {
                $item = \App\Models\Item::where('item_code', $d->item_code)->first();
                $this->items[] =
                    [
                        'id' => $d->id,
                        'do_no' => $d->do_no,
                        'item_code' => $d->item_code,
                        'item_name' => $item->item_name,
                        'barcode_ean' => $item->barcode_ean,
                        'waranty' => $item->waranty,
                        'location' => $d->location,
                        'adaptor' => $item->adaptor,
                        'manual_book' => $item->manual_book,
                        'sn' => $item->sn,
                        'status_qa' => $d->status_qa,
                        'warehouse' => $d->wh_code,
                        'quantity' => $d->req_qty,
                        'remarks' => $d->remarks,

                        // 'id' => Str::random(10),
                        // 'do_no' => '',
                        // 'item_code' => '',
                        // 'item_name' => '',
                        // 'barcode_ean' => '',
                        // 'waranty' => '',
                        // 'location' => 'STAGING',
                        // 'adaptor' => '',
                        // 'manual_book' => '',
                        // 'sn' => '',
                        // 'status_qa' => 'A',
                        // 'warehouse' => '',
                        // 'quantity' => 1,
                        // 'remarks' => ''
                    ];
            }
        } else {
            $customer = \App\Models\Customer::where('code', 'CUS-0001')->first();
            $trucker = \App\Models\Transporter::where('code', 'EXP-0001')->first();
            $this->headerData = [
                'outbound_no' => 'Auto Generate',
                'plan_pickup_date' => date('Y-m-d'),
                'picking_date' => date('Y-m-d'),
                'rec_do_date' => date('Y-m-d'),
                'rec_do_time' => date('H:i'),
                'start_picking' => date('H:i'),
                'end_picking' => date('H:i'),
                'picker_name' => '',
                'truck_code' => $trucker->code,
                'trucker_name' => $trucker->name,
                'truck_no' => '',
                'truck_size' => '',
                'driver' => '',
                'remarks' => '',
                'destination' => '',
                'customer_code' => $customer->code,
                'customer_name' => $customer->name,
                'customer_address' => $customer->address,
                'delivery_customer_code' => $customer->code,
                'delivery_customer_name' => $customer->name,
                'delivery_customer_address' => $customer->address,
                'koli' => 0,
                'seal' => 0,
            ];
            $this->addItem();
        }

        $this->itemPilihan = \App\Models\Item::all();
        $this->whsOptions = \App\Models\Warehouse::all();
        $this->customers = \App\Models\Customer::where('delete_status', 'no')->orderByDesc('created_at')->get();
        $this->transporters = \App\Models\Transporter::where('delete_status', 'no')->orderByDesc('created_at')->get();
        $this->truck_sizes = \App\Models\TruckSize::where('delete_status', 'no')->orderByDesc('created_at')->get();
        $this->origins = \App\Models\Origin::where('delete_status', 'no')->orderByDesc('created_at')->get();
    }

    public function selectCustomer($code, $name, $address)
    {
        $this->headerData['customer_code'] = $code;
        $this->headerData['customer_name'] = $name;
        $this->headerData['customer_address'] = $address;
    }
    public function selectDeliveryCustomer($code, $name, $address)
    {
        $this->headerData['delivery_customer_code'] = $code;
        $this->headerData['delivery_customer_name'] = $name;
        $this->headerData['delivery_customer_address'] = $address;
    }

    public function selectTransporter($code, $name)
    {
        $this->headerData['truck_code'] = $code;
        $this->headerData['trucker_name'] = $name;
    }

    private function validateInput(): bool
    {
        $this->validate([
            'headerData.outbound_no' => 'required',
            'headerData.plan_pickup_date' => 'required',
            'headerData.picking_date' => 'required',
            'headerData.rec_do_date' => 'required',
            'headerData.rec_do_time' => 'required',
            'headerData.start_picking' => 'required',
            'headerData.end_picking' => 'required',
            'headerData.picker_name' => 'required',
            'headerData.truck_code' => 'required',
            'headerData.trucker_name' => 'required',
            // 'headerData.truck_no' => 'required',
            // 'headerData.truck_size' => 'required',
            // 'headerData.driver' => 'required',
            // 'headerData.destination' => 'required',
            'headerData.customer_code' => 'required',
            'headerData.delivery_customer_code' => 'required',
        ]);


        if (empty($this->items)) {
            session()->flash('error', 'Items cannot be empty');
            return false;
        }

        foreach ($this->items as $item) {
            // if (empty($item['do_no']) || $item['do_no'] == '') {
            //     session()->flash('error', 'DO cannot must be filled');
            //     return false;
            // }
            if (empty($item['item_code']) || $item['item_code'] == '') {
                session()->flash('error', 'Item code cannot must be filled');
                return false;
            }

            if (empty($item['quantity']) || $item['quantity'] < 1) {
                session()->flash('error', 'Quantity cannot must be filled');
                return false;
            }

            if (empty($item['warehouse'])) {
                session()->flash('error', 'Warehouse cannot must be filled');
                return false;
            }
        }

        return true;
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
                    'do_no' => '',
                    'item_code' => '',
                    'item_name' => '',
                    'barcode_ean' => '',
                    'waranty' => '',
                    'location' => '',
                    'adaptor' => '',
                    'manual_book' => '',
                    'sn' => '',
                    'status_qa' => 'A',
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

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->dispatch('livewire-update');
    }

    public function create()
    {

        if ($this->is_submit) {
            session()->flash('error', 'Please wait...');
            return;
        }

        if (!$this->validateInput()) {
            return;
        }

        // dd($this->headerData, $this->items);

        try {

            DB::beginTransaction();

            $newOutboundNo = \App\Models\OutboundHeader::generateOutboundNo();
            $transNo = \App\Models\Trans::getTransNo();

            $dataOutboundHeader = [
                'outbound_no' => $newOutboundNo,
                'trans_no' => $transNo,
                'plan_pickup_date' => $this->headerData['plan_pickup_date'],
                'picking_date' => $this->headerData['picking_date'],
                'rec_do_date' => $this->headerData['rec_do_date'],
                'rec_do_time' => $this->headerData['rec_do_time'],
                'start_picking' => $this->headerData['start_picking'],
                'end_picking' => $this->headerData['end_picking'],
                'picker_name' => $this->headerData['picker_name'],
                'truck_no' => $this->headerData['truck_no'],
                'truck_code' => $this->headerData['truck_code'],
                'truck_size' => $this->headerData['truck_size'],
                'driver' => $this->headerData['driver'],
                'remarks' => $this->headerData['remarks'],
                'destination' => $this->headerData['destination'],
                'customer_code' => $this->headerData['customer_code'],
                'delivery_customer_code' => $this->headerData['delivery_customer_code'],
                'koli' => $this->headerData['koli'],
                'seal' => $this->headerData['seal'],
                'created_by' => Auth::id(),
            ];


            $outboundHeader = \App\Models\OutboundHeader::create($dataOutboundHeader);

            foreach ($this->items as $item) {

                $dataItems = [
                    'outbound_id' => $outboundHeader->id,
                    'outbound_no' => $outboundHeader->outbound_no,
                    'do_no' => $item['do_no'],
                    'item_code' => $item['item_code'],
                    'location' => $item['location'],
                    'wh_code' => $item['warehouse'],
                    'req_qty' => $item['quantity'],
                    'status_qa' => $item['status_qa'],
                    'remarks' => $item['remarks'],
                    'created_by' => Auth::id(),
                ];
                \App\Models\OutboundDetail::create($dataItems);
            }

            DB::commit();
            $this->is_submit = true;
            session()->flash('success', 'Outbound created successfully');
            return redirect()->route('outbound');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function update()
    {

        if ($this->is_submit) {
            session()->flash('error', 'Please wait...');
            return;
        }

        // check if receive_id is exist and status is open
        $outbound = \App\Models\OutboundHeader::where('outbound_no', $this->headerData['outbound_no'])
            ->where('status_proccess', 'open')
            ->firstOrFail();

        if (!$this->validateInput()) {
            return;
        }


        // dd($this->headerData, $this->items);


        try {
            DB::beginTransaction();

            $outbound->plan_pickup_date = $this->headerData['plan_pickup_date'];
            $outbound->picking_date = $this->headerData['picking_date'];
            $outbound->rec_do_date = $this->headerData['rec_do_date'];
            $outbound->rec_do_time = $this->headerData['rec_do_time'];
            $outbound->start_picking = $this->headerData['start_picking'];
            $outbound->end_picking = $this->headerData['end_picking'];
            $outbound->picker_name = $this->headerData['picker_name'];
            $outbound->truck_no = $this->headerData['truck_no'];
            $outbound->truck_code = $this->headerData['truck_code'];
            $outbound->truck_size = $this->headerData['truck_size'];
            $outbound->driver = $this->headerData['driver'];
            $outbound->remarks = $this->headerData['remarks'];
            $outbound->destination = $this->headerData['destination'];
            $outbound->customer_code = $this->headerData['customer_code'];
            $outbound->delivery_customer_code = $this->headerData['delivery_customer_code'];
            $outbound->koli = $this->headerData['koli'];
            $outbound->seal = $this->headerData['seal'];
            $outbound->updated_by = Auth::id();
            $outbound->save();

            // delete all item detail
            \App\Models\OutboundDetail::where('outbound_id', $outbound->id)->delete();

            foreach ($this->items as $item) {

                $dataItems = [
                    'outbound_id' => $outbound->id,
                    'outbound_no' => $outbound->outbound_no,
                    'do_no' => $item['do_no'],
                    'item_code' => $item['item_code'],
                    'location' => $item['location'],
                    'wh_code' => $item['warehouse'],
                    'req_qty' => $item['quantity'],
                    'status_qa' => $item['status_qa'],
                    'remarks' => $item['remarks'],
                    'created_by' => Auth::id(),
                ];
                \App\Models\OutboundDetail::create($dataItems);
            }

            DB::commit();
            $this->is_submit = true;
            session()->flash('success', 'Outbound updated successfully');
            return redirect()->route('outbound');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Error update outbound: " . $th->getMessage());
            session()->flash('error', $th->getMessage());
            return;
        }
    }

    #[\Livewire\Attributes\On('selectLocation')]
    public function selectLocation($index, $location)
    {
        $this->items[$index]['location'] = $location;
        $this->dispatch('closeModalStock');
    }
}
