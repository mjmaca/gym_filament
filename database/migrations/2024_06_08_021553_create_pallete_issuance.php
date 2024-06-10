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
        Schema::create('pallet_issuances', function (Blueprint $table) {
            $table->id();
            $table->string('warehouse_location');
            $table->date('date');
            $table->string('document_status');
            $table->string('approved_by');
            $table->string('pallet_issuance_no');
            $table->string('trip_no');
            $table->string('reference_no');
            $table->string('driver');
            $table->string('plate_no');
            $table->string('trucker');
            $table->string('pallet_issuance_image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pallete_issuance');
    }
};
