<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class OutboundHeader extends Model
{
    protected $guarded = [];

    public static function generateOutboundNo(): string
    {
        // Get the current year (last two digits) and month
        $year = Carbon::now()->format('y'); // e.g., '24'
        $month = Carbon::now()->format('m'); // e.g., '01'

        // Prefix for the ID
        $prefix = "OBD-$year$month";

        // Query to find the last inserted ID with the same prefix
        $lastId = DB::table('outbound_headers')
            ->where('outbound_no', 'like', "$prefix%")
            ->orderBy('outbound_no', 'desc')
            ->value('outbound_no');

        // Extract the last numeric part from the last ID
        if ($lastId) {
            $lastNumber = (int) substr($lastId, -5); // Get the last 5 digits
        } else {
            $lastNumber = 0; // Start from 0 if no matching ID exists
        }

        // Increment the last number
        $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

        // Combine prefix and new number to generate the new ID
        return "$prefix$newNumber";
    }

    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_code', 'code');
    }

    public function delivery_customers()
    {
        return $this->belongsTo(Customer::class, 'customer_code', 'code');
    }

    public function transporters()
    {
        return $this->belongsTo(Transporter::class, 'truck_code', 'code');
    }
}
