<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard.
     */
    public function index()
    {
        $totalVendors = User::where('role', 'vendor')->count();
        $activeVendors = User::where('role', 'vendor')->where('status', 'active')->count();
        $inactiveVendors = User::where('role', 'vendor')->where('status', 'inactive')->count();
        $recentVendors = User::where('role', 'vendor')->orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('totalVendors', 'activeVendors', 'inactiveVendors', 'recentVendors'));
    }
}
