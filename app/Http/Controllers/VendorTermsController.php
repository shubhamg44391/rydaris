<?php

namespace App\Http\Controllers;

use App\Models\VendorPage;
use App\Models\User;

class VendorTermsController extends Controller
{
    

    public function show($vendorId)
    {
        $vendor = User::findOrFail($vendorId);
        $tc = VendorPage::where('vendor_id', $vendorId)->first();

        return view('public.vendor-terms', compact('vendor', 'tc'));
    }

    

    public function showVehicleTerms($vehicleId)
    {
        $vehicle = \App\Models\Vehicle::findOrFail($vehicleId);
        $vendor = User::findOrFail($vehicle->vendor_id);
        
        $tc = (object)[
            'title' => $vehicle->name . ' - Terms & Conditions',
            'description' => $vehicle->terms,
        ];

        return view('public.vendor-terms', compact('vendor', 'tc'));
    }
}

