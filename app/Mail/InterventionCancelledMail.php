<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InterventionCancelledMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $targetName;
    public $dateIntervention;
    public $userType;
    public $reason;

    public function __construct($userName, $targetName, $dateIntervention, $userType, $reason)
    {
        $this->userName = $userName;
        $this->targetName = $targetName;
        $this->dateIntervention = $dateIntervention;
        $this->userType = $userType;
        $this->reason = $reason;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Votre intervention Helpora a été annulée",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.intervention_cancelled',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
