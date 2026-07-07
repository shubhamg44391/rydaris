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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('reservation_number')->unique();
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('vehicle_id');
            
            // Customer Info
            $table->string('customer_fname');
            $table->string('customer_lname');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('customer_dob')->nullable();
            
            // Rental Info
            $table->unsignedBigInteger('pickup_location_id')->nullable();
            $table->unsignedBigInteger('return_location_id')->nullable();
            $table->string('pickup_date');
            $table->string('pickup_time');
            $table->string('return_date');
            $table->string('return_time');
            
            // Financial Info
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('pending_amount', 10, 2)->default(0);
            
            // Payment & Status
            $table->string('payment_method')->nullable();
            $table->string('payment_reference')->nullable();
            $table->string('booking_status')->default('pending'); // pending, confirmed, cancelled, completed
            $table->string('payment_status')->default('unpaid'); // unpaid, paid, partially_paid
            
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
