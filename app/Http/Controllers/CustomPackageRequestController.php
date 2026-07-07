<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomPackageRequest;

class CustomPackageRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'country_code' => 'required|string|max:10',
            'contact_details' => 'required|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['status'] = 'unread';
        CustomPackageRequest::create($data);

        return back()->with('success', 'Your custom package request has been submitted successfully! Our team will contact you shortly.');
    }
}
