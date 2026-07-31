<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'name',
        'phone',
        'address',
        'email',
        'license_number',
        'license_expiry',
        'photo',
        'notes',
        'status',
    ];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'driver_id');
    }
}
