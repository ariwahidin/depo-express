<?php

namespace App\Livewire\Supplier;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public $name;
    public $suppliers;
    public $supplier_id;

    public function mount()
    {
        $this->suppliers = \App\Models\Supplier::where('delete_status', 'no')->orderByDesc('created_at')->get();
    }

    public function create()
    {
        $validatedData = $this->validate([
            'name' => 'required | unique:suppliers,name,' . $this->supplier_id,
        ]);
        try {
            DB::beginTransaction();
            $data = [
                'name' => $validatedData['name'],
                'created_by' => Auth::id(),
            ];
            \App\Models\Supplier::create($data);
            DB::commit();
            $this->reset(['name']);
            session()->flash('success', 'Supplier created successfully');
            $this->dispatch('reloadSupplier');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Log::error('Error: ' . $th->getMessage()); // Log kesalahan
            session()->flash('error', 'Failed to create new supplier: ' . $th->getMessage());
            $this->dispatch('reloadSupplier');
        }
    }
    public function render()
    {
        return view('livewire.supplier.form');
    }
}
