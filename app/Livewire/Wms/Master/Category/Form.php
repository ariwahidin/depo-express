<?php

namespace App\Livewire\Wms\Master\Category;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Form extends Component
{
    public $edit = false;
    public $id;
    public $name;
    public function render()
    {
        return view('livewire.wms.master.category.form');
    }

    public function create()
    {
        $dataValidate = $this->validate([
            'name' => 'required | unique:customers,name',
        ]);

        try {
            DB::beginTransaction();
            $data = [
                'name' => $dataValidate['name'],
                'created_by' => Auth::id(),
            ];
            Category::create($data);
            DB::commit();
            $this->reset(['name']);
            session()->flash('success', 'Category created successfully');
            $this->dispatch('reload');
            $this->dispatch('hideCreateModalNow');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('error: ' . $e->getMessage());
            session()->flash('error', $e->getMessage());
        }
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($id)
    {
        $data = Category::find($id);
        $this->id = $data->id;
        $this->name = $data->name;
        $this->edit = true;
        $this->dispatch('showCreateModalNow');
    }

    public function update()
    {
        $dataValidate = $this->validate([
            'name' => 'required | unique:customers,name,' . $this->id,
        ]);

        try {
            DB::beginTransaction();
            $data = [
                'name' => $dataValidate['name'],
                'updated_by' => Auth::id(),
            ];
            Category::find($this->id)->update($data);
            DB::commit();
            $this->edit = false;
            $this->reset(['name']);
            session()->flash('success', 'Category updated successfully');
            $this->dispatch('reload');
            $this->dispatch('hideCreateModalNow');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('error: ' . $e->getMessage());
            session()->flash('error', $e->getMessage());
        }
    }
}
