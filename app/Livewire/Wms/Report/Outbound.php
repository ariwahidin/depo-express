<?php

namespace App\Livewire\Wms\Report;

use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Livewire\WithPagination;


class Outbound extends Component
{
    use WithPagination;
    public $start_date = '';
    public $end_date = '';
    public $search = '';
    public $status = 'all';

    #[\Livewire\Attributes\Title('Report Outbound')] 
    public function render()
    {
        return view('livewire.wms.report.outbound', [
            'outbounds' => $this->getOutboundDetail($this->start_date, $this->end_date, $this->status),
        ]);
    }

    public function mount()
    {
        $this->start_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 month'));
        $this->end_date = date('Y-m-d');
    }

    private function getOutboundDetail($start_date, $end_date, $status)
    {
        return \App\Models\OutboundDetail::join('outbound_headers', 'outbound_headers.id', '=', 'outbound_details.outbound_id')
            ->join('items', 'items.item_code', '=', 'outbound_details.item_code')
            ->whereBetween('outbound_headers.created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
            ->where(function ($query) {
                $query->where('items.item_name', 'like', '%' . $this->search . '%')
                    ->orWhere('outbound_details.item_code', 'like', '%' . $this->search . '%')
                    ->orWhere('outbound_details.req_qty', 'like', '%' . $this->search . '%')
                    ->orWhere('outbound_headers.status_proccess', 'like', '%' . $this->search . '%');
            })
            ->where(function ($query) use ($status) {
                if ($status == 'open') {
                    $query->where('outbound_headers.status_proccess', 'open');
                } else if ($status == 'completed') {
                    $query->where('outbound_headers.status_proccess', 'completed');
                }
            })
            ->select(
                'items.item_name',
                'outbound_details.*',
                'outbound_headers.picking_date',
                'outbound_headers.status_proccess',
                'outbound_headers.created_at'
            )
            ->orderByDesc('outbound_headers.created_at')
            ->paginate(10);
    }

    public function exportExcel()
    {
        $status = $this->status;
        $outbounds = \App\Models\OutboundDetail::join('outbound_headers', 'outbound_headers.id', '=', 'outbound_details.outbound_id')
            ->join('items', 'items.item_code', '=', 'outbound_details.item_code')
            ->whereBetween('outbound_headers.created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
            ->where(function ($query) {
                $query->where('items.item_name', 'like', '%' . $this->search . '%')
                    ->orWhere('outbound_details.item_code', 'like', '%' . $this->search . '%')
                    ->orWhere('outbound_details.req_qty', 'like', '%' . $this->search . '%')
                    ->orWhere('outbound_headers.status_proccess', 'like', '%' . $this->search . '%');
            })
            ->where(function ($query) use ($status) {
                if ($status == 'open') {
                    $query->where('outbound_headers.status_proccess', 'open');
                } else if ($status == 'completed') {
                    $query->where('outbound_headers.status_proccess', 'completed');
                }
            })
            ->select(
                'outbound_headers.outbound_no',
                'outbound_headers.picking_date',
                'outbound_headers.status_proccess',
                'outbound_details.item_code',
                'items.item_name',
                'outbound_details.req_qty',
            )
            ->orderByDesc('outbound_headers.created_at')
            ->get();

        return Excel::download(new class($outbounds) implements FromCollection, WithHeadings {

            private $outbounds;

            public function __construct($outbounds)
            {
                $this->outbounds = $outbounds;
            }

            public function collection()
            {
                return $this->outbounds;
            }

            public function headings(): array
            {
                return [
                    'Outbound No',
                    'Picking Date',
                    'Status',
                    'Item Code',
                    'Item Name',
                    'Qty',
                ];
            }
        }, 'outbound_report.xlsx');
    }
}
