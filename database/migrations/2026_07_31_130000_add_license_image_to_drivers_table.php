<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('drivers', 'license_image')) {
            Schema::table('drivers', function (Blueprint $table) {
                $table->string('license_image')->nullable()->after('license_expiry');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('drivers', 'license_image')) {
            Schema::table('drivers', function (Blueprint $table) {
                $table->dropColumn('license_image');
            });
        }
    }
};
