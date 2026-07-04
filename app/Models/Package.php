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
        'button_text',
        'order',
        'no_of_users',
        'no_of_vehicles',
        'no_of_groups',
        'no_of_coupons',
    ];

    protected $casts = [
        'features' => 'array',
        'is_featured' => 'boolean',
    ];
}
