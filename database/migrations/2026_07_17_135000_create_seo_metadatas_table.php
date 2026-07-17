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
        Schema::create('seo_metadatas', function (Blueprint $table) {
            $table->id();
            $table->string('url_path')->unique();
            $table->string('page_name');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('portal_type'); // 'frontend', 'vendor', 'admin'
            $table->timestamps();
        });

        // Prepopulate default pages
        $defaultPages = [
            // Frontend
            [
                'url_path' => '/',
                'page_name' => 'Home Page',
                'meta_title' => 'Rydaris | Car Rental Management System',
                'meta_description' => 'Rydaris is the ultimate car rental management software designed for fleet operations, reservation booking, and real-time damage tracking.',
                'portal_type' => 'frontend',
            ],
            [
                'url_path' => '/about',
                'page_name' => 'About Us Page',
                'meta_title' => 'About Us | Rydaris',
                'meta_description' => 'Learn about the Rydaris mission to build calm, high-performance car rental software that streamlines fleet tracking, billing, and booking operations.',
                'portal_type' => 'frontend',
            ],
            [
                'url_path' => '/pricing',
                'page_name' => 'Pricing Page',
                'meta_title' => 'Pricing | Rydaris',
                'meta_description' => 'View transparent, growth-friendly pricing plans for Rydaris fleet management. Choose the right tier based on your vehicles and branch count.',
                'portal_type' => 'frontend',
            ],
            [
                'url_path' => '/faq',
                'page_name' => 'FAQ Page',
                'meta_title' => 'FAQ | Rydaris',
                'meta_description' => 'Find answers to frequently asked questions about Rydaris fleet tracking, vehicle booking customization, payment gateway setup, and setup assistance.',
                'portal_type' => 'frontend',
            ],
            [
                'url_path' => '/contact',
                'page_name' => 'Contact Us Page',
                'meta_title' => 'Contact Us | Rydaris',
                'meta_description' => 'Get in touch with Rydaris sales, tech support, or onboarding specialist to request a custom platform demo for your rental fleet.',
                'portal_type' => 'frontend',
            ],
            [
                'url_path' => '/sitemap',
                'page_name' => 'Sitemap Page',
                'meta_title' => 'Sitemap | Rydaris',
                'meta_description' => 'Access the Rydaris website sitemap to navigate through all our car rental products, pricing, FAQ, help center, and legal documentation.',
                'portal_type' => 'frontend',
            ],
            [
                'url_path' => '/terms-of-service',
                'page_name' => 'Terms of Service Page',
                'meta_title' => 'Terms of Service | Rydaris',
                'meta_description' => 'Read our terms of service, platform user agreements, and car rental service terms.',
                'portal_type' => 'frontend',
            ],
            [
                'url_path' => '/login',
                'page_name' => 'Customer Login Page',
                'meta_title' => 'Customer Login | Rydaris',
                'meta_description' => 'Sign in to your Rydaris customer account to view bookings and manage your profile.',
                'portal_type' => 'frontend',
            ],
            [
                'url_path' => '/register',
                'page_name' => 'Customer Register Page',
                'meta_title' => 'Customer Register | Rydaris',
                'meta_description' => 'Create a customer account to start reserving rental vehicles easily.',
                'portal_type' => 'frontend',
            ],
            [
                'url_path' => '/vendor/register',
                'page_name' => 'Vendor Register Page',
                'meta_title' => 'Vendor Portal Registration | Rydaris',
                'meta_description' => 'Register your rental fleet business to start managing operations via the Rydaris platform.',
                'portal_type' => 'frontend',
            ],
            [
                'url_path' => '/vendor/login',
                'page_name' => 'Vendor Login Page',
                'meta_title' => 'Vendor Portal Login | Rydaris',
                'meta_description' => 'Log in to your Rydaris Vendor dashboard to monitor fleet activity, branches, and payments.',
                'portal_type' => 'frontend',
            ],

            // Vendor Portal
            [
                'url_path' => '/vendor/dashboard',
                'page_name' => 'Vendor Dashboard',
                'meta_title' => 'Vendor Dashboard | Rydaris',
                'meta_description' => 'View real-time branch performance metrics, active bookings, and fleet utilization stats.',
                'portal_type' => 'vendor',
            ],
            [
                'url_path' => '/vendor/bookings',
                'page_name' => 'Vendor Bookings List',
                'meta_title' => 'Manage Bookings | Rydaris Vendor',
                'meta_description' => 'Review active reservations, checkout vehicles, capture security deposits, and process returns.',
                'portal_type' => 'vendor',
            ],
            [
                'url_path' => '/vendor/vehicles',
                'page_name' => 'Vendor Vehicle Fleet',
                'meta_title' => 'Vehicle Fleet Management | Rydaris Vendor',
                'meta_description' => 'Manage branch fleet inventory, vehicle statuses, fuel/mileage levels, and damage records.',
                'portal_type' => 'vendor',
            ],
            [
                'url_path' => '/vendor/branches',
                'page_name' => 'Vendor Branches List',
                'meta_title' => 'Manage Branches | Rydaris Vendor',
                'meta_description' => 'Configure multiple branch locations, operational hours, contact details, and dynamic settings.',
                'portal_type' => 'vendor',
            ],
            [
                'url_path' => '/vendor/availability',
                'page_name' => 'Vendor Availability & Rates Calendar',
                'meta_title' => 'Availability & Pricing Calendar | Rydaris Vendor',
                'meta_description' => 'Monitor vehicle group availability and edit dynamic daily pricing rates.',
                'portal_type' => 'vendor',
            ],
            [
                'url_path' => '/vendor/profile',
                'page_name' => 'Vendor Profile Page',
                'meta_title' => 'My Profile | Rydaris Vendor',
                'meta_description' => 'Update personal information, security credentials, and partner contact details.',
                'portal_type' => 'vendor',
            ],

            // Admin Portal
            [
                'url_path' => '/admin/dashboard',
                'page_name' => 'Admin Dashboard',
                'meta_title' => 'Admin Dashboard | Rydaris',
                'meta_description' => 'Access system admin overview, global usage metrics, active vendors, and inquiries.',
                'portal_type' => 'admin',
            ],
            [
                'url_path' => '/admin/vendors',
                'page_name' => 'Admin Vendor Control',
                'meta_title' => 'Vendor Partners List | Rydaris Admin',
                'meta_description' => 'Monitor registered vendor partners, approve accounts, and view subscription standings.',
                'portal_type' => 'admin',
            ],
            [
                'url_path' => '/admin/packages',
                'page_name' => 'Admin Packages & Pricing',
                'meta_title' => 'Manage Packages | Rydaris Admin',
                'meta_description' => 'Create and modify standard subscription tiers, features, and platform prices.',
                'portal_type' => 'admin',
            ],
            [
                'url_path' => '/admin/faqs',
                'page_name' => 'Admin FAQ Management',
                'meta_title' => 'Manage FAQ | Rydaris Admin',
                'meta_description' => 'Update frequently asked questions displayed on the public frontend portal.',
                'portal_type' => 'admin',
            ],
            [
                'url_path' => '/admin/pages',
                'page_name' => 'Admin Custom Pages Editor',
                'meta_title' => 'Manage Pages | Rydaris Admin',
                'meta_description' => 'Create and customize dynamic legal or help center document pages.',
                'portal_type' => 'admin',
            ],
        ];

        foreach ($defaultPages as $page) {
            $page['created_at'] = now();
            $page['updated_at'] = now();
            DB::table('seo_metadatas')->insert($page);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_metadatas');
    }
};
