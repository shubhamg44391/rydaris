<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'razorpay_key_id',
        'razorpay_key_secret',
        'razorpay_active',
        'tax_percentage',
        'smtp_host',
        'smtp_port',
        'smtp_username',
        'smtp_password',
        'smtp_encryption',
        'from_email',
        'from_name',
    ];

    protected $casts = [
        'razorpay_active' => 'boolean',
    ];

    public static function setMailConfig()
    {
        $setting = self::first();
        if ($setting && $setting->smtp_host) {
            \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.host', $setting->smtp_host);
            \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.port', $setting->smtp_port);
            \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.encryption', $setting->smtp_encryption);
            \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.username', $setting->smtp_username);
            \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.password', $setting->smtp_password);
            \Illuminate\Support\Facades\Config::set('mail.from.address', $setting->from_email ?? $setting->smtp_username);
            \Illuminate\Support\Facades\Config::set('mail.from.name', $setting->from_name ?? 'Rydaris');
            
            
            \Illuminate\Support\Facades\Mail::purge('smtp');
            
            return true;
        }
        return false;
    }
}
