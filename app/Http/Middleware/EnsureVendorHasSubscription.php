<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureVendorHasSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user->activeSubscription) {
            return redirect()->route('vendor.pricing')->with('error', 'Please subscribe to a package to access this feature.');
        }

        $route = $request->route() ? $request->route()->getName() : null;

        if ($route) {
            $permissionMap = [
                'vendor.bookings' => 'booking',
                'vendor.vehicles' => 'vehicles',
                'vendor.groups' => 'vehicles',
                'vendor.locations' => 'locations',
                'vendor.customers' => 'customers',
                'vendor.invitations' => 'customers',
                'vendor.availability' => 'fleet_management',
                'vendor.extras' => 'extras',
                'vendor.insurance' => 'extras',
                'vendor.features' => 'extras',
                'vendor.rules' => 'extras',
                'vendor.coupons' => 'coupons',
                'vendor.support-tickets' => 'support_ticket',
                'vendor.profile' => 'settings',
                'vendor.payment_settings' => 'settings',
                'vendor.smtp_settings' => 'settings',
            ];

            foreach ($permissionMap as $prefix => $permission) {
                if (str_starts_with($route, $prefix)) {
                    if (!$user->hasMenuAccess($permission)) {
                        return redirect()->route('vendor.dashboard')->with('error', 'Your subscription package does not allow access to this feature.');
                    }
                }
            }
        }

        return $next($request);
    }
}
