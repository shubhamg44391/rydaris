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
            if (!Schema::hasColumn('packages', 'no_of_users')) {
                $table->integer('no_of_users')->nullable();
            }
            if (!Schema::hasColumn('packages', 'no_of_vehicles')) {
                $table->integer('no_of_vehicles')->nullable();
            }
            if (!Schema::hasColumn('packages', 'no_of_groups')) {
                $table->integer('no_of_groups')->nullable();
            }
            if (!Schema::hasColumn('packages', 'no_of_coupons')) {
                $table->integer('no_of_coupons')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            if (Schema::hasColumn('packages', 'no_of_users')) {
                $table->dropColumn('no_of_users');
            }
            if (Schema::hasColumn('packages', 'no_of_vehicles')) {
                $table->dropColumn('no_of_vehicles');
            }
            if (Schema::hasColumn('packages', 'no_of_groups')) {
                $table->dropColumn('no_of_groups');
            }
            if (Schema::hasColumn('packages', 'no_of_coupons')) {
                $table->dropColumn('no_of_coupons');
            }
        });
    }
};
