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
        Schema::create('training_types', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('branch_location');
            $table->integer('session_number');
            $table->integer('session_price');
            $table->integer('session_duration');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_types');
    }
};
