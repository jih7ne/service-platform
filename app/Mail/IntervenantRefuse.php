<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IntervenantRefuse extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $reason;
    public $typeService;

    public function __construct($user, $reason, $typeService)
    {
        $this->user = $user;
        $this->reason = $reason;
        $this->typeService = $typeService;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Réponse à votre candidature - Helpora',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.intervenant-refuse',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
