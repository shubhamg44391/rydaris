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
            $table->integer('no_of_invitations')->nullable()->after('no_of_users');
            $table->integer('no_of_insurances')->nullable()->after('no_of_extras');
            $table->integer('no_of_features')->nullable()->after('no_of_insurances');
            $table->integer('no_of_rules')->nullable()->after('no_of_features');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn([
                'no_of_invitations',
                'no_of_insurances',
                'no_of_features',
                'no_of_rules'
            ]);
        });
    }
};
