<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Shared\DemandesIntervention;
use App\Mail\InterventionCompletedMail;
use App\Mail\InterventionCancelledMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendInterventionCompletionEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'intervention:send-completion-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoie automatiquement les emails de fin d\'intervention pour toutes les interventions terminées';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Vérification des interventions terminées pour envoi d\'emails...');
        
        $now = Carbon::now();
        
        // Récupérer toutes les demandes validées et annulées
        $demandesValidees = DemandesIntervention::where('statut', 'validée')
            ->with(['client'])
            ->get();
        $demandesAnnulees = DemandesIntervention::where('statut', 'annulée')
            ->with(['client'])
            ->get();

        $this->info("{$demandesValidees->count()} demandes validées trouvées");
        $this->info("{$demandesAnnulees->count()} demandes annulées trouvées");

        $emailsEnvoyes = 0;

        // Traitement des interventions terminées (emails de complétion)
        foreach ($demandesValidees as $demande) {
                    // Traitement des interventions annulées (emails d'annulation)
                    foreach ($demandesAnnulees as $demande) {
                        $emailAlreadySentKey = "intervention_cancelled_email_sent_{$demande->idDemande}";
                        $this->info("Cache check for key: {$emailAlreadySentKey} - Exists: " . (cache()->has($emailAlreadySentKey) ? 'YES' : 'NO'));
                        if (cache()->has($emailAlreadySentKey)) {
                            $this->info("Emails d'annulation déjà envoyés pour intervention #{$demande->idDemande} - SKIP");
                            continue;
                        }
                        $this->info("Envoi des emails d'annulation pour intervention #{$demande->idDemande}");
                        cache()->put($emailAlreadySentKey, true, now()->addDays(30));

                        // Envoyer l'email au client
                        if ($demande->client && $demande->client->email) {
                            try {
                                $intervenantUser = \App\Models\Shared\Utilisateur::where('idUser', $demande->idIntervenant)
                                    ->where('role', 'intervenant')
                                    ->first();
                                $intervenantName = $intervenantUser ?
                                    $intervenantUser->prenom . ' ' . $intervenantUser->nom :
                                    "l'intervenant";
                                $reason = $demande->raisonAnnulation ?? 'Non précisé';
                                Mail::to($demande->client->email)->send(new InterventionCancelledMail(
                                    $demande->client->prenom . ' ' . $demande->client->nom,
                                    $intervenantName,
                                    $demande->dateSouhaitee ? \Carbon\Carbon::parse($demande->dateSouhaitee)->format('d/m/Y') : 'N/A',
                                    'client',
                                    $reason
                                ));
                                $this->info("Email d'annulation client envoyé à " . $demande->client->email);
                                $emailsEnvoyes++;
                            } catch (\Exception $e) {
                                $this->error("Erreur envoi email d'annulation client: " . $e->getMessage());
                            }
                        }

                        // Envoyer l'email à l'intervenant
                        $intervenantUser = \App\Models\Shared\Utilisateur::where('idUser', $demande->idIntervenant)
                            ->where('role', 'intervenant')
                            ->first();
                        if ($intervenantUser && $intervenantUser->email) {
                            try {
                                $clientName = $demande->client ?
                                    ($demande->client->prenom . ' ' . $demande->client->nom) :
                                    'le client';
                                $reason = $demande->raisonAnnulation ?? 'Non précisé';
                                Mail::to($intervenantUser->email)->send(new InterventionCancelledMail(
                                    $intervenantUser->prenom . ' ' . $intervenantUser->nom,
                                    $clientName,
                                    $demande->dateSouhaitee ? \Carbon\Carbon::parse($demande->dateSouhaitee)->format('d/m/Y') : 'N/A',
                                    'intervenant',
                                    $reason
                                ));
                                $this->info("Email d'annulation intervenant envoyé à " . $intervenantUser->email);
                                $emailsEnvoyes++;
                            } catch (\Exception $e) {
                                $this->error("Erreur envoi email d'annulation intervenant: " . $e->getMessage());
                            }
                        }
                    }
            // Créer la date complète de fin d'intervention
            $dateFinIntervention = Carbon::parse($demande->heureFin);
            
            // Debug information
            $this->info("Intervention #{$demande->idDemande} - Fin: {$dateFinIntervention->toDateTimeString()} - Now: {$now->toDateTimeString()} - Is Past: " . ($now->greaterThan($dateFinIntervention) ? 'YES' : 'NO'));
            
            // Vérifier si l'intervention est terminée (date de fin dépassée)
            if ($now->greaterThan($dateFinIntervention)) {
                
                // Vérifier si les emails ont déjà été envoyés pour éviter les doublons
                $emailAlreadySentKey = "intervention_completed_email_sent_{$demande->idDemande}";
                $this->info("Cache check for key: {$emailAlreadySentKey} - Exists: " . (cache()->has($emailAlreadySentKey) ? 'YES' : 'NO'));
                if (cache()->has($emailAlreadySentKey)) {
                    $this->info("Emails déjà envoyés pour intervention #{$demande->idDemande} - SKIP");
                    continue; // Emails déjà envoyés pour cette intervention
                }
                
                $this->info("Envoi des emails pour intervention #{$demande->idDemande}");
                
                // Marquer que les emails ont été envoyés (valide 30 jours)
                cache()->put($emailAlreadySentKey, true, now()->addDays(30));
                
                // Envoyer l'email au client
                if ($demande->client && $demande->client->email) {
                    try {
                        $intervenantUser = \App\Models\Shared\Utilisateur::where('idUser', $demande->idIntervenant)
                            ->where('role', 'intervenant')
                            ->first();
                        
                        $intervenantName = $intervenantUser ? 
                            $intervenantUser->prenom . ' ' . $intervenantUser->nom : 
                            'l\'intervenant';
                        
                        Mail::to($demande->client->email)->send(new InterventionCompletedMail(
                            $demande->client->prenom . ' ' . $demande->client->nom,
                            $intervenantName,
                            Carbon::parse($demande->dateSouhaitee)->format('d/m/Y'),
                            $this->generateFeedbackUrl($demande, 'client'),
                            'client'
                        ));
                        
                        $this->info("Email client envoyé à " . $demande->client->email);
                        $emailsEnvoyes++;
                        
                    } catch (\Exception $e) {
                        $this->error("Erreur envoi email client: " . $e->getMessage());
                    }
                }
                
                // Envoyer l'email à l'intervenant
                $intervenantUser = \App\Models\Shared\Utilisateur::where('idUser', $demande->idIntervenant)
                    ->where('role', 'intervenant')
                    ->first();
                    
                if ($intervenantUser && $intervenantUser->email) {
                    try {
                        $clientName = $demande->client ? 
                            ($demande->client->prenom . ' ' . $demande->client->nom) : 
                            'le client';
                        
                        Mail::to($intervenantUser->email)->send(new InterventionCompletedMail(
                            $intervenantUser->prenom . ' ' . $intervenantUser->nom,
                            $clientName,
                            Carbon::parse($demande->dateSouhaitee)->format('d/m/Y'),
                            $this->generateFeedbackUrl($demande, 'intervenant'),
                            'intervenant'
                        ));
                        
                        $this->info("Email intervenant envoyé à " . $intervenantUser->email);
                        $emailsEnvoyes++;
                        
                    } catch (\Exception $e) {
                        $this->error("Erreur envoi email intervenant: " . $e->getMessage());
                    }
                }
            }
        }
        
        $this->info("Terminé. {$emailsEnvoyes} emails envoyés.");
        return 0;
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
                return route('feedback.pet-keeping', [
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
}