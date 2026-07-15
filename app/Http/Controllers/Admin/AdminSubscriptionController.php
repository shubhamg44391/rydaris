<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorSubscription;

class AdminSubscriptionController extends Controller
{
    /**
     * Display a listing of vendor subscriptions (payment entries).
     */
    public function index()
    {
        $subscriptions = VendorSubscription::with(['vendor', 'package'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function subscriptionInvoice($id)
    {
        $subscription = VendorSubscription::with(['vendor', 'package'])
            ->findOrFail($id);

        return view('partials.subscription-invoice', compact('subscription'));
    }
}
