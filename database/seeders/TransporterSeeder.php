<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OldDB\Ekspedisi;

class TransporterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transporters = Ekspedisi::all();
        foreach ($transporters as $transporter) {
            \App\Models\Transporter::create(
                [
                    'code' => $transporter->eks_id,
                    'name' => $transporter->eks_name,
                    'address' => $transporter->eks_adderss ?? '',
                    'phone' => $transporter->phone ?? '',
                    'email' => $transporter->email ?? '',
                    'city' => $transporter->city ?? '',
                    'country' => $transporter->country ?? '',
                    'pic' => $transporter->pic ?? '',
                    'fax' => $transporter->fax ?? '',
                ]
            );
        }
    }
}
