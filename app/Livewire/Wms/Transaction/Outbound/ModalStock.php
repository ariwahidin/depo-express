<?php

namespace App\Livewire\Wms\Transaction\Outbound;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ModalStock extends Component
{
    public $item_code;
    public $index;
    public $stocks;
    public function render()
    {
        return view('livewire.wms.transaction.outbound.modal-stock');
    }

    #[\Livewire\Attributes\On('checkStock')]
    public function checkStock($index, $item_code)
    {
        $this->item_code = $item_code;
        $this->index = $index;

        $stock = \App\Models\Pallet::where('pallets.item_code', $item_code)
            ->join('items', 'items.item_code', '=', 'pallets.item_code')
            ->where('qty_avail', '>', 0)
            ->select(
                'pallets.item_code',
                'pallets.location',
                'items.item_name',
                DB::raw('SUM(pallets.qty_avail) as total_qty_avail')
            )
            ->groupBy('pallets.item_code', 'pallets.location', 'items.item_name')
            ->get();

        $this->stocks = $stock;

        $this->dispatch('openModalStock');
    }
}
