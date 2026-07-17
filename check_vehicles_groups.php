<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Group;
use App\Models\Vehicle;

$vehicles = Vehicle::all();
foreach ($vehicles as $v) {
    echo "Vehicle ID: {$v->id}, Name: {$v->name}, Group ID: " . json_encode($v->group_id) . ", Branch ID: " . json_encode($v->branch_id) . ", Status: {$v->status}, Vendor ID: {$v->vendor_id}\n";
}

$groups = Group::all();
foreach ($groups as $g) {
    echo "Group ID: {$g->id}, Name: {$g->name}, Branch ID: " . json_encode($g->branch_id) . ", Vendor ID: {$g->vendor_id}\n";
}
