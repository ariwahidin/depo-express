<?php

namespace App\Livewire\Supplier;

use Livewire\Component;

class Block extends Component
{
    public $suppliers;

    #[\Livewire\Attributes\On('reloadSupplier')]
    public function mount()
    {
        $this->suppliers = \App\Models\Supplier::where('delete_status', 'no')->orderByDesc('created_at')->get();
    }
    public function render()
    {
        return view('livewire.supplier.block');
    }
}
