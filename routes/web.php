<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Vendor\VendorRegisterController;
use App\Http\Controllers\Admin\AdminVendorController;
use App\Http\Controllers\Vendor\GroupController as VendorGroupController;
use App\Http\Controllers\Vendor\VehicleController as VendorVehicleController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboardController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\Admin\ContactInquiryController as AdminContactInquiryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/clear', function () {

    Artisan::call('optimize:clear');

    return 'Cache Cleared';
});

Route::get('/migrate', function () {

    Artisan::call('migrate');

    return 'Migration Completed';
});


Route::get('/migrate-fresh', function () {

    Artisan::call('migrate:fresh --seed');

    return 'Fresh Migration & Seeder Completed';
});

Route::get('/seed', function () {

    Artisan::call('db:seed');

    return 'Seeder Completed';
});

Route::get('/storage-link', function () {

    Artisan::call('storage:link');

    return 'Storage Linked';
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes (Auth + Admin Middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/vendor', [AdminVendorController::class, 'index'])->name('admin.vendors.index');
    Route::post('/vendor/{id}/toggle-status', [AdminVendorController::class, 'toggleStatus'])->name('admin.vendors.toggle-status');
    Route::get('/vendor/{id}/edit', [AdminVendorController::class, 'edit'])->name('admin.vendors.edit');
    Route::put('/vendor/{id}', [AdminVendorController::class, 'update'])->name('admin.vendors.update');
    Route::delete('/vendor/{id}', [AdminVendorController::class, 'destroy'])->name('admin.vendors.destroy');

    Route::resource('faqs', AdminFaqController::class)->except(['show'])->names([
        'index' => 'admin.faqs.index',
        'create' => 'admin.faqs.create',
        'store' => 'admin.faqs.store',
        'edit' => 'admin.faqs.edit',
        'update' => 'admin.faqs.update',
        'destroy' => 'admin.faqs.destroy',
    ]);

    Route::resource('packages', AdminPackageController::class)->except(['show'])->names([
        'index' => 'admin.packages.index',
        'create' => 'admin.packages.create',
        'store' => 'admin.packages.store',
        'edit' => 'admin.packages.edit',
        'update' => 'admin.packages.update',
        'destroy' => 'admin.packages.destroy',
    ]);

    Route::resource('contact-inquiries', AdminContactInquiryController::class)->only(['index', 'destroy'])->names([
        'index' => 'admin.contact-inquiries.index',
        'destroy' => 'admin.contact-inquiries.destroy',
    ]);
    Route::post('contact-inquiries/{id}/toggle-status', [AdminContactInquiryController::class, 'toggleStatus'])->name('admin.contact-inquiries.toggle-status');
});

// Vendor registration
Route::get('/vendor/register', [VendorRegisterController::class, 'showRegisterForm'])->name('vendor.register')->middleware('guest');
Route::post('/vendor/register', [VendorRegisterController::class, 'register'])->name('vendor.register.submit')->middleware('guest');

// Vendor Routes (Auth + Vendor Middleware)
Route::middleware(['auth', 'vendor'])->prefix('vendor')->group(function () {
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('vendor.dashboard');
    Route::resource('groups', VendorGroupController::class)->except(['show'])->names([
        'index' => 'vendor.groups.index',
        'create' => 'vendor.groups.create',
        'store' => 'vendor.groups.store',
        'edit' => 'vendor.groups.edit',
        'update' => 'vendor.groups.update',
        'destroy' => 'vendor.groups.destroy',
    ]);

    Route::resource('vehicles', VendorVehicleController::class)->except(['show'])->names([
        'index' => 'vendor.vehicles.index',
        'create' => 'vendor.vehicles.create',
        'store' => 'vendor.vehicles.store',
        'edit' => 'vendor.vehicles.edit',
        'update' => 'vendor.vehicles.update',
        'destroy' => 'vendor.vehicles.destroy',
    ]);
});
