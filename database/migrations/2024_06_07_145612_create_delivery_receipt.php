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
        Schema::create('delivery_receipts', function (Blueprint $table) {
            $table->id();
            $table->string('document_status');
            $table->string('approved_by');
            $table->date('date');
            $table->string('deliver_to');
            $table->string('delivery_receipt_no');
            $table->string('address');
            $table->string('trip_no');
            $table->string('tin_no');
            $table->string('custom_code');
            $table->string('ref_so_no');
            $table->string('hauler');
            $table->string('ref_po_no');
            $table->string('plate_no');
            $table->string('warehouse_location');
            $table->string('checked_by');
            $table->string('trucking');
            $table->decimal('total_amount');
            $table->json('item_details');
            $table->string('delivery_receipt_image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_receipt');
    }
};
