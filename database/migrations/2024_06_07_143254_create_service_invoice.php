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
        Schema::create('service_invoices', function (Blueprint $table) {
            $table->id();
            $table->date('date_submit');
            $table->string('service_invoice_no');
            $table->string('trip_no');
            $table->string('client_name');
            $table->string('terms');
            $table->string('approved_by');
            $table->decimal('total_amount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_invoice');
    }
};
