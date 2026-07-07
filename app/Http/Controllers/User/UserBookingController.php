<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\VendorExtra;
use App\Models\PickupLocation;
use Carbon\Carbon;

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

        return view('user.booking.payment', compact(
            'vehicle', 'rentalDays', 'pickupDate', 'returnDate', 'pickupTime', 'returnTime',
            'pickupLocation', 'returnLocation', 'selectedInsurance', 'selectedExtras',
            'insuranceTotal', 'extrasTotal', 'grandTotal', 'paymentSettings'
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
        $vehicle = Vehicle::findOrFail($vehicle_id);

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
            'booking_status' => 'confirmed',
            'payment_status' => $paymentStatus,
        ]);

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
}
