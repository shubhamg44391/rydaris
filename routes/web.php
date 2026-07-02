<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Vendor\VendorRegisterController;
use App\Http\Controllers\Admin\AdminVendorController;
use App\Http\Controllers\Vendor\GroupController as VendorGroupController;
use App\Http\Controllers\Vendor\VehicleController as VendorVehicleController;
use App\Http\Controllers\Vendor\LocationController as VendorLocationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboardController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\Admin\ContactInquiryController as AdminContactInquiryController;
use App\Http\Controllers\Vendor\AvailabilityController as VendorAvailabilityController;

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

    Route::resource('locations', VendorLocationController::class)->except(['show'])->names([
        'index'   => 'vendor.locations.index',
        'create'  => 'vendor.locations.create',
        'store'   => 'vendor.locations.store',
        'edit'    => 'vendor.locations.edit',
        'update'  => 'vendor.locations.update',
        'destroy' => 'vendor.locations.destroy',
    ]);

    // Availability / Pricing Management
    Route::post('availability/fetch-rates',  [VendorAvailabilityController::class, 'fetchRates'])->name('vendor.availability.fetch-rates');
    Route::post('availability/update-rate',  [VendorAvailabilityController::class, 'updateSingleRate'])->name('vendor.availability.update-rate');
    Route::post('availability/bulk-copy-day1', [VendorAvailabilityController::class, 'bulkCopyDay1'])->name('vendor.availability.bulk-copy-day1');
    Route::post('availability/bulk-update',  [VendorAvailabilityController::class, 'bulkUpdateRates'])->name('vendor.availability.bulk-update');
    Route::post('availability/bulk-import',  [VendorAvailabilityController::class, 'bulkImportRates'])->name('vendor.availability.bulk-import');
    Route::post('availability/import-csv',   [VendorAvailabilityController::class, 'importRatesCSV'])->name('vendor.availability.import-csv');
    Route::get('availability/export',        [VendorAvailabilityController::class, 'exportRates'])->name('vendor.availability.export');
    Route::get('availability/history',       [VendorAvailabilityController::class, 'getHistory'])->name('vendor.availability.history');
    Route::post('availability/{id}/toggle',  [VendorAvailabilityController::class, 'toggleStatus'])->name('vendor.availability.toggle');
    Route::get('availability/periods',       [VendorAvailabilityController::class, 'periodsIndex'])->name('vendor.availability.periods');
    Route::post('availability/periods',      [VendorAvailabilityController::class, 'periodStore'])->name('vendor.availability.period-store');
    Route::delete('availability/periods/{id}', [VendorAvailabilityController::class, 'periodDestroy'])->name('vendor.availability.period-destroy');
    Route::resource('availability', VendorAvailabilityController::class)->except(['show'])->names([
        'index'   => 'vendor.availability.index',
        'create'  => 'vendor.availability.create',
        'store'   => 'vendor.availability.store',
        'edit'    => 'vendor.availability.edit',
        'update'  => 'vendor.availability.update',
        'destroy' => 'vendor.availability.destroy',
    ]);

    // Extras Management
    Route::get('extras', [\App\Http\Controllers\Vendor\ExtrasController::class, 'extrasIndex'])->name('vendor.extras.index');
    Route::get('extras/create', [\App\Http\Controllers\Vendor\ExtrasController::class, 'createExtra'])->name('vendor.extras.create');
    Route::get('extras/{id}/edit', [\App\Http\Controllers\Vendor\ExtrasController::class, 'editExtra'])->name('vendor.extras.edit');
    Route::get('insurance', [\App\Http\Controllers\Vendor\ExtrasController::class, 'insuranceIndex'])->name('vendor.insurance.index');
    Route::get('insurance/create', [\App\Http\Controllers\Vendor\ExtrasController::class, 'createInsurance'])->name('vendor.insurance.create');
    Route::get('insurance/{id}/edit', [\App\Http\Controllers\Vendor\ExtrasController::class, 'editInsurance'])->name('vendor.insurance.edit');

    Route::get('features', [\App\Http\Controllers\Vendor\ExtrasController::class, 'featuresIndex'])->name('vendor.features.index');
    Route::post('features', [\App\Http\Controllers\Vendor\ExtrasController::class, 'updateFeatures'])->name('vendor.features.update');
    Route::post('features-mapping/toggle', [\App\Http\Controllers\Vendor\ExtrasController::class, 'toggleFeatureMapping'])->name('vendor.features.mapping.toggle');
    Route::post('features/{id}/sort', [\App\Http\Controllers\Vendor\ExtrasController::class, 'updateFeatureSort'])->name('vendor.features.sort');

    Route::get('rules', [\App\Http\Controllers\Vendor\ExtrasController::class, 'rulesIndex'])->name('vendor.rules.index');

    Route::post('extras', [\App\Http\Controllers\Vendor\ExtrasController::class, 'storeExtra'])->name('vendor.extras.store');
    Route::post('extras/{id}', [\App\Http\Controllers\Vendor\ExtrasController::class, 'updateExtra'])->name('vendor.extras.update');
    Route::delete('extras/{id}', [\App\Http\Controllers\Vendor\ExtrasController::class, 'destroyExtra'])->name('vendor.extras.destroy');
    Route::post('extras/{id}/toggle', [\App\Http\Controllers\Vendor\ExtrasController::class, 'toggleExtraStatus'])->name('vendor.extras.toggle');
    
    Route::post('rules', [\App\Http\Controllers\Vendor\ExtrasController::class, 'storeRule'])->name('vendor.rules.store');
    Route::post('rules/{id}', [\App\Http\Controllers\Vendor\ExtrasController::class, 'updateRule'])->name('vendor.rules.update');
    Route::delete('rules/{id}', [\App\Http\Controllers\Vendor\ExtrasController::class, 'destroyRule'])->name('vendor.rules.destroy');
});
