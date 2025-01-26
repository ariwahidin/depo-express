<?php

namespace App\Livewire\Wms\Dashboard;

use Livewire\Component;

class Index extends Component
{
    public $inbound_open = 0;
    public $outbound_open = 0;
    public $value_stock = 0;

    #[\Livewire\Attributes\Title('Dashboard Inventory')]
    public function render()
    {
        return view('livewire.wms.dashboard.index');
    }

    public function mount()
    {
        $inbound = \App\Models\InboundHeader::where('status_proccess', 'open')->get();
        $this->inbound_open = $inbound->count();

        $outbound = \App\Models\OutboundHeader::where('status_proccess', 'open')->get();
        $this->outbound_open = $outbound->count();

        $value_stock = \App\Livewire\Wms\Report\Stock::getStockValue();
        $this->value_stock = $value_stock;
    }
}
