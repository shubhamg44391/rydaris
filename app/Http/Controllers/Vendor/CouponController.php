<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::where('vendor_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('vendor.coupons.index', compact('coupons'));
    }

    public function create()
    {
        if (!Auth::user()->canAddCoupon()) {
            return redirect()->route('vendor.coupons.index')->with('error', 'You have reached your coupon limit for your current subscription package.');
        }
        return view('vendor.coupons.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->canAddCoupon()) {
            return redirect()->back()->with('error', 'You have reached your coupon limit for your current subscription package.');
        }

        $request->validate([
            'type' => 'required|in:percentage,fixed',
            'code' => 'required|string|max:255|unique:coupons,code',
            'discount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date|after_or_equal:valid_from',
            'min_booking_amount' => 'nullable|numeric|min:0',
            'availability_count' => 'nullable|integer|min:1',
        ]);

        Coupon::create([
            'vendor_id' => Auth::id(),
            'type' => $request->type,
            'code' => strtoupper($request->code),
            'discount' => $request->discount,
            'description' => $request->description,
            'valid_from' => $request->valid_from,
            'valid_to' => $request->valid_to,
            'min_booking_amount' => $request->min_booking_amount,
            'availability_count' => $request->availability_count,
        ]);

        return redirect()->route('vendor.coupons.index')->with('success', 'Coupon created successfully.');
    }

    public function edit($id)
    {
        $coupon = Coupon::where('vendor_id', Auth::id())->findOrFail($id);
        return view('vendor.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::where('vendor_id', Auth::id())->findOrFail($id);

        $request->validate([
            'type' => 'required|in:percentage,fixed',
            'code' => 'required|string|max:255|unique:coupons,code,' . $id,
            'discount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date|after_or_equal:valid_from',
            'min_booking_amount' => 'nullable|numeric|min:0',
            'availability_count' => 'nullable|integer|min:1',
        ]);

        $coupon->update([
            'type' => $request->type,
            'code' => strtoupper($request->code),
            'discount' => $request->discount,
            'description' => $request->description,
            'valid_from' => $request->valid_from,
            'valid_to' => $request->valid_to,
            'min_booking_amount' => $request->min_booking_amount,
            'availability_count' => $request->availability_count,
        ]);

        return redirect()->route('vendor.coupons.index')->with('success', 'Coupon updated successfully.');
    }

    public function destroy($id)
    {
        $coupon = Coupon::where('vendor_id', Auth::id())->findOrFail($id);
        $coupon->delete();

        return redirect()->route('vendor.coupons.index')->with('success', 'Coupon deleted successfully.');
    }
}
