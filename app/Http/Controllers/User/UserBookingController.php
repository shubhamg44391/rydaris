<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\VendorExtra;
use App\Models\PickupLocation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Models\VendorSmtpSetting;
use App\Models\User;
class UserBookingController extends Controller
{
    public function coverage(Request $request, $vehicle_id)
    {
        $vehicle = Vehicle::with(['vendor'])->findOrFail($vehicle_id);
        
        // Calculate Days
        $pickupDate = $request->input('pickup_date'); // Format: d/m/Y
        $returnDate = $request->input('return_date'); // Format: d/m/Y
        $rentalDays = 2; // Default

        if ($pickupDate && $returnDate) {
            try {
                $pDate = Carbon::createFromFormat('d/m/Y', $pickupDate);
                $rDate = Carbon::createFromFormat('d/m/Y', $returnDate);
                $diff = $pDate->diffInDays($rDate);
                $rentalDays = $diff > 0 ? $diff : 1;
            } catch (\Exception $e) {
                $rentalDays = 2;
            }
        }

        // Base price
        $availability = \App\Models\VehicleAvailability::where('vehicle_id', $vehicle->id)
            ->where('status', 1)
            ->orderBy('price', 'asc')
            ->first();
        
        $vehicle->base_price = $availability ? $availability->price : 50.00;
        $vehicle->total_price = $vehicle->base_price * $rentalDays;

        // Time
        $pickupTime = $request->input('pickup_time', '00:00');
        $returnTime = $request->input('return_time', '00:00');

        // Locations
        $pickupLocation = null;
        $returnLocation = null;
        if ($request->has('pickup_location') && $request->input('pickup_location')) {
            $pickupLocation = PickupLocation::find($request->input('pickup_location'));
        }
        if ($request->has('return_location') && $request->input('return_location')) {
            $returnLocation = PickupLocation::find($request->input('return_location'));
        }

        // Fetch Extras for the vendor
        $insurances = VendorExtra::with('features')
                        ->where('vendor_id', $vehicle->vendor_id)
                        ->where('type', 'insurance')
                        ->where('status', 1)
                        ->get();
        
        // Fetch all global features defined by the vendor for the rows
        $vendorFeatures = \App\Models\VendorFeature::where('vendor_id', $vehicle->vendor_id)
                        ->where('status', 1)
                        ->orderBy('index_no')
                        ->get();

        $featureMappings = \DB::table('vendor_extra_feature_mappings')
                        ->whereIn('vendor_extra_id', $insurances->pluck('id'))
                        ->get();

        $extras = VendorExtra::where('vendor_id', $vehicle->vendor_id)
                        ->where('type', 'extra')
                        ->where('status', 1)
                        ->get();

        return view('user.booking.coverage', compact(
            'vehicle', 'rentalDays', 'pickupDate', 'returnDate', 'pickupTime', 'returnTime',
            'pickupLocation', 'returnLocation', 'insurances', 'extras', 'vendorFeatures', 'featureMappings'
        ));
    }

