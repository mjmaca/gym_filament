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
        Schema::create('waybills', function (Blueprint $table) {
            $table->id();
            $table->string('waybill_no');
            $table->date('date');
            $table->string('shipment_no');
            $table->string('trip_ticket_no');
            $table->string('document_status');
            $table->string('approved_by');
            $table->string('type_of_trip');
            $table->string('truck_type');
            $table->string('plate_no');
            $table->string('driver_name');
            $table->string('helper_name');
            $table->string('routes');
            $table->string('origin_location');
            $table->dateTime('truck_in_origin');
            $table->dateTime('received_datetime_origin');
            $table->dateTime('loading_time_start');
            $table->dateTime('loading_time_finish');
            $table->dateTime('loading_docs_release');
            $table->dateTime('loading_truck_out');
            $table->string('destination_location');
            $table->dateTime('truck_in_destination');
            $table->dateTime('received_datetime_destination');
            $table->dateTime('unloading_time_start');
            $table->dateTime('unloading_time_finish');
            $table->dateTime('unloading_docs_release');
            $table->dateTime('unloading_truck_out');
            $table->string('waybill_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waybill');
    }
};
