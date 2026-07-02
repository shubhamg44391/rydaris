<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'type',
        'location',
        'price',
        'map_type',
        'latitude',
        'longitude',
        'map_embed',
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'latitude'  => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    /**
     * The vendor (user) who owns this location.
     */
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    /**
     * Available location types.
     */
    public static function types(): array
    {
        return [
            'Airports',
            'Self Collection',
            'Delivery to your location',
            'Borders',
        ];
    }
}
