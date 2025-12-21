<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InterventionCompletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $targetName;
    public $dateIntervention;
    public $feedbackUrl;
    public $userType;

    /**
     * Create a new message instance.
     */
    public function __construct($userName, $targetName, $dateIntervention, $feedbackUrl, $userType)
    {
        $this->userName = $userName;
        $this->targetName = $targetName;
        $this->dateIntervention = $dateIntervention;
        $this->feedbackUrl = $feedbackUrl;
        $this->userType = $userType;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre intervention Helpora est terminée - Partagez votre expérience !',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.intervention_completed',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
