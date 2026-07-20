<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_number', 'vendor_id', 'user_id', 'vehicle_id',
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
        return $this->hasOne(Review::class);
    }

    public function getPaymentMethodLabelAttribute()
    {
        $paymentId = $this->payment_reference;
        $method = $this->payment_method; 

        if (empty($paymentId)) {
            return $method === 'arrival' ? 'Pay on Arrival' : 'N/A';
        }

        if (strpos($paymentId, 'SIMULATED_') === 0) {
            return 'Razorpay (Simulated)';
        }

        return \Illuminate\Support\Facades\Cache::rememberForever("razorpay_booking_method_{$paymentId}", function () use ($paymentId, $method) {
            try {
                $settings = \App\Models\VendorPaymentSetting::where('vendor_id', $this->vendor_id)->first();
                $keyId = $settings ? $settings->razorpay_key : '';
                $keySecret = $settings ? $settings->razorpay_secret : '';

                if (empty($keyId) || empty($keySecret)) {
                    
                    $siteSettings = \App\Models\SiteSetting::first();
                    $keyId = $siteSettings ? $siteSettings->razorpay_key_id : '';
                    $keySecret = $siteSettings ? $siteSettings->razorpay_key_secret : '';
                }

                if (empty($keyId) || empty($keySecret)) {
                    return 'Razorpay';
                }

                $response = \Illuminate\Support\Facades\Http::timeout(5)
                    ->withBasicAuth($keyId, $keySecret)
                    ->get("https://api.razorpay.com/v1/payments/{$paymentId}");
                    
                if ($response->successful()) {
                    $data = $response->json();
                    return isset($data['method']) ? strtoupper($data['method']) : 'Razorpay';
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Failed to fetch Razorpay method for booking {$paymentId}: " . $e->getMessage());
            }
            return 'Razorpay (' . ucfirst($method) . ')';
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
