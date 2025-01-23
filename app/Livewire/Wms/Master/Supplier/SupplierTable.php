<?php

namespace App\Livewire\Wms\Master\Supplier;

use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SupplierTable extends Component
{

    use WithPagination;
    public $search = '';

    #[\Livewire\Attributes\On('reloadSupplier')]
    public function render()
    {
        return view(
            'livewire.wms.master.supplier.supplier-table',
            [
                'suppliers' => \App\Models\Supplier::where('delete_status', 'no')
                    ->where(function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('code', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%')
                            ->orWhere('address', 'like', '%' . $this->search . '%')
                            ->orWhere('phone', 'like', '%' . $this->search . '%')
                            ->orWhere('pic', 'like', '%' . $this->search . '%');
                    })
                    ->orderByDesc('created_at')
                    ->paginate(10),
            ]
        );
    }

    public function exportExcel()
    {
        $suppliers = \App\Models\Supplier::where('name', 'like', '%' . $this->search . '%')
            ->select('code', 'name', 'address', 'phone', 'email', 'city', 'country', 'pic')
            ->get();

        return Excel::download(new class($suppliers) implements FromCollection, WithHeadings {
            private $suppliers;

            public function __construct($suppliers)
            {
                $this->suppliers = $suppliers;
            }

            public function collection()
            {
                return $this->suppliers;
            }

            public function headings(): array
            {
                return [
                    'Code',
                    'Name',
                    'Address',
                    'Phone',
                    'Email',
                    'City',
                    'Country',
                    'PIC',
                ];
            }
        }, 'filtered_suppliers.xlsx');
    }
}
