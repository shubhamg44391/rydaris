<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vendor_pages', function (Blueprint $table) {
            if (!Schema::hasColumn('vendor_pages', 'agreement_title')) {
                $table->string('agreement_title')->nullable()->after('description');
            }
            if (!Schema::hasColumn('vendor_pages', 'agreement_description')) {
                $table->longText('agreement_description')->nullable()->after('agreement_title');
            }
        });
    }

    public function down(): void
    {
        Schema::table('vendor_pages', function (Blueprint $table) {
            $table->dropColumn(['agreement_title', 'agreement_description']);
        });
    }
};
