<?php

namespace App\Jobs;

use App\Models\Shared\FeedbackRappel;
use App\Models\Shared\DemandeIntervention;
use App\Models\Shared\Utilisateur;
use App\Models\Shared\Intervenant;
use App\Models\Babysitting\FeedbackBabysitter;
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
        
        // Récupérer les demandes terminées depuis au moins 1 jour
        $demandesTerminees = DemandeIntervention::where('statut', 'confirmé')
            ->where('dateSouhaitee', '<', Carbon::now()->subDay())
            ->where('heureFin', '<', Carbon::now()->format('H:i'))
            ->get();

        foreach ($demandesTerminees as $demande) {
            $this->processDemandeForReminders($demande);
        }
        
        Log::info('Fin du job de rappel de feedback');
    }

    private function processDemandeForReminders(DemandeIntervention $demande)
    {
        // Vérifier si des feedbacks existent déjà
        $clientFeedbackExists = FeedbackBabysitter::where('idDemande', $demande->idDemande)
            ->where('idClient', $demande->idClient)
            ->exists();

        $intervenantFeedbackExists = FeedbackBabysitter::where('idDemande', $demande->idDemande)
            ->where('idBabysitter', $demande->idIntervenant)
            ->exists();

        // Traiter le rappel pour le client
        if (!$clientFeedbackExists) {
            $this->sendReminderToUser($demande, 'client');
        }

        // Traiter le rappel pour l'intervenant
        if (!$intervenantFeedbackExists) {
            $this->sendReminderToUser($demande, 'intervenant');
        }
    }

    private function sendReminderToUser(DemandeIntervention $demande, string $userType)
    {
        $userId = $userType === 'client' ? $demande->idClient : $demande->idIntervenant;
        
        // Calculer la date de fin de l'intervention
        $finIntervention = Carbon::parse($demande->dateSouhaitee . ' ' . $demande->heureFin);
        $joursDepuisFin = Carbon::now()->diffInDays($finIntervention);
        
        // Vérifier si un rappel existe déjà
        $existingRappel = FeedbackRappel::where('idDemande', $demande->idDemande)
            ->where('type_destinataire', $userType)
            ->where('feedback_fourni', false)
            ->first();

        if ($existingRappel) {
            // Vérifier si on doit envoyer le 2ème rappel (jour 6)
            if ($existingRappel->rappel_number == 1 && $joursDepuisFin == 6) {
                $this->sendSecondReminder($demande, $userType, $existingRappel);
            }
        } else {
            // Envoyer le premier rappel (jour 1)
            if ($joursDepuisFin == 1) {
                $this->createFirstReminder($demande, $userType);
            }
        }
    }

    private function createFirstReminder(DemandeIntervention $demande, string $userType)
    {
        $userId = $userType === 'client' ? $demande->idClient : $demande->idIntervenant;
        
        $rappel = FeedbackRappel::create([
            'idDemande' => $demande->idDemande,
            'idClient' => $demande->idClient,
            'idIntervenant' => $demande->idIntervenant,
            'type_destinataire' => $userType,
            'rappel_number' => 1,
            'date_envoi' => now(),
            'prochain_rappel' => null, // Pas de prochain rappel automatique
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
            'prochain_rappel' => null, // Pas d'autres rappels
        ]);
    }

    
    private function sendReminderEmail(DemandeIntervention $demande, string $userType, FeedbackRappel $rappel)
    {
        try {
            $user = $userType === 'client' 
                ? Utilisateur::find($demande->idClient)
                : Utilisateur::find($demande->idIntervenant);

            if (!$user) {
                Log::error('Utilisateur non trouvé pour le rappel', [
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
                'feedback_url' => route('feedback.form', ['idDemande' => $demande->idDemande])
            ];

            $emailView = $userType === 'client' 
                ? 'emails.feedback.client-reminder' 
                : 'emails.feedback.intervenant-reminder';

            Mail::send($emailView, $emailData, function ($message) use ($user, $rappel) {
                $message->to($user->email)
                    ->subject('Rappel : Donnez votre feedback sur le service #' . $rappel->idDemande);
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
                'error' => $e->getMessage()
            ]);
        }
    }
}
