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
        Schema::create('inbound_details', function (Blueprint $table) {
            $table->id();
            $table->integer('inbound_id');
            $table->string('receive_id');
            $table->string('item_code');
            $table->float('price');
            $table->string('location');
            $table->date('receive_date');
            $table->integer('req_qty');
            $table->integer('scan_qty')->default(0);
            $table->string('wh_code');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->enum('status', ['open', 'close'])->default('open');
            $table->enum('delete_status', ['yes', 'no'])->default('no');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inbound_details');
    }
};
