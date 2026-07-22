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
        Schema::table('site_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('site_settings', 'site_logo')) {
                $table->string('site_logo')->nullable()->after('contact_phone');
            }
            if (!Schema::hasColumn('site_settings', 'favicon')) {
                $table->string('favicon')->nullable()->after('site_logo');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['site_logo', 'favicon']);
        });
    }
};
