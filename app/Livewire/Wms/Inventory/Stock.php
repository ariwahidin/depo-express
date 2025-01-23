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
    public $search = '';
    public $status = 'all';


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
            ->where('stocks.status_qa', 'A')
            ->where('qty_avail', '>', 0)
            ->select('pallets.*', 'stocks.expiry_date', 'items.item_name')
            ->orderBy('stocks.expiry_date')
            ->paginate(10);
    }
}
