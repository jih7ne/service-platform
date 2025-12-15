<?php

namespace App\Mail\Tutoring;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationCodeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $prenom;

    public function __construct($code, $prenom)
    {
        $this->code = $code;
        $this->prenom = $prenom;
    }

    public function build()
    {
        return $this->subject(" Code de vérification Helpora")
                    ->view('emails.tutoring.verification_code');
    }
}