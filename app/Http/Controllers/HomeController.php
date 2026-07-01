<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactSubmissionMail;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function pricing()
    {
        $packages = \App\Models\Package::orderBy('order', 'asc')->get();
        return view('frontend.pricing', compact('packages'));
    }

    public function faq()
    {
        $productBasics = \App\Models\Faq::where('category', 'product_basics')->orderBy('created_at', 'asc')->get();
        $onboarding = \App\Models\Faq::where('category', 'onboarding')->orderBy('created_at', 'asc')->get();
        $reporting = \App\Models\Faq::where('category', 'reporting')->orderBy('created_at', 'asc')->get();

        return view('frontend.faq', compact('productBasics', 'onboarding', 'reporting'));
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'fleet_size' => ['required', 'string', 'max:255'],
            'need' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        // Save to database
        \App\Models\ContactInquiry::create($validated);

        // Find the super admin's email or default
        $adminEmail = \App\Models\User::where('role', 'super_admin')->first()->email ?? 'admin@rydaris.com';

        try {
            Mail::to($adminEmail)->send(new ContactSubmissionMail($validated));
        } catch (\Exception $e) {
            // Log the error but proceed so the inquiry is still registered in database
            \Illuminate\Support\Facades\Log::error('Contact email notification failed: ' . $e->getMessage());
        }

        return redirect()->route('contact')->with('success', 'Thank you! Your message has been sent successfully. We will get back to you within one business day.');
    }
}
