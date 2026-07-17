<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\Vendor\AvailabilityController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

$vendor = User::find(8);
echo "Vendor Current Branch ID: " . json_encode($vendor->current_branch_id) . "\n";
// Temporarily set current_branch_id to null to fetch all
$vendor->current_branch_id = null;
$vendor->save();

Auth::login($vendor);

$controller = new AvailabilityController();
$request = new Request([
    'year' => 2026,
    'month' => 'next30',
]);

$response = $controller->fetchRates($request);
$data = json_decode($response->getContent(), true);

echo "Fetched matrix successfully!\n";
echo "Groups found in matrix: " . implode(', ', array_keys($data['data'])) . "\n";
foreach ($data['data'] as $groupId => $groupData) {
    echo "Group ID: {$groupId}, Name: {$groupData['name']}\n";
    echo "  Vehicles in group in matrix: " . implode(', ', array_keys($groupData['vehicles'])) . "\n";
    foreach ($groupData['vehicles'] as $vehicleId => $vehicleData) {
        echo "    Vehicle ID: {$vehicleId}, Name: {$vehicleData['name']}\n";
    }
}
