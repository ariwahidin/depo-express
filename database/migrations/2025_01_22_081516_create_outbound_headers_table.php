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
        Schema::create('outbound_headers', function (Blueprint $table) {
            $table->id();
            $table->string('trans_no');
            $table->string('outbound_no')->unique();
            $table->date('plan_pickup_date');
            $table->date('picking_date');
            $table->date('rec_do_date');
            $table->time('rec_do_time')->default('00:00:00');
            $table->time('start_picking')->default('00:00:00');
            $table->time('end_picking')->default('00:00:00');
            $table->string('picker_name');
            $table->string('truck_code');
            $table->string('truck_no');
            $table->string('truck_size');
            $table->string('driver');
            $table->string('remarks');
            $table->string('destination');
            $table->string('customer_code');
            $table->string('delivery_customer_code');
            $table->float('koli')->default(0);
            $table->float('seal')->default(0);
            $table->enum('status_proccess', ['open', 'process', 'completed'])->default('open');
            $table->string('wh_code')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->integer('completed_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('completed_by')->references('id')->on('users');
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
        Schema::dropIfExists('outbound_headers');
    }
};
