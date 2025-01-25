<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OldDB\SizeTruck;

class TruckSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $trucks = SizeTruck::all();
        // foreach ($trucks as $truck) {
        //     \App\Models\TruckSize::create(
        //         [
        //             'code' => $truck->size_tr,
        //             'name' => $truck->desc,
        //             'description' => $truck->desc,
        //             'volume_cbm' => $truck->volume_cbm,
        //             'volume_cbm_90' => $truck->volume_cbm_90
        //         ]
        //     );
        // }

        \App\Models\TruckSize::create(
            [
                'code' => 'TRK-0001',
                'name' => 'OTHER',
                'description' => 'OTHER',
                'volume_cbm' => 0,
                'volume_cbm_90' => 0,
            ]
        );
    }
}
