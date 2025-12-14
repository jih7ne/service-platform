<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DemandeAccepteeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $demande;
    public $intervenant;
    public $client; // Nouvelle variable pour stocker le client récupéré manuellement

    /**
     * Constructeur modifié : on accepte $client ici
     */
    public function __construct($demande, $intervenant, $client)
    {
        $this->demande = $demande;
        $this->intervenant = $intervenant;
        $this->client = $client; // On le stocke pour l'utiliser dans la Vue
    }

    /**
     * Sujet de l'email.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bonne nouvelle ! Votre demande a été acceptée ✅',
        );
    }

    /**
     * Vue qui sera utilisée pour le contenu de l'email.
     */
    public function content(): Content
{
    return new Content(
        view: 'emails.demande_acceptee',
        with: [
            'demande' => $this->demande,
            'intervenant' => $this->intervenant,
            'client' => $this->client,
        ]
    );
}

}