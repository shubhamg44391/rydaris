<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

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
            Config::set('mail.mailers.smtp.host', $smtpSetting->smtp_host);
            Config::set('mail.mailers.smtp.port', $smtpSetting->smtp_port);
            Config::set('mail.mailers.smtp.encryption', $smtpSetting->smtp_encryption);
            Config::set('mail.mailers.smtp.username', $smtpSetting->smtp_username);
            Config::set('mail.mailers.smtp.password', $smtpSetting->smtp_password);
            Config::set('mail.from.address', $smtpSetting->from_email ?? $smtpSetting->smtp_username);
            Config::set('mail.from.name', $smtpSetting->from_name ?? 'Rydaris Vendor');
            
            
            Mail::purge('smtp');
            
            return true;
        }
        return false;
    }
}
