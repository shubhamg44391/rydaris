<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\User;
use App\Models\VendorSubscription;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard.
     */
    public function index()
    {
        $totalVendors   = User::where('role', 'vendor')->count();
        $activeVendors  = User::where('role', 'vendor')->where('status', 'active')->count();
        $inactiveVendors = User::where('role', 'vendor')->where('status', 'inactive')->count();
        $recentVendors  = User::where('role', 'vendor')->orderBy('created_at', 'desc')->take(5)->get();

        // ── Gross Monthly Churn Calculation ──────────────────────────────────
        // Formula: (Churned last month / Active at start of last month) × 100
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd   = Carbon::now()->subMonth()->endOfMonth();

        // Subscriptions that were active at start of last month
        $activeAtStartOfLastMonth = VendorSubscription::where('starts_at', '<=', $lastMonthStart)
            ->where(function ($q) use ($lastMonthStart) {
                $q->whereNull('ends_at')
                  ->orWhere('ends_at', '>=', $lastMonthStart);
            })
            ->count();

        // Subscriptions that expired/cancelled during last month
        $churnedLastMonth = VendorSubscription::where(function ($q) use ($lastMonthStart, $lastMonthEnd) {
                $q->where('status', 'expired')
                  ->orWhere('status', 'cancelled')
                  ->orWhere(function ($q2) use ($lastMonthStart, $lastMonthEnd) {
                      $q2->where('ends_at', '>=', $lastMonthStart)
                         ->where('ends_at', '<=', $lastMonthEnd)
                         ->where('status', '!=', 'active');
                  });
            })
            ->whereBetween('ends_at', [$lastMonthStart, $lastMonthEnd])
            ->count();

        // Calculate churn percentage (avoid division by zero)
        if ($activeAtStartOfLastMonth > 0) {
            $churnRate = round(($churnedLastMonth / $activeAtStartOfLastMonth) * 100, 1);
        } else {
            $churnRate = 0.0;
        }

        // Month-over-month churn delta (compare to 2 months ago)
        $twoMonthsStart = Carbon::now()->subMonths(2)->startOfMonth();
        $twoMonthsEnd   = Carbon::now()->subMonths(2)->endOfMonth();

        $activeAtStartOfTwoMonthsAgo = VendorSubscription::where('starts_at', '<=', $twoMonthsStart)
            ->where(function ($q) use ($twoMonthsStart) {
                $q->whereNull('ends_at')
                  ->orWhere('ends_at', '>=', $twoMonthsStart);
            })
            ->count();

        $churnedTwoMonthsAgo = VendorSubscription::whereBetween('ends_at', [$twoMonthsStart, $twoMonthsEnd])
            ->where('status', '!=', 'active')
            ->count();

        $prevChurnRate = ($activeAtStartOfTwoMonthsAgo > 0)
            ? round(($churnedTwoMonthsAgo / $activeAtStartOfTwoMonthsAgo) * 100, 1)
            : 0.0;

        $churnDelta = round($churnRate - $prevChurnRate, 1);

        return view('admin.dashboard', compact(
            'totalVendors',
            'activeVendors',
            'inactiveVendors',
            'recentVendors',
            'churnRate',
            'churnDelta'
        ));
    }
}
