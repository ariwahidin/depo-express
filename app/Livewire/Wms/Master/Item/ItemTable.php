<?php

namespace App\Livewire\Wms\Master\Item;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ItemTable extends Component
{

    use WithPagination;
    public $search = '';

    #[\Livewire\Attributes\On('reload')]
    public function render()
    {
        $items = \App\Models\Item::where('delete_status', 'no')
            ->paginate(10);

        return view('livewire.wms.master.item.item-table', [
            'items' => $this->getItems(),
        ]);
    }

    private function getItems ()
    {
        $items = \App\Models\Item::where('delete_status', 'no')
            ->where('item_code', 'like', '%' . $this->search . '%')
            ->orWhere('item_name', 'like', '%' . $this->search . '%')
            ->orWhere('uom', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return $items;
    }

    public function delete($id)
    {
        $item = \App\Models\Item::findOrFail($id);
        $item->delete_status = 'yes';
        $item->status = 'inactive';
        $item->deleted_by = Auth::id();
        $item->deleted_at = now();
        $item->save();
        $this->dispatch('reload');
    }
}
