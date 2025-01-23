<?php

namespace App\Livewire\Wms\Master\Supplier;

use Livewire\Component;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Form extends Component
{

    public $edit = false;
    public $id;
    public $code;
    public $name;
    public $address;
    public $phone;
    public $email;
    public $city;
    public $country;
    public $pic;

    public function render()
    {
        return view('livewire.wms.master.supplier.form');
    }

    public function create()
    {
        $dataValidate = $this->validate([
            'code' => 'required | unique:suppliers,code',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'city' => 'required',
            'country' => 'required',
            'pic' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $data = [
                'code' => $dataValidate['code'],
                'name' => $dataValidate['name'],
                'address' => $dataValidate['address'],
                'phone' => $dataValidate['phone'],
                'email' => $dataValidate['email'],
                'city' => $dataValidate['city'],
                'country' => $dataValidate['country'],
                'pic' => $dataValidate['pic'],
                'created_by' => Auth::id(),
            ];
            Supplier::create($data);
            DB::commit();
            $this->reset(['code', 'name', 'address', 'phone', 'email', 'city', 'country']);
            session()->flash('success', 'Supplier created successfully');
            $this->dispatch('reloadSupplier');
            $this->dispatch('hideCreateModalNow');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('error: ' . $e->getMessage());
            session()->flash('error', $e->getMessage());
        }
    }

    #[\Livewire\Attributes\On('editSupplier')]
    public function editSupplier($supplier_id)
    {
        $supplier = Supplier::find($supplier_id);
        $this->id = $supplier->id;
        $this->code = $supplier->code;
        $this->name = $supplier->name;
        $this->address = $supplier->address;
        $this->phone = $supplier->phone;
        $this->email = $supplier->email;
        $this->city = $supplier->city;
        $this->country = $supplier->country;
        $this->pic = $supplier->pic;
        $this->edit = true;
        $this->dispatch('showCreateModalNow');
    }

    public function update()
    {
        $dataValidate = $this->validate([
            'code' => 'required',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'city' => 'required',
            'country' => 'required',
            'pic' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $data = [
                'code' => $dataValidate['code'],
                'name' => $dataValidate['name'],
                'address' => $dataValidate['address'],
                'phone' => $dataValidate['phone'],
                'email' => $dataValidate['email'],
                'city' => $dataValidate['city'],
                'country' => $dataValidate['country'],
                'pic' => $dataValidate['pic'],
                'updated_by' => Auth::id(),
            ];
            Supplier::find($this->id)->update($data);
            DB::commit();
            $this->edit = false;
            $this->reset(['code', 'name', 'address', 'phone', 'email', 'city', 'country']);
            session()->flash('success', 'Supplier updated successfully');
            $this->dispatch('reloadSupplier');
            $this->dispatch('hideCreateModalNow');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('error: ' . $e->getMessage());
            session()->flash('error', $e->getMessage());
        }
    }
}
