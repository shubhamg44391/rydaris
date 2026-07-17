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
        'middle_name',
        'last_name',
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
        'last_checked_bookings_at',
        'street_address',
        'landmark',
        'pincode',
        'city',
        'country',
        'current_branch_id',
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

    public function branches()
    {
        return $this->hasMany(Branch::class, 'vendor_id');
    }

    public function currentBranch()
    {
        return $this->belongsTo(Branch::class, 'current_branch_id');
    }

    public function groups()
    {
        return $this->hasMany(Group::class, 'vendor_id');
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'vendor_id');
    }

    public function hasMenuAccess(string $menu): bool
    {
        if ($this->role === 'user' && $this->vendor_id) {
            $vendor = self::find($this->vendor_id);
            return $vendor ? $vendor->hasMenuAccess($menu) : false;
        }

        $subscription = $this->activeSubscription;
        if (!$subscription || !$subscription->package) {
            return false;
        }

        $column = $menu . '_menu';
        return (bool) ($subscription->package->$column ?? false);
    }

    public function canAddGroup()
    {
        if (!$this->hasMenuAccess('vehicles')) {
            return false;
        }
        $subscription = $this->activeSubscription;
        if (!$subscription || !$subscription->package) {
            return false;
        }

        return $this->checkLimit($this->groups()->count(), $subscription->package->no_of_groups);
    }

    public function canAddVehicle()
    {
        if (!$this->hasMenuAccess('vehicles')) {
            return false;
        }
        $subscription = $this->activeSubscription;
        if (!$subscription || !$subscription->package) {
            return false;
        }

        return $this->checkLimit($this->vehicles()->count(), $subscription->package->no_of_vehicles);
    }

    public function canAddBranch()
    {
        $subscription = $this->activeSubscription;
        if (!$subscription) {
            return false;
        }

        $limit = $subscription->package->no_of_branches;
        if (is_null($limit) || $limit === -1) {
            return true;
        }

        return $this->branches()->count() < (int)$limit;
    }

    public function paymentSetting()
    {
        return $this->hasOne(VendorPaymentSetting::class, 'vendor_id');
    }

    public function hasCouponFeature()
    {
        if (!$this->hasMenuAccess('coupons')) {
            return false;
        }
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
        if (!$this->hasMenuAccess('coupons')) {
            return false;
        }
        $subscription = $this->activeSubscription;
        if (!$subscription) {
            return false;
        }

        $limit = (int) $subscription->package->no_of_coupons;
        return $this->coupons()->count() < $limit;
    }

    public function pickupLocations()
    {
        return $this->hasMany(\App\Models\PickupLocation::class, 'vendor_id');
    }

    public function vendorExtras()
    {
        return $this->hasMany(\App\Models\VendorExtra::class, 'vendor_id')->where('type', 'extra');
    }

    public function vendorInsurances()
    {
        return $this->hasMany(\App\Models\VendorExtra::class, 'vendor_id')->where('type', 'insurance');
    }

    public function vendorFeatures()
    {
        return $this->hasMany(\App\Models\VendorFeature::class, 'vendor_id');
    }

    public function vendorRules()
    {
        return $this->hasMany(\App\Models\VendorRule::class, 'vendor_id');
    }

    public function userInvitations()
    {
        return $this->hasMany(\App\Models\UserInvitation::class, 'vendor_id');
    }

    public function supportTickets()
    {
        return $this->hasMany(\App\Models\SupportTicket::class, 'vendor_id');
    }

    public function checkLimit($count, $limit)
    {
        if ($limit === null || $limit === '' || $limit === 'Unlimited') {
            return true;
        }
        return $count < (int)$limit;
    }

    public function canAddLocation()
    {
        if (!$this->hasMenuAccess('locations')) {
            return false;
        }
        $subscription = $this->activeSubscription;
        if (!$subscription || !$subscription->package) {
            return false;
        }
        return $this->checkLimit($this->pickupLocations()->count(), $subscription->package->no_of_locations);
    }

    public function canAddExtra()
    {
        if (!$this->hasMenuAccess('extras')) {
            return false;
        }
        $subscription = $this->activeSubscription;
        if (!$subscription || !$subscription->package) {
            return false;
        }
        return $this->checkLimit($this->vendorExtras()->count(), $subscription->package->no_of_extras);
    }

    public function canAddInsurance()
    {
        if (!$this->hasMenuAccess('extras')) {
            return false;
        }
        $subscription = $this->activeSubscription;
        if (!$subscription || !$subscription->package) {
            return false;
        }
        return $this->checkLimit($this->vendorInsurances()->count(), $subscription->package->no_of_insurances);
    }

    public function canAddFeature($countToCheck = null)
    {
        if (!$this->hasMenuAccess('extras')) {
            return false;
        }
        $subscription = $this->activeSubscription;
        if (!$subscription || !$subscription->package) {
            return false;
        }
        $count = $countToCheck ?? $this->vendorFeatures()->count();
        return $this->checkLimit($count, $subscription->package->no_of_features);
    }

    public function canAddRule()
    {
        if (!$this->hasMenuAccess('extras')) {
            return false;
        }
        $subscription = $this->activeSubscription;
        if (!$subscription || !$subscription->package) {
            return false;
        }
        return $this->checkLimit($this->vendorRules()->count(), $subscription->package->no_of_rules);
    }

    public function canAddInvitation()
    {
        if (!$this->hasMenuAccess('customers')) {
            return false;
        }
        $subscription = $this->activeSubscription;
        if (!$subscription || !$subscription->package) {
            return false;
        }
        return $this->checkLimit($this->userInvitations()->count(), $subscription->package->no_of_invitations);
    }

    public function canAcceptSupportTickets()
    {
        if (!$this->hasMenuAccess('support_ticket')) {
            return false;
        }
        $subscription = $this->activeSubscription;
        if (!$subscription || !$subscription->package) {
            return false;
        }
        return $this->checkLimit($this->supportTickets()->count(), $subscription->package->no_of_support_tickets);
    }

    public function canAcceptBookings()
    {
        if (!$this->hasMenuAccess('booking')) {
            return false;
        }
        $subscription = $this->activeSubscription;
        if (!$subscription || !$subscription->package) {
            return false;
        }
        
        $count = \App\Models\Booking::where('vendor_id', $this->id)
            ->where('created_at', '>=', $subscription->starts_at)
            ->count();
            
        return $this->checkLimit($count, $subscription->package->no_of_bookings);
    }
}
