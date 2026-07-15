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
            $table->boolean('booking_menu')->default(true)->after('no_of_coupons');
            $table->boolean('vehicles_menu')->default(true)->after('booking_menu');
            $table->boolean('locations_menu')->default(true)->after('vehicles_menu');
            $table->boolean('customers_menu')->default(true)->after('locations_menu');
            $table->boolean('fleet_management_menu')->default(true)->after('customers_menu');
            $table->boolean('extras_menu')->default(true)->after('fleet_management_menu');
            $table->boolean('coupons_menu')->default(true)->after('extras_menu');
            $table->boolean('support_ticket_menu')->default(true)->after('coupons_menu');
            $table->boolean('settings_menu')->default(true)->after('support_ticket_menu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn([
                'booking_menu',
                'vehicles_menu',
                'locations_menu',
                'customers_menu',
                'fleet_management_menu',
                'extras_menu',
                'coupons_menu',
                'support_ticket_menu',
                'settings_menu'
            ]);
        });
    }
};
