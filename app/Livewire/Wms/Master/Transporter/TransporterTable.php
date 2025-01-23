<?php

namespace App\Livewire\Wms\Master\Transporter;

use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Transporter;

class TransporterTable extends Component
{
    use WithPagination;
    public $search = '';
    public function render()
    {
        return view('livewire.wms.master.transporter.transporter-table', [
            'transporters' => Transporter::where('delete_status', 'no')
                ->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('code', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('address', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%')
                        ->orWhere('pic', 'like', '%' . $this->search . '%');
                })
                ->paginate(10),
        ]);
    }
}
