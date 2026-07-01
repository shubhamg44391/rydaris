<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Remove global unique on 'name' and add composite unique on (vendor_id, name)
     * so that each vendor can have their own unique group names,
     * but two different vendors CAN have groups with the same name.
     */
    public function up(): void
    {
        Schema::table('groups', function (Blueprint $table) {
            // Drop the old global unique index on 'name'
            $table->dropUnique('groups_name_unique');

            // Add composite unique: same vendor cannot have duplicate group names
            $table->unique(['vendor_id', 'name'], 'groups_vendor_id_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropUnique('groups_vendor_id_name_unique');
            $table->unique('name', 'groups_name_unique');
        });
    }
};
