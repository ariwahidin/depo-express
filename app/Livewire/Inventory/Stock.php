<?php

namespace App\Livewire\Inventory;

use Livewire\Component;

class Stock extends Component
{
    public $title;
    public $stocks;
    public function mount() {
        $this->stocks = \App\Models\Stock::stockActive();
    }

    public function render()
    {
        return view('livewire.inventory.stock');
    }
}
