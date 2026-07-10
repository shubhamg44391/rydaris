<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\UserInvitation;

class InviteUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invitation;
    public $registrationUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(UserInvitation $invitation)
    {
        $this->invitation = $invitation;
        $this->registrationUrl = route('vendor.register') . '?invite_token=' . $invitation->token;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $vendor = $this->invitation->vendor;
        $vendorName = $vendor->company_name ?? $vendor->name;
        
        $email = $this->subject('Invitation from ' . $vendorName)
                      ->view('emails.invite-user');

        $smtpSetting = \App\Models\VendorSmtpSetting::where('vendor_id', $this->invitation->vendor_id)->first();
        if ($smtpSetting && $smtpSetting->from_email) {
            $email->from($smtpSetting->from_email, $smtpSetting->from_name ?? $vendorName);
        } else {
            $email->from(config('mail.from.address'), $vendorName);
        }

        return $email;
    }
}
