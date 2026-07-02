<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pickup_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->string('type');           // Airports, Self Collection, Delivery to your location, Borders
            $table->string('location');       // Pickup location name / address
            $table->decimal('price', 10, 2); // Location price
            $table->enum('map_type', ['coordinates', 'embedded'])->default('coordinates');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->text('map_embed')->nullable(); // iframe embed code
            $table->timestamps();

            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pickup_locations');
    }
};
