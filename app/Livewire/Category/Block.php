<?php

namespace App\Livewire\Category;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Block extends Component
{
    public $categories;

    
    public function mount()
    {
        $this->categories = \App\Models\Category::getActiveCategories()->get();
    }

    #[\Livewire\Attributes\On('reloadCategories')]
    public function refresh()
    {
        $this->mount();
    }

    public function edit($id)
    {
        $this->dispatch('editCategory', id : $id);
    }

    public function deactivate($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        $category->status = 'inactive';
        $category->updated_by = Auth::id();
        $category->updated_at = now();
        $category->save();
        $this->dispatch('reloadCategories');
    }

    public function activate($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        $category->status = 'active';
        $category->updated_by = Auth::id();
        $category->updated_at = now();
        $category->save();
        $this->dispatch('reloadCategories');
    }

    public function render()
    {
        return view('livewire.category.block');
    }
}
