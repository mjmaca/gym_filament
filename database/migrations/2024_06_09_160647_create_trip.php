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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('trip_no');
            $table->string('plate_no');
            $table->string('driver_name');
            $table->string('helper_name');
            $table->decimal('budget');
            $table->json('items');
            $table->decimal('total_expenses');
            $table->decimal('cash_return');
            $table->decimal('total_toll_fee');
            $table->string('status');
            $table->foreignId('clients_id')->constrained()->cascadeOnDelete();
            $table->dateTime('billed_date');
            $table->string('billing_status');
            $table->boolean('is_archive')->default(false);
            $table->string('trip_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip');
    }
};
