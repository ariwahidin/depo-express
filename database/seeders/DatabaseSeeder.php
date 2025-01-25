<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\OldDB\Origin;
use App\Models\Supplier;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Permission::create(['name' => 'add-category']);
        Permission::create(['name' => 'edit-category']);
        Permission::create(['name' => 'delete-category']);
        Permission::create(['name' => 'view-category']);

        Permission::create(['name' => 'add-product']);
        Permission::create(['name' => 'edit-product']);
        Permission::create(['name' => 'delete-product']);
        Permission::create(['name' => 'view-product']);

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        $roleAdmin = Role::findByName('admin');

        $roleAdmin->givePermissionTo('add-category');
        $roleAdmin->givePermissionTo('edit-category');
        $roleAdmin->givePermissionTo('delete-category');
        $roleAdmin->givePermissionTo('view-category');

        $roleAdmin->givePermissionTo('add-product');
        $roleAdmin->givePermissionTo('edit-product');
        $roleAdmin->givePermissionTo('delete-product');
        $roleAdmin->givePermissionTo('view-product');

        $roleUser = Role::findByName('user');

        $roleUser->givePermissionTo('view-category');
        $roleUser->givePermissionTo('view-product');

        // User::factory(10)->create();
        $admin = User::factory()->create([
            'name' => 'Ari Wahidin',
            'email' => 'ariwahidin88@gmail.com',
        ]);

        $admin->assignRole('admin');

        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@gmail.com',
        ]);

        $user->assignRole('user');


        $this->call([
            SupplierSeeder::class,
            MenuSeeder::class,
            OwnerSeeder::class,
            CustomerSeeder::class,
            CategorySeeder::class,
            ItemDepoSeeder::class,
            TransporterSeeder::class,
            TruckSizeSeeder::class,
            WarehouseSeeder::class,
            OriginSeeder::class,
            UserSeeder::class,
        ]);

    }
}
