<?php

namespace App\Livewire\Wms\Master\Item;

use Livewire\Component;

class Index extends Component
{
    #[\Livewire\Attributes\Title('List Item')]
    public function render()
    {
        return view('livewire.wms.master.item.index');
    }
}
