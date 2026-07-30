<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorSubscription;
use App\Models\User;
use App\Models\Package;
use Carbon\Carbon;

class AdminSubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = VendorSubscription::with(['vendor', 'package'])->orderBy('created_at', 'desc');

        if ($status === 'active') {
            $query->where('status', 'active')
                  ->where('starts_at', '<=', now())
                  ->where('ends_at', '>=', now());
        } elseif ($status === 'expired') {
            $query->where(function($q) {
                $q->where('status', '!=', 'active')
                  ->orWhere('ends_at', '<', now());
            });
        }

        $subscriptions = $query->paginate(15)->appends(['status' => $status]);
        $vendors = User::where('role', 'vendor')->orderBy('name')->get();
        $packages = Package::where('is_active', true)->orderBy('name')->get();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'html' => view('admin.subscriptions.partials.table', compact('subscriptions', 'status'))->render(),
                'status' => $status,
                'heading_status' => ($status === 'active') ? '- Active' : (($status === 'expired') ? '- Expired' : '')
            ]);
        }

        return view('admin.subscriptions.index', compact('subscriptions', 'status', 'vendors', 'packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:users,id',
            'package_id' => 'required|exists:packages,id',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after_or_equal:starts_at',
            'amount_paid' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,expired',
            'razorpay_payment_id' => 'nullable|string|max:255',
        ]);

        $subscription = VendorSubscription::create([
            'vendor_id' => $request->vendor_id,
            'package_id' => $request->package_id,
            'starts_at' => Carbon::parse($request->starts_at),
            'ends_at' => Carbon::parse($request->ends_at),
            'amount_paid' => $request->amount_paid ?? 0,
            'status' => $request->status,
            'razorpay_payment_id' => $request->razorpay_payment_id ?: 'MANUAL_' . strtoupper(uniqid()),
            'razorpay_order_id' => 'ORD_' . strtoupper(uniqid()),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Subscription created successfully.'
            ]);
        }

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription created successfully.');
    }

    public function update(Request $request, $id)
    {
        $subscription = VendorSubscription::findOrFail($id);

        $request->validate([
            'vendor_id' => 'required|exists:users,id',
            'package_id' => 'required|exists:packages,id',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after_or_equal:starts_at',
            'amount_paid' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,expired',
            'razorpay_payment_id' => 'nullable|string|max:255',
        ]);

        $subscription->update([
            'vendor_id' => $request->vendor_id,
            'package_id' => $request->package_id,
            'starts_at' => Carbon::parse($request->starts_at),
            'ends_at' => Carbon::parse($request->ends_at),
            'amount_paid' => $request->amount_paid ?? 0,
            'status' => $request->status,
            'razorpay_payment_id' => $request->razorpay_payment_id,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Subscription updated successfully.'
            ]);
        }

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription updated successfully.');
    }

    public function destroy($id)
    {
        $subscription = VendorSubscription::findOrFail($id);
        $subscription->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Subscription deleted successfully.'
            ]);
        }

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription deleted successfully.');
    }

    public function subscriptionInvoice($id)
    {
        $subscription = VendorSubscription::with(['vendor', 'package'])
            ->findOrFail($id);

        return view('partials.subscription-invoice', compact('subscription'));
    }
}
