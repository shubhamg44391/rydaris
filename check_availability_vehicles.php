<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Group;
use App\Models\Vehicle;
use App\Http\Controllers\Vendor\AvailabilityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();

try {
    // 1. Find a vendor
    $vendor = User::where('role', 'vendor')->first();
    if (!$vendor) {
        throw new Exception("No vendor found");
    }
    Auth::login($vendor);
    echo "Logged in as vendor: {$vendor->id}\n";

    // 2. Set current branch to null (All Branches) and verify all is loaded
    $vendor->current_branch_id = null;
    $vendor->save();
    Auth::setUser($vendor->fresh());

    $controller = new AvailabilityController();
    $request = new Request([
        'year' => 2026,
        'month' => 'next30',
    ]);
    
    // Create a group with branch_id = null and a vehicle with branch_id = 99
    $group = Group::create([
        'vendor_id' => $vendor->id,
        'name' => 'Legacy Group ' . uniqid(),
        'branch_id' => null,
    ]);

    $vehicle = Vehicle::create([
        'vendor_id' => $vendor->id,
        'name' => 'Branch Vehicle ' . uniqid(),
        'model' => 'Model S',
        'seats' => 5,
        'doors' => 4,
        'bags' => 2,
        'group_id' => $group->id,
        'branch_id' => 99, // Some branch ID
        'status' => 'active',
        'gear_system' => 'automatic',
        'passengers' => 5,
        'wheel_drive' => 'AWD',
        'code' => 'CODE_' . uniqid(),
        'stock' => 10,
    ]);

    echo "Created legacy group ID: {$group->id} with branch_id = null\n";
    echo "Created vehicle ID: {$vehicle->id} in Group {$group->id} with branch_id = 99\n";

    // Call fetchRates under Branch 99
    $vendor->current_branch_id = 99;
    $vendor->save();
    Auth::setUser($vendor->fresh());

    $response = $controller->fetchRates($request);
    $data = json_decode($response->getContent(), true);

    if (!isset($data['data'][$group->id])) {
        throw new Exception("Legacy group not found in Branch 99 view!");
    }
    echo "Successfully loaded legacy group in Branch 99 view!\n";

    if (!isset($data['data'][$group->id]['vehicles'][$vehicle->id])) {
        throw new Exception("Branch 99 vehicle not found in legacy group under Branch 99 view!");
    }
    echo "Successfully loaded Branch 99 vehicle inside the legacy group under Branch 99 view!\n";

    echo "ALL VERIFICATION TESTS PASSED SUCCESSFULLY!\n";
} catch (Exception $e) {
    echo "VERIFICATION FAILED: " . $e->getMessage() . "\n";
} finally {
    DB::rollBack();
    echo "Database rolled back successfully.\n";
}
