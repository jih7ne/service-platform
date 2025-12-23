<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Shared\Utilisateur;

class FeedbackReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $targetName;
    public $dateIntervention;
    public $feedbackUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($userName, $targetName, $dateIntervention, $feedbackUrl)
    {
        $this->userName = $userName;
        $this->targetName = $targetName;
        $this->dateIntervention = $dateIntervention;
        $this->feedbackUrl = $feedbackUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Rappel : Votre avis sur votre intervention Helpora',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.feedback_reminder',
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
