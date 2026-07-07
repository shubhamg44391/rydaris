<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'type',
        'code',
        'description',
        'discount',
        'valid_from',
        'valid_to',
        'min_booking_amount',
        'availability_count',
        'used_count',
    ];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}
