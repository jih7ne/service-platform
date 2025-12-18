<?php

namespace App\Jobs;

use App\Models\Shared\FeedbackRappel;
use App\Models\DemandeIntervention;
use App\Models\Shared\Utilisateur;
use App\Models\Shared\Intervenant;
use App\Models\Shared\Feedback;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendFeedbackReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Début du job de rappel de feedback');
        
        // Récupérer les demandes terminées (statut validée)
        $demandesTerminees = DemandeIntervention::where('statut', 'validée')
            ->whereNotNull('idIntervenant')
            ->get();

        Log::info('Demandes trouvées', ['count' => $demandesTerminees->count()]);

        foreach ($demandesTerminees as $demande) {
            // Vérifier si l'intervention est terminée
            if ($this->isInterventionTerminee($demande)) {
                $this->processDemandeForReminders($demande);
            }
        }
        
        Log::info('Fin du job de rappel de feedback');
    }

    private function isInterventionTerminee(DemandeIntervention $demande): bool
    {
        if (!$demande->dateSouhaitee || !$demande->heureFin) {
            return false;
        }

        // Extraire seulement la partie date de dateSouhaitee si elle contient déjà un timestamp
        $dateOnly = explode(' ', $demande->dateSouhaitee)[0];
        $finIntervention = Carbon::parse($dateOnly . ' ' . $demande->heureFin);
        return Carbon::now()->greaterThan($finIntervention);
    }

    private function processDemandeForReminders(DemandeIntervention $demande)
    {
        // Vérifier si des feedbacks existent déjà pour cette demande
        $clientFeedbackExists = Feedback::where('idDemande', $demande->idDemande)
            ->where('idAuteur', $demande->idClient)
            ->where('typeAuteur', 'client')
            ->exists();

        $intervenantFeedbackExists = Feedback::where('idDemande', $demande->idDemande)
            ->where('idAuteur', $demande->idIntervenant)
            ->where('typeAuteur', 'intervenant')
            ->exists();

        // Marquer les rappels comme terminés si des feedbacks existent
        if ($clientFeedbackExists) {
            $this->markRappelsAsCompleted($demande, 'client');
        }

        if ($intervenantFeedbackExists) {
            $this->markRappelsAsCompleted($demande, 'intervenant');
        }

        // Traiter le rappel pour le client seulement si pas de feedback
        if (!$clientFeedbackExists) {
            $this->sendReminderToUser($demande, 'client');
        }

        // Traiter le rappel pour l'intervenant seulement si pas de feedback
        if (!$intervenantFeedbackExists) {
            $this->sendReminderToUser($demande, 'intervenant');
        }
    }

    private function markRappelsAsCompleted(DemandeIntervention $demande, string $userType)
    {
        FeedbackRappel::where('idDemande', $demande->idDemande)
            ->where('type_destinataire', $userType)
            ->where('feedback_fourni', false)
            ->update(['feedback_fourni' => true]);

        Log::info('Rappels marqués comme terminés', [
            'idDemande' => $demande->idDemande,
            'userType' => $userType
        ]);
    }

    private function sendReminderToUser(DemandeIntervention $demande, string $userType)
    {
        // Calculer la date de fin de l'intervention
        $dateOnly = explode(' ', $demande->dateSouhaitee)[0];
        $finIntervention = Carbon::parse($dateOnly . ' ' . $demande->heureFin);
        $joursDepuisFin = Carbon::now()->diffInDays($finIntervention, false);
        
        // Vérifier si un rappel existe déjà
        $existingRappel = FeedbackRappel::where('idDemande', $demande->idDemande)
            ->where('type_destinataire', $userType)
            ->where('feedback_fourni', false)
            ->first();

        if ($existingRappel) {
            // Vérifier si on doit envoyer le 2ème rappel (jour 3)
            if ($existingRappel->rappel_number == 1 && $joursDepuisFin >= 3) {
                $this->sendSecondReminder($demande, $userType, $existingRappel);
            }
        } else {
            // Envoyer le premier rappel (jour 1)
            if ($joursDepuisFin >= 1) {
                $this->createFirstReminder($demande, $userType);
            }
        }
    }

    private function createFirstReminder(DemandeIntervention $demande, string $userType)
    {
        $rappel = FeedbackRappel::create([
            'idDemande' => $demande->idDemande,
            'idClient' => $demande->idClient,
            'idIntervenant' => $demande->idIntervenant,
            'type_destinataire' => $userType,
            'rappel_number' => 1,
            'date_envoi' => now(),
            'prochain_rappel' => null,
            'feedback_fourni' => false,
        ]);

        $this->sendReminderEmail($demande, $userType, $rappel);
    }

    private function sendSecondReminder(DemandeIntervention $demande, string $userType, FeedbackRappel $rappel)
    {
        // Envoyer le deuxième rappel (jour 6)
        $this->sendReminderEmail($demande, $userType, $rappel);

        // Mettre à jour le rappel
        $rappel->update([
            'rappel_number' => 2,
            'date_envoi' => now(),
            'prochain_rappel' => null,
        ]);
    }

    private function sendReminderEmail(DemandeIntervention $demande, string $userType, FeedbackRappel $rappel)
    {
        try {
            $userId = $userType === 'client' ? $demande->idClient : $demande->idIntervenant;
            
            $user = Utilisateur::find($userId);

            if (!$user) {
                Log::error('Utilisateur non trouvé pour le rappel', [
                    'userId' => $userId,
                    'userType' => $userType
                ]);
                return;
            }

            if (!$user->email) {
                Log::warning('Utilisateur sans email', [
                    'userId' => $userId,
                    'userType' => $userType
                ]);
                return;
            }

            $emailData = [
                'user' => $user,
                'demande' => $demande,
                'rappel_number' => $rappel->rappel_number,
                'userType' => $userType,
                'feedback_url' => url('/feedback/' . $demande->idDemande)
            ];

            $emailView = $userType === 'client' 
                ? 'emails.feedback.client-reminder' 
                : 'emails.feedback.intervenant-reminder';

            Mail::send($emailView, $emailData, function ($message) use ($user, $demande) {
                $message->to($user->email)
                    ->subject('Rappel : Donnez votre feedback sur l\'intervention #' . $demande->idDemande);
            });

            Log::info('Email de rappel envoyé', [
                'idDemande' => $demande->idDemande,
                'userType' => $userType,
                'userEmail' => $user->email,
                'rappel_number' => $rappel->rappel_number
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi de l\'email de rappel', [
                'idDemande' => $demande->idDemande,
                'userType' => $userType,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
