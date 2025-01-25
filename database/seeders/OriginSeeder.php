<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OldDB\Origin;

class OriginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $origins = Origin::all();
        // foreach ($origins as $origin) {
        //     \App\Models\Origin::create(
        //         [
        //             'name' => $origin->country,
        //         ]
        //     );
        // }

        \App\Models\Origin::create(
            [
                'name' => 'OTHER',
            ]
        );
    }
}
