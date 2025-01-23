<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    protected $guarded = [];



    public static function generateStockNo(): string
    {
        // Prefix for the ID
        $prefix = "STK-";

        // Query to find the last inserted ID with the same prefix
        $lastId = DB::table('stocks')
            ->where('stock_no', 'like', "$prefix%")
            ->orderBy('stock_no', 'desc')
            ->value('stock_no');

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





    // protected function casts(): array
    // {
    //     return [
    //         'quantity' => 'integer',
    //     ];
    // }

    // public function product(): BelongsTo
    // {
    //     // how to get category?
    //     return $this->belongsTo(Product::class);
    // }

    // public function scopeStockActive(Builder $query)
    // {
    //     return $query->join('products', 'products.id', '=', 'stocks.product_id')
    //         ->selectRaw('stocks.product_id, SUM(stocks.quantity) as quantity, products.name as product_name')
    //         ->where('stocks.delete_status', 'no')
    //         ->where('stocks.status', 'active')
    //         ->groupBy('stocks.product_id', 'products.name')
    //         ->orderBy('products.name', 'asc')
    //         ->get();
    // }

    // public function scopeStockActiveByProduct(Builder $query, $product_id)
    // {
    //     return $query->join('products', 'products.id', '=', 'stocks.product_id')
    //         ->join('categories', 'categories.id', '=', 'products.category_id')
    //         ->selectRaw('stocks.product_id, categories.name as category_name, stocks.quantity, products.name as product_name')
    //         ->where('stocks.delete_status', 'no')
    //         ->where('stocks.status', 'active')
    //         ->where('stocks.product_id', $product_id)
    //         ->orderBy('products.name', 'asc')
    //         ->get();
    // }
}
