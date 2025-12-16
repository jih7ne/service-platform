<?php

namespace App\Mail\PetKeeping;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminAccountAlerte extends Mailable
{
    use Queueable, SerializesModels;

    public string $keeper_email;
    public string $keeper_fname;
    public string $keeper_lname;
    public array $admin_emails;
    public array $pet_keeper_data;

    /**
     * Create a new message instance.
     */
    public function __construct(
        string $keeper_email,
        string $keeper_fname,
        string $keeper_lname,
        array $admin_emails,
        array $pet_keeper_data
    ) {
        $this->keeper_email     = $keeper_email;
        $this->keeper_fname     = $keeper_fname;
        $this->keeper_lname     = $keeper_lname;
        $this->admin_emails     = $admin_emails;
        $this->pet_keeper_data  = $pet_keeper_data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            to: $this->admin_emails,
            subject: 'PetKeeper Account Creation Alert',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.pet-keeping.pet-keeper-admin-account-alerte',
            with: [
                'firstName'        => $this->keeper_fname,
                'lastName'         => $this->keeper_lname,
                'email'            => $this->keeper_email,
                'pet_keeper_data'  => $this->pet_keeper_data,
            ],
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
