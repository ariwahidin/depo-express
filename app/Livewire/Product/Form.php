<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Faker\Generator as Faker;
use Illuminate\Support\Testing\Fakes\Fake;

class Form extends Component
{
    public $category_id;
    public $categories;

    public $product_id;
    public $code;
    public $name;
    public $price;
    public $edit = false;

    public function mount() {
        $this->categories = \App\Models\Category::getActiveCategories()->get();
    }

    public function generateCode(Faker $faker) {
        $this->code = $faker->unique()->ean13();
    }

    #[\Livewire\Attributes\On('editProduct')]
    public function getProduct($product_id) {
        $product = \App\Models\Product::find($product_id);
        $this->product_id = $product->id;
        $this->category_id = $product->category_id;
        $this->code = $product->code;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->edit = true;
    }

    public function create(){
        $validatedData = $this->validate([
            'category_id' => 'required | numeric',
            'code' => 'required | unique:products,code,' . $this->product_id,
            'name' => 'required | unique:products,name,' . $this->product_id,
            'price' => 'required',
        ]);

        $validatedData['price'] = (int) str_replace(',', '', $validatedData['price']);

        try {
            DB::beginTransaction();
            $data = [
                'category_id' => $validatedData['category_id'],
                'code' => $validatedData['code'],
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'description' => '',
                'created_by' => Auth::id(),
            ];
            $product = \App\Models\Product::create($data);
            DB::commit();
            session()->flash('success', 'Product created successfully');
            $this->dispatch('reload-product', product_id : $product->id);
            $this->reset(['name']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error: ' . $th->getMessage()); // Log kesalahan
            session()->flash('error', 'Failed to create new product: ' . $th->getMessage());
        }
    }

    public function update() {

        $validatedData = $this->validate([
            'product_id' => 'required | numeric',
            'category_id' => 'required | numeric',
            'code' => 'required | unique:products,code,' . $this->product_id,
            'name' => 'required | unique:products,name,' . $this->product_id,
            'price' => 'required',
        ]);

        $validatedData['price'] = (int) str_replace(',', '', $validatedData['price']);

        try {
            DB::beginTransaction();
            $data = [
                'category_id' => $validatedData['category_id'],
                'code' => $validatedData['code'],
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'description' => '',
                'updated_by' => Auth::id(),
            ];
            $product = \App\Models\Product::find($this->product_id);
            $product->update($data);
            DB::commit();
            session()->flash('success', 'Product updated successfully');
            $this->dispatch('reload-product', product_id : $product->id);
            $this->reset(['name', 'product_id', 'category_id', 'code', 'price']);
            $this->edit = false;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error: ' . $th->getMessage()); // Log kesalahan
            session()->flash('error', 'Failed to update product: ' . $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.product.form');
    }
}
