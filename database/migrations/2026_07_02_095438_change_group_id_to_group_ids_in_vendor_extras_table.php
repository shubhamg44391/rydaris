<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vendor_extras', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropColumn('group_id');
            $table->json('group_ids')->nullable()->after('vendor_id');
        });
    }

    public function down(): void
    {
        Schema::table('vendor_extras', function (Blueprint $table) {
            $table->dropColumn('group_ids');
            $table->foreignId('group_id')->nullable()->constrained('groups')->onDelete('set null')->after('vendor_id');
        });
    }
};
