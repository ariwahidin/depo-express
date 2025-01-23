<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Delete extends Component
{
    public $product_id;

    #[ \Livewire\Attributes\On('delete-product') ]
    public function deleteProduct($id)
    {
        $category = \App\Models\Product::findOrFail($id);
        $category->delete_status = 'yes';
        $category->status = 'inactive';
        $category->deleted_by = Auth::id();
        $category->deleted_at = now();
        $category->save();
        $this->dispatch('reload-product');
    }
    
    public function render()
    {
        return view('livewire.product.delete');
    }
}
