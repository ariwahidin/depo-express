<?php

namespace App\Livewire\Wms\Inventory;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Stock extends Component
{

    use WithPagination;
    public $periode_date = '';
    public $search = '';

    public function render()
    {
        return view('livewire.wms.inventory.stock', [
            'stocks' => $this->getStock(),
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
}
