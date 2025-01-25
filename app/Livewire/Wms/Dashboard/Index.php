<?php

namespace App\Livewire\Wms\Dashboard;

use Livewire\Component;

class Index extends Component
{

    #[\Livewire\Attributes\Title('Dashboard Inventory')]
    public function render()
    {
        return view('livewire.wms.dashboard.index');
    }
}
