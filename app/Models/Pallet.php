<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pallet extends Model
{
    protected $guarded = [];

    public static function generatePalletNo(): string
    {
        // Prefix for the ID
        $prefix = "PLT-";

        // Query to find the last inserted ID with the same prefix
        $lastId = DB::table('pallets')
            ->where('pallet_no', 'like', "$prefix%")
            ->orderBy('pallet_no', 'desc')
            ->value('pallet_no');

        // Extract the last numeric part from the last ID
        if ($lastId) {
            $lastNumber = (int) substr($lastId, -10); // Get the last 5 digits
        } else {
            $lastNumber = 0; // Start from 0 if no matching ID exists
        }

        // Increment the last number
        $newNumber = str_pad($lastNumber + 1, 10, '0', STR_PAD_LEFT);

        // Combine prefix and new number to generate the new ID
        return "$prefix$newNumber";
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'stock_no', 'stock_no');
    }
}
