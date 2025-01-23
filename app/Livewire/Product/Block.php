<?php

namespace App\Livewire\Product;

use Livewire\Component;

class Block extends Component
{
    public $products;

    #[ \Livewire\Attributes\On('reload-product') ]
    public function mount(){
        $this->products = \App\Models\Product::where('delete_status', 'no')->orderByDesc('created_at')->get();
    }

    public function render()
    {
        return view('livewire.product.block');
    }
}
