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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('membership_id')->unique();
            $table->string('full_name');
            $table->string('gender');
            $table->string('province');
            $table->string('city');
            $table->string('barangay');
            $table->string('street');
            $table->string('occupation');
            $table->string('mobile_number');
            $table->string('email')->unique();
            $table->string('emergency_name');
            $table->string('emergency_contact');
            $table->string('branch_location');
            $table->date('birth_date');

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
            $table->string('pt_session_coach_name');
            $table->integer('pt_session_price');
            $table->date('pt_session_expiration_date');
            $table->date('pt_session_start_date');
            $table->integer('pt_session_extension');
            $table->string('pt_session_type');
            $table->integer('pt_session_total');
            $table->integer('pt_session_used');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
