<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorExtra extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'vendor_id', 'group_id', 'type', 'name', 'price', 'arrival_price',
        'refunded_amount', 'excess_amount', 'icon_class', 'description', 'status'
    ];

    public function features()
    {
        return $this->hasMany(VendorExtraFeature::class, 'vendor_extra_id');
    }
}
