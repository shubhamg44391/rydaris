<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pickup_locations', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->nullable()->after('vendor_id');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->nullable()->after('vendor_id');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
        });

        Schema::table('vendor_extras', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->nullable()->after('vendor_id');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pickup_locations', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });

        Schema::table('vendor_extras', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });
    }
};
