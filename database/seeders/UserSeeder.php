<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Wahyudi',
            'email' => 'wahyudi@gmail.com',
        ]);

        $admin->assignRole('admin');

        $adminYcid = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@ycid.com',
            'password' => bcrypt('@dmin123#!'),
        ]);

        $adminYcid->assignRole('admin');

        $adminYcid = User::factory()->create([
            'name' => 'Derry Mulyanto',
            'email' => 'derry.mulyanto@id.yusen-logistics.com',
            'password' => bcrypt('DMyo2501'),
        ]);

        $adminYcid->assignRole('admin');

        $adminYcid = User::factory()->create([
            'name' => 'Deri Andi Wijaya',
            'email' => 'gudanginventory.cakung@id.yusen-logistics.com',
            'password' => bcrypt('GIck2501'),
        ]);

        $adminYcid->assignRole('admin');
    }
}
