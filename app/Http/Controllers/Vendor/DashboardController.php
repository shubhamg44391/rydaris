<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the Vendor Dashboard.
     */
    public function index()
    {
        return view('vendor.dashboard');
    }

    public function pricing()
    {
        $packages = \App\Models\Package::orderBy('order', 'asc')->get();
        return view('vendor.pricing.index', compact('packages'));
    }

    public function subscribe(Request $request, $packageId)
    {
        $package = \App\Models\Package::findOrFail($packageId);
        $user = auth()->user();

        // Expire any existing active subscriptions
        \App\Models\VendorSubscription::where('vendor_id', $user->id)
            ->where('status', 'active')
            ->update(['status' => 'expired']);

        // Create new subscription for 1 month
        \App\Models\VendorSubscription::create([
            'vendor_id' => $user->id,
            'package_id' => $package->id,
            'starts_at' => now(),
            'ends_at' => now()->addMonth(),
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'Successfully subscribed to ' . $package->name . ' package.');
    }
}
