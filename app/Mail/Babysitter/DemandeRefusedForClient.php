<?php

namespace App\Mail\Babysitter;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DemandeRefusedForClient extends Mailable
{
    use Queueable, SerializesModels;

    public $demande;
    public $motif;

    public function __construct($demande, $motif)
    {
        $this->demande = $demande;
        $this->motif = $motif;
    }

    public function build()
    {
        return $this->subject('Mise à jour concernant votre demande de garde')
                    ->view('emails.babysitter.demande-refused-client');
    }
}
