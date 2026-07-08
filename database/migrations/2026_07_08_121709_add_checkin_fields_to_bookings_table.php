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
            $table->string('license_number')->nullable();
            $table->date('license_issue_date')->nullable();
            $table->date('license_expiry_date')->nullable();
            $table->string('license_image')->nullable();
            $table->string('passport_image')->nullable();
            $table->string('pass_number')->nullable();
            $table->string('flight_number')->nullable();
            $table->boolean('checkin_status')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'license_number',
                'license_issue_date',
                'license_expiry_date',
                'license_image',
                'passport_image',
                'pass_number',
                'flight_number',
                'checkin_status'
            ]);
        });
    }
};
