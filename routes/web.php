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
use App\Http\Controllers\Vendor\VendorProfileController;
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
Route::get('/terms-of-service', [HomeController::class, 'terms'])->name('terms');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/page/{slug}', function($slug) {
    return redirect()->to('/' . $slug, 301);
});
Route::get('/sitemap', function() {
    return view('frontend.sitemap');
})->name('sitemap.html');

Route::get('/sitemap.xml', function() {
    $path = public_path('sitemap.xml');
    if (!file_exists($path)) {
        $path = base_path('sitemap.xml');
    }
    if (file_exists($path)) {
        return response()->file($path, [
            'Content-Type' => 'application/xml'
        ]);
    }
    abort(404);
})->name('sitemap.xml');

Route::get('/{slug}', [HomeController::class, 'showPage'])->name('frontend.page');

Route::get('/test-loader', function() {
    $videoUrl = asset('assets/loader/loader.mp4');
    $brandColor = '#52ead2';
    $textColor = '#f8fafc';
    $homeUrl = route('home');

    return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loader Test | Rydaris</title>
    <style>
        body {
            margin: 0;
            background-color: #050711;
            color: {$textColor};
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            overflow: hidden;
            width: 100vw;
            height: 100vh;
        }
        /* Fallback Preloader Spinner Styling */
        .site-preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: #050711;
            z-index: 999999;
            overflow: hidden;
            transition: opacity 0.5s ease;
        }
        .site-preloader video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center center;
            display: block;
            z-index: 2;
        }
        .preloader-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 1;
            pointer-events: none;
        }
        .preloader-spinner .spinner-circle {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(255, 255, 255, 0.08);
            border-top: 3px solid {$brandColor};
            border-radius: 50%;
            animation: preloader-spin 1s linear infinite;
        }
        .preloader-spinner span {
            margin-top: 16px;
            font-size: 13px;
            color: {$textColor};
            letter-spacing: 3px;
            text-transform: uppercase;
            font-weight: 500;
            opacity: 0.8;
        }
        @keyframes preloader-spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

    <div id="sitePreloader" class="site-preloader">
        <!-- Fallback Spinner -->
        <div class="preloader-spinner">
            <div class="spinner-circle"></div>
            <span>Testing Loader</span>
        </div>
        <video id="preloaderVideo" src="{$videoUrl}" playsinline webkit-playsinline preload="auto"></video>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var loader = document.getElementById('sitePreloader');
            var video  = document.getElementById('preloaderVideo');
            
            var navigated = false;
            function doNavigate() {
                if (navigated) return;
                navigated = true;
                window.location.href = "{$homeUrl}";
            }

            if (!loader || !video) {
                doNavigate();
                return;
            }

            // Play video with sound
            video.currentTime = 0;
            video.muted = false;
            
            var playPromise = video.play();
            if (playPromise !== undefined) {
                playPromise.catch(function(error) {
                    console.warn("Video preloader unmuted play blocked. Trying muted.", error);
                    video.muted = true;
                    video.play().catch(function(err) {
                        console.error("Muted play failed. Navigating in 3s.", err);
                        setTimeout(doNavigate, 3000);
                    });
                });
            }

            video.addEventListener('ended', doNavigate);
            setTimeout(doNavigate, 10000);
        });
    </script>
</body>
</html>
HTML;
})->name('test-loader');

Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');
Route::post('/custom-package-request', [\App\Http\Controllers\CustomPackageRequestController::class, 'store'])->name('custom-package.submit');
Route::post('/demo-inquiry', [\App\Http\Controllers\DemoInquiryController::class, 'store'])->name('demo-inquiry.submit');

// Public: Vendor Terms & Conditions (new tab)
Route::get('/terms-conditions/{vendorId}', [\App\Http\Controllers\VendorTermsController::class, 'show'])->name('vendor.terms.public');
Route::get('/vehicle-terms/{vehicleId}', [\App\Http\Controllers\VendorTermsController::class, 'showVehicleTerms'])->name('vehicle.terms.public');


