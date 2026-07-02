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
        Schema::create('vendor_extra_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_extra_id')->constrained('vendor_extras')->onDelete('cascade');
            $table->string('title');
            $table->boolean('status')->default(true);
            $table->integer('index_no')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_extra_features');
    }
};
