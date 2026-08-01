<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admin_terms_conditions', function (Blueprint $table) {
            if (!Schema::hasColumn('admin_terms_conditions', 'agreement_title')) {
                $table->string('agreement_title')->nullable()->after('description');
            }
            if (!Schema::hasColumn('admin_terms_conditions', 'agreement_description')) {
                $table->longText('agreement_description')->nullable()->after('agreement_title');
            }
        });
    }

    public function down(): void
    {
        Schema::table('admin_terms_conditions', function (Blueprint $table) {
            $table->dropColumn(['agreement_title', 'agreement_description']);
        });
    }
};