Route::get('/user/login', [LoginController::class, 'showLoginForm'])->name('user.login')->middleware('guest');
Route::post('/user/login', [LoginController::class, 'customerLogin'])->middleware('guest');

Route::get('/vendor/login', [LoginController::class, 'showVendorLoginForm'])->name('login')->middleware('guest');
Route::post('/vendor/login', [LoginController::class, 'vendorLogin'])->name('vendor.login')->middleware('guest');

Route::get('/admin/login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login')->middleware('guest');
Route::post('/admin/login', [LoginController::class, 'adminLogin'])->middleware('guest');

Route::match(['get', 'post'], '/logout', [LoginController::class, 'logout'])->name('logout');

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

    Route::resource('pages', \App\Http\Controllers\Admin\AdminPageController::class)->names([
        'index' => 'admin.pages.index',
        'create' => 'admin.pages.create',
        'store' => 'admin.pages.store',
        'edit' => 'admin.pages.edit',
        'update' => 'admin.pages.update',
        'destroy' => 'admin.pages.destroy',
    ]);

    Route::resource('contact-inquiries', AdminContactInquiryController::class)->only(['index', 'destroy'])->names([
        'index' => 'admin.contact-inquiries.index',
        'destroy' => 'admin.contact-inquiries.destroy',
    ]);
    Route::post('contact-inquiries/{id}/toggle-status', [AdminContactInquiryController::class, 'toggleStatus'])->name('admin.contact-inquiries.toggle-status');

    Route::resource('demo-inquiries', \App\Http\Controllers\Admin\AdminDemoInquiryController::class)->only(['index', 'destroy'])->names([
        'index' => 'admin.demo-inquiries.index',
        'destroy' => 'admin.demo-inquiries.destroy',
    ]);
    Route::post('demo-inquiries/{id}/toggle-status', [\App\Http\Controllers\Admin\AdminDemoInquiryController::class, 'toggleStatus'])->name('admin.demo-inquiries.toggle-status');

    Route::resource('custom-package-requests', \App\Http\Controllers\Admin\AdminCustomPackageRequestController::class)->only(['index', 'destroy'])->names([
        'index' => 'admin.custom-package-requests.index',
        'destroy' => 'admin.custom-package-requests.destroy',
    ]);
    Route::post('custom-package-requests/{id}/toggle-status', [\App\Http\Controllers\Admin\AdminCustomPackageRequestController::class, 'toggleStatus'])->name('admin.custom-package-requests.toggle-status');

    // Site Settings
    Route::get('/settings/general', [\App\Http\Controllers\Admin\AdminSettingController::class, 'generalSettings'])->name('admin.settings.general');
    Route::post('/settings/general', [\App\Http\Controllers\Admin\AdminSettingController::class, 'updateGeneralSettings'])->name('admin.settings.general.update');
    Route::get('/settings/payment', [\App\Http\Controllers\Admin\AdminSettingController::class, 'paymentSettings'])->name('admin.settings.payment');
    Route::post('/settings/payment', [\App\Http\Controllers\Admin\AdminSettingController::class, 'updatePaymentSettings'])->name('admin.settings.payment.update');

    // Mail Settings
    Route::get('/settings/mail', [\App\Http\Controllers\Admin\AdminSettingController::class, 'mailSettings'])->name('admin.settings.mail');
    Route::post('/settings/mail', [\App\Http\Controllers\Admin\AdminSettingController::class, 'updateMailSettings'])->name('admin.settings.mail.update');
    Route::post('/settings/mail/test', [\App\Http\Controllers\Admin\AdminSettingController::class, 'sendTestMail'])->name('admin.settings.mail.test');

    // Terms & Conditions
    Route::get('/terms-conditions', [\App\Http\Controllers\Admin\AdminTermsController::class, 'index'])->name('admin.terms.index');
    Route::post('/terms-conditions', [\App\Http\Controllers\Admin\AdminTermsController::class, 'store'])->name('admin.terms.store');

    // Subscriptions
    Route::get('/subscriptions', [\App\Http\Controllers\Admin\AdminSubscriptionController::class, 'index'])->name('admin.subscriptions.index');
    Route::get('/subscriptions/{id}/invoice', [\App\Http\Controllers\Admin\AdminSubscriptionController::class, 'subscriptionInvoice'])->name('admin.subscriptions.invoice');

    // SEO Settings
    Route::resource('seo-settings', \App\Http\Controllers\Admin\SeoMetadataController::class)->only(['index', 'edit', 'update'])->names([
        'index' => 'admin.seo-settings.index',
        'edit' => 'admin.seo-settings.edit',
        'update' => 'admin.seo-settings.update',
    ])->parameters([
        'seo-settings' => 'seoMetadata'
    ]);
});

