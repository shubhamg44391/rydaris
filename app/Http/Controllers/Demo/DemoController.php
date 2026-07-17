<?php

namespace App\Http\Controllers\Demo;

use App\Demo\DemoData;
use App\Http\Controllers\Controller;

class DemoController extends Controller
{
    public function dashboard()
    {
        return view('demo.dashboard');
    }

    public function bookings()
    {
        return view('demo.bookings.index', ['items' => DemoData::bookings()]);
    }

    public function bookingsPayment()
    {
        return view('demo.bookings.payment', ['items' => DemoData::bookings()]);
    }

    public function vehicles()
    {
        return view('demo.vehicles.index', ['items' => DemoData::vehicles()]);
    }

    public function vehiclesCreate()
    {
        return view('demo.vehicles.create');
    }

    public function locations()
    {
        return view('demo.locations.index', ['items' => DemoData::locations()]);
    }

    public function locationsCreate()
    {
        return view('demo.locations.create');
    }

    public function customers()
    {
        return view('demo.customers', ['items' => DemoData::customers()]);
    }

    public function customersCreate()
    {
        return view('demo.customers-create');
    }

    public function invitations()
    {
        return view('demo.invitations', ['items' => DemoData::invitations()]);
    }

    public function invitationsCreate()
    {
        return view('demo.invitations-create');
    }

    public function fleet()
    {
        $groups = DemoData::rateGroups();
        $initialData = DemoData::ratesMatrix();

        return view('demo.fleet', compact('groups', 'initialData'));
    }

    public function extras()
    {
        return view('demo.extras', ['items' => DemoData::extras()]);
    }

    public function extrasCreate()
    {
        return view('demo.extras-create');
    }

    public function insurance()
    {
        return view('demo.insurance', ['items' => DemoData::insurance()]);
    }

    public function insuranceCreate()
    {
        return view('demo.insurance-create');
    }

    public function features()
    {
        return view('demo.features', ['items' => DemoData::features()]);
    }

    public function featuresCreate()
    {
        return view('demo.features-create');
    }

    public function rules()
    {
        return view('demo.rules', ['items' => DemoData::rules()]);
    }

    public function rulesCreate()
    {
        return view('demo.rules-create');
    }

    public function coupons()
    {
        return view('demo.coupons', ['items' => DemoData::coupons()]);
    }

    public function couponsCreate()
    {
        return view('demo.coupons-create');
    }

    public function supportTickets()
    {
        return view('demo.support-tickets', ['items' => DemoData::tickets()]);
    }

    public function supportTicketsCreate()
    {
        return view('demo.support-tickets-create');
    }

    public function subscription()
    {
        return view('demo.subscription', ['packages' => DemoData::packages()]);
    }

    public function subscriptionHistory()
    {
        return view('demo.subscription-history', ['items' => DemoData::subscriptionHistory()]);
    }

    public function terms()
    {
        return view('demo.terms');
    }

    public function businessSettings()
    {
        return view('demo.settings.business');
    }

    public function paymentSettings()
    {
        return view('demo.settings.payment');
    }

    public function profile()
    {
        return view('demo.profile');
    }
}
