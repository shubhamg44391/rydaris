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
            if (!Schema::hasColumn('packages', 'maintenance_schedule_menu')) {
                $table->boolean('maintenance_schedule_menu')->default(true)->after('fleet_management_menu');
            }
            if (!Schema::hasColumn('packages', 'no_of_maintenance_schedules')) {
                $table->integer('no_of_maintenance_schedules')->nullable()->after('no_of_support_tickets');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            if (Schema::hasColumn('packages', 'maintenance_schedule_menu')) {
                $table->dropColumn('maintenance_schedule_menu');
            }
            if (Schema::hasColumn('packages', 'no_of_maintenance_schedules')) {
                $table->dropColumn('no_of_maintenance_schedules');
            }
        });
    }
};
