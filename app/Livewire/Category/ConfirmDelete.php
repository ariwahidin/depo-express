<?php

namespace App\Livewire\Category;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ConfirmDelete extends Component
{
    public $id;

    public function deleteCategory($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        $category->delete_status = 'yes';
        $category->status = 'inactive';
        $category->deleted_by = Auth::id();
        $category->deleted_at = now();
        $category->save();
        $this->dispatch('reloadCategories');
    }

    public function render()
    {
        return view('livewire.category.confirm-delete');
    }
}
