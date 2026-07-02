<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorFeature extends Model
{
    use HasFactory;

    protected $fillable = ['vendor_id', 'title', 'index_no', 'status'];
}
