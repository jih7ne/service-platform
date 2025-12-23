<?php

namespace App\Mail\Babysitting;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Babysitting\DemandeIntervention;

class BookingAutoCancelled extends Mailable
{
    use Queueable, SerializesModels;

    public $demande;
    public $clientName;
    public $dateDemande;
    public $dateSouhaitee;

    /**
     * Create a new message instance.
     */
    public function __construct(DemandeIntervention $demande)
    {
        $this->demande = $demande;
        $this->clientName = $demande->client->prenom . ' ' . $demande->client->nom;
        $this->dateDemande = $demande->dateDemande ? $demande->dateDemande->format('d/m/Y H:i') : 'N/A';
        $this->dateSouhaitee = $demande->dateSouhaitee ? $demande->dateSouhaitee->format('d/m/Y') : 'N/A';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Annulation automatique de votre réservation - Délai dépassé',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.babysitting.booking_auto_cancelled',
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
