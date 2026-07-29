<?php

namespace App\Mail;

use App\Models\Certificate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $certificate;

    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'E-Sertifikat: ' . $this->certificate->transaction->event->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.certificate',
            with: ['certificate' => $this->certificate],
        );
    }

    public function attachments(): array
{
    return [];
}
}