// Vendor registration
Route::get('/vendor/register', [VendorRegisterController::class, 'showRegisterForm'])->name('vendor.register')->middleware('guest');
Route::post('/vendor/register', [VendorRegisterController::class, 'register'])->name('vendor.register.submit')->middleware('guest');

// User Registration
Route::get('/register', [\App\Http\Controllers\User\UserRegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/register', [\App\Http\Controllers\User\UserRegisterController::class, 'register'])->name('register.submit')->middleware('guest');

// User Routes (Auth + User Middleware)
Route::middleware(['auth', 'user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\User\UserDashboardController::class, 'index'])->name('user.dashboard');
    
    // Profile
    Route::get('/profile', [\App\Http\Controllers\User\UserProfileController::class, 'index'])->name('user.profile.index');
    Route::post('/profile', [\App\Http\Controllers\User\UserProfileController::class, 'update'])->name('user.profile.update');
    Route::post('/profile/password', [\App\Http\Controllers\User\UserProfileController::class, 'updatePassword'])->name('user.profile.password');

    Route::get('/search', [\App\Http\Controllers\User\UserDashboardController::class, 'search'])->name('user.vendors.search');
    Route::get('/vendors/{id}', [\App\Http\Controllers\User\UserDashboardController::class, 'showVendor'])->name('user.vendors.show');
    Route::get('/book/{vehicle}/coverage', [\App\Http\Controllers\User\UserBookingController::class, 'coverage'])->name('user.book.coverage');
    Route::get('/book/{vehicle}/information', [\App\Http\Controllers\User\UserBookingController::class, 'information'])->name('user.book.information');
    Route::get('/book/{vehicle}/payment', [\App\Http\Controllers\User\UserBookingController::class, 'payment'])->name('user.book.payment');
    Route::post('/book/{vehicle}/store', [\App\Http\Controllers\User\UserBookingController::class, 'store'])->name('user.book.store');
    Route::get('/book/{vehicle}/bookingsucces', [\App\Http\Controllers\User\UserBookingController::class, 'bookingsucces'])->name('user.book.bookingsucces');
    
    // Manage Bookings
    Route::get('/bookings/{id}/edit', [\App\Http\Controllers\User\UserBookingController::class, 'edit'])->name('user.bookings.edit');
    Route::put('/bookings/{id}', [\App\Http\Controllers\User\UserBookingController::class, 'update'])->name('user.bookings.update');
    Route::get('/bookings/{id}/invoice', [\App\Http\Controllers\User\UserBookingController::class, 'invoice'])->name('user.bookings.invoice');

    // Check-in flow
    Route::get('/checkin', [\App\Http\Controllers\User\UserBookingController::class, 'checkinRedirect'])->name('user.checkin.redirect');
    Route::get('/bookings/{id}/checkin', [\App\Http\Controllers\User\UserBookingController::class, 'checkinForm'])->name('user.bookings.checkin');
    Route::post('/bookings/{id}/checkin', [\App\Http\Controllers\User\UserBookingController::class, 'submitCheckin'])->name('user.bookings.checkin.submit');

    // Payment flow
    Route::get('/payment', [\App\Http\Controllers\User\UserBookingController::class, 'paymentRedirect'])->name('user.payment.redirect');
    Route::get('/bookings/{id}/payment-page', [\App\Http\Controllers\User\UserBookingController::class, 'paymentPage'])->name('user.bookings.payment-page');
    Route::post('/bookings/{id}/payment-page', [\App\Http\Controllers\User\UserBookingController::class, 'processPaymentPage'])->name('user.bookings.payment-page.submit');
    Route::post('/bookings/{id}/review', [\App\Http\Controllers\User\UserBookingController::class, 'submitReview'])->name('user.bookings.review.submit');
    // Support Ticket System (User Side)
    Route::get('/support-tickets', [\App\Http\Controllers\User\SupportTicketController::class, 'index'])->name('user.support-tickets.index');
    Route::get('/support-tickets/create', [\App\Http\Controllers\User\SupportTicketController::class, 'create'])->name('user.support-tickets.create');
    Route::post('/support-tickets', [\App\Http\Controllers\User\SupportTicketController::class, 'store'])->name('user.support-tickets.store');
    Route::get('/support-tickets/{id}', [\App\Http\Controllers\User\SupportTicketController::class, 'show'])->name('user.support-tickets.show');
    Route::post('/support-tickets/{id}/reply', [\App\Http\Controllers\User\SupportTicketController::class, 'reply'])->name('user.support-tickets.reply');
});

// Subscription Payment Routes — Vendor only
Route::middleware(['auth', 'vendor'])->group(function () {
    Route::post('/subscribe/create-order/{packageId}', [\App\Http\Controllers\Vendor\DashboardController::class, 'createOrder'])->name('vendor.subscribe.create-order');
    Route::post('/subscribe/verify-payment', [\App\Http\Controllers\Vendor\DashboardController::class, 'verifyPayment'])->name('vendor.subscribe.verify');
});

// Vendor Routes (Auth + Vendor Middleware)
Route::middleware(['auth', 'vendor'])->prefix('vendor')->group(function () {
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('vendor.dashboard');
    Route::get('/pricing', [VendorDashboardController::class, 'pricing'])->name('vendor.pricing');
    Route::get('/subscription/history', [VendorDashboardController::class, 'subscriptionHistory'])->name('vendor.subscription.history');
    Route::get('/subscription/{id}/invoice', [VendorDashboardController::class, 'subscriptionInvoice'])->name('vendor.subscription.invoice');
    Route::post('/subscribe/{packageId}', [VendorDashboardController::class, 'subscribe'])->name('vendor.subscribe');

    // Routes that require a subscription
    Route::middleware(['vendor.subscription'])->group(function () {
        Route::get('/bookings', [\App\Http\Controllers\Vendor\BookingController::class, 'index'])->name('vendor.bookings.index');
        Route::post('/bookings/update-status', [\App\Http\Controllers\Vendor\BookingController::class, 'updateStatus'])->name('vendor.bookings.update_status');
        Route::get('/bookings/payment', [\App\Http\Controllers\Vendor\BookingController::class, 'payment'])->name('vendor.bookings.payment');
        Route::get('/bookings/export', [\App\Http\Controllers\Vendor\BookingController::class, 'exportCsv'])->name('vendor.bookings.export');
        Route::get('/bookings/{id}', [\App\Http\Controllers\Vendor\BookingController::class, 'show'])->name('vendor.bookings.show');
        Route::put('/bookings/{id}', [\App\Http\Controllers\Vendor\BookingController::class, 'update'])->name('vendor.bookings.update');
        
        // Profile & Settings
        Route::get('/profile', [VendorProfileController::class, 'index'])->name('vendor.profile.index');
        Route::post('/profile', [VendorProfileController::class, 'update'])->name('vendor.profile.update');
        Route::post('/profile/password', [VendorProfileController::class, 'updatePassword'])->name('vendor.profile.password');

        // Terms & Conditions
        Route::get('/terms-conditions', [\App\Http\Controllers\Vendor\PageController::class, 'index'])->name('vendor.pages.index');
        Route::post('/terms-conditions', [\App\Http\Controllers\Vendor\PageController::class, 'store'])->name('vendor.pages.store');
        Route::delete('/terms-conditions', [\App\Http\Controllers\Vendor\PageController::class, 'destroy'])->name('vendor.pages.destroy');

        Route::get('/payment-settings', [\App\Http\Controllers\Vendor\PaymentSettingController::class, 'index'])->name('vendor.payment_settings.index');
        Route::post('/payment-settings', [\App\Http\Controllers\Vendor\PaymentSettingController::class, 'update'])->name('vendor.payment_settings.update');

        // Branch Management Routes (AJAX CRUD)
        Route::get('/branches', [\App\Http\Controllers\Vendor\BranchController::class, 'index'])->name('vendor.branches.index');
        Route::get('/branches/data', [\App\Http\Controllers\Vendor\BranchController::class, 'list'])->name('vendor.branches.list');
        Route::post('/branches', [\App\Http\Controllers\Vendor\BranchController::class, 'store'])->name('vendor.branches.store');
        Route::get('/branches/{id}/edit', [\App\Http\Controllers\Vendor\BranchController::class, 'edit'])->name('vendor.branches.edit');
        Route::put('/branches/{id}', [\App\Http\Controllers\Vendor\BranchController::class, 'update'])->name('vendor.branches.update');
        Route::delete('/branches/{id}', [\App\Http\Controllers\Vendor\BranchController::class, 'destroy'])->name('vendor.branches.destroy');
        Route::post('/branches/select', [\App\Http\Controllers\Vendor\BranchController::class, 'selectBranch'])->name('vendor.branches.select');

        Route::get('/smtp-settings', [\App\Http\Controllers\Vendor\SmtpSettingController::class, 'index'])->name('vendor.smtp_settings.index');
        Route::post('/smtp-settings', [\App\Http\Controllers\Vendor\SmtpSettingController::class, 'update'])->name('vendor.smtp_settings.update');
        Route::resource('customers', \App\Http\Controllers\Vendor\VendorCustomerController::class)->except(['show'])->names([
            'index'   => 'vendor.customers.index',
            'create'  => 'vendor.customers.create',
            'store'   => 'vendor.customers.store',
            'edit'    => 'vendor.customers.edit',
            'update'  => 'vendor.customers.update',
            'destroy' => 'vendor.customers.destroy',
        ]);

        // User Invitation routes
        Route::resource('invitations', \App\Http\Controllers\Vendor\VendorInvitationController::class)->except(['show'])->names([
            'index'   => 'vendor.invitations.index',
            'create'  => 'vendor.invitations.create',
            'store'   => 'vendor.invitations.store',
            'edit'    => 'vendor.invitations.edit',
            'update'  => 'vendor.invitations.update',
            'destroy' => 'vendor.invitations.destroy',
        ]);
        Route::post('invitations/{id}/resend', [\App\Http\Controllers\Vendor\VendorInvitationController::class, 'resend'])->name('vendor.invitations.resend');

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

        // Coupons Management
        Route::resource('coupons', \App\Http\Controllers\Vendor\CouponController::class)->except(['show'])->names([
            'index'   => 'vendor.coupons.index',
            'create'  => 'vendor.coupons.create',
            'store'   => 'vendor.coupons.store',
            'edit'    => 'vendor.coupons.edit',
            'update'  => 'vendor.coupons.update',
            'destroy' => 'vendor.coupons.destroy',
        ]);

        // Support Ticket System (Vendor Side)
        Route::get('/support-tickets', [\App\Http\Controllers\Vendor\SupportTicketController::class, 'index'])->name('vendor.support-tickets.index');
        Route::get('/support-tickets/{id}', [\App\Http\Controllers\Vendor\SupportTicketController::class, 'show'])->name('vendor.support-tickets.show');
        Route::post('/support-tickets/{id}/reply', [\App\Http\Controllers\Vendor\SupportTicketController::class, 'reply'])->name('vendor.support-tickets.reply');
        Route::post('/support-tickets/{id}/close', [\App\Http\Controllers\Vendor\SupportTicketController::class, 'close'])->name('vendor.support-tickets.close');

        // Customer Reviews (Vendor Side)
        Route::get('/reviews', [\App\Http\Controllers\Vendor\VendorReviewController::class, 'index'])->name('vendor.reviews.index');
        Route::delete('/reviews/{id}', [\App\Http\Controllers\Vendor\VendorReviewController::class, 'destroy'])->name('vendor.reviews.destroy');
    });
});

Route::get('/dev-login', function() {
    Auth::loginUsingId(49);
    return redirect('/user/dashboard');
});

// Demo Routes (static mock portal — no live DB)
Route::prefix('demo')->name('demo.')->group(function () {
    $demo = \App\Http\Controllers\Demo\DemoController::class;

    Route::get('/dashboard', [$demo, 'dashboard'])->name('dashboard');

    Route::get('/bookings', [$demo, 'bookings'])->name('bookings');
    Route::get('/bookings/payment', [$demo, 'bookingsPayment'])->name('bookings.payment');

    Route::get('/vehicles', [$demo, 'vehicles'])->name('vehicles');
    Route::get('/vehicles/create', [$demo, 'vehiclesCreate'])->name('vehicles.create');

    Route::get('/locations', [$demo, 'locations'])->name('locations');
    Route::get('/locations/create', [$demo, 'locationsCreate'])->name('locations.create');

    Route::get('/customers', [$demo, 'customers'])->name('customers');
    Route::get('/customers/create', [$demo, 'customersCreate'])->name('customers.create');
    Route::get('/invitations', [$demo, 'invitations'])->name('invitations');
    Route::get('/invitations/create', [$demo, 'invitationsCreate'])->name('invitations.create');

    Route::get('/fleet', [$demo, 'fleet'])->name('fleet');

    Route::get('/extras', [$demo, 'extras'])->name('extras');
    Route::get('/extras/create', [$demo, 'extrasCreate'])->name('extras.create');
    Route::get('/insurance', [$demo, 'insurance'])->name('insurance');
    Route::get('/insurance/create', [$demo, 'insuranceCreate'])->name('insurance.create');
    Route::get('/features', [$demo, 'features'])->name('features');
    Route::get('/features/create', [$demo, 'featuresCreate'])->name('features.create');
    Route::get('/rules', [$demo, 'rules'])->name('rules');
    Route::get('/rules/create', [$demo, 'rulesCreate'])->name('rules.create');

    Route::get('/coupons', [$demo, 'coupons'])->name('coupons');
    Route::get('/coupons/create', [$demo, 'couponsCreate'])->name('coupons.create');
    Route::get('/support-tickets', [$demo, 'supportTickets'])->name('support-tickets');
    Route::get('/support-tickets/create', [$demo, 'supportTicketsCreate'])->name('support-tickets.create');

    Route::get('/subscription', [$demo, 'subscription'])->name('subscription');
    Route::get('/subscription/history', [$demo, 'subscriptionHistory'])->name('subscription.history');

    Route::get('/terms-conditions', [$demo, 'terms'])->name('terms');

    Route::get('/settings/business', [$demo, 'businessSettings'])->name('settings.business');
    Route::get('/settings/payment', [$demo, 'paymentSettings'])->name('settings.payment');

    Route::get('/profile', [$demo, 'profile'])->name('profile');
});
