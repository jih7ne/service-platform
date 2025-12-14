<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BabysitterRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nom;
    public $prenom;

    public function __construct($nom, $prenom)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
    }

    public function build()
    {
        return $this->subject('Votre candidature babysitter - Helpora')
                    ->view('emails.babysitter-registration')
                    ->with([
                        'nom' => $this->nom,
                        'prenom' => $this->prenom,
                    ]);
    }
}