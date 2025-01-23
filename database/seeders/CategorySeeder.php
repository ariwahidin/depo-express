<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\OldDB\Barang;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Barang::select('category')->distinct()->get();
        foreach ($categories as $category) {
            \App\Models\Category::create(
                [
                    'name' => $category->category
                ]
            );
        }
    }
}
