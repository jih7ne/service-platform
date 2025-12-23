<?php

namespace App\Observers;

use App\Models\Shared\DemandesIntervention;
use App\Mail\InterventionCompletedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DemandeInterventionObserver
{
    /**
     * Handle the DemandeIntervention "updated" event.
     */
    public function updated(DemandesIntervention $demande): void
    {
        // Vérifier si l'intervention est maintenant terminée (dateSouhaitee + heureFin dépassées)
        // et si elle était validée (pour éviter les emails pour les demandes annulées)
        if ($demande->wasChanged('statut') && $demande->statut === 'validée') {
            $this->checkInterventionCompletion($demande);
        }
    }

    /**
     * Handle the DemandeIntervention "saved" event.
     */
    public function saved(DemandesIntervention $demande): void
    {
        // Vérifier également à chaque sauvegarde si une intervention validée est maintenant terminée
        if ($demande->statut === 'validée') {
            $this->checkInterventionCompletion($demande);
        }
    }

    /**
     * Vérifie si l'intervention est terminée et envoie les emails si nécessaire
     */
    private function checkInterventionCompletion(DemandesIntervention $demande): void
    {
        // Créer la date complète de fin d'intervention
        $dateFinIntervention = Carbon::parse($demande->dateSouhaitee . ' ' . $demande->heureFin);
        $maintenant = Carbon::now();

        Log::info("Vérification intervention #{$demande->idDemande}", [
            'date_fin' => $dateFinIntervention->format('Y-m-d H:i:s'),
            'maintenant' => $maintenant->format('Y-m-d H:i:s'),
            'statut' => $demande->statut
        ]);

        // Vérifier si l'intervention est terminée (date de fin dépassée)
        if ($maintenant->greaterThan($dateFinIntervention)) {
            
            Log::info("Intervention #{$demande->idDemande} est terminée, vérification envoi email");
            
            // Vérifier si les emails ont déjà été envoyés pour éviter les doublons
            $emailAlreadySentKey = "intervention_completed_email_sent_{$demande->idDemande}";
            if (cache()->has($emailAlreadySentKey)) {
                Log::info("Emails déjà envoyés pour intervention #{$demande->idDemande}");
                return; // Emails déjà envoyés pour cette intervention
            }

            // Marquer que les emails ont été envoyés (valide 30 jours)
            cache()->put($emailAlreadySentKey, true, now()->addDays(30));

            Log::info("Envoi des emails pour intervention #{$demande->idDemande}");

            // Envoyer l'email au client
            if ($demande->client && $demande->client->email) {
                try {
                    Log::info("Tentative envoi email client: " . $demande->client->email);
                    
                    Mail::to($demande->client->email)->send(new InterventionCompletedMail(
                        $demande->client->prenom . ' ' . $demande->client->nom,
                        $this->getIntervenantName($demande),
                        Carbon::parse($demande->dateSouhaitee)->format('d/m/Y'),
                        $this->generateFeedbackUrl($demande, 'client'),
                        'client'
                    ));
                    
                    Log::info("Email client envoyé avec succès pour intervention #{$demande->idDemande}");
                } catch (\Exception $e) {
                    Log::error("Erreur envoi email client intervention #{$demande->idDemande}: " . $e->getMessage());
                }
            } else {
                Log::warning("Aucun client ou email trouvé pour intervention #{$demande->idDemande}");
            }

            // Envoyer l'email à l'intervenant
            $intervenantUser = \App\Models\Shared\Utilisateur::where('idUser', $demande->idIntervenant)
                ->where('role', 'intervenant')
                ->first();
                
            if ($intervenantUser && $intervenantUser->email) {
                try {
                    Log::info("Tentative envoi email intervenant: " . $intervenantUser->email);
                    
                    Mail::to($intervenantUser->email)->send(new InterventionCompletedMail(
                        $intervenantUser->prenom . ' ' . $intervenantUser->nom,
                        $this->getClientName($demande),
                        Carbon::parse($demande->dateSouhaitee)->format('d/m/Y'),
                        $this->generateFeedbackUrl($demande, 'intervenant'),
                        'intervenant'
                    ));
                    
                    Log::info("Email intervenant envoyé avec succès pour intervention #{$demande->idDemande}");
                } catch (\Exception $e) {
                    Log::error("Erreur envoi email intervenant intervention #{$demande->idDemande}: " . $e->getMessage());
                }
            } else {
                Log::warning("Aucun intervenant ou email trouvé pour intervention #{$demande->idDemande}");
            }
        } else {
            Log::info("Intervention #{$demande->idDemande} pas encore terminée");
        }
    }

    /**
     * Générer l'URL de feedback selon le type d'utilisateur
     */
    private function generateFeedbackUrl(DemandesIntervention $demande, string $userType): string
    {
        $auteurId = $userType === 'client' ? $demande->idClient : $demande->idIntervenant;
        $cibleId = $userType === 'client' ? $demande->idIntervenant : $demande->idClient;
        
        // Route selon le type de service
        switch ($demande->idService) {
            case 1: // Babysitting
                return route('feedback.babysitter', [
                    'idService' => $demande->idService,
                    'demandeId' => $demande->idDemande,
                    'auteurId' => $auteurId,
                    'cibleId' => $cibleId,
                    'typeAuteur' => $userType
                ]);
            case 2: // Soutien scolaire
                return route('feedback.tutoring', [
                    'idService' => $demande->idService,
                    'demandeId' => $demande->idDemande,
                    'auteurId' => $auteurId,
                    'cibleId' => $cibleId,
                    'typeAuteur' => $userType
                ]);
            case 3: // Pet keeping
                return route('feedback.petkeeping', [
                    'idService' => $demande->idService,
                    'demandeId' => $demande->idDemande,
                    'auteurId' => $auteurId,
                    'cibleId' => $cibleId,
                    'typeAuteur' => $userType
                ]);
            default:
                return route('dashboard');
        }
    }

    /**
     * Récupérer le nom de l'intervenant
     */
    private function getIntervenantName(DemandesIntervention $demande): string
    {
        $intervenantUser = \App\Models\Shared\Utilisateur::where('idUser', $demande->idIntervenant)
            ->where('role', 'intervenant')
            ->first();
            
        if ($intervenantUser) {
            return $intervenantUser->prenom . ' ' . $intervenantUser->nom;
        }
        return 'l\'intervenant';
    }

    /**
     * Récupérer le nom du client
     */
    private function getClientName(DemandesIntervention $demande): string
    {
        if ($demande->client) {
            return $demande->client->prenom . ' ' . $demande->client->nom;
        }
        return 'le client';
    }
}