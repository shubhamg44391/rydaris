<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

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
        'contact_email',
        'sales_email',
        'contact_phone',
        'site_logo',
        'site_logo_light',
        'favicon',
    ];

    protected $casts = [
        'razorpay_active' => 'boolean',
    ];

    public static function setMailConfig()
    {
        $setting = self::first();
        if ($setting && $setting->smtp_host) {
            Config::set('mail.mailers.smtp.host', $setting->smtp_host);
            Config::set('mail.mailers.smtp.port', $setting->smtp_port);
            Config::set('mail.mailers.smtp.encryption', $setting->smtp_encryption);
            Config::set('mail.mailers.smtp.username', $setting->smtp_username);
            Config::set('mail.mailers.smtp.password', $setting->smtp_password);
            Config::set('mail.from.address', $setting->from_email ?? $setting->smtp_username);
            Config::set('mail.from.name', $setting->from_name ?? 'Rydaris');
            
            
            Mail::purge('smtp');
            
            return true;
        }
        return false;
    }
}
