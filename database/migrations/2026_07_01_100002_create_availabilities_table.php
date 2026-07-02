<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('availabilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('vehicle_id')->nullable(); // null = whole group
            $table->unsignedBigInteger('rental_period_id')->nullable();
            $table->date('pickup_date');
            $table->date('dropup_date');
            $table->integer('min_day');
            $table->integer('max_day');
            $table->decimal('price', 10, 2);
            $table->tinyInteger('status')->default(1); // 1=active, 0=inactive
            $table->timestamps();

            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->foreign('rental_period_id')->references('id')->on('rental_periods')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('availabilities');
    }
};
