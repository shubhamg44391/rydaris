<?php

namespace App\Http\Controllers\Demo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function dashboard()
    {
        return view('demo.dashboard');
    }

    public function fleet()
    {
        return view('demo.fleet');
    }

    public function customers()
    {
        return view('demo.customers');
    }
}
