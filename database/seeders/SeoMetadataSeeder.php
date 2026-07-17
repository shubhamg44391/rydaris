<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeoMetadataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate existing metadata
        DB::table('seo_metadatas')->truncate();

        $pages = [
            // Frontend Portal
            [
                'url_path' => '/',
                'page_name' => 'Home Page',
                'meta_title' => 'Rydaris | Car Rental Management System',
                'meta_description' => 'Rydaris is the ultimate car rental management software designed for fleet operations, reservation booking, and real-time damage tracking.',
                'portal_type' => 'frontend',
            ],
            [
                'url_path' => 'about',
                'page_name' => 'About Us Page',
                'meta_title' => 'About Us | Rydaris',
                'meta_description' => 'Learn about the Rydaris mission to build calm, high-performance car rental software that streamlines fleet tracking, billing, and booking operations.',
                'portal_type' => 'frontend',
            ],
            [
                'url_path' => 'pricing',
                'page_name' => 'Pricing Page',
                'meta_title' => 'Pricing | Rydaris',
                'meta_description' => 'View transparent, growth-friendly pricing plans for Rydaris fleet management. Choose the right tier based on your vehicles and branch count.',
                'portal_type' => 'frontend',
            ],
            [
                'url_path' => 'faq',
                'page_name' => 'FAQ Page',
                'meta_title' => 'FAQ | Rydaris',
                'meta_description' => 'Find answers to frequently asked questions about Rydaris fleet tracking, vehicle booking customization, payment gateway setup, and setup assistance.',
                'portal_type' => 'frontend',
            ],
            [
                'url_path' => 'contact',
                'page_name' => 'Contact Us Page',
                'meta_title' => 'Contact Us | Rydaris',
                'meta_description' => 'Get in touch with Rydaris sales, tech support, or onboarding specialist to request a custom platform demo for your rental fleet.',
                'portal_type' => 'frontend',
            ],
            [
                'url_path' => 'sitemap',
                'page_name' => 'Sitemap Page',
                'meta_title' => 'Sitemap | Rydaris',
                'meta_description' => 'Access the Rydaris website sitemap to navigate through all our car rental products, pricing, FAQ, help center, and legal documentation.',
                'portal_type' => 'frontend',
            ],
            [
                'url_path' => 'terms-of-service',
                'page_name' => 'Terms of Service Page',
                'meta_title' => 'Terms of Service | Rydaris',
                'meta_description' => 'Read our terms of service, platform user agreements, and car rental service terms.',
                'portal_type' => 'frontend',
            ],
            [
                'url_path' => 'login',
                'page_name' => 'Customer Login Page',
                'meta_title' => 'Customer Login | Rydaris',
                'meta_description' => 'Sign in to your Rydaris customer account to view bookings and manage your profile.',
                'portal_type' => 'frontend',
            ],
            [
                'url_path' => 'register',
                'page_name' => 'Customer Register Page',
                'meta_title' => 'Customer Register | Rydaris',
                'meta_description' => 'Create a customer account to start reserving rental vehicles easily.',
                'portal_type' => 'frontend',
            ],
            [
                'url_path' => 'vendor/register',
                'page_name' => 'Vendor Register Page',
                'meta_title' => 'Vendor Portal Registration | Rydaris',
                'meta_description' => 'Register your rental fleet business to start managing operations via the Rydaris platform.',
                'portal_type' => 'frontend',
            ],
            [
                'url_path' => 'vendor/login',
                'page_name' => 'Vendor Login Page',
                'meta_title' => 'Vendor Portal Login | Rydaris',
                'meta_description' => 'Log in to your Rydaris Vendor dashboard to monitor fleet activity, branches, and payments.',
                'portal_type' => 'frontend',
            ],

            // Vendor Portal — Dashboard
            [
                'url_path' => 'vendor/dashboard',
                'page_name' => 'Dashboard - Dashboard',
                'meta_title' => 'Vendor Dashboard | Rydaris',
                'meta_description' => 'View real-time branch performance metrics, active bookings, and fleet utilization stats.',
                'portal_type' => 'vendor',
            ],

            // Vendor Portal — Booking
            [
                'url_path' => 'vendor/bookings',
                'page_name' => 'Booking - Booking List',
                'meta_title' => 'Booking List | Rydaris Vendor',
                'meta_description' => 'Review active reservations, checkout vehicles, capture security deposits, and process returns.',
                'portal_type' => 'vendor',
            ],
            [
                'url_path' => 'vendor/bookings/payment',
                'page_name' => 'Booking - Booking Payment',
                'meta_title' => 'Booking Payments | Rydaris Vendor',
                'meta_description' => 'Process outstanding payment requests, view dues, and reconcile booking invoices.',
                'portal_type' => 'vendor',
            ],

            // Vendor Portal — Vehicles
            [
                'url_path' => 'vendor/vehicles',
                'page_name' => 'Vehicles - Vehicles (List & Add)',
                'meta_title' => 'Vehicle Fleet Management | Rydaris Vendor',
                'meta_description' => 'Manage your fleet inventory — add vehicles and edit availability.',
                'portal_type' => 'vendor',
            ],
            [
                'url_path' => 'vendor/groups',
                'page_name' => 'Vehicles - Vehicle Groups',
                'meta_title' => 'Vehicle Groups | Rydaris Vendor',
                'meta_description' => 'Manage vehicle category groups and ACRISS codes for fleet classification and rate assignment.',
                'portal_type' => 'vendor',
            ],

            // Vendor Portal — Locations
            [
                'url_path' => 'vendor/locations',
                'page_name' => 'Locations - Locations (List & Add)',
                'meta_title' => 'Locations List | Rydaris Vendor',
                'meta_description' => 'Manage pickup/drop-off locations, add zones, and customize branch mappings.',
                'portal_type' => 'vendor',
            ],
            [
                'url_path' => 'vendor/branches',
                'page_name' => 'Locations - Branch List',
                'meta_title' => 'Branch Offices | Rydaris Vendor',
                'meta_description' => 'Configure multiple branch locations, operational hours, contact details, and dynamic settings.',
                'portal_type' => 'vendor',
            ],

            // Vendor Portal — Customers
            [
                'url_path' => 'vendor/customers',
                'page_name' => 'Customers - Customer List',
                'meta_title' => 'Customer Directory | Rydaris Vendor',
                'meta_description' => 'View all registered customers, their booking history, license verification status, and contact details.',
                'portal_type' => 'vendor',
            ],
            [
                'url_path' => 'vendor/invitations',
                'page_name' => 'Customers - User Invitations',
                'meta_title' => 'Customer Invitations | Rydaris Vendor',
                'meta_description' => 'Send rental invitations to customers via email for seamless onboarding into the booking system.',
                'portal_type' => 'vendor',
            ],

            // Vendor Portal — Fleet Management
            [
                'url_path' => 'vendor/availability',
                'page_name' => 'Fleet Management - Fleet Management',
                'meta_title' => 'Fleet Availability & Pricing | Rydaris Vendor',
                'meta_description' => 'Monitor vehicle availability calendar and manage dynamic daily pricing rates for your fleet.',
                'portal_type' => 'vendor',
            ],

            // Vendor Portal — Extras
            [
                'url_path' => 'vendor/extras',
                'page_name' => 'Extras - Extras',
                'meta_title' => 'Rental Extras & Add-ons | Rydaris Vendor',
                'meta_description' => 'Configure extras, add-ons and miscellaneous options for customer bookings.',
                'portal_type' => 'vendor',
            ],
            [
                'url_path' => 'vendor/insurance',
                'page_name' => 'Extras - Insurance',
                'meta_title' => 'Rental Insurance Options | Rydaris Vendor',
                'meta_description' => 'Define and manage insurance coverage plans offered to customers at the time of booking.',
                'portal_type' => 'vendor',
            ],
            [
                'url_path' => 'vendor/features',
                'page_name' => 'Extras - Features',
                'meta_title' => 'Vehicle Features | Rydaris Vendor',
                'meta_description' => 'Manage vehicle feature tags like air conditioning, sunroof, and bluetooth for fleet listings.',
                'portal_type' => 'vendor',
            ],
            [
                'url_path' => 'vendor/rules',
                'page_name' => 'Extras - Our Rules',
                'meta_title' => 'Rental Rules & Policies | Rydaris Vendor',
                'meta_description' => 'Set and manage rental rules such as minimum age, driving license requirements, and fuel policies.',
                'portal_type' => 'vendor',
            ],

            // Vendor Portal — Coupons
            [
                'url_path' => 'vendor/coupons',
                'page_name' => 'Coupons - Coupons',
                'meta_title' => 'Discount Coupons | Rydaris Vendor',
                'meta_description' => 'Create and manage promotional coupon codes for discounts on car rental bookings.',
                'portal_type' => 'vendor',
            ],

            // Vendor Portal — Support Ticket
            [
                'url_path' => 'vendor/support-tickets',
                'page_name' => 'Support Ticket - Support Ticket',
                'meta_title' => 'Vendor Support Tickets | Rydaris',
                'meta_description' => 'View and respond to customer support tickets. Track resolution status and conversation threads.',
                'portal_type' => 'vendor',
            ],

            // Vendor Portal — Subscription
            [
                'url_path' => 'vendor/pricing',
                'page_name' => 'Subscription - Plans',
                'meta_title' => 'Subscription & Plans | Rydaris Vendor',
                'meta_description' => 'Explore subscription plans and upgrade your account settings.',
                'portal_type' => 'vendor',
            ],
            [
                'url_path' => 'vendor/subscription/history',
                'page_name' => 'Subscription - History',
                'meta_title' => 'Subscription History | Rydaris Vendor',
                'meta_description' => 'Explore billing history and payment details.',
                'portal_type' => 'vendor',
            ],

            // Vendor Portal — Terms & Conditions
            [
                'url_path' => 'vendor/terms-conditions',
                'page_name' => 'Terms & Conditions - Terms & Conditions',
                'meta_title' => 'Vendor Terms & Conditions | Rydaris',
                'meta_description' => 'Review the platform rental agreement policies, compliance obligations, and service terms for vendors.',
                'portal_type' => 'vendor',
            ],

            // Vendor Portal — Settings
            [
                'url_path' => 'vendor/profile',
                'page_name' => 'Settings - Profile Management',
                'meta_title' => 'Vendor Profile | Rydaris',
                'meta_description' => 'Update personal information, security credentials, and partner contact details.',
                'portal_type' => 'vendor',
            ],
            [
                'url_path' => 'vendor/payment-settings',
                'page_name' => 'Settings - Payment Gateway',
                'meta_title' => 'Payment Gateway Settings | Rydaris Vendor',
                'meta_description' => 'Configure payment gateway credentials to accept online payments for car rental bookings.',
                'portal_type' => 'vendor',
            ],
            [
                'url_path' => 'vendor/smtp-settings',
                'page_name' => 'Settings - SMTP Settings',
                'meta_title' => 'SMTP Settings | Rydaris Vendor',
                'meta_description' => 'Configure your outbound email SMTP server for customer notification and confirmation emails.',
                'portal_type' => 'vendor',
            ],

            // User / Customer Portal (Only Menu items matching the sidebar)
            [
                'url_path' => 'user/search',
                'page_name' => 'Search Vehicle',
                'meta_title' => 'Search Fleet Inventory | Rydaris Customer',
                'meta_description' => 'Browse through hundreds of high-quality rental vehicles and view real-time branch availability.',
                'portal_type' => 'user',
            ],
            [
                'url_path' => 'user/dashboard',
                'page_name' => 'My Bookings',
                'meta_title' => 'My Bookings & Payment History | Rydaris Customer',
                'meta_description' => 'View active and past bookings, check status, make outstanding payments, and view invoice details.',
                'portal_type' => 'user',
            ],
            [
                'url_path' => 'user/bookings/{id}/checkin',
                'page_name' => 'Check-in',
                'meta_title' => 'Check-in Form | Rydaris Customer',
                'meta_description' => 'Submit your driver license, verify details, and check in your vehicle reservation online.',
                'portal_type' => 'user',
            ],
            [
                'url_path' => 'user/bookings/{id}/payment-page',
                'page_name' => 'Payments',
                'meta_title' => 'Process Booking Payment | Rydaris Customer',
                'meta_description' => 'Securely pay for your car rental booking using credit cards or other supported gateways.',
                'portal_type' => 'user',
            ],
            [
                'url_path' => 'user/support-tickets',
                'page_name' => 'Support Ticket',
                'meta_title' => 'Customer Support Tickets | Rydaris',
                'meta_description' => 'Raise concerns or inquiries, and track ticket status replies from administrators and vendors.',
                'portal_type' => 'user',
            ],
        ];

        foreach ($pages as $page) {
            $page['created_at'] = now();
            $page['updated_at'] = now();
            DB::table('seo_metadatas')->insert($page);
        }
    }
}
