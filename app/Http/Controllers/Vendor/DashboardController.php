<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the Vendor Dashboard.
     */
    public function index()
    {
        return view('vendor.dashboard');
    }
}
