<?php

namespace App\Livewire\Wms\Transaction\Inbound;

use Livewire\Component;

class FormSelectItem extends Component
{
    public $itemOptions;
    public $index;
    public $itemSelected;
    public function render()
    {
        return view('livewire.wms.transaction.inbound.form-select-item');
    }

}