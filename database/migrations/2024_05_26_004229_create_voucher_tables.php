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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('voucher_no', 50)->unique();
            $table->string('trip_no');
            $table->string('plate_no');
            $table->string('destination');
            $table->decimal('first_amount')->default(0);
            $table->string('first_received_by')->nullable();
            $table->decimal('second_amount')->default(0);
            $table->string('second_received_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('status')->nullable();
            $table->string('attached_liquidation')->nullable();
            $table->string('voucher_image')->nullable();
            $table->boolean('is_archive')->default(false);
            $table->boolean('is_liquidated')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
