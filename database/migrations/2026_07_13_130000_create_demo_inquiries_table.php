<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demo_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('company_name');
            $table->string('employee_size');
            $table->string('email');
            $table->string('country_code')->nullable();
            $table->string('contact_details');
            $table->decimal('budget', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('unread');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demo_inquiries');
    }
};
