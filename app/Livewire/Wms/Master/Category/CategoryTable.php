<?php

namespace App\Livewire\Wms\Master\Category;

use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoryTable extends Component
{
    use WithPagination;
    public $search = '';

    #[\Livewire\Attributes\On('reload')]
    public function render()
    {
        return view('livewire.wms.master.category.category-table', [
            'categories' => \App\Models\Category::where('delete_status', 'no')
                ->where('name', 'like', '%' . $this->search . '%')
                ->orderByDesc('created_at')
                ->paginate(10),
        ]);
    }

    public function exportExcel()
    {
        $categories = \App\Models\Category::where('name', 'like', '%' . $this->search . '%')
            ->select('name')
            ->get();

        return Excel::download(new class($categories) implements FromCollection, WithHeadings {
            
            private $categories;

            public function __construct($categories)
            {
                $this->categories = $categories;
            }

            public function collection()
            {
                return $this->categories;
            }

            public function headings(): array
            {
                return [
                    'Name',
                ];
            }
        }, 'filtered_categories.xlsx');
    }
}
