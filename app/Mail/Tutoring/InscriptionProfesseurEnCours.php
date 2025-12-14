<?php

namespace App\Mail\Tutoring;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InscriptionProfesseurEnCours extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject("Demande d'inscription en cours de traitement - Helpora")
                    ->view('emails.tutoring.inscription_professeur_en_cours');
    }
}