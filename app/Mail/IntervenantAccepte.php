<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IntervenantAccepte extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $typeService;

    public function __construct($user, $typeService)
    {
        $this->user = $user;
        $this->typeService = $typeService;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre candidature a été acceptée - Helpora',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.intervenant-accepte',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
