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
        Schema::create('inbound_headers', function (Blueprint $table) {
            $table->id();
            $table->string('receive_id')->unique();
            $table->date('received_date');
            $table->string('trans_no');
            $table->string('supplier_code');
            $table->string('truck_code');
            $table->string('location');
            $table->time('start_time')->default('00:00:00');
            $table->time('end_time')->default('00:00:00');
            $table->string('doc_no');
            $table->string('sj_no');
            $table->string('country');
            $table->string('invoice_no');
            $table->date('po_date');
            $table->string('site');
            $table->string('truck_no');
            $table->string('container_no');
            $table->string('remarks');
            $table->string('driver');
            $table->integer('stat')->default(0);
            $table->string('bl');
            $table->string('aju');
            $table->integer('size_id')->default(0);
            $table->time('start_unloading')->default('00:00:00');
            $table->time('end_unloading')->default('00:00:00');
            $table->string('dos');
            $table->string('ib_type');
            $table->string('status_proccess');
            $table->float('koli')->default(0);
            $table->float('seal')->default(0);
            $table->string('wh_code');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->integer('completed_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('delete_status', ['yes', 'no'])->default('no');
            $table->softDeletes();
            $table->timestamps();
            $table->dateTime('completed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inbound_headers');
    }
};
