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
            $table->integer('gym_access_discount')->nullable();
            $table->date('gym_access_expiration_date')->nullable();
            $table->date('gym_access_start_date')->nullable();
            $table->integer('gym_access_price')->nullable();
            $table->string('gym_access_plan')->nullable();
            $table->integer('gym_access_extension')->nullable();

            // Gym Membership
            $table->integer('gym_membership_discount')->nullable();
            $table->date('gym_membership_expiration_date')->nullable();
            $table->date('gym_membership_start_date')->nullable();
            $table->integer('gym_membership_price')->nullable();
            $table->string('gym_membership_type')->nullable();
            $table->integer('gym_membership_extension')->nullable();

            // PT Session
            $table->string('pt_session_coach_name')->nullable();
            $table->integer('pt_session_price')->nullable();
            $table->date('pt_session_expiration_date')->nullable();
            $table->date('pt_session_start_date')->nullable();
            $table->integer('pt_session_extension')->nullable();
            $table->string('pt_session_type')->nullable();
            $table->integer('pt_session_total')->nullable();
            $table->integer('pt_session_used')->default(0)->nullable();
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
