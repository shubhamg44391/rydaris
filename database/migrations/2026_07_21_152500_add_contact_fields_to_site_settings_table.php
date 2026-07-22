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
            $table->string('contact_email')->nullable()->after('from_name');
            $table->string('sales_email')->nullable()->after('contact_email');
            $table->string('contact_phone')->nullable()->after('sales_email');
        });

        // Set default values for existing row
        DB::table('site_settings')->update([
            'contact_email' => 'support@rydaris.com',
            'sales_email'   => 'sales@rydaris.com',
            'contact_phone' => '+918882688646',
        ]);
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['contact_email', 'sales_email', 'contact_phone']);
        });
    }
};