    public function payment(Request $request, $vehicle_id)
    {
        $vehicle = Vehicle::with(['vendor'])->findOrFail($vehicle_id);
        
        // Calculate Days
        $pickupDate = $request->input('pickup_date'); 
        $returnDate = $request->input('return_date'); 
        $rentalDays = 2; // Default

        if ($pickupDate && $returnDate) {
            try {
                $pDate = Carbon::createFromFormat('d/m/Y', $pickupDate);
                $rDate = Carbon::createFromFormat('d/m/Y', $returnDate);
                $diff = $pDate->diffInDays($rDate);
                $rentalDays = $diff > 0 ? $diff : 1;
            } catch (\Exception $e) {
                $rentalDays = 2;
            }
        }

        // Base price
        $availability = \App\Models\VehicleAvailability::where('vehicle_id', $vehicle->id)
            ->where('status', 1)
            ->orderBy('price', 'asc')
            ->first();
        
        $vehicle->base_price = $availability ? $availability->price : 50.00;
        $vehicle->total_price = $vehicle->base_price * $rentalDays;

        // Time
        $pickupTime = $request->input('pickup_time', '00:00');
        $returnTime = $request->input('return_time', '00:00');

        // Locations
        $pickupLocation = null;
        $returnLocation = null;
        if ($request->has('pickup_location') && $request->input('pickup_location')) {
            $pickupLocation = PickupLocation::find($request->input('pickup_location'));
        }
        if ($request->has('return_location') && $request->input('return_location')) {
            $returnLocation = PickupLocation::find($request->input('return_location'));
        }

        // Fetch Selected Insurance
        $selectedInsurance = null;
        if ($request->filled('insurance_id')) {
            $selectedInsurance = VendorExtra::find($request->input('insurance_id'));
        }

        // Fetch Selected Extras
        $selectedExtras = collect();
        if ($request->filled('extras')) {
            // Format: id:qty,id:qty
            $extrasArr = explode(',', $request->input('extras'));
            foreach ($extrasArr as $ex) {
                $parts = explode(':', $ex);
                if (count($parts) == 2) {
                    $extra = VendorExtra::find($parts[0]);
                    if ($extra) {
                        $extra->qty = (int)$parts[1];
                        $selectedExtras->push($extra);
                    }
                }
            }
        }

        // Calculate Grand Total
        $insuranceTotal = $selectedInsurance ? ($selectedInsurance->price * $rentalDays) : 0;
        
        $extrasTotal = 0;
        foreach ($selectedExtras as $extra) {
            $extrasTotal += ($extra->price * $extra->qty * $rentalDays);
        }

        $grandTotal = $vehicle->total_price + $insuranceTotal + $extrasTotal;

        // Fetch vendor's payment gateway settings
        $paymentSettings = \App\Models\VendorPaymentSetting::where('vendor_id', $vehicle->vendor_id)->first();

        // Fetch vendor's Terms & Conditions
        $vendorTC = \App\Models\VendorPage::where('vendor_id', $vehicle->vendor_id)->first();

        return view('user.booking.payment', compact(
            'vehicle', 'rentalDays', 'pickupDate', 'returnDate', 'pickupTime', 'returnTime',
            'pickupLocation', 'returnLocation', 'selectedInsurance', 'selectedExtras',
            'insuranceTotal', 'extrasTotal', 'grandTotal', 'paymentSettings', 'vendorTC'
        ));
    }

    public function information(Request $request, $vehicle_id)
    {
        $vehicle = Vehicle::with(['vendor'])->findOrFail($vehicle_id);
        
        // Calculate Days
        $pickupDate = $request->input('pickup_date'); 
        $returnDate = $request->input('return_date'); 
        $rentalDays = 2; // Default

        if ($pickupDate && $returnDate) {
            try {
                $pDate = Carbon::createFromFormat('d/m/Y', $pickupDate);
                $rDate = Carbon::createFromFormat('d/m/Y', $returnDate);
                $diff = $pDate->diffInDays($rDate);
                $rentalDays = $diff > 0 ? $diff : 1;
            } catch (\Exception $e) {
                $rentalDays = 2;
            }
        }

        // Base price
        $availability = \App\Models\VehicleAvailability::where('vehicle_id', $vehicle->id)
            ->where('status', 1)
            ->orderBy('price', 'asc')
            ->first();
        
        $vehicle->base_price = $availability ? $availability->price : 50.00;
        $vehicle->total_price = $vehicle->base_price * $rentalDays;

        // Time
        $pickupTime = $request->input('pickup_time', '00:00');
        $returnTime = $request->input('return_time', '00:00');

        // Locations
        $pickupLocation = null;
        $returnLocation = null;
        if ($request->has('pickup_location') && $request->input('pickup_location')) {
            $pickupLocation = PickupLocation::find($request->input('pickup_location'));
        }
        if ($request->has('return_location') && $request->input('return_location')) {
            $returnLocation = PickupLocation::find($request->input('return_location'));
        }

        // Fetch Selected Insurance
        $selectedInsurance = null;
        if ($request->filled('insurance_id')) {
            $selectedInsurance = VendorExtra::find($request->input('insurance_id'));
        }

        // Fetch Selected Extras
        $selectedExtras = collect();
        if ($request->filled('extras')) {
            // Format: id:qty,id:qty
            $extrasArr = explode(',', $request->input('extras'));
            foreach ($extrasArr as $ex) {
                $parts = explode(':', $ex);
                if (count($parts) == 2) {
                    $extra = VendorExtra::find($parts[0]);
                    if ($extra) {
                        $extra->qty = (int)$parts[1];
                        $selectedExtras->push($extra);
                    }
                }
            }
        }

        // Calculate Grand Total
        $insuranceTotal = $selectedInsurance ? ($selectedInsurance->price * $rentalDays) : 0;
        
        $extrasTotal = 0;
        foreach ($selectedExtras as $extra) {
            $extrasTotal += ($extra->price * $extra->qty * $rentalDays);
        }

        $grandTotal = $vehicle->total_price + $insuranceTotal + $extrasTotal;

        return view('user.booking.information', compact(
            'vehicle', 'rentalDays', 'pickupDate', 'returnDate', 'pickupTime', 'returnTime',
            'pickupLocation', 'returnLocation', 'selectedInsurance', 'selectedExtras',
            'insuranceTotal', 'extrasTotal', 'grandTotal'
        ));
    }

