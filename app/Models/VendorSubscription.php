<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'package_id',
        'starts_at',
        'ends_at',
        'status',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'amount_paid',
        'street_address',
        'landmark',
        'pincode',
        'city',
        'country',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(function ($subscription) {
            if ($subscription->status === 'active') {
                try {
                    // Set SMTP settings dynamically
                    \App\Models\SiteSetting::setMailConfig();

                    $vendor = $subscription->vendor;
                    if ($vendor && $vendor->email) {
                        \Illuminate\Support\Facades\Mail::to($vendor->email)
                            ->send(new \App\Mail\PlanActivationMail($subscription));
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Failed to send subscription activation email to vendor: " . $e->getMessage());
                }
            }
        });
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function isValid()
    {
        return $this->status === 'active' && 
               $this->starts_at <= now() && 
               $this->ends_at >= now();
    }

    public function getPaymentMethodAttribute()
    {
        $paymentId = $this->razorpay_payment_id;
        if (empty($paymentId)) {
            return 'Free / Trial';
        }
        if (strpos($paymentId, 'SIMULATED_') === 0) {
            return 'Simulated / Free';
        }
        
        return \Illuminate\Support\Facades\Cache::rememberForever("razorpay_method_{$paymentId}", function () use ($paymentId) {
            try {
                $settings = \App\Models\SiteSetting::first();
                $keyId = $settings ? $settings->razorpay_key_id : '';
                $keySecret = $settings ? $settings->razorpay_key_secret : '';
                
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
                \Illuminate\Support\Facades\Log::error("Failed to fetch Razorpay method for subscription payment {$paymentId}: " . $e->getMessage());
            }
            return 'Razorpay';
        });
    }
}
