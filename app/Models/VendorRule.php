<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorRule extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'vendor_id', 'min_age', 'max_age', 'underage_charge', 'status'
    ];
}
