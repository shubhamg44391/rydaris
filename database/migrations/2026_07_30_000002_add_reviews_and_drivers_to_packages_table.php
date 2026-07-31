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
            if (!Schema::hasColumn('packages', 'reviews_menu')) {
                $table->boolean('reviews_menu')->default(true)->after('community_menu');
            }
            if (!Schema::hasColumn('packages', 'no_of_reviews')) {
                $table->string('no_of_reviews')->nullable()->after('no_of_maintenance_schedules');
            }
            if (!Schema::hasColumn('packages', 'drivers_menu')) {
                $table->boolean('drivers_menu')->default(true)->after('reviews_menu');
            }
            if (!Schema::hasColumn('packages', 'no_of_drivers')) {
                $table->string('no_of_drivers')->nullable()->after('no_of_reviews');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn(['reviews_menu', 'no_of_reviews', 'drivers_menu', 'no_of_drivers']);
        });
    }
};
