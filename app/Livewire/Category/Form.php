<?php

namespace App\Livewire\Category;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Form extends Component
{
    public $category_id;
    public $category;
    public $edit = false;

    public function create()
    {
        $validatedData = $this->validate([
            'category' => 'required | unique:categories,name',
        ]);

        $data = [
            'name' => $validatedData['category'],
            'created_by' => Auth::id(),
        ];

        try {
            DB::beginTransaction();
            Category::create($data);
            DB::commit();
            $this->reset(['category']);
            $this->dispatch('reloadCategories');
            session()->flash('success', 'Category created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error: ' . $e->getMessage()); // Log kesalahan
            session()->flash('error', 'Failed to create category: ' . $e->getMessage());
        }
    }

    #[\Livewire\Attributes\On('editCategory')]
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->category = $category->name;
        $this->category_id = $category->id;
        $this->edit = true;
    }

    public function update()
    {
        $validatedData = $this->validate([
            'category' => 'required | unique:categories,name,' . $this->category_id,
        ]);

        $category = Category::findOrFail($this->category_id);
        $category->name = $validatedData['category'];
        $category->updated_by = Auth::id();
        $category->updated_at = now();
        $category->save();

        $this->reset(['category', 'category_id', 'edit']);
        $this->dispatch('reloadCategories');
        session()->flash('success', 'Category updated successfully');
    }

    public function cancel()
    {
        $this->reset(['category', 'category_id', 'edit']);
        $this->dispatch('reloadCategories');
    }

    public  function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->status = 'inactive';
        $category->deleted_by = Auth::id();
        $category->deleted_at = now();
        $category->save();
        $this->dispatch('reloadCategories');
        session()->flash('success', 'Category deleted successfully');
    }
    
    public function render()
    {
        return view('livewire.category.form');
    }
}
