<?php

namespace App\Livewire\Wms\Master\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerTable extends Component
{
    use WithPagination;
    public $search = '';

    #[\Livewire\Attributes\On('reload')]
    public function render()
    {
        return view('livewire.wms.master.customer.customer-table', [
            'customers' => \App\Models\Customer::where('delete_status', 'no')
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
        ]);
    }


    public function exportExcel()
    {
        $customers = \App\Models\Customer::where('name', 'like', '%' . $this->search . '%')
            ->select('code', 'name', 'address', 'phone', 'email', 'city', 'country')
            ->get();

        return Excel::download(new class($customers) implements FromCollection, WithHeadings {
            
            private $customers;

            public function __construct($customers)
            {
                $this->customers = $customers;
            }

            public function collection()
            {
                return $this->customers;
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
                ];
            }
        }, 'filtered_customer.xlsx');
    }
}
