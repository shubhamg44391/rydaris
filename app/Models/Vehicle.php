<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'branch_id',
        'group_id',
        'name',
        'model',
        'seats',
        'doors',
        'bags',
        'status',
        'image',
        'gear_system',
        'passengers',
        'wheel_drive',
        'code',
        'stock',
        'features',
        'terms',
    ];

    protected $casts = [
        'features' => 'array',
    ];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
