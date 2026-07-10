<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomPackageRequest;

class CustomPackageRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'employee_size' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'country_code' => 'required|string|max:10',
            'contact_details' => 'required|string|max:255',
            'budget' => 'required|numeric|min:0',
            'description' => 'required|string',
        ]);

        $data = $request->all();
        $data['name'] = trim($request->first_name . ' ' . ($request->middle_name ? $request->middle_name . ' ' : '') . $request->last_name);
        $data['status'] = 'unread';
        CustomPackageRequest::create($data);

        return back()->with('success', 'Your custom package request has been submitted successfully! Our team will contact you shortly.');
    }
}
