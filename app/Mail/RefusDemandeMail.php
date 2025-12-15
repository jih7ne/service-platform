<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RefusDemandeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $demande;
    public $intervenant;
    public $client;
    public $raison;

    public function __construct($demande, $intervenant, $client, $raison)
    {
        $this->demande = $demande;
        $this->intervenant = $intervenant;
        $this->client = $client;
        $this->raison = $raison;
    }

    public function build()
    {
        return $this->subject('Votre demande a été refusée')
            ->view('emails.demande-refusee');
    }
}
