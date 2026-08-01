<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('community_posts', 'slug')) {
            Schema::table('community_posts', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('title');
            });

            // Generate slug for all existing community posts
            $posts = DB::table('community_posts')->get();
            foreach ($posts as $post) {
                $baseSlug = Str::slug($post->title);
                $slug = $baseSlug ?: 'post-' . $post->id;
                $originalSlug = $slug;
                $count = 1;

                while (DB::table('community_posts')->where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                    $slug = $originalSlug . '-' . $count++;
                }

                DB::table('community_posts')->where('id', $post->id)->update(['slug' => $slug]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('community_posts', 'slug')) {
            Schema::table('community_posts', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
};
