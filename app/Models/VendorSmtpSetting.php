<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorSmtpSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'smtp_host',
        'smtp_port',
        'smtp_username',
        'smtp_password',
        'smtp_encryption',
        'from_email',
        'from_name',
    ];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public static function setMailConfig($vendor_id)
    {
        $smtpSetting = self::where('vendor_id', $vendor_id)->first();
        if ($smtpSetting && $smtpSetting->smtp_host) {
            \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.host', $smtpSetting->smtp_host);
            \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.port', $smtpSetting->smtp_port);
            \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.encryption', $smtpSetting->smtp_encryption);
            \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.username', $smtpSetting->smtp_username);
            \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.password', $smtpSetting->smtp_password);
            \Illuminate\Support\Facades\Config::set('mail.from.address', $smtpSetting->from_email ?? $smtpSetting->smtp_username);
            \Illuminate\Support\Facades\Config::set('mail.from.name', $smtpSetting->from_name ?? 'Rydaris Vendor');
            
            
            \Illuminate\Support\Facades\Mail::purge('smtp');
            
            return true;
        }
        return false;
    }
}
