<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use FakerCommerce\Faker\FakerFactory;

use App\Models\OldDB\Barang;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barangs = Barang::all();
        foreach ($barangs as $item) {
            \App\Models\Item::create([
                'item_code' => $item->item_code,
                'barcode_ean' => $item->barcode_ean,
                'area' => $item->area,
                'barcode_model' => $item->barcode_model,
                'item_name' => $item->item_name,
                'owner' => $item->owner_id,
                'std_pallet' => $item->std_pallet,

                'width' => $item->width,
                'length' => $item->length,
                'height' => $item->height,
                'uom' => $item->UOM,
                'kubikasi' => $item->kubikasi,
                'kubikasi_sap' => $item->kubikasi_sap,
                'gross_weight' => $item->gross_weight,
                'net_weight' => $item->net_weight,

                'category' => $item->category,
                'group' => $item->grup,

                'sap_code' => $item->sap_code,
                'sap_description' => $item->sap_description,
                'val_type' => $item->val_type,

                'waranty' =>  in_array(strtoupper($item->waranty), ['Y', 'N']) ? strtoupper($item->waranty) : 'N',
                'manual_book' => in_array(strtoupper($item->manual_book), ['Y', 'N']) ? strtoupper($item->manual_book) : 'N',
                'adaptor' => in_array(strtoupper($item->adaptor), ['Y', 'N']) ? strtoupper($item->adaptor) : 'N',
                'sn' => in_array(strtoupper($item->sn), ['Y', 'N']) ? strtoupper($item->sn) : 'N',
                'remarks' => $item->remarks,
            ]);
        }
    }
}
