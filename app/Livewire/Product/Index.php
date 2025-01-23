<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\Attributes\Title;

class Index extends Component
{
    
    #[Title('Products')]
    public function render()
    {
        return view('livewire.product.index');
    }
}
