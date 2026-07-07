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
        'company_logo',
        'vendor_id',
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

    /**
     * Get the vendor that this user belongs to.
     */
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    /**
     * Get the users/customers under this vendor.
     */
    public function customers()
    {
        return $this->hasMany(User::class, 'vendor_id');
    }

    public function subscription()
    {
        return $this->hasOne(VendorSubscription::class, 'vendor_id')->latest();
    }

    public function subscriptions()
    {
        return $this->hasMany(VendorSubscription::class, 'vendor_id')->latest();
    }

    public function activeSubscription()
    {
        return $this->hasOne(VendorSubscription::class, 'vendor_id')
                    ->ofMany([], function ($query) {
                        $query->where('status', 'active')
                              ->where('starts_at', '<=', now())
                              ->where('ends_at', '>=', now());
                    });
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

        $limit = (int) $subscription->package->no_of_groups;
        return $this->groups()->count() < $limit;
    }

    public function canAddVehicle()
    {
        $subscription = $this->activeSubscription;
        if (!$subscription) {
            return false;
        }

        $limit = (int) $subscription->package->no_of_vehicles;
        return $this->vehicles()->count() < $limit;
    }

    public function paymentSetting()
    {
        return $this->hasOne(VendorPaymentSetting::class, 'vendor_id');
    }

    public function hasCouponFeature()
    {
        $subscription = $this->activeSubscription;
        if (!$subscription) {
            return false;
        }

        $limit = (int) $subscription->package->no_of_coupons;
        return $limit > 0;
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class, 'vendor_id');
    }

    public function canAddCoupon()
    {
        $subscription = $this->activeSubscription;
        if (!$subscription) {
            return false;
        }

        $limit = (int) $subscription->package->no_of_coupons;
        return $this->coupons()->count() < $limit;
    }
}
