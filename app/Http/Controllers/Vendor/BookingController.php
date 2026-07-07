<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = \App\Models\Booking::with(['vehicle', 'pickupLocation', 'returnLocation', 'user'])
            ->where('vendor_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('vendor.bookings.index', compact('bookings'));
    }

    public function payment()
    {
        $bookings = \App\Models\Booking::with(['vehicle'])
            ->where('vendor_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('vendor.bookings.payment', compact('bookings'));
    }
}
