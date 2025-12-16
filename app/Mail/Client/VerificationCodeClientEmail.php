<?php

namespace App\Mail\Client;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationCodeClientEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $verificationCode;
    public $firstName;
    public $lastName;

    /**
     * Create a new message instance.
     */
    public function __construct($verificationCode, $firstName, $lastName)
    {
        $this->verificationCode = $verificationCode;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Code de vérification - Helpora',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.client.verification-code',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}