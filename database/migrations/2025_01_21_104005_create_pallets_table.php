<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pallets', function (Blueprint $table) {
            $table->id();
            $table->string('pallet_no')->unique();
            $table->string('stock_no');
            $table->string('item_code');
            $table->string('location');
            $table->float('qty_in')->default(0);
            $table->float('qty_out')->default(0);
            $table->float('qty_adjust')->default(0);
            $table->float('qty_alloc')->default(0);
            $table->float('qty_onhand')->default(0);
            $table->float('qty_avail')->default(0);
            $table->string('status_qa')->default('A');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pallets');
    }
};
