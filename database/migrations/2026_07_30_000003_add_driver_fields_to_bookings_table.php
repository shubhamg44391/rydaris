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
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('driver_id')->nullable()->after('vehicle_id')->constrained('drivers')->onDelete('set null');
            $table->timestamp('assigned_at')->nullable()->after('driver_id');
            $table->unsignedBigInteger('assigned_by_vendor')->nullable()->after('assigned_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['driver_id']);
            $table->dropColumn(['driver_id', 'assigned_at', 'assigned_by_vendor']);
        });
    }
};
