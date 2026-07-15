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
        Schema::table('packages', function (Blueprint $table) {
            $table->integer('no_of_bookings')->nullable()->after('no_of_coupons');
            $table->integer('no_of_locations')->nullable()->after('no_of_bookings');
            $table->integer('no_of_extras')->nullable()->after('no_of_locations');
            $table->integer('no_of_support_tickets')->nullable()->after('no_of_extras');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn([
                'no_of_bookings',
                'no_of_locations',
                'no_of_extras',
                'no_of_support_tickets'
            ]);
        });
    }
};
