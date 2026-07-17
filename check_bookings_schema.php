<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Bookings table columns:\n";
print_r(Schema::getColumnListing('bookings'));

echo "Users/Customers table columns:\n";
print_r(Schema::getColumnListing('users'));
