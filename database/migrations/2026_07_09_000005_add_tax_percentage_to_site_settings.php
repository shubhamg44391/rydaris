<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->decimal('tax_percentage', 5, 2)->default(18.00)->after('razorpay_active');
        });

        // Set default value for existing rows
        DB::table('site_settings')->update(['tax_percentage' => 18.00]);
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn('tax_percentage');
        });
    }
};
