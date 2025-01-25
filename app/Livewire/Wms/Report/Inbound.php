<?php

namespace App\Livewire\Wms\Report;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class Inbound extends Component
{
    use WithPagination;
    public $start_date = '';
    public $end_date = '';
    public $search = '';
    public $status = 'all';

    #[\Livewire\Attributes\Title('Report Inbound')] 
    public function render()
    {
        // dd($this->inbounds);
        return view('livewire.wms.report.inbound', [
            'inbounds' => $this->getInboundDetail($this->start_date, $this->end_date, $this->status),
        ]);
    }


    public function mount()
    {
        $this->start_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 month'));
        $this->end_date = date('Y-m-d');
    }

    private function getInboundDetail($start_date, $end_date, $status)
    {
        return \App\Models\InboundDetail::join('inbound_headers', 'inbound_headers.id', '=', 'inbound_details.inbound_id')
            ->join('items', 'items.item_code', '=', 'inbound_details.item_code')
            ->whereBetween('inbound_headers.created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
            ->where(function ($query) {
                $query->where('items.item_name', 'like', '%' . $this->search . '%')
                    ->orWhere('inbound_details.item_code', 'like', '%' . $this->search . '%')
                    ->orWhere('inbound_details.req_qty', 'like', '%' . $this->search . '%')
                    ->orWhere('inbound_details.price', 'like', '%' . $this->search . '%')
                    ->orWhere('inbound_headers.status_proccess', 'like', '%' . $this->search . '%');
            })
            ->where(function ($query) use ($status) {
                if ($status == 'open') {
                    $query->where('inbound_headers.status_proccess', 'open');
                } else if ($status == 'closed') {
                    $query->where('inbound_headers.status_proccess', 'closed');
                }
            })
            ->select(
                'items.item_name',
                'inbound_details.*',
                'inbound_headers.status_proccess',
                'inbound_headers.created_at'
            )
            ->orderByDesc('inbound_headers.created_at')
            ->paginate(10);
    }

    public function exportExcel()
    {
        $status = $this->status;
        $inbound = \App\Models\InboundDetail::join('inbound_headers', 'inbound_headers.id', '=', 'inbound_details.inbound_id')
            ->join('items', 'items.item_code', '=', 'inbound_details.item_code')
            ->whereBetween('inbound_headers.created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
            ->where(function ($query) {
                $query->where('items.item_name', 'like', '%' . $this->search . '%')
                    ->orWhere('inbound_details.item_code', 'like', '%' . $this->search . '%')
                    ->orWhere('inbound_details.req_qty', 'like', '%' . $this->search . '%')
                    ->orWhere('inbound_details.price', 'like', '%' . $this->search . '%')
                    ->orWhere('inbound_headers.status_proccess', 'like', '%' . $this->search . '%');
            })
            ->where(function ($query) use ($status) {
                if ($status == 'open') {
                    $query->where('inbound_headers.status_proccess', 'open');
                } else if ($status == 'closed') {
                    $query->where('inbound_headers.status_proccess', 'closed');
                }
            })
            ->select(
                'inbound_headers.receive_id',
                'inbound_details.receive_date',
                'inbound_headers.status_proccess',
                'inbound_details.item_code',
                'items.item_name',
                'inbound_details.req_qty',
                'inbound_details.price',
            )
            ->orderByDesc('inbound_headers.created_at')
            ->get();

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
                    'Inbound No',
                    'Received Date',
                    'Status',
                    'Item Code',
                    'Item Name',
                    'Qty',
                    'Price',
                ];
            }
        }, 'inbound_report.xlsx');
    }
}
