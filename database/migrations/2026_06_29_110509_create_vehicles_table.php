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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('group_id')->nullable()->constrained('groups')->onDelete('set null');
            $table->string('name');
            $table->string('model')->nullable();
            $table->integer('seats')->default(4);
            $table->integer('doors')->default(4);
            $table->integer('bags')->default(0);
            $table->string('status')->default('active'); // active/inactive
            $table->string('image')->nullable();
            $table->string('gear_system')->default('manual'); // manual/automatic
            $table->integer('passengers')->default(4);
            $table->string('wheel_drive')->default('FWD'); // FWD, RWD, AWD
            $table->string('code');
            $table->integer('stock')->default(1);
            $table->text('features')->nullable(); // JSON array
            $table->text('terms')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
