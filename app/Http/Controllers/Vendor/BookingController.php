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

    public function updateStatus(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'status' => 'required|string',
        ]);

        $booking = \App\Models\Booking::with('vehicle')->where('id', $request->booking_id)
            ->where('vendor_id', auth()->id())
            ->firstOrFail();

        $booking->booking_status = $request->status;
        $booking->save();

        // Send Email Notification
        try {
            \App\Models\VendorSmtpSetting::setMailConfig($booking->vendor_id);
            $template = 'email_templates.status_change';
            
            if ($request->status == 'cancelled') {
                $template = 'email_templates.cancel-booking';
            } elseif ($request->status == 'confirmed') {
                $template = 'email_templates.confirm_booking';
            }
            
            // Note: Since these templates were originally from CodeIgniter, we must pass the variables they expect.
            // But we will use Laravel's Mail facade. If the templates have php echo $trip_data['...'];
            // we will need to map the Laravel booking model to those array structures, or update the views to Blade.
            // For now, we will map basic arrays so the raw PHP templates don't crash.
            
            $customer_data = [
                'c_name' => $booking->customer_fname . ' ' . $booking->customer_lname,
            ];
            
            $trip_data = [
                't_trackingcode' => $booking->reservation_number ?? $booking->id,
                'payment_status' => ucfirst($booking->payment_status),
                'total_amount' => $booking->total_amount,
                // Add missing keys to prevent "Undefined array key" exceptions in the templates
                't_trip_amount' => $booking->total_amount,
                'paid_amount' => $booking->payment_status === 'completed' ? $booking->total_amount : 0,
                'pending_amount' => $booking->payment_status === 'completed' ? 0 : $booking->total_amount,
                'payment_method' => 'pay_on_arrival',
                't_start_date' => $booking->start_date ?? date('Y-m-d'),
                't_end_date' => $booking->end_date ?? date('Y-m-d'),
                'fromtime' => '10:00',
                'totime' => '10:00',
                'days' => $booking->total_days ?? 1,
                't_vechicle' => $booking->vehicle->name ?? 'Vehicle',
                'v_nane' => $booking->vehicle->name ?? 'Vehicle',
                'carprice' => $booking->vehicle->price_per_day ?? 0,
                'v_amount' => $booking->vehicle->price_per_day ?? 0,
                't_trip_fromlocation' => 'Pickup Location',
                't_trip_tolocation' => 'Dropoff Location',
                'extras' => '',
                'extras_total' => 0,
                'insurance_name' => '',
                'insurance_price' => 0,
                'pai' => '',
            ];
            
            \Illuminate\Support\Facades\Mail::send($template, ['booking' => $booking, 'vehicle' => $booking->vehicle, 'customer_data' => $customer_data, 'trip_data' => $trip_data], function ($message) use ($booking, $request) {
                $message->to($booking->customer_email)
                        ->subject('Booking Status Updated - Rydaris');
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send status update email: ' . $e->getMessage());
        }

        return response()->json(['success' => true, 'message' => 'Booking status updated successfully.']);
    }

    public function show($id)
    {
        $booking = \App\Models\Booking::with(['vehicle', 'pickupLocation', 'returnLocation', 'user'])
            ->where('vendor_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();
            
        return view('vendor.bookings.show', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        $booking = \App\Models\Booking::where('vendor_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();

        $request->validate([
            'customer_fname' => 'required|string|max:255',
            'customer_lname' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:255',
            'customer_dob' => 'nullable|date',
            'total_amount' => 'required|numeric',
            'paid_amount' => 'required|numeric',
            'pending_amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'payment_reference' => 'nullable|string',
            'pickup_date' => 'required|date',
            'pickup_time' => 'required|string',
            'return_date' => 'required|date',
            'return_time' => 'required|string',
        ]);

        $booking->update($request->only([
            'customer_fname',
            'customer_lname',
            'customer_email',
            'customer_phone',
            'customer_dob',
            'total_amount',
            'paid_amount',
            'pending_amount',
            'payment_method',
            'payment_reference',
            'pickup_date',
            'pickup_time',
            'return_date',
            'return_time',
        ]));

        return redirect()->back()->with('success', 'Booking details updated successfully.');
    }
}
