<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id', 'group_id', 'vehicle_id', 'rental_period_id',
        'pickup_date', 'dropup_date', 'min_day', 'max_day', 'price', 'status',
    ];

    protected $casts = [
        'pickup_date' => 'date',
        'dropup_date' => 'date',
        'price'       => 'decimal:2',
        'status'      => 'integer',
    ];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function rentalPeriod()
    {
        return $this->belongsTo(RentalPeriod::class, 'rental_period_id');
    }
}
