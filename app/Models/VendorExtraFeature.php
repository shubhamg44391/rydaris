<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorExtraFeature extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'vendor_extra_id', 'title', 'status', 'index_no'
    ];
}
