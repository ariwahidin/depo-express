<?php

namespace App\Livewire\Wms\Master\TruckSize;

use Livewire\Component;
use App\Models\TruckSize;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class TruckSizeTable extends Component
{
    use WithPagination;
    public $search = '';
    public function render()
    {
        return view('livewire.wms.master.truck-size.truck-size-table', [
            'trucksizes' => TruckSize::where('delete_status', 'no')
                ->where(function ($query) {
                    $query->where('code', 'like', '%' . $this->search . '%')
                        ->orWhere('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhere('volume_cbm', 'like', '%' . $this->search . '%')
                        ->orWhere('volume_cbm_90', 'like', '%' . $this->search . '%');
                })
                ->orderByDesc('created_at')
                ->paginate(10),
        ]);
    }
}
