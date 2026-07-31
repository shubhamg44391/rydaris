<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use App\Models\Driver;
use App\Models\VendorSmtpSetting;

class BookingController extends Controller
{
    public function index()
    {
        
        auth()->user()->update(['last_checked_bookings_at' => now()]);

        $bookings = Booking::with(['vehicle', 'pickupLocation', 'returnLocation', 'user', 'review', 'driver'])
            ->where('vendor_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('vendor.bookings.index', compact('bookings'));
    }

    public function payment()
    {
        $bookings = Booking::with(['vehicle', 'review', 'driver'])
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

        $booking = Booking::with('vehicle')->where('id', $request->booking_id)
            ->where('vendor_id', auth()->id())
            ->firstOrFail();

        $booking->booking_status = $request->status;
        $booking->save();

        
        try {
            VendorSmtpSetting::setMailConfig($booking->vendor_id);
            $template = 'email_templates.status_change';
            
            if ($request->status == 'cancelled') {
                $template = 'email_templates.cancel-booking';
            } elseif ($request->status == 'confirmed') {
                $template = 'email_templates.confirm_booking';
            }
            
            
            
            
            
            
            $customer_data = [
                'c_name' => $booking->customer_fname . ' ' . $booking->customer_lname,
            ];
            
            $trip_data = [
                't_trackingcode' => $booking->reservation_number ?? $booking->id,
                'payment_status' => ucfirst($booking->payment_status),
                'total_amount' => $booking->total_amount,
                
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
            
            Mail::send($template, ['booking' => $booking, 'vehicle' => $booking->vehicle, 'customer_data' => $customer_data, 'trip_data' => $trip_data], function ($message) use ($booking, $request) {
                $message->to($booking->customer_email)
                        ->subject('Booking Status Updated - Rydaris');
            });
        } catch (\Exception $e) {
            Log::error('Failed to send status update email: ' . $e->getMessage());
        }

        return response()->json(['success' => true, 'message' => 'Booking status updated successfully.']);
    }

    public function show($id)
    {
        $booking = Booking::with(['vehicle', 'pickupLocation', 'returnLocation', 'user', 'driver'])
            ->where('vendor_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();

        $activeDrivers = Driver::where('vendor_id', auth()->id())
            ->where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();
            
        return view('vendor.bookings.show', compact('booking', 'activeDrivers'));
    }

    public function assignDriver(Request $request, $id)
    {
        $booking = Booking::where('vendor_id', auth()->id())->findOrFail($id);

        if (in_array(strtolower($booking->booking_status), ['completed', 'cancelled'])) {
            $msg = 'Driver assignment cannot be modified for ' . strtolower($booking->booking_status) . ' bookings.';
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return redirect()->back()->with('error', $msg);
        }

        $request->validate([
            'driver_id' => [
                'required',
                \Illuminate\Validation\Rule::exists('drivers', 'id')->where(function ($query) {
                    return $query->where('vendor_id', auth()->id())->where('status', 'active');
                }),
            ],
        ], [
            'driver_id.required' => 'Please select a driver.',
            'driver_id.exists' => 'Selected driver is invalid or inactive.',
        ]);

        $driver = Driver::where('vendor_id', auth()->id())->where('status', 'active')->findOrFail($request->driver_id);

        $booking->update([
            'driver_id' => $driver->id,
            'assigned_at' => now(),
            'assigned_by_vendor' => auth()->id(),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Driver assigned successfully.',
                'driver' => [
                    'id' => $driver->id,
                    'name' => $driver->name,
                    'phone' => $driver->phone,
                    'address' => $driver->address,
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Driver assigned successfully.');
    }

    public function removeDriver(Request $request, $id)
    {
        $booking = Booking::where('vendor_id', auth()->id())->findOrFail($id);

        if (in_array(strtolower($booking->booking_status), ['completed', 'cancelled'])) {
            $msg = 'Driver assignment cannot be modified for ' . strtolower($booking->booking_status) . ' bookings.';
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return redirect()->back()->with('error', $msg);
        }

        $booking->update([
            'driver_id' => null,
            'assigned_at' => null,
            'assigned_by_vendor' => null,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Driver assignment removed successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'Driver assignment removed successfully.');
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::where('vendor_id', auth()->id())
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

    

    public function exportCsv()
    {
        
        $bookings = Booking::with(['vehicle', 'pickupLocation', 'returnLocation', 'user'])
            ->where('vendor_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        
        $headers = [
            'S.No',
            'Date & Time of Booking',
            'Reservation #',
            'Customer First Name',
            'Customer Last Name',
            'Customer Email',
            'Customer Phone',
            'Vehicle',
            'Pickup Location',
            'Pickup Date',
            'Pickup Time',
            'Return Location',
            'Return Date',
            'Return Time',
            'Total Days',
            'Paid Amount',
            'Pending Amount',
            'Total Amount',
            'Payment Reference',
            'Booking Status',
            'Payment Status',
            'Created At',
        ];

        
        $csvField = function ($value) {
            $value = str_replace('"', '""', (string) $value); 
            return '"' . $value . '"';
        };

        
        $filename = 'bookings_' . now()->format('Ymd_His') . '.csv';

        $callback = function () use ($bookings, $headers, $csvField) {
            $handle = fopen('php://output', 'w');

            
            fwrite($handle, "\xEF\xBB\xBF");

            
            fputcsv($handle, $headers);

            
            foreach ($bookings as $index => $booking) {
                fputcsv($handle, [
                    $index + 1,
                    $booking->created_at ? $booking->created_at->format('Y-m-d H:i:s') : '',
                    $booking->reservation_number ?? '',
                    $booking->customer_fname ?? '',
                    $booking->customer_lname ?? '',
                    $booking->customer_email ?? '',
                    $booking->customer_phone ?? '',
                    $booking->vehicle->name ?? 'N/A',
                    $booking->pickupLocation->name ?? 'N/A',
                    $booking->pickup_date ?? '',
                    $booking->pickup_time ?? '',
                    $booking->returnLocation->name ?? 'N/A',
                    $booking->return_date ?? '',
                    $booking->return_time ?? '',
                    $booking->total_days ?? '',
                    number_format((float)$booking->paid_amount, 2, '.', ''),
                    number_format((float)$booking->pending_amount, 2, '.', ''),
                    number_format((float)$booking->total_amount, 2, '.', ''),
                    $booking->payment_reference ?? '',
                    ucfirst($booking->booking_status ?? ''),
                    ucfirst($booking->payment_status ?? ''),
                    $booking->created_at ? $booking->created_at->format('Y-m-d H:i:s') : '',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ]);
    }
}