    public function store(Request $request, $vehicle_id)
    {
        $vehicle = Vehicle::with(['vendor'])->findOrFail($vehicle_id);

        $vendor = $vehicle->vendor;
        if ($vendor && !$vendor->canAcceptBookings()) {
            return back()->with('error', 'This vehicle cannot be booked at this moment because the vendor has reached their subscription booking limit.');
        }

        $reservationNumber = 'DCR' . mt_rand(10000, 99999);

        // Retrieve total price from request or recalculate
        $totalAmount = (float)$request->input('total_price', 0);
        $paidAmount = 0; 
        $pendingAmount = $totalAmount;
        $paymentStatus = 'unpaid';
        $paymentReference = null;
        $paymentMethod = $request->input('payment_method', 'arrival');

        // Fetch vendor payment settings to calculate deposit or full discount
        $paymentSettings = \App\Models\VendorPaymentSetting::where('vendor_id', $vehicle->vendor_id)->first();
        
        if ($request->has('razorpay_payment_id') && !empty($request->input('razorpay_payment_id'))) {
            $paymentReference = $request->input('razorpay_payment_id');
            $paymentStatus = 'paid';
            
            if ($paymentMethod === 'deposit' && $paymentSettings) {
                $depositPercent = (float)($paymentSettings->deposit_percentage ?? 5);
                $paidAmount = $totalAmount * ($depositPercent / 100);
                $pendingAmount = $totalAmount - $paidAmount;
                $paymentStatus = 'partial_paid';
            } elseif ($paymentMethod === 'full' && $paymentSettings) {
                $discountPercent = (float)($paymentSettings->full_payment_discount ?? 5);
                $paidAmount = $totalAmount * ((100 - $discountPercent) / 100);
                $pendingAmount = 0; 
                // Note: The total booking value effectively becomes $paidAmount in case of a full payment discount, 
                // but we keep total_amount as original and just set pending to 0.
            }
        }

        $booking = \App\Models\Booking::create([
            'reservation_number' => $reservationNumber,
            'vendor_id' => $vehicle->vendor_id,
            'user_id' => auth()->id(), // nullable
            'vehicle_id' => $vehicle->id,
            'customer_fname' => $request->input('fname'),
            'customer_lname' => $request->input('lname'),
            'customer_email' => $request->input('email'),
            'customer_phone' => $request->input('phone'),
            'customer_dob' => $request->input('dob'),
            'pickup_location_id' => $request->input('pickup_location'),
            'return_location_id' => $request->input('return_location'),
            'pickup_date' => $request->input('pickup_date'),
            'pickup_time' => $request->input('pickup_time'),
            'return_date' => $request->input('return_date'),
            'return_time' => $request->input('return_time'),
            'total_amount' => $totalAmount,
            'paid_amount' => $paidAmount,
            'pending_amount' => $pendingAmount,
            'payment_method' => $paymentMethod,
            'payment_reference' => $paymentReference,
            'booking_status' => 'pending',
            'payment_status' => $paymentStatus,
        ]);

        // Save Selected Insurance
        if ($request->filled('insurance_id')) {
            $selectedInsurance = \App\Models\VendorExtra::find($request->input('insurance_id'));
            if ($selectedInsurance) {
                \App\Models\BookingExtra::create([
                    'booking_id' => $booking->id,
                    'vendor_extra_id' => $selectedInsurance->id,
                    'qty' => 1,
                    'price' => $selectedInsurance->price
                ]);
            }
        }

        // Save Selected Extras
        if ($request->filled('extras')) {
            // Format: id:qty,id:qty
            $extrasArr = explode(',', $request->input('extras'));
            foreach ($extrasArr as $ex) {
                $parts = explode(':', $ex);
                if (count($parts) == 2) {
                    $extra = \App\Models\VendorExtra::find($parts[0]);
                    if ($extra) {
                        \App\Models\BookingExtra::create([
                            'booking_id' => $booking->id,
                            'vendor_extra_id' => $extra->id,
                            'qty' => (int)$parts[1],
                            'price' => $extra->price
                        ]);
                    }
                }
            }
        }

        // Send Emails
        try {
            // Backup default config
            $defaultConfig = config('mail');

            // Apply vendor specific SMTP config if available
            VendorSmtpSetting::setMailConfig($vehicle->vendor_id);

            // Send to Customer
            Mail::send('email_templates.user-booking', ['booking' => $booking, 'vehicle' => $vehicle], function ($message) use ($booking) {
                $message->to($booking->customer_email)
                        ->subject('Your Booking Under Review - Rydaris');
            });

            // Send to Vendor
            $vendor = User::find($vehicle->vendor_id);
            if ($vendor) {
                Mail::send('email_templates.vendor-booking', ['booking' => $booking, 'vehicle' => $vehicle], function ($message) use ($vendor, $booking) {
                    $message->to($vendor->email)
                            ->subject('New Booking Received: ' . $booking->reservation_number);
                });
            }

            // Restore default config
            Config::set('mail', $defaultConfig);
            \Illuminate\Support\Facades\Mail::purge('smtp');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error sending booking emails: ' . $e->getMessage());
        }

        // Redirect to success page with reservation number
        $urlParams = $request->except(['_token']);
        $urlParams['reservation_number'] = $reservationNumber;
        $queryString = http_build_query($urlParams);

        return redirect()->to("/user/book/{$vehicle_id}/bookingsucces?{$queryString}");
    }

