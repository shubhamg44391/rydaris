<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class VendorCustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'user')
            ->where('vendor_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('vendor.customers.index', compact('customers'));
    }
}
