<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReponseDemandeClient extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // Contient nom prof, statut, matière...

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        
        
        $subject = $this->data['statut'] === 'validée' 
            ? "Demande acceptée par le professeur" 
            : "Mise à jour demande";

        return $this->subject($subject)
                    ->view('emails.reponse_client');
    }
}