    public function bookingsucces(Request $request, $vehicle_id)
    {
        $vehicle = Vehicle::with(['vendor'])->findOrFail($vehicle_id);
        
        // Calculate Days
        $pickupDate = $request->input('pickup_date'); 
        $returnDate = $request->input('return_date'); 
        $rentalDays = 2; // Default

        if ($pickupDate && $returnDate) {
            try {
                $pDate = Carbon::createFromFormat('d/m/Y', $pickupDate);
                $rDate = Carbon::createFromFormat('d/m/Y', $returnDate);
                $diff = $pDate->diffInDays($rDate);
                $rentalDays = $diff > 0 ? $diff : 1;
            } catch (\Exception $e) {
                $rentalDays = 2;
            }
        }

        // Base price
        $availability = \App\Models\VehicleAvailability::where('vehicle_id', $vehicle->id)
            ->where('status', 1)
            ->orderBy('price', 'asc')
            ->first();
        
        $vehicle->base_price = $availability ? $availability->price : 50.00;
        $vehicle->total_price = $vehicle->base_price * $rentalDays;

        // Time
        $pickupTime = $request->input('pickup_time', '00:00');
        $returnTime = $request->input('return_time', '00:00');

        // Locations
        $pickupLocation = null;
        $returnLocation = null;
        if ($request->has('pickup_location') && $request->input('pickup_location')) {
            $pickupLocation = PickupLocation::find($request->input('pickup_location'));
        }
        if ($request->has('return_location') && $request->input('return_location')) {
            $returnLocation = PickupLocation::find($request->input('return_location'));
        }

        // Fetch Selected Insurance
        $selectedInsurance = null;
        if ($request->filled('insurance_id')) {
            $selectedInsurance = VendorExtra::find($request->input('insurance_id'));
        }

        // Fetch Selected Extras
        $selectedExtras = collect();
        if ($request->filled('extras')) {
            // Format: id:qty,id:qty
            $extrasArr = explode(',', $request->input('extras'));
            foreach ($extrasArr as $ex) {
                $parts = explode(':', $ex);
                if (count($parts) == 2) {
                    $extra = VendorExtra::find($parts[0]);
                    if ($extra) {
                        $extra->qty = (int)$parts[1];
                        $selectedExtras->push($extra);
                    }
                }
            }
        }

        // Calculate Grand Total
        $insuranceTotal = $selectedInsurance ? ($selectedInsurance->price * $rentalDays) : 0;
        
        $extrasTotal = 0;
        foreach ($selectedExtras as $extra) {
            $extrasTotal += ($extra->price * $extra->qty * $rentalDays);
        }

        $grandTotal = $vehicle->total_price + $insuranceTotal + $extrasTotal;

        return view('user.booking.bookingsucces', compact(
            'vehicle', 'rentalDays', 'pickupDate', 'returnDate', 'pickupTime', 'returnTime',
            'pickupLocation', 'returnLocation', 'selectedInsurance', 'selectedExtras',
            'insuranceTotal', 'extrasTotal', 'grandTotal'
        ));
    }

