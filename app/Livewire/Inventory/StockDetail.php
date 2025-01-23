<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use Livewire\Attributes\On;

class StockDetail extends Component
{
    public $title;
    public $product_id;
    public $stocks = [];


    #[On('showStokDetail')]
    public function mount($product_id = null) {
        $this->product_id = $product_id;
        $this->stocks = \App\Models\Stock::stockActiveByProduct($product_id);
    }

    public function render()
    {
        return view('livewire.inventory.stock-detail');
    }
}
