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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('membership_id')->unique();
            $table->string('branch_location');

            // Gym Access
            $table->integer('gym_access_discount');
            $table->date('gym_access_expiration_date');
            $table->date('gym_access_start_date');
            $table->integer('gym_access_price');
            $table->string('gym_access_plan');
            $table->integer('gym_access_extension');

            // Gym Membership
            $table->integer('gym_membership_discount');
            $table->date('gym_membership_expiration_date');
            $table->date('gym_membership_start_date');
            $table->integer('gym_membership_price');
            $table->string('gym_membership_type');
            $table->integer('gym_membership_extension');

            // PT Session
            $table->string('pt_session_coach_name')->nullable();
            $table->integer('pt_session_price')->nullable();
            $table->date('pt_session_expiration_date')->nullable();
            $table->date('pt_session_start_date')->nullable();
            $table->integer('pt_session_extension')->nullable();
            $table->string('pt_session_type')->nullable();
            $table->integer('pt_session_total')->nullable();
            $table->integer('pt_session_used')->default(0); // Not nullable, default value 0

            // //Payment
            $table->string('payment_method');
            $table->integer('amount');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
