<?php

namespace App\Livewire\Wms\Transaction\Outbound;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    public $status = 'all';

    #[\Livewire\Attributes\Title('List Outbound')] 
    public function render()
    {
        return view('livewire.wms.transaction.outbound.index', [
            'outbounds' => $this->getOutbound(),
        ]);
    }

    private function getOutbound()
    {
        return \App\Models\OutboundHeader::where('outbound_headers.delete_status', 'no')
            ->join('customers', 'customers.code', '=', 'outbound_headers.customer_code')
            ->join('transporters', 'transporters.code', '=', 'outbound_headers.truck_code')
            ->leftJoin('outbound_details', 'outbound_details.outbound_id', '=', 'outbound_headers.id')
            ->where(function ($query) {
                $query->where('outbound_headers.id', 'like', '%' . $this->search . '%')
                    ->orWhere('outbound_headers.customer_code', 'like', '%' . $this->search . '%')
                    ->orWhere('outbound_headers.driver', 'like', '%' . $this->search . '%')
                    ->orWhere('outbound_headers.remarks', 'like', '%' . $this->search . '%')
                    ->orWhere('outbound_headers.destination', 'like', '%' . $this->search . '%')
                    ->orWhere('customers.name', 'like', '%' . $this->search . '%');
            })
            ->where(function ($query) {
                if ($this->status == 'open') {
                    $query->where('outbound_headers.status_proccess', 'open');
                } elseif ($this->status == 'completed') {
                    $query->where('outbound_headers.status_proccess', 'completed');
                }
            })
            ->select(
                'outbound_headers.*',
                'customers.name as customer_name',
                DB::raw('COUNT(outbound_details.item_code) as total_items'),
                DB::raw('SUM(outbound_details.req_qty) as total_qty')
            )
            ->groupBy('outbound_headers.id')
            ->orderByDesc('outbound_headers.created_at')
            ->paginate(10);
    }

    public function close($id)
    {

        \App\Models\OutboundHeader::where('id', $id)
            ->where('status_proccess', 'open')
            ->firstOrFail(); // Check if the inbound is open


        try {
            DB::beginTransaction();

            // Ambil data header outbound
            $outbound_header = \App\Models\OutboundHeader::where('id', $id)
                ->where('status_proccess', 'open')
                ->lockForUpdate()
                ->firstOrFail();

            // Ambil data detail outbound
            $outbound_detail = \App\Models\OutboundDetail::where('outbound_id', $id)
                ->where('status', 'open')
                ->get();

            // dd($outbound_detail);

            if ($outbound_detail->isEmpty()) {
                session()->flash('error', 'No outbound details found to process.');
                throw new \Exception('No outbound details found to process.');
            }

            foreach ($outbound_detail as $item) {

                if ($item->location != "") {
                    try {
                        $this->processOutboundItemWithLocation($item, $outbound_header);
                    } catch (\Exception $e) {
                        Log::error("Failed to process outbound item: {$e->getMessage()}");
                        throw $e;
                    }
                } else {
                    try {
                        $this->processOutboundItem($item, $outbound_header);
                    } catch (\Exception $e) {
                        Log::error("Failed to process outbound item: {$e->getMessage()}");
                        throw $e;
                    }
                }
            }

            // Update status header inbound menjadi closed
            $outbound_header->update([
                'status_proccess' => 'completed',
                'updated_by' => Auth::id(),
                'updated_at' => now(),
                'completed_by' => Auth::id(),
                'completed_at' => now(),
            ]);

            // Update status transaksi
            \App\Models\Trans::where('trans_no', $outbound_header->trans_no)
                ->update(
                    [
                        'trans_status' => 'closed',
                        'updated_at' => now(),
                    ]
                );

            DB::commit();
            session()->flash('success', 'Outbound closed successfully');
            return redirect()->route('outbound');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to close outbound: {$e->getMessage()}");
            session()->flash('error', "Failed to close outbound {$outbound_header->outbound_no} : {$e->getMessage()}");
            return redirect()->back();
        }
    }

    private function processOutboundItemWithLocation($item, $outbound_header)
    {

        $stocks = \App\Models\Pallet::where('pallets.item_code', $item->item_code)
            ->join('stocks', 'stocks.stock_no', '=', 'pallets.stock_no')
            ->where('stocks.status_qa', 'A')
            ->where('qty_avail', '>', 0)
            ->where('location', $item->location)
            ->select('pallets.*', 'stocks.expiry_date')
            ->orderBy('stocks.expiry_date')
            ->lockForUpdate()
            ->get();


        if ($stocks->isEmpty()) {
            session()->flash('error', 'No available stock for item ' . $item->item_code . ' in location ' . $item->location);
            throw new \Exception('No available stock for item ' . $item->item_code . ' in location ' . $item->location);
        }

        $total_stock_qty = $stocks->sum('qty_avail');

        if ($total_stock_qty < $item->req_qty) {
            session()->flash('error', 'No available stock for item ' . $item->item_code . ' in location ' . $item->location);
            throw new \Exception('No available stock for item ' . $item->item_code . ' in location ' . $item->location);
        }

        // Jika qty stock lebih besar dari qty item, maka ambil stock secara looping sampai qty item terpenuhi
        $qty_req = $item->req_qty;
        foreach ($stocks as $stock) {
            if ($qty_req > 0) { // Jika qty request masih lebih dari 0
                if ($qty_req >= $stock->qty_avail) {
                    // Ambil semua stok yang tersedia
                    $qty_pick = $stock->qty_avail;
                    $qty_req -= $stock->qty_avail;
                    $stock->qty_avail -= $qty_pick; // Stok habis
                    $stock->qty_onhand -= $qty_pick;
                    $stock->qty_out += $qty_pick;
                } else {
                    // Ambil sebagian stok sesuai kebutuhan
                    $qty_pick = $qty_req;
                    $stock->qty_avail -= $qty_req;
                    $stock->qty_onhand -= $qty_req;
                    $stock->qty_out += $qty_req;
                    $qty_req = 0; // Kebutuhan terpenuhi
                }
                $stock->save(); // Simpan perubahan stok

                $dataInsertFlag = [
                    'reference_no' => $outbound_header->outbound_no,
                    'stock_no' => $stock->stock_no,
                    'pallet_no' => $stock->pallet_no,
                    'item_code' => $item->item_code,
                    'detail_id' => (int)$item->id,
                    'qty' => $qty_pick,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                ];
                \App\Models\Flag::create($dataInsertFlag);
            }
            if ($qty_req <= 0) {
                break; // Keluar dari loop jika kebutuhan sudah terpenuhi
            }
        }
    }
    private function processOutboundItem($item, $outbound_header)
    {

        // Check stock
        $stocks = \App\Models\Pallet::where('pallets.item_code', $item->item_code)
            ->join('stocks', 'stocks.stock_no', '=', 'pallets.stock_no')
            ->where('stocks.status_qa', 'A')
            ->where('qty_avail', '>', 0)
            ->select('pallets.*', 'stocks.expiry_date')
            ->orderBy('stocks.expiry_date')
            ->lockForUpdate()
            ->get();

        if ($stocks->isEmpty()) {
            session()->flash('error', 'No available stock for item ' . $item->item_code);
            throw new \Exception('No available stock for item ' . $item->item_code);
        }

        $total_stock_qty = $stocks->sum('qty_avail');

        if ($total_stock_qty < $item->req_qty) {
            session()->flash('error', 'No available stock for item ' . $item->item_code);
            throw new \Exception('No available stock for item ' . $item->item_code);
        }

        // Jika qty stock lebih besar dari qty item, maka ambil stock secara looping sampai qty item terpenuhi
        $qty_req = $item->req_qty;
        foreach ($stocks as $stock) {
            if ($qty_req > 0) { // Jika qty request masih lebih dari 0
                if ($qty_req >= $stock->qty_avail) {
                    // Ambil semua stok yang tersedia
                    $qty_pick = $stock->qty_avail;
                    $qty_req -= $stock->qty_avail;
                    $stock->qty_avail -= $qty_pick; // Stok habis
                    $stock->qty_onhand -= $qty_pick;
                    $stock->qty_out += $qty_pick;
                } else {
                    // Ambil sebagian stok sesuai kebutuhan
                    $qty_pick = $qty_req;
                    $stock->qty_avail -= $qty_req;
                    $stock->qty_onhand -= $qty_req;
                    $stock->qty_out += $qty_req;
                    $qty_req = 0; // Kebutuhan terpenuhi
                }
                $stock->save(); // Simpan perubahan stok

                $dataInsertFlag = [
                    'reference_no' => $outbound_header->outbound_no,
                    'stock_no' => $stock->stock_no,
                    'pallet_no' => $stock->pallet_no,
                    'item_code' => $item->item_code,
                    'detail_id' => (int)$item->id,
                    'qty' => $qty_pick,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                ];
                \App\Models\Flag::create($dataInsertFlag);
            }
            if ($qty_req <= 0) {
                break; // Keluar dari loop jika kebutuhan sudah terpenuhi
            }
        }
    }
}
