<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'vendor_id',
    ];

    /**
     * Get the vendor that owns the group.
     */
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    /**
     * Get the vehicles associated with the group.
     */
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'group_id');
    }
}
