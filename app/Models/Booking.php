<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_number', 'vendor_id', 'user_id', 'vehicle_id', 'driver_id', 'assigned_at', 'assigned_by_vendor',
        'customer_fname', 'customer_lname', 'customer_email', 'customer_phone', 'customer_dob',
        'pickup_location_id', 'return_location_id', 'pickup_date', 'pickup_time', 'return_date', 'return_time',
        'total_amount', 'paid_amount', 'pending_amount',
        'payment_method', 'payment_reference', 'booking_status', 'payment_status',
        'license_number', 'license_issue_date', 'license_expiry_date', 'license_image', 'passport_image', 'pass_number', 'flight_number', 'checkin_status'
    ];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function assignedByVendor()
    {
        return $this->belongsTo(User::class, 'assigned_by_vendor');
    }

    public function pickupLocation()
    {
        return $this->belongsTo(PickupLocation::class, 'pickup_location_id');
    }

    public function returnLocation()
    {
        return $this->belongsTo(PickupLocation::class, 'return_location_id');
    }

    public function extras()
    {
        return $this->hasMany(BookingExtra::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'booking_id');
    }

    public function getFormattedPaymentMethodAttribute()
    {
        $method = $this->payment_method ?? 'Offline';
        if ($method !== 'Razorpay') {
            return ucfirst($method);
        }

        $paymentId = $this->payment_reference;
        if (empty($paymentId)) {
            return 'Razorpay';
        }

        if (strpos($paymentId, 'SIMULATED_') === 0) {
            return 'Razorpay (Simulated)';
        }

        return Cache::rememberForever("razorpay_booking_method_{$paymentId}", function () use ($paymentId, $method) {
            try {
                $settings = VendorPaymentSetting::where('vendor_id', $this->vendor_id)->first();
                $keyId = $settings ? $settings->razorpay_key : '';
                $keySecret = $settings ? $settings->razorpay_secret : '';

                if (empty($keyId) || empty($keySecret)) {
                    
                    $siteSettings = SiteSetting::first();
                    $keyId = $siteSettings ? $siteSettings->razorpay_key_id : '';
                    $keySecret = $siteSettings ? $siteSettings->razorpay_key_secret : '';
                }

                if (empty($keyId) || empty($keySecret)) {
                    return 'Razorpay';
                }

                $response = Http::timeout(5)
                    ->withBasicAuth($keyId, $keySecret)
                    ->get("https://api.razorpay.com/v1/payments/{$paymentId}");
                    
                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['method'])) {
                        return 'Razorpay (' . ucfirst($data['method']) . ')';
                    }
                }
            } catch (\Exception $e) {
                Log::error("Failed to fetch Razorpay method for booking payment {$paymentId}: " . $e->getMessage());
            }

            return 'Razorpay';
        });
    }

    public static function parseRobust($dateStr, $default = null)
    {
        if (empty($dateStr)) {
            return $default ?: \Carbon\Carbon::now();
        }
        foreach (['Y-m-d', 'd/m/Y', 'd-m-Y'] as $format) {
            try {
                return \Carbon\Carbon::createFromFormat($format, $dateStr)->startOfDay();
            } catch (\Exception $e) {}
        }
        try {
            return \Carbon\Carbon::parse($dateStr)->startOfDay();
        } catch (\Exception $e) {
            return $default ?: \Carbon\Carbon::now();
        }
    }

    public function getPickupDateParsedAttribute()
    {
        return self::parseRobust($this->pickup_date, \Carbon\Carbon::now());
    }

    public function getReturnDateParsedAttribute()
    {
        return self::parseRobust($this->return_date, \Carbon\Carbon::now()->addDays(2));
    }

    public function getCustomerDobParsedAttribute()
    {
        return self::parseRobust($this->customer_dob, \Carbon\Carbon::now()->subYears(20));
    }

    public function getIsCompletedOrEndedAttribute()
    {
        if (in_array(strtolower($this->booking_status), ['completed', 'finished'])) {
            return true;
        }
        try {
            $returnDt = $this->return_date_parsed->copy();
            if ($this->return_time) {
                $timeStr = date('H:i', strtotime($this->return_time));
                $parts = explode(':', $timeStr);
                $h = isset($parts[0]) ? (int)$parts[0] : 12;
                $m = isset($parts[1]) ? (int)$parts[1] : 0;
                $returnDt->setTime($h, $m);
            } else {
                $returnDt->endOfDay();
            }
            return \Carbon\Carbon::now()->greaterThanOrEqualTo($returnDt);
        } catch (\Exception $e) {
            return false;
        }
    }
}
