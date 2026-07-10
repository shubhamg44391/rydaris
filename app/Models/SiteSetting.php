<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'razorpay_key_id',
        'razorpay_key_secret',
        'razorpay_active',
        'tax_percentage',
    ];

    protected $casts = [
        'razorpay_active' => 'boolean',
    ];
}