    public function edit($id)
    {
        $booking = \App\Models\Booking::with(['vehicle', 'pickupLocation', 'returnLocation', 'vendor', 'extras.vendorExtra'])
            ->where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();
            
        $locations = \App\Models\PickupLocation::where('vendor_id', $booking->vendor_id)->get();
        $vehicles = \App\Models\Vehicle::where('vendor_id', $booking->vendor_id)->where('status', 1)->get();
        
        $availableExtras = \App\Models\VendorExtra::where('vendor_id', $booking->vendor_id)
            ->where('type', 'extra')
            ->where('status', 1)
            ->get();
        
        $selectedExtras = $booking->extras->pluck('qty', 'vendor_extra_id')->toArray();

        return view('user.booking.edit', compact('booking', 'locations', 'vehicles', 'availableExtras', 'selectedExtras'));
    }

    public function update(Request $request, $id)
    {
        $booking = \App\Models\Booking::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();

        $request->validate([
            'customer_fname' => 'required|string|max:255',
            'customer_lname' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255|same:customer_email_confirm',
            'customer_email_confirm' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:255',
            'customer_dob' => 'nullable|date',
            'pickup_date' => 'required|date',
            'pickup_time' => 'required|string',
            'return_date' => 'required|date',
            'return_time' => 'required|string',
            'pickup_location' => 'required|exists:pickup_locations,id',
            'return_location' => 'required|exists:pickup_locations,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'extras' => 'nullable|array',
            'special_comments' => 'nullable|string'
        ]);

        // Calculate Days
        $pickupDate = $request->input('pickup_date');
        $returnDate = $request->input('return_date');
        
        $pDate = null;
        $rDate = null;
        
        foreach (['Y-m-d', 'd/m/Y', 'd-m-Y'] as $format) {
            try {
                if (!$pDate) $pDate = \Carbon\Carbon::createFromFormat($format, $pickupDate);
            } catch (\Exception $e) {}
            try {
                if (!$rDate) $rDate = \Carbon\Carbon::createFromFormat($format, $returnDate);
            } catch (\Exception $e) {}
        }
        
        if (!$pDate) {
            try {
                $pDate = \Carbon\Carbon::parse($pickupDate);
            } catch (\Exception $e) {
                $pDate = \Carbon\Carbon::now();
            }
        }
        if (!$rDate) {
            try {
                $rDate = \Carbon\Carbon::parse($returnDate);
            } catch (\Exception $e) {
                $rDate = \Carbon\Carbon::now()->addDays(2);
            }
        }
        
        $diff = $pDate->diffInDays($rDate);
        $rentalDays = $diff > 0 ? $diff : 1;

        // Calculate Vehicle Price
        $vehicle = \App\Models\Vehicle::findOrFail($request->input('vehicle_id'));
        $carTotal = ($vehicle->price_per_day ?? 50) * $rentalDays;

        // Calculate Extras Total and Prepare Sync Data
        $extrasTotal = 0;
        $syncExtras = [];
        if ($request->has('extras')) {
            foreach ($request->input('extras') as $extraId => $qty) {
                $qty = (int)$qty;
                if ($qty > 0) {
                    $extra = \App\Models\VendorExtra::find($extraId);
                    if ($extra) {
                        $price = $extra->price;
                        if ($extra->price_type == 1) { // Per Day
                            $extrasTotal += ($price * $rentalDays * $qty);
                        } else { // Total
                            $extrasTotal += ($price * $qty);
                        }
                        $syncExtras[] = [
                            'vendor_extra_id' => $extra->id,
                            'qty' => $qty,
                            'price' => $price
                        ];
                    }
                }
            }
        }

        $grandTotal = $carTotal + $extrasTotal;
        $paidAmount = $booking->paid_amount ?? 0;
        $pendingAmount = $grandTotal - $paidAmount;
        if ($pendingAmount < 0) {
            $pendingAmount = 0;
        }

        // Update Booking
        $booking->update([
            'customer_fname' => $request->input('customer_fname'),
            'customer_lname' => $request->input('customer_lname'),
            'customer_email' => $request->input('customer_email'),
            'customer_phone' => $request->input('customer_phone'),
            'customer_dob' => $request->input('customer_dob'),
            'pickup_date' => $request->input('pickup_date'),
            'pickup_time' => $request->input('pickup_time'),
            'return_date' => $request->input('return_date'),
            'return_time' => $request->input('return_time'),
            'pickup_location_id' => $request->input('pickup_location'),
            'return_location_id' => $request->input('return_location'),
            'vehicle_id' => $request->input('vehicle_id'),
            'special_comments' => $request->input('special_comments'),
            'total_amount' => $grandTotal,
            'pending_amount' => $pendingAmount,
        ]);

        // Sync Extras
        $booking->extras()->delete();
        foreach ($syncExtras as $se) {
            $booking->extras()->create($se);
        }

        // Reload booking with fresh relations for email
        $booking->load(['vehicle', 'pickupLocation', 'returnLocation', 'vendor', 'extras.vendorExtra']);

        // Send Emails
        try {
            $defaultConfig = config('mail');
            VendorSmtpSetting::setMailConfig($booking->vendor_id);

            // Mail to Customer
            Mail::send('email_templates.modify-booking', ['booking' => $booking], function ($message) use ($booking) {
                $message->to($booking->customer_email)
                        ->subject('Your Booking Has Been Modified - ' . $booking->reservation_number);
            });

            // Mail to Vendor
            $vendor = User::find($booking->vendor_id);
            if ($vendor) {
                Mail::send('email_templates.modify-booking', ['booking' => $booking], function ($message) use ($vendor, $booking) {
                    $message->to($vendor->email)
                            ->subject('Booking Modified by Customer: ' . $booking->reservation_number);
                });
            }

            Config::set('mail', $defaultConfig);
            \Illuminate\Support\Facades\Mail::purge('smtp');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error sending modify-booking emails: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Booking details updated successfully.');
    }

    public function checkinRedirect()
    {
        $booking = \App\Models\Booking::where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->first();

        if (!$booking) {
            return redirect()->route('user.dashboard')->with('error', 'You do not have any bookings to check in.');
        }

        return redirect()->route('user.bookings.checkin', $booking->id);
    }

    public function checkinForm($id)
    {
        $booking = \App\Models\Booking::with(['vehicle', 'pickupLocation', 'returnLocation', 'vendor', 'extras.vendorExtra'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('user.booking.checkin', compact('booking'));
    }

    public function submitCheckin(Request $request, $id)
    {
        $booking = \App\Models\Booking::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'license_number' => 'required|string|max:255',
            'license_issue_date' => 'required|date',
            'license_expiry_date' => 'required|date|after:license_issue_date',
            'license_image' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'passport_image' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'pass_number' => 'required|string|max:255',
            'flight_number' => 'nullable|string|max:255',
            'terms_agreed' => 'accepted'
        ]);

        $data = [
            'license_number' => $request->input('license_number'),
            'license_issue_date' => $request->input('license_issue_date'),
            'license_expiry_date' => $request->input('license_expiry_date'),
            'pass_number' => $request->input('pass_number'),
            'flight_number' => $request->input('flight_number'),
            'checkin_status' => true
        ];

        if ($request->hasFile('license_image')) {
            if ($booking->license_image && \Storage::disk('public')->exists($booking->license_image)) {
                \Storage::disk('public')->delete($booking->license_image);
            }
            $data['license_image'] = $request->file('license_image')->store('documents', 'public');
        }

        if ($request->hasFile('passport_image')) {
            if ($booking->passport_image && \Storage::disk('public')->exists($booking->passport_image)) {
                \Storage::disk('public')->delete($booking->passport_image);
            }
            $data['passport_image'] = $request->file('passport_image')->store('documents', 'public');
        }

        $booking->update($data);

        return redirect()->route('user.bookings.payment-page', $booking->id)->with('success', 'Your check-in has been completed successfully! Please proceed with the payment.');
    }

    public function paymentRedirect()
    {
        $booking = \App\Models\Booking::where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->first();

        if (!$booking) {
            return redirect()->route('user.dashboard')->with('error', 'You do not have any bookings to pay.');
        }

        return redirect()->route('user.bookings.payment-page', $booking->id);
    }

    public function paymentPage($id)
    {
        $booking = \App\Models\Booking::with(['vehicle', 'pickupLocation', 'returnLocation', 'vendor', 'extras.vendorExtra'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        $paymentSettings = \App\Models\VendorPaymentSetting::where('vendor_id', $booking->vendor_id)->first();

        return view('user.booking.payment-page', compact('booking', 'paymentSettings'));
    }

    public function processPaymentPage(\Illuminate\Http\Request $request, $id)
    {
        $booking = \App\Models\Booking::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'payment_choice' => 'required|in:deposit,full'
        ]);

        $choice = $request->input('payment_choice');
        $totalAmount = (float)$booking->total_amount;

        $paymentSettings = \App\Models\VendorPaymentSetting::where('vendor_id', $booking->vendor_id)->first();
        $discountPercent = $paymentSettings ? (float)($paymentSettings->full_payment_discount ?? 5) : 5;
        $depositPercent = $paymentSettings ? (float)($paymentSettings->deposit_percentage ?? 5) : 5;

        $paymentReference = $request->input('razorpay_payment_id') ?: 'SIMULATED_' . strtoupper(\Illuminate\Support\Str::random(10));

        if ($choice === 'deposit') {
            $depositAmount = $totalAmount * ($depositPercent / 100);
            $booking->update([
                'paid_amount' => $depositAmount,
                'pending_amount' => $totalAmount - $depositAmount,
                'payment_status' => 'partial_paid',
                'payment_method' => 'deposit',
                'payment_reference' => $paymentReference
            ]);
            $msg = '5% Deposit payment completed successfully!';
        } else {
            if ($booking->payment_status === 'unpaid' || $booking->payment_status === 'pending') {
                $discount = $totalAmount * ($discountPercent / 100);
                $finalAmount = $totalAmount - $discount;
                $booking->update([
                    'paid_amount' => $finalAmount,
                    'pending_amount' => 0,
                    'payment_status' => 'paid',
                    'payment_method' => 'full',
                    'payment_reference' => $paymentReference
                ]);
            } else {
                $booking->update([
                    'paid_amount' => $totalAmount,
                    'pending_amount' => 0,
                    'payment_status' => 'paid',
                    'payment_method' => 'full',
                    'payment_reference' => $paymentReference
                ]);
            }
            $msg = 'Full payment completed successfully!';
        }

        return redirect()->route('user.bookings.payment-page', $booking->id)->with('success', $msg);
    }

    public function invoice($id)
    {
        $booking = \App\Models\Booking::with(['vehicle.vendor', 'pickupLocation', 'returnLocation', 'extras.vendorExtra'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('partials.booking-invoice', compact('booking'));
    }
}
