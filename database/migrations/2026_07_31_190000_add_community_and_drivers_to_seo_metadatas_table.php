<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $newPages = [
            [
                'url_path' => 'community',
                'page_name' => 'Community Page',
                'meta_title' => 'Community | Rydaris',
                'meta_description' => 'Join the Rydaris car rental community to connect with operators, read articles, and share industry insights.',
                'portal_type' => 'frontend',
            ],
            [
                'url_path' => 'vendor/drivers',
                'page_name' => 'Drivers - Driver List',
                'meta_title' => 'Driver List | Rydaris Vendor',
                'meta_description' => 'Manage driver profiles, licenses, contact details, and assigned status for your rental fleet.',
                'portal_type' => 'vendor',
            ],
            [
                'url_path' => 'vendor/drivers/create',
                'page_name' => 'Drivers - Add Driver',
                'meta_title' => 'Add New Driver | Rydaris Vendor',
                'meta_description' => 'Add a new driver to your rental operations with contact and license details.',
                'portal_type' => 'vendor',
            ],
            [
                'url_path' => 'vendor/community',
                'page_name' => 'Community - Community Posts',
                'meta_title' => 'Vendor Community | Rydaris',
                'meta_description' => 'Participate in the Rydaris rental community, share insights, ask questions, and engage with other rental operators.',
                'portal_type' => 'vendor',
            ],
            [
                'url_path' => 'vendor/community/create',
                'page_name' => 'Community - Create Post',
                'meta_title' => 'Create Community Post | Rydaris Vendor',
                'meta_description' => 'Create and publish a new post to share updates or engage with the rental community.',
                'portal_type' => 'vendor',
            ],
        ];

        foreach ($newPages as $page) {
            $exists = DB::table('seo_metadatas')->where('url_path', $page['url_path'])->exists();
            if (!$exists) {
                $page['created_at'] = now();
                $page['updated_at'] = now();
                DB::table('seo_metadatas')->insert($page);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('seo_metadatas')->whereIn('url_path', [
            'community',
            'vendor/drivers',
            'vendor/drivers/create',
            'vendor/community',
            'vendor/community/create',
        ])->delete();
    }
};
