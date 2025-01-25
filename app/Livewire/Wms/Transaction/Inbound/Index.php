<?php

namespace App\Livewire\Wms\Transaction\Inbound;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    public $status = 'all';

    #[\Livewire\Attributes\Title('List Inbound')] 
    #[\Livewire\Attributes\On('hideDeleteModalNow')]
    public function render()
    {
        return view('livewire.wms.transaction.inbound.index', [
            'inbounds' => $this->getInbound(),
        ]);
    }

    private function getInbound()
    {
        return \App\Models\InboundHeader::where('inbound_headers.delete_status', 'no')
            ->join('suppliers', 'suppliers.code', '=', 'inbound_headers.supplier_code')
            ->join('transporters', 'transporters.code', '=', 'inbound_headers.truck_code')
            ->leftJoin('inbound_details', 'inbound_details.inbound_id', '=', 'inbound_headers.id')
            ->where(function ($query) {
                $query->where('inbound_headers.receive_id', 'like', '%' . $this->search . '%')
                    ->orWhere('inbound_headers.supplier_code', 'like', '%' . $this->search . '%')
                    ->orWhere('inbound_headers.doc_no', 'like', '%' . $this->search . '%')
                    ->orWhere('inbound_headers.invoice_no', 'like', '%' . $this->search . '%')
                    ->orWhere('inbound_headers.ib_type', 'like', '%' . $this->search . '%')
                    ->orWhere('suppliers.name', 'like', '%' . $this->search . '%');
            })
            ->where(function ($query) {
                if ($this->status == 'open') {
                    $query->where('inbound_headers.status_proccess', 'open');
                } elseif ($this->status == 'closed') {
                    $query->where('inbound_headers.status_proccess', 'closed');
                }
            })
            ->select(
                'inbound_headers.remarks',
                'inbound_headers.receive_id',
                'inbound_headers.received_date',
                'inbound_headers.invoice_no',
                'transporters.name as transporter_name',
                'inbound_headers.truck_no',
                DB::raw('COUNT(inbound_details.item_code) as total_items'),
                DB::raw('SUM(inbound_details.req_qty) as total_qty'),
                DB::raw('SUM(inbound_details.price) as total_price'),
                'inbound_headers.koli',
                'inbound_headers.ib_type',
                'inbound_headers.status_proccess',
                'suppliers.name as supplier_name',
                'inbound_headers.created_at',
                'inbound_headers.id',
            )
            ->groupBy('inbound_headers.id')
            ->orderByDesc('inbound_headers.created_at')
            ->paginate(10);
    }


    public function close($id)
    {

        \App\Models\InboundHeader::where('id', $id)
            ->where('status_proccess', 'open')
            ->firstOrFail(); // Check if the inbound is open


        try {
            DB::beginTransaction();

            // Ambil data header inbound
            $inbound_header = \App\Models\InboundHeader::where('id', $id)
                ->where('status_proccess', 'open')
                ->lockForUpdate()
                ->firstOrFail();

            // Ambil data detail inbound
            $inbound_detail = \App\Models\InboundDetail::where('inbound_id', $id)
                ->where('status', 'open')
                ->get();

            if ($inbound_detail->isEmpty()) {
                throw new \Exception('No inbound details found to process.');
            }

            foreach ($inbound_detail as $item) {
                try {
                    $this->processInboundItem($item, $inbound_header);
                } catch (\Exception $e) {

                    Log::error("Error processing item ID {$item->id}: {$e->getMessage()}");
                    throw $e;
                }
            }

            // Update status header inbound menjadi closed
            $inbound_header->update([
                'status_proccess' => 'closed',
                'updated_by' => Auth::id(),
                'updated_at' => now(),
                'completed_by' => Auth::id(),
                'completed_at' => now(),
            ]);

            // Update status transaksi
            \App\Models\Trans::where('trans_no', $inbound_header->trans_no)
                ->update([
                    'trans_status' => 'closed',
                    'updated_at' => now(),
                ]);

            DB::commit();
            session()->flash('success', 'Inbound closed successfully.');
            return redirect()->route('inbound');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', "Failed to close inbound: {$e->getMessage()}");
            return redirect()->back();
        }
    }


    private function processInboundItem($item, $inbound_header)
    {
        // Generate nomor stock dan pallet
        $new_stock_no = \App\Models\Stock::generateStockNo();
        $new_pallet_no = \App\Models\Pallet::generatePalletNo();
        $inbound_no = $inbound_header->receive_id;

        // Buat data Stock
        $dataStock = [
            'stock_no' => $new_stock_no,
            'item_code' => $item->item_code,
            'receive_date' => $item->receive_date,
            'expiry_date' => $item->receive_date,
            'status_qa' => 'A',
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ];
        $stock = \App\Models\Stock::create($dataStock);

        // Buat data Pallet
        $dataPallet = [
            'pallet_no' => $new_pallet_no,
            'stock_no' => $stock->stock_no,
            'item_code' => $item->item_code,
            'location' => $item->location,
            'qty_in' => $item->req_qty,
            'qty_onhand' => $item->req_qty,
            'qty_avail' => $item->req_qty,
            'status_qa' => $stock->status_qa,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ];
        $pallet = \App\Models\Pallet::create($dataPallet);

        // Buat data Flag
        $dataFlag = [
            'reference_no' => $inbound_no,
            'stock_no' => $pallet->stock_no,
            'pallet_no' => $pallet->pallet_no,
            'item_code' => $item->item_code,
            'detail_id' => (int)$item->id,
            'qty' => $item->req_qty,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ];
        \App\Models\Flag::create($dataFlag);

        // Update status item detail menjadi closed
        $item->update([
            'status' => 'close',
            'updated_by' => Auth::id(),
            'updated_at' => now(),
        ]);
    }

    public function exportExcel()
    {
        $inbound = $this->getInbound();

        return Excel::download(new class($inbound) implements FromCollection, WithHeadings {

            private $inbound;

            public function __construct($inbound)
            {
                $this->inbound = $inbound;
            }

            public function collection()
            {
                return $this->inbound;
            }

            public function headings(): array
            {
                return [
                    'Receive ID',
                    'Supplier Code',
                    'Doc No',
                    'Invoice No',
                    'IB Type',
                    'Supplier Name',
                    'Truck Code',
                    'Truck Name',
                    'Total Items',
                    'Total Qty',
                    'Status Proccess',
                    'Created At',
                    'Updated At',
                    'Completed At',
                ];
            }
        }, 'filtered_inbound.xlsx');

        // return Excel::download(new class($categories) implements FromCollection, WithHeadings {

        //     private $categories;

        //     public function __construct($categories)
        //     {
        //         $this->categories = $categories;
        //     }

        //     public function collection()
        //     {
        //         return $this->categories;
        //     }

        //     public function headings(): array
        //     {
        //         return [
        //             'Name',
        //         ];
        //     }
        // }, 'filtered_inbound.xlsx');
    }
}
