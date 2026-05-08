<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $adminEmail;

    public function __construct(Invoice $invoice, $adminEmail)
    {
        $this->invoice = $invoice;
        $this->adminEmail = $adminEmail;
    }

    public function build()
    {
        return $this->subject('📄 New Invoice Created: ' . $this->invoice->invoice_number)
                    ->to($this->adminEmail)
                    ->view('admin.pages.emails.invoice-created');
    }
}