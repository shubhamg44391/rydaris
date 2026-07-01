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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('eyebrow')->nullable();
            $table->text('description')->nullable();
            $table->string('price');
            $table->string('billing_period')->nullable()->default('/ month');
            $table->json('features');
            $table->boolean('is_featured')->default(false);
            $table->string('button_text')->default('Book Demo');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
