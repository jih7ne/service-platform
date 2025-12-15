<?php

namespace App\Mail\Tutoring;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubmitBooking extends Mailable
{
    use Queueable, SerializesModels;

    public $professeur;
    public $client;
    public $service;
    public $demandes;
    public $selectedDate;
    public $typeService;
    public $ville;
    public $adresse;
    public $noteSpeciales;
    public $montantTotal;
    public $nombreHeures;

    /**
     * Create a new message instance.
     */
    public function __construct(
        $professeur,
        $client,
        $service,
        $demandes,
        $selectedDate,
        $typeService,
        $ville,
        $adresse,
        $noteSpeciales,
        $montantTotal,
        $nombreHeures
    ) {
        $this->professeur = $professeur;
        $this->client = $client;
        $this->service = $service;
        $this->demandes = $demandes;
        $this->selectedDate = $selectedDate;
        $this->typeService = $typeService;
        $this->ville = $ville;
        $this->adresse = $adresse;
        $this->noteSpeciales = $noteSpeciales;
        $this->montantTotal = $montantTotal;
        $this->nombreHeures = $nombreHeures;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle demande de réservation - ' . $this->service->matiere->nom_matiere,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.tutoring.submit_booking',
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