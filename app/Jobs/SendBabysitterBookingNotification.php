<?php

namespace App\Jobs;

use App\Models\Babysitting\DemandeIntervention;
use App\Models\Shared\Utilisateur;
use App\Models\Babysitting\Babysitter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendBabysitterBookingNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $demande;

    public function __construct(DemandeIntervention $demande)
    {
        $this->demande = $demande;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $client = Utilisateur::find($this->demande->idClient);
            $babysitter = Babysitter::with('intervenant.utilisateur')->find($this->demande->idIntervenant);
            
            if (!$babysitter || !$babysitter->intervenant || !$babysitter->intervenant->utilisateur) {
                Log::error('Babysitter ou intervenant non trouvé pour la réservation', [
                    'idDemande' => $this->demande->idDemande,
                    'idIntervenant' => $this->demande->idIntervenant
                ]);
                return;
            }

            $babysitterUser = $babysitter->intervenant->utilisateur;
            
            // Envoyer l'email au babysitter
            Mail::raw(
                "Bonjour {$babysitterUser->nom} {$babysitterUser->prenom},\n\n" .
                "Vous avez reçu une nouvelle réservation !\n\n" .
                "Détails de la réservation:\n" .
                "Client: {$client->nom} {$client->prenom}\n" .
                "Date: {$this->demande->dateSouhaitee}\n" .
                "Heure: {$this->demande->heureDebut} - {$this->demande->heureFin}\n" .
                "Nombre d'enfants: " . ($this->demande->nombreEnfants ?? 'Non spécifié') . "\n" .
                "Message: " . ($this->demande->message ?: 'Aucun message') . "\n\n" .
                "Veuillez vous connecter à votre espace pour accepter ou refuser cette réservation.\n\n" .
                "Cordialement,\nL'équipe Helpora\n\n" .
                "© " . date('Y') . " Helpora - Service de garde d'enfants de confiance",
                function ($message) use ($babysitterUser) {
                    $message->to('moenissdouae@etu.uae.ac.ma') // Email de test
                        ->subject('Nouvelle réservation - Helpora')
                        ->from('noreply@helpora.com', 'Helpora');
                }
            );

            Log::info('Email de notification de réservation envoyé au babysitter', [
                'idDemande' => $this->demande->idDemande,
                'babysitter_email' => $babysitterUser->email,
                'client_nom' => $client->nom . ' ' . $client->prenom
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi de l\'email de notification de réservation', [
                'idDemande' => $this->demande->idDemande,
                'error' => $e->getMessage()
            ]);
        }
    }
}
