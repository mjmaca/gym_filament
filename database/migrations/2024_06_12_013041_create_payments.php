<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('membership_id')->nullable();
            $table->string('full_name');
            $table->string('branch_location');

            // Gym Membership
            $table->integer('gym_membership_discount')->nullable();
            $table->date('gym_membership_expiration_date')->nullable();
            $table->date('gym_membership_start_date')->nullable();
            $table->float('gym_membership_price', 8, 2)->nullable();
            $table->string('gym_membership_type')->nullable();
            $table->integer('gym_membership_extension')->nullable();

            // Gym Access
            $table->integer('gym_access_discount')->nullable();;
            $table->date('gym_access_expiration_date')->nullable();;
            $table->date('gym_access_start_date')->nullable();;
            $table->float('gym_access_price', 8, 2)->nullable();;
            $table->string('gym_access_plan')->nullable();;
            $table->integer('gym_access_extension')->nullable();;

            // PT Session
            $table->string('pt_session_coach_name')->nullable();
            $table->float('pt_session_price', 8, 2)->nullable();
            $table->date('pt_session_expiration_date')->nullable();
            $table->date('pt_session_start_date')->nullable();
            $table->integer('pt_session_extension')->nullable();
            $table->string('pt_session_type')->nullable();
            $table->integer('pt_session_total')->nullable();
            $table->integer('pt_session_used')->default(0); // Not nullable, default value 0

            // //Payment
            $table->string('reference_no');
            $table->string('payment_method');
            $table->float('amount', 8, 2);

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
