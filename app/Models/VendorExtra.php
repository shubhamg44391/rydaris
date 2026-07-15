<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorExtra extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'vendor_id', 'branch_id', 'group_ids', 'type', 'name', 'price', 'arrival_price',
        'refunded_amount', 'excess_amount', 'icon_class', 'description', 'status'
    ];

    protected $casts = [
        'group_ids' => 'array',
        'status' => 'boolean',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function features()
    {
        return $this->hasMany(VendorExtraFeature::class, 'vendor_extra_id');
    }
}
