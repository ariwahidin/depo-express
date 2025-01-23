<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 15; $i++) {
            $owner = \App\Models\Owner::create(
                [
                    'code' => Str::random(6),
                    'name' => fake()->name(),
                    'address' => fake()->address(),
                    'city' => fake()->city(),
                    'country' => fake()->country(),
                ]
            );
        }
    }
}
