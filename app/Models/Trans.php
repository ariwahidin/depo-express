<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Trans extends Model
{
    protected $guarded = [];

    public static function getTransNo(): string
    {
        // Get the current year (last two digits) and month
        $year = Carbon::now()->format('y'); // e.g., '24'
        $month = Carbon::now()->format('m'); // e.g., '01'

        // Prefix for the ID
        $prefix = "TRN-$year$month";

        // Query to find the last inserted ID with the same prefix
        $lastId = DB::table('trans')
            ->where('trans_no', 'like', "$prefix%")
            ->orderBy('trans_no', 'desc')
            ->value('trans_no');

        // Extract the last numeric part from the last ID
        if ($lastId) {
            $lastNumber = (int) substr($lastId, -10); // Get the last 10 digits
        } else {
            $lastNumber = 0; // Start from 0 if no matching ID exists
        }

        // Increment the last number
        $newNumber = str_pad($lastNumber + 1, 10, '0', STR_PAD_LEFT);

        // Insert To Table

        DB::table('trans')
            ->insert([
                'trans_no' => "$prefix$newNumber",
                'trans_date' => Carbon::now()->format('Y-m-d'),
                'trans_status' => 'open',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        // Combine prefix and new number to generate the new ID
        return "$prefix$newNumber";
    }
}
