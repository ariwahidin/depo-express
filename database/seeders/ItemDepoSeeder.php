<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class ItemDepoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path file Excel
        $filePath = storage_path('app/data_item.xlsx');

        $data = Excel::toArray([], $filePath);

        // Data berada di sheet pertama
        $rows = $data[0];

        // Lewati header
        array_shift($rows);

        // Insert data ke database
        foreach ($rows as $item) {
            \App\Models\Item::create([


                'item_code' => $item[0],
                'barcode_ean' => $item[0],
                'area' => 'OTHER',
                'barcode_model' => $item[0],
                'item_name' => $item[1],
                'price' => $item[4],
                'owner' => 'OTHER',
                'std_pallet' => 0,

                'width' => 0,
                'length' => 0,
                'height' => 0,
                'uom' => $item[2],
                'kubikasi' => 0,
                'kubikasi_sap' => 0,
                'gross_weight' => 0,
                'net_weight' => 0,

                'category' => 'OTHER',
                'group' => 'OTHER',

                'sap_code' => '',
                'sap_description' => '',
                'val_type' => '',

                'waranty' =>  'N', 
                'manual_book' => 'N',
                'adaptor' => 'N',
                'sn' => 'N',
                'remarks' => '',

                // 'name' => $row[0],
                // 'email' => $row[1],
                // 'phone' => $row[2],
            ]);
        }
    }
}
