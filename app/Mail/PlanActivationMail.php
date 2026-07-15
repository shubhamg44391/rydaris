<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\VendorSubscription;
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
        $this->subscription = $subscription;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        try {
            $pdf = Pdf::loadView('emails.subscription-invoice-pdf', ['subscription' => $this->subscription]);
            $pdfContent = $pdf->output();
            $pdfFilename = 'Invoice_#INV-' . $this->subscription->created_at->format('Y') . '-' . str_pad($this->subscription->id, 4, '0', STR_PAD_LEFT) . '.pdf';

            return $this->subject('Subscription Plan Activated - Rydaris')
                        ->view('emails.plan-activation')
                        ->attachData($pdfContent, $pdfFilename, [
                            'mime' => 'application/pdf',
                        ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to generate and attach invoice PDF to subscription email: " . $e->getMessage());

            // Fallback: Send email without attachment if PDF generation fails
            return $this->subject('Subscription Plan Activated - Rydaris')
                        ->view('emails.plan-activation');
        }
    }
}
