<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorPaymentSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'pay_on_arrival',
        'pay_deposit',
        'deposit_percentage',
        'pay_full',
        'full_payment_discount',
        'razorpay_key',
        'razorpay_secret',
    ];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}
