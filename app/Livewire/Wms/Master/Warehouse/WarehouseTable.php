<?php

namespace App\Livewire\Wms\Master\Warehouse;

use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Warehouse;

class WarehouseTable extends Component
{
    use WithPagination;
    public $search = '';
    public function render()
    {
        return view('livewire.wms.master.warehouse.warehouse-table', [
            'warehouses' => Warehouse::where('delete_status', 'no')
                ->where(function ($query) {
                    $query->where('code', 'like', '%' . $this->search . '%');
                })
                ->orderByDesc('created_at')
                ->paginate(10),
        ]);
    }
}
