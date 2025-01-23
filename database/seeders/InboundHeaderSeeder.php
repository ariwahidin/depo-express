<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OldDB\InboundHeader;

class InboundHeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $inboundHeaders = InboundHeader::all();
        foreach ($inboundHeaders as $inboundHeader) {
            \App\Models\InboundHeader::create([
                'receive_id' => $inboundHeader->receive_id,
                'trans_no' => $inboundHeader->trans_no,
                'supplier_code' => $inboundHeader->supplier_id,
                'truck_code' => $inboundHeader->truck_id,
                'location' => $inboundHeader->loc_id,
                'start_time' => $inboundHeader->start_time,
                'end_time' => $inboundHeader->finish_time,
                'doc_no' => $inboundHeader->doc_no,
                'invoice_no' => $inboundHeader->invoice_no,
                'po_date' => $inboundHeader->po_date,
                'site' => $inboundHeader->site,
                'truck_no' => $inboundHeader->truck_no,
                'remarks' => $inboundHeader->remarks,
                'driver' => $inboundHeader->driver,
                'stat' => $inboundHeader->stat,
                'bl' => $inboundHeader->BL,
                'aju' => $inboundHeader->AJU,
                'size_id' => $inboundHeader->id_sz,
                'start_unloading' => $inboundHeader->st_load,
                'end_unloading' => $inboundHeader->fs_load,
                'dos' => $inboundHeader->dos,
                'ib_type' => $inboundHeader->ib_type,
                'koli' => $inboundHeader->koli,
                'wh_code' => $inboundHeader->wh_code
            ]);
        }
    }
}
