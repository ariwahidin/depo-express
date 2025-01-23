<?php

namespace App\Livewire\Wms\Master\Customer;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Delete extends Component
{
    public function render()
    {
        return view('livewire.wms.master.customer.delete');
    }
    public function delete($id)
    {
        $data = \App\Models\Customer::find($id);
        $data->delete_status = 'yes';
        $data->status = 'inactive';
        $data->deleted_by = Auth::id();
        $data->deleted_at = now();
        $data->save();
        $this->dispatch('reload');
        $this->dispatch('hideDeleteModalNow');
    }
}
