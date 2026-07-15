<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactSubmissionMail;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $user = auth()->user();
           
               
            if ($user->role === 'user') {
                return redirect()->route('user.dashboard');
            }
         
        }
        return view('frontend.index');
    }

    /**
     * Show frontend homepage directly without auth redirect.
     * Used by the "Visit Website" button in the admin/vendor panel.
     */
    public function frontend()
    {
        return view('frontend.index');
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function pricing()
    {
        $packages = \App\Models\Package::where('is_active', true)->get()->sortBy(function ($package) {
            $priceStr = strtolower($package->price);
            if ($priceStr === 'free' || $priceStr === '0' || $priceStr === '$0') {
                return 0;
            }
            if ($priceStr === 'custom' || $priceStr === 'enterprise') {
                return 999999;
            }
            preg_match_all('!\d+!', $package->price, $matches);
            if (!empty($matches[0])) {
                return (float) implode('', $matches[0]);
            }
            return 999999;
        })->values();
        return view('frontend.pricing', compact('packages'));
    }

    public function faq()
    {
        $productBasics = \App\Models\Faq::where('category', 'product_basics')->orderBy('created_at', 'asc')->get();
        $onboarding = \App\Models\Faq::where('category', 'onboarding')->orderBy('created_at', 'asc')->get();
        $reporting = \App\Models\Faq::where('category', 'reporting')->orderBy('created_at', 'asc')->get();

        return view('frontend.faq', compact('productBasics', 'onboarding', 'reporting'));
    }

    public function terms()
    {
        $page = \App\Models\AdminTermsCondition::first();

        return view('frontend.terms', compact('page'));
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
