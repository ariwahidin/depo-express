<?php

namespace App\Livewire\Wms\Master\Customer;

use Livewire\Component;
use App\Models\Customer;
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
    public $area;

    public function render()
    {
        return view('livewire.wms.master.customer.form');
    }

    public function create()
    {
        $dataValidate = $this->validate([
            'code' => 'required | unique:customers,code',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'city' => 'required',
            'country' => 'required',
            'area' => 'required',
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
                'area' => $dataValidate['area'],
                'delivery_owner' => '',
                'created_by' => Auth::id(),
            ];
            Customer::create($data);
            DB::commit();
            $this->reset(['code', 'name', 'address', 'phone', 'email', 'city', 'country', 'area']);
            session()->flash('success', 'Customer created successfully');
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
        $customer = Customer::find($id);
        $this->id = $customer->id;
        $this->code = $customer->code;
        $this->name = $customer->name;
        $this->address = $customer->address;
        $this->phone = $customer->phone;
        $this->email = $customer->email;
        $this->city = $customer->city;
        $this->country = $customer->country;
        $this->area = $customer->area;
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
            'area' => 'required',
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
                'area' => $dataValidate['area'],
                'updated_by' => Auth::id(),
            ];
            Customer::find($this->id)->update($data);
            DB::commit();
            $this->edit = false;
            $this->reset(['code', 'name', 'address', 'phone', 'email', 'city', 'country', 'area']);
            session()->flash('success', 'Supplier updated successfully');
            $this->dispatch('reload');
            $this->dispatch('hideCreateModalNow');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('error: ' . $e->getMessage());
            session()->flash('error', $e->getMessage());
        }
    }
}
