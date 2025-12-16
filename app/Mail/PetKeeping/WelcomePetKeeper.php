<?php

namespace App\Mail\PetKeeping;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomePetKeeper extends Mailable
{
    use Queueable, SerializesModels;

    public string $keeper_email;
    public string $keeper_fname;
    public string $keeper_lname;

    /**
     * Create a new message instance.
     */
    public function __construct(
        string $keeper_email,
        string $keeper_fname,
        string $keeper_lname,
    )
    {
        $this->keeper_email       = $keeper_email;
        $this->keeper_fname       = $keeper_fname;
        $this->keeper_lname       = $keeper_lname;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            to: [$this->keeper_email],
            subject: 'Welcome Pet Keeper',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.pet-keeping.pet-keeper-welcome',
            with: [
                'firstName'        => $this->keeper_fname,
                'lastName'         => $this->keeper_lname,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
