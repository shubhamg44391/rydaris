<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'eyebrow',
        'description',
        'price',
        'billing_period',
        'features',
        'is_featured',
        'is_active',
        'button_text',
        'order',
        'no_of_users',
        'no_of_invitations',
        'no_of_vehicles',
        'no_of_groups',
        'no_of_branches',
        'no_of_coupons',
        'no_of_bookings',
        'no_of_locations',
        'no_of_extras',
        'no_of_insurances',
        'no_of_features',
        'no_of_rules',
        'no_of_support_tickets',
        'booking_menu',
        'vehicles_menu',
        'locations_menu',
        'customers_menu',
        'fleet_management_menu',
        'extras_menu',
        'coupons_menu',
        'support_ticket_menu',
        'settings_menu',
    ];

    protected $casts = [
        'features' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'no_of_bookings' => 'integer',
        'no_of_locations' => 'integer',
        'no_of_extras' => 'integer',
        'no_of_insurances' => 'integer',
        'no_of_features' => 'integer',
        'no_of_rules' => 'integer',
        'no_of_support_tickets' => 'integer',
        'no_of_branches' => 'integer',
        'booking_menu' => 'boolean',
        'vehicles_menu' => 'boolean',
        'locations_menu' => 'boolean',
        'customers_menu' => 'boolean',
        'fleet_management_menu' => 'boolean',
        'extras_menu' => 'boolean',
        'coupons_menu' => 'boolean',
        'support_ticket_menu' => 'boolean',
        'settings_menu' => 'boolean',
    ];
}
