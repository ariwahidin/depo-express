<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\OldDB\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // $suppliers = Supplier::where('supplier_id', '!=', '')
        //     ->where('supplier_id', '!=', null)
        //     ->get();

        // foreach ($suppliers as $supplier) {
        //     \App\Models\Supplier::create(
        //         [
        //             'code' => $supplier->supplier_id,
        //             'name' => $supplier->supplier_name,
        //             'address' => $supplier->supplier_addr1,
        //             'phone' => $supplier->supplier_phone ?? '',
        //             'email' => $supplier->supplier_email ?? '',
        //             'city' => $supplier->supplier_city ?? '',
        //             'country' => $supplier->supplier_country ?? '',
        //             'pic' => $supplier->supplier_pic ?? '',
        //         ]
        //     );
        // }

        \App\Models\Supplier::create(
            [
                'code' => 'SUP-0001',
                'name' => 'OTHER',
                'address' => 'OTHER',
                'phone' => '',
                'email' => '',
                'city' => '',
                'country' => '',
                'pic' => '',
            ]
        );
    }
}
