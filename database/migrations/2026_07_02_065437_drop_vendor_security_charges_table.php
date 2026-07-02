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
        Schema::dropIfExists('vendor_security_charges');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('vendor_security_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('users')->onDelete('cascade');
            $table->decimal('security_deposit', 10, 2)->default(0);
            $table->decimal('excess_amount', 10, 2)->default(0);
            $table->decimal('young_driver_excess', 10, 2)->default(0);
            $table->decimal('under_21_surcharge', 10, 2)->default(0);
            $table->decimal('additional_driver_charge', 10, 2)->default(0);
            $table->decimal('young_additional_driver_charge', 10, 2)->default(0);
            $table->timestamps();
        });
    }
};
