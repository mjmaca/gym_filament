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
        Schema::create('route_rates', function (Blueprint $table) {
            $table->id();
            $table->string('unique_identifier');
            $table->string('route_description');
            $table->string('route_code');
            $table->foreignId('clients_id')->constrained()->cascadeOnDelete();
            $table->string('plant');
            $table->string('truck_type');
            $table->string('customer_delivery');
            $table->decimal('rate_ex_vat', 10, 2);
            $table->decimal('rate_fuel_cost', 10, 2);
            $table->string('shipment_type');
            $table->decimal('two_way_distance', 10, 2);
            $table->decimal('fuel_consumption', 10, 2);
            $table->decimal('actual_fuel_consumption', 10, 2);
            $table->decimal('pump_price', 10, 2);
            $table->decimal('fuel_cost', 10, 2);
            $table->date('start_fuel_period');
            $table->date('end_fuel_period');
            $table->decimal('total_rates', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_rates');
    }
};
