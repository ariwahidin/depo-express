<?php

namespace App\Livewire\Wms\Master\Supplier;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Delete extends Component
{
    public function render()
    {
        return view('livewire.wms.master.supplier.delete');
    }

    public function deleteSupplier($id)
    {
        $supplier = \App\Models\Supplier::find($id);
        $supplier->delete_status = 'yes';
        $supplier->status = 'inactive';
        $supplier->deleted_by = Auth::id();
        $supplier->deleted_at = now();
        $supplier->save();
        $this->dispatch('reloadSupplier');
        $this->dispatch('hideDeleteModalNow');
    }
}
