<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OldDB\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::all();
        foreach ($customers as $customer) {
            \App\Models\Customer::create(
                [
                    'code' => $customer->cust_id,
                    'name' => $customer->cust_name,
                    'address' => $customer->cust_addr1,
                    'area' => $customer->cust_area,
                    'city' => $customer->cust_city,
                    'country' => $customer->cust_country,
                    'phone' => $customer->cust_phone ?? '',
                    'email' => $customer->cust_email ?? '',
                    'delivery_owner' => $customer->delivery_owner,
                ]
            );
        }
    }
}
