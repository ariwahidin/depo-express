<?php

namespace App\Livewire\Wms\Transaction\Inbound;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Delete extends Component
{
    public function render()
    {
        return view('livewire.wms.transaction.inbound.delete');
    }

    public function delete($id)
    {
        $inbound = \App\Models\InboundHeader::find($id);
        $inbound->delete_status = 'yes';
        $inbound->deleted_by = Auth::id();
        $inbound->deleted_at = now();
        $inbound->status = 'inactive';
        $inbound->save();
        $this->dispatch('hideDeleteModalNow');
    }
}
