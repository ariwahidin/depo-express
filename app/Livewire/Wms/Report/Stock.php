<?php

namespace App\Livewire\Wms\Report;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class Stock extends Component
{
    use WithPagination;
    public $periode_date = '';
    public $search = '';


    #[\Livewire\Attributes\Title('Report Stock')] 
    public function render()
    {
        return view('livewire.wms.report.stock', [
            'stocks' => $this->getInventoryStock(),
        ]);
    }

    private function getStock()
    {
        return \App\Models\Pallet::join('stocks', 'stocks.stock_no', '=', 'pallets.stock_no')
            ->join('items', 'items.item_code', '=', 'pallets.item_code')
            ->where(function ($query) {
                $query->where('items.item_code', 'like', '%' . $this->search . '%')
                    ->orWhere('items.item_name', 'like', '%' . $this->search . '%');
            })
            ->select(
                'stocks.stock_no',
                'pallets.item_code',
                'pallets.location',
                'items.item_name',
                DB::raw('SUM(pallets.qty_in) as total_qty_in'),
                DB::raw('SUM(pallets.qty_out) as total_qty_out'),
                DB::raw('SUM(pallets.qty_avail) as total_qty_avail')
            )
            ->groupBy('pallets.item_code', 'pallets.location')
            ->orderBy('pallets.created_at', 'desc')
            ->paginate(10);
    }

    public static function getStockValue(){
        $instance = new self();
        $value_stock = $instance->getInventoryStock();
        $total_stock_value = 0;
        foreach ($value_stock as $value) {
            $total_stock_value += $value->total_stock_value;
        }
        return $total_stock_value;
    }

    private function getInventoryStock()
    {
        $result = DB::select('
            SELECT
                a.item_code,
                a.item_name,
                a.qty_in, 
                a.total_price, 
                a.avg_price_per_qty AS avg_price_per_qty_in, 
                b.qty_out, 
                b.qty_stock,
                -- Menghitung total nilai sisa stok
                b.qty_stock * a.avg_price_per_qty AS total_stock_value
            FROM
                (SELECT
                    a.item_code,
                    c.item_name,
                    SUM(req_qty) AS qty_in,
                    SUM(a.price) AS total_price,
                    SUM(a.price) / SUM(req_qty) AS avg_price_per_qty
                FROM inbound_details a
                INNER JOIN inbound_headers b ON a.inbound_id = b.id
                INNER JOIN items c ON a.item_code = c.item_code 
                WHERE b.status_proccess = :status
                GROUP BY a.item_code) a
            LEFT JOIN
                (SELECT 
                    item_code,
                    SUM(qty_out) AS qty_out,
                    SUM(qty_avail) AS qty_stock
                FROM pallets
                GROUP BY item_code) b 
            ON a.item_code = b.item_code;
        ', ['status' => 'closed']);
        return $result;
    }
}
