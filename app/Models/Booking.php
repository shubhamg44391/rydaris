<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_number', 'vendor_id', 'user_id', 'vehicle_id',
        'customer_fname', 'customer_lname', 'customer_email', 'customer_phone', 'customer_dob',
        'pickup_location_id', 'return_location_id', 'pickup_date', 'pickup_time', 'return_date', 'return_time',
        'total_amount', 'paid_amount', 'pending_amount',
        'payment_method', 'payment_reference', 'booking_status', 'payment_status'
    ];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function pickupLocation()
    {
        return $this->belongsTo(PickupLocation::class, 'pickup_location_id');
    }

    public function returnLocation()
    {
        return $this->belongsTo(PickupLocation::class, 'return_location_id');
    }
}
