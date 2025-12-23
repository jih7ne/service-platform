<?php

namespace App\Mail\Babysitter;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BabysitterNewRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $demandes;

    /**
     * Create a new message instance.
     *
     * @param mixed $demandes Collection or array of DemandeIntervention
     */
    public function __construct($demandes)
    {
        $this->demandes = $demandes;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle demande de service Babysitting',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.babysitter.babysitter_new_request',
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
