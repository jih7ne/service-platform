<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Shared\DemandesIntervention;
use App\Models\Shared\Feedback;
use App\Models\Shared\Utilisateur;
use App\Mail\FeedbackReminderMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendFeedbackReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feedback:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoie des rappels quotidiens pour le feedback (Client et Intervenant) pour TOUS les services pendant 7 jours après l\'intervention.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Début de l\'envoi des rappels de feedback pour tous les services...');

        // 1. Définir la fenêtre de temps
        $sevenDaysAgo = Carbon::now()->subDays(7);
        $now = Carbon::now();

        // 2. Récupérer toutes les demandes validées dans cette fenêtre
        // On utilise le modèle Shared pour avoir accès à toutes les demandes (Babysitting, Soutien, PetKeeping)
        $demandes = DemandesIntervention::where('statut', 'validée')
            ->where('dateSouhaitee', '<', $now)
            ->where('dateSouhaitee', '>=', $sevenDaysAgo)
            ->with(['client', 'intervenant.user', 'service']) // Charger les relations vitales
            ->get();

        if ($demandes->isEmpty()) {
            $this->info('Aucune demande nécessitant un rappel trouvée.');
            return;
        }

        $countEmails = 0;

        foreach ($demandes as $demande) {
            $dateIntervention = ($demande->dateSouhaitee) ? $demande->dateSouhaitee->format('d/m/Y') : 'N/A';
            
            // --- Traitement pour le CLIENT ---
            if ($demande->client) {
                // Vérifier si le client a déjà laissé/reçu un feedback pour cette demande
                // Attention: idAuteur = client
                $feedbackExists = Feedback::where('idDemande', $demande->idDemande)
                    ->where('idAuteur', $demande->idClient)
                    ->exists();

                if (!$feedbackExists) {
                    $this->sendReminderToClient($demande, $dateIntervention);
                    $countEmails++;
                }
            }

            // --- Traitement pour l'INTERVENANT ---
            if ($demande->idIntervenant) {
                // idAuteur = intervenant
                $feedbackIntervenantExists = Feedback::where('idDemande', $demande->idDemande)
                    ->where('idAuteur', $demande->idIntervenant)
                    ->exists();

                if (!$feedbackIntervenantExists) {
                    $this->sendReminderToIntervenant($demande, $dateIntervention);
                    $countEmails++;
                }
            }
        }

        $this->info("Terminé. {$countEmails} e-mails de rappel envoyés.");
    }

    // Helper pour déterminer la route de feedback en fonction du service
    protected function getFeedbackRouteName($service)
    {
        if (!$service) return null;

        $nom = strtolower($service->nomService);

        if (str_contains($nom, 'babysitting')) {
            return 'feedback.babysitter';
        }
        if (str_contains($nom, 'soutien') || str_contains($nom, 'scolaire')) {
            return 'feedback.tutoring';
        }
        if (str_contains($nom, 'pet') || str_contains($nom, 'animaux')) {
            return 'feedback.pet-keeping';
        }

        return 'feedback.form'; // Fallback générique
    }

    protected function sendReminderToClient($demande, $dateStr)
    {
        try {
            $routeName = $this->getFeedbackRouteName($demande->service);
            if (!$routeName) return;

            $url = route($routeName, [
                'idService' => $demande->idService,
                'demandeId' => $demande->idDemande,
                'auteurId' => $demande->idClient,
                'cibleId' => $demande->idIntervenant,
                'typeAuteur' => 'client'
            ]);

            $targetName = 'l\'intervenant';
            if ($demande->intervenant && $demande->intervenant->user) {
                $targetName = $demande->intervenant->user->prenom . ' ' . $demande->intervenant->user->nom;
            }

            Mail::to($demande->client->email)->send(new FeedbackReminderMail(
                $demande->client->prenom,
                $targetName,
                $dateStr,
                $url
            ));
            
            $this->info("Rappel envoyé au client ID {$demande->idClient} pour demande #{$demande->idDemande} (Service: " . ($demande->service->nomService ?? '?') . ")");

        } catch (\Exception $e) {
            $this->error("Erreur envoi client demande #{$demande->idDemande}: " . $e->getMessage());
        }
    }

    protected function sendReminderToIntervenant($demande, $dateStr)
    {
        try {
            $routeName = $this->getFeedbackRouteName($demande->service);
            if (!$routeName) return;

            $url = route($routeName, [
                'idService' => $demande->idService,
                'demandeId' => $demande->idDemande,
                'auteurId' => $demande->idIntervenant,
                'cibleId' => $demande->idClient,
                'typeAuteur' => 'intervenant' // ou 'pro' selon votre logique feedback controller
            ]);

            // Récupérer l'utilisateur intervenant
            // Intervenant model -> user() relation
            $intervenantUser = null;
            if ($demande->intervenant && $demande->intervenant->user) {
                $intervenantUser = $demande->intervenant->user;
            } else {
                // Fallback: si la relation n'est pas chargée ou définie
                $intervenantUser = Utilisateur::find($demande->idIntervenant);
            }

            if ($intervenantUser && $intervenantUser->email) {
                $clientName = $demande->client ? ($demande->client->prenom . ' ' . $demande->client->nom) : 'le client';

                Mail::to($intervenantUser->email)->send(new FeedbackReminderMail(
                    $intervenantUser->prenom,
                    $clientName,
                    $dateStr,
                    $url
                ));

                $this->info("Rappel envoyé à l'intervenant ID {$demande->idIntervenant} pour demande #{$demande->idDemande}");
            }

        } catch (\Exception $e) {
            $this->error("Erreur envoi intervenant demande #{$demande->idDemande}: " . $e->getMessage());
        }
    }
}
