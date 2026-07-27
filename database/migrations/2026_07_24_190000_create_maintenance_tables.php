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
        if (!Schema::hasTable('maintenance_schedules')) {
            Schema::create('maintenance_schedules', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('vendor_id');
                $table->unsignedBigInteger('branch_id')->nullable();
                $table->unsignedBigInteger('vehicle_id');
                $table->integer('target_km')->nullable();
                $table->integer('engine_hours')->default(0);
                $table->date('next_due_date')->nullable();
                $table->text('checklist_summary')->nullable();
                $table->string('status')->default('on_schedule');
                $table->timestamps();
            });
        } else if (!Schema::hasColumn('maintenance_schedules', 'branch_id')) {
            Schema::table('maintenance_schedules', function (Blueprint $table) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('vendor_id');
            });
        }

        if (!Schema::hasTable('maintenance_requests')) {
            Schema::create('maintenance_requests', function (Blueprint $table) {
                $table->id();
                $table->string('request_number');
                $table->unsignedBigInteger('vendor_id');
                $table->unsignedBigInteger('branch_id')->nullable();
                $table->unsignedBigInteger('vehicle_id');
                $table->string('interval_type')->default('Engine Hours');
                $table->string('priority')->default('Medium');
                $table->json('checklist_tasks')->nullable();
                $table->text('notes')->nullable();
                $table->string('status')->default('pending');
                $table->timestamps();
            });
        } else if (!Schema::hasColumn('maintenance_requests', 'branch_id')) {
            Schema::table('maintenance_requests', function (Blueprint $table) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('vendor_id');
            });
        }

        if (!Schema::hasTable('work_orders')) {
            Schema::create('work_orders', function (Blueprint $table) {
                $table->id();
                $table->string('work_order_number');
                $table->unsignedBigInteger('vendor_id');
                $table->unsignedBigInteger('branch_id')->nullable();
                $table->unsignedBigInteger('vehicle_id');
                $table->string('mechanic_workshop');
                $table->string('vehicle_status')->default('In Maintenance');
                $table->integer('progress_percentage')->default(0);
                $table->json('checklist_completed')->nullable();
                $table->string('incident_flag')->default('No Incident');
                $table->string('status')->default('in_progress');
                $table->timestamp('completed_at')->nullable();
                $table->timestamps();
            });
        } else if (!Schema::hasColumn('work_orders', 'branch_id')) {
            Schema::table('work_orders', function (Blueprint $table) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('vendor_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
        Schema::dropIfExists('maintenance_requests');
        Schema::dropIfExists('maintenance_schedules');
    }
};
