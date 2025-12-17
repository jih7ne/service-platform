<?php

namespace App\Mail\Babysitter;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DemandeAcceptedForClient extends Mailable
{
    use Queueable, SerializesModels;

    public $demande;

    public function __construct($demande)
    {
        $this->demande = $demande;
    }

    public function build()
    {
        return $this->subject('Votre demande de garde a été acceptée !')
                    ->view('emails.babysitter.demande-accepted-client');
    }
}
