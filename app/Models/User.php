<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'email',
        'password',
        'contact_number',
        'country_code',
        'role',
        'status',
        'username',
        'company_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function subscription()
    {
        return $this->hasOne(VendorSubscription::class, 'vendor_id')->latest();
    }

    public function activeSubscription()
    {
        return $this->hasOne(VendorSubscription::class, 'vendor_id')
                    ->where('status', 'active')
                    ->where('starts_at', '<=', now())
                    ->where('ends_at', '>=', now())
                    ->latest();
    }

    public function groups()
    {
        return $this->hasMany(Group::class, 'vendor_id');
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'vendor_id');
    }

    public function canAddGroup()
    {
        $subscription = $this->activeSubscription;
        if (!$subscription) {
            return false;
        }

        $limit = $subscription->package->no_of_groups;
        // Assuming null or -1 means unlimited
        if (is_null($limit) || $limit == -1) {
            return true;
        }

        return $this->groups()->count() < (int) $limit;
    }

    public function canAddVehicle()
    {
        $subscription = $this->activeSubscription;
        if (!$subscription) {
            return false;
        }

        $limit = $subscription->package->no_of_vehicles;
        if (is_null($limit) || $limit == -1) {
            return true;
        }

        return $this->vehicles()->count() < (int) $limit;
    }
}
