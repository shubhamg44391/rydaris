<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('demo_inquiries', function (Blueprint $table) {
            $table->string('employee_size')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('demo_inquiries', function (Blueprint $table) {
            $table->string('employee_size')->nullable(false)->change();
        });
    }
};
