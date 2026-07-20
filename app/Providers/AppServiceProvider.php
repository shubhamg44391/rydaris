<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        \Illuminate\Pagination\Paginator::useBootstrapFive();

        view()->composer('*', function ($view) {
            if (!app()->runningInConsole() && Schema::hasTable('seo_metadatas')) {
                $route = request()->route();
                $path = $route ? trim($route->uri(), '/') : trim(request()->path(), '/');
                if ($path === '') {
                    $path = '/';
                }

                // Resolve path to its canonical/parent path for vendor fallback prefix mapping
                $lookupPath = $path;
                if (str_starts_with($path, 'vendor/')) {
                    $vendorPrefixMap = [
                        'vendor/bookings/payment'     => 'vendor/bookings/payment',
                        'vendor/bookings'             => 'vendor/bookings',
                        'vendor/vehicles'             => 'vendor/vehicles',
                        'vendor/groups'               => 'vendor/groups',
                        'vendor/locations'            => 'vendor/locations',
                        'vendor/branches'             => 'vendor/branches',
                        'vendor/customers'            => 'vendor/customers',
                        'vendor/invitations'          => 'vendor/invitations',
                        'vendor/extras'               => 'vendor/extras',
                        'vendor/insurance'            => 'vendor/insurance',
                        'vendor/features'             => 'vendor/features',
                        'vendor/rules'                => 'vendor/rules',
                        'vendor/pricing'              => 'vendor/pricing',
                        'vendor/subscription/history' => 'vendor/subscription/history',
                        'vendor/profile'              => 'vendor/profile',
                        'vendor/payment-settings'     => 'vendor/payment-settings',
                        'vendor/smtp-settings'        => 'vendor/smtp-settings',
                    ];

                    foreach ($vendorPrefixMap as $prefix => $mappedPath) {
                        if ($path === $prefix || str_starts_with($path, $prefix . '/')) {
                            $lookupPath = $mappedPath;
                            break;
                        }
                    }
                }

                $seo = \Illuminate\Support\Facades\Cache::remember('seo_' . md5($lookupPath), 600, function () use ($lookupPath) {
                    return \App\Models\SeoMetadata::where('url_path', $lookupPath)->first();
                });

                if ($seo) {
                    $view->with('seo_title', $seo->meta_title);
                    $view->with('seo_description', $seo->meta_description);
                    $view->with('seo_keyword', $seo->keyword);
                }
            }
        });
    }
}
