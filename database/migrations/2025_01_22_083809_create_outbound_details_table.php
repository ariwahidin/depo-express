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
        Schema::create('outbound_details', function (Blueprint $table) {
            $table->id();
            $table->integer('outbound_id');
            $table->foreign('outbound_id')->references('id')->on('outbound_headers');
            $table->string('outbound_no');
            $table->string('do_no');
            $table->string('item_code');
            $table->string('location');
            $table->integer('req_qty');
            $table->integer('scan_qty')->default(0);
            $table->string('status_qa');
            $table->string('wh_code');
            $table->string('remarks');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
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
        Schema::dropIfExists('outbound_details');
    }
};
