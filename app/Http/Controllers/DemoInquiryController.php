<?php

namespace App\Http\Controllers;

use App\Models\DemoInquiry;
use Illuminate\Http\Request;

class DemoInquiryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'first_name'      => 'required|string|max:255',
            'middle_name'     => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'company_name'    => 'required|string|max:255',
            'email'           => 'required|email|max:255',
            'country_code'    => 'required|string|max:10',
            'contact_details' => 'required|string|max:255',
            'description'     => 'required|string',
        ]);

        $data = $request->only([
            'first_name', 'middle_name', 'last_name', 'company_name',
            'email', 'country_code', 'contact_details', 'description',
        ]);
        $data['name'] = trim($request->first_name . ' ' . ($request->middle_name ? $request->middle_name . ' ' : '') . $request->last_name);
        $data['status'] = 'unread';

        DemoInquiry::create($data);

        return back()->with('demo_inquiry_success', 'Your demo inquiry has been submitted successfully! Our team will contact you shortly.');
    }
}
