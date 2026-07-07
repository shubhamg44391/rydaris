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
        Schema::create('vendor_payment_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id')->unique();
            $table->boolean('pay_on_arrival')->default(true);
            $table->boolean('pay_deposit')->default(false);
            $table->decimal('deposit_percentage', 5, 2)->default(5.00);
            $table->boolean('pay_full')->default(false);
            $table->decimal('full_payment_discount', 5, 2)->default(0.00);
            $table->timestamps();
            
            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_payment_settings');
    }
};
