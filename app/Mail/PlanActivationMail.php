<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\VendorSubscription;
use App\Models\SiteSetting;
use Barryvdh\DomPDF\Facade\Pdf;

class PlanActivationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subscription;

    /**
     * Create a new message instance.
     */
    public function __construct(VendorSubscription $subscription)
    {
        $this->subscription = $subscription->loadMissing(['vendor', 'package']);
    }

    /**
     * Build the message.
     */
    public function build()
    {
        try {
            SiteSetting::setMailConfig();
            $site_setting = SiteSetting::first();

            if (class_exists('Barryvdh\DomPDF\Facade\Pdf')) {
                $pdf = Pdf::loadView('emails.subscription-invoice-pdf', [
                    'subscription' => $this->subscription,
                    'site_setting' => $site_setting
                ]);
                $pdfContent = $pdf->output();
                $pdfFilename = 'Invoice_#INV-' . $this->subscription->created_at->format('Y') . '-' . str_pad($this->subscription->id, 4, '0', STR_PAD_LEFT) . '.pdf';

                return $this->subject('Subscription Plan Activated & Invoice - Rydaris')
                            ->view('emails.plan-activation')
                            ->with([
                                'subscription' => $this->subscription,
                                'site_setting' => $site_setting
                            ])
                            ->attachData($pdfContent, $pdfFilename, [
                                'mime' => 'application/pdf',
                            ]);
            }
        } catch (\Throwable $e) {
            Log::error("Failed to generate and attach invoice PDF to subscription email: " . $e->getMessage());
        }

        // Fallback: Send email without PDF attachment if PDF generation fails or package not installed
        return $this->subject('Subscription Plan Activated & Invoice - Rydaris')
                    ->view('emails.plan-activation')
                    ->with([
                        'subscription' => $this->subscription,
                        'site_setting' => SiteSetting::first()
                    ]);
    }
}
