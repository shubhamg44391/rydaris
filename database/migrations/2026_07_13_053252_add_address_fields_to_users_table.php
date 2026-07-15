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
        Schema::table('users', function (Blueprint $table) {
            $table->string('street_address')->nullable()->after('company_name');
            $table->string('landmark')->nullable()->after('street_address');
            $table->string('pincode')->nullable()->after('landmark');
            $table->string('city')->nullable()->after('pincode');
            $table->string('country')->nullable()->after('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['street_address', 'landmark', 'pincode', 'city', 'country']);
        });
    }
};
