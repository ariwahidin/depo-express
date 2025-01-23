<?php

namespace App\Livewire\GoodReceive;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public $suppliers;
    public $products;
    public $supplier_id;
    public $product_id;
    public $quantity;

    public function mount()
    {
        $this->suppliers = \App\Models\Supplier::where('delete_status', 'no')->orderByDesc('created_at')->get();
        $this->products = \App\Models\Product::where('delete_status', 'no')->orderByDesc('created_at')->get();
    }

    public function create(){
        $validatedData = $this->validate([
            'supplier_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required|numeric',
        ]);
        try {
            DB::beginTransaction();
            $data = [
                'supplier_id' => $validatedData['supplier_id'],
                'product_id' => $validatedData['product_id'],
                'quantity' => $validatedData['quantity'],
                'created_by' => Auth::id(),
            ];
            \App\Models\ReceiptDetail::create($data);
            DB::commit();
            $this->reset(['product_id', 'quantity']);
            $this->dispatch('reloadReceipt');
            session()->flash('success', 'Post created successfully');
            $this->dispatch('reloadReceipt');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Log::error('Error: ' . $th->getMessage()); // Log kesalahan
            session()->flash('error', 'Failed to create post: ' . $th->getMessage());
            $this->dispatch('reloadReceipt');
        }
    }

    public function render()
    {
        return view('livewire.good-receive.form');
    }
}
