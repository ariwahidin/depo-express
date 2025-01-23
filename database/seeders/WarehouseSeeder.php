<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OldDB\Warehouse;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $warehouses = Warehouse::all();
        foreach ($warehouses as $warehouse) {
            \App\Models\Warehouse::create(
                [
                    'code' => $warehouse->wh_code
                ]
            );
        }
    }
}
