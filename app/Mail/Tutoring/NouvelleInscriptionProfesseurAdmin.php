<?php

namespace App\Mail\Tutoring;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NouvelleInscriptionProfesseurAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject("🔔 Nouvelle demande d'inscription professeur - Action requise")
                    ->view('emails.tutoring.nouvelle_inscription_professeur_admin');
    }
}