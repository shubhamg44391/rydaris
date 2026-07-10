<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'package_id',
        'starts_at',
        'ends_at',
        'status',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'amount_paid',
        'street_address',
        'landmark',
        'pincode',
        'city',
        'country',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function isValid()
    {
        return $this->status === 'active' && 
               $this->starts_at <= now() && 
               $this->ends_at >= now();
    }
}
