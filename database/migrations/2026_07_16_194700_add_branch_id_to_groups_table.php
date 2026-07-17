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
        Schema::table('groups', function (Blueprint $table) {
            if (!Schema::hasColumn('groups', 'branch_id')) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('vendor_id');
                $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            }
            
            // Drop old composite unique constraint
            $table->dropUnique('groups_vendor_id_name_unique');
            
            // Add new composite unique constraint including branch_id
            $table->unique(['vendor_id', 'branch_id', 'name'], 'groups_vendor_id_branch_id_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropUnique('groups_vendor_id_branch_id_name_unique');
            $table->unique(['vendor_id', 'name'], 'groups_vendor_id_name_unique');
            
            if (Schema::hasColumn('groups', 'branch_id')) {
                $table->dropForeign(['branch_id']);
                $table->dropColumn('branch_id');
            }
        });
    }
};
