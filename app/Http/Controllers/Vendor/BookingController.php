<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        // Mark bookings list as seen/checked
        auth()->user()->update(['last_checked_bookings_at' => now()]);

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

    /**
     * Export all bookings for the logged-in vendor as a CSV file.
     *
     * Algorithm:
     * 1. Fetch all bookings belonging to the authenticated vendor (no pagination).
     * 2. Eager-load vehicle, pickupLocation, and returnLocation relationships.
     * 3. Build CSV headers matching the booking list table columns.
     * 4. Iterate each booking, sanitize any commas/newlines in string fields,
     *    and append a comma-separated row.
     * 5. Stream the CSV back to the browser with appropriate download headers
     *    (Content-Type: text/csv, Content-Disposition: attachment).
     */
    public function exportCsv()
    {
        // Step 1 & 2 – Load all vendor bookings with relations
        $bookings = \App\Models\Booking::with(['vehicle', 'pickupLocation', 'returnLocation', 'user'])
            ->where('vendor_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Step 3 – Define column headers
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

        // Helper to safely quote a CSV field
        $csvField = function ($value) {
            $value = str_replace('"', '""', (string) $value); // Escape double-quotes
            return '"' . $value . '"';
        };

        // Step 4 & 5 – Build CSV content and stream to browser
        $filename = 'bookings_' . now()->format('Ymd_His') . '.csv';

        $callback = function () use ($bookings, $headers, $csvField) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM so Excel opens it correctly
            fwrite($handle, "\xEF\xBB\xBF");

            // Write header row
            fputcsv($handle, $headers);

            // Write data rows
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
