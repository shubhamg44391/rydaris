<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('work_orders') && !Schema::hasColumn('work_orders', 'checklist_tasks')) {
            Schema::table('work_orders', function (Blueprint $table) {
                $table->json('checklist_tasks')->nullable()->after('checklist_completed');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('work_orders') && Schema::hasColumn('work_orders', 'checklist_tasks')) {
            Schema::table('work_orders', function (Blueprint $table) {
                $table->dropColumn('checklist_tasks');
            });
        }
    }
};
