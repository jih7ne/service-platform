<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Shared\Reclamation;

class ReclamationResponse extends Mailable
{
    use Queueable, SerializesModels;

    public $reclamation;
    public $reponseTexte;

    /**
     * Create a new message instance.
     */
    public function __construct(Reclamation $reclamation, string $reponseTexte)
    {
        $this->reclamation = $reclamation;
        $this->reponseTexte = $reponseTexte;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Réponse à votre réclamation - ' . $this->reclamation->sujet,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.reclamation_response',
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