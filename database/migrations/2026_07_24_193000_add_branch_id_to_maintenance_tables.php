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
        if (Schema::hasTable('maintenance_schedules') && !Schema::hasColumn('maintenance_schedules', 'branch_id')) {
            Schema::table('maintenance_schedules', function (Blueprint $table) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('vendor_id');
            });
        }

        if (Schema::hasTable('maintenance_requests') && !Schema::hasColumn('maintenance_requests', 'branch_id')) {
            Schema::table('maintenance_requests', function (Blueprint $table) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('vendor_id');
            });
        }

        if (Schema::hasTable('work_orders') && !Schema::hasColumn('work_orders', 'branch_id')) {
            Schema::table('work_orders', function (Blueprint $table) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('vendor_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('maintenance_schedules') && Schema::hasColumn('maintenance_schedules', 'branch_id')) {
            Schema::table('maintenance_schedules', function (Blueprint $table) {
                $table->dropColumn('branch_id');
            });
        }
        if (Schema::hasTable('maintenance_requests') && Schema::hasColumn('maintenance_requests', 'branch_id')) {
            Schema::table('maintenance_requests', function (Blueprint $table) {
                $table->dropColumn('branch_id');
            });
        }
        if (Schema::hasTable('work_orders') && Schema::hasColumn('work_orders', 'branch_id')) {
            Schema::table('work_orders', function (Blueprint $table) {
                $table->dropColumn('branch_id');
            });
        }
    }
};
