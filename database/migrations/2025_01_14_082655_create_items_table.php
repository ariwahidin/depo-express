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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_code')->unique();
            $table->string('barcode_ean');
            $table->string('area');
            $table->string('barcode_model');
            $table->string('item_name');
            $table->string('owner');
            $table->float('std_pallet')->default(0);

            $table->float('width')->default(0);
            $table->float('length')->default(0);
            $table->float('height')->default(0);
            $table->string('uom');
            $table->float('kubikasi')->default(0);
            $table->float('kubikasi_sap')->default(0);
            $table->float('gross_weight')->default(0);
            $table->float('net_weight')->default(0);

            $table->string('sap_code');
            $table->string('sap_description');
            
            $table->string('category');
            $table->string('group');
            $table->string('val_type');
            $table->enum('waranty', ['Y', 'N'])->default('Y');
            $table->enum('manual_book', ['Y', 'N'])->default('Y');
            $table->enum('adaptor', ['Y', 'N'])->default('Y');
            $table->enum('sn', ['Y', 'N'])->default('Y');
            $table->string('remarks');
            $table->float('price')->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
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
        Schema::dropIfExists('items');
    }
};
