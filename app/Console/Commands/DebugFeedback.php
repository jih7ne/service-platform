<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Shared\Feedback;
use App\Models\Shared\FeedbackRappel;
use App\Models\DemandeIntervention;
use Carbon\Carbon;

class DebugFeedback extends Command
{
    protected $signature = 'feedback:debug';
    protected $description = 'Debug du système de rappels de feedback';

    public function handle()
    {
        $this->info("╔════════════════════════════════════════════════════════════╗");
        $this->info("║     DEBUG SYSTÈME DE RAPPELS DE FEEDBACK - HELPORA        ║");
        $this->info("╚════════════════════════════════════════════════════════════╝");
        $this->line("");

        // 1. Configuration Email
        $this->section1_EmailConfig();
        
        // 2. Demandes d'intervention
        $this->section2_DemandesIntervention();
        
        // 3. Feedbacks existants
        $this->section3_Feedbacks();
        
        // 4. Rappels envoyés
        $this->section4_Rappels();
        
        // 5. Prochains rappels à envoyer
        $this->section5_ProchainsRappels();

        $this->line("");
        $this->info("╔════════════════════════════════════════════════════════════╗");
        $this->info("║                    FIN DU DEBUG                            ║");
        $this->info("╚════════════════════════════════════════════════════════════╝");
        
        return 0;
    }

    private function section1_EmailConfig()
    {
        $this->info("📧 1. CONFIGURATION EMAIL");
        $this->line("─────────────────────────────────────────────────────────────");
        
        $mailer = env('MAIL_MAILER', 'non défini');
        $host = env('MAIL_HOST', 'non défini');
        $port = env('MAIL_PORT', 'non défini');
        $username = env('MAIL_USERNAME', 'non défini');
        $from = env('MAIL_FROM_ADDRESS', 'non défini');
        
        $this->line("Mailer: <fg=yellow>{$mailer}</>");
        $this->line("Host: <fg=yellow>{$host}</>");
        $this->line("Port: <fg=yellow>{$port}</>");
        $this->line("Username: <fg=yellow>{$username}</>");
        $this->line("From: <fg=yellow>{$from}</>");
        
        if ($mailer === 'log') {
            $this->warn("⚠️  Mode LOG activé - Les emails sont enregistrés dans storage/logs/laravel.log");
        } elseif ($mailer === 'smtp') {
            $this->info("✅ Mode SMTP activé");
        }
        
        $this->line("");
    }

    private function section2_DemandesIntervention()
    {
        $this->info("📋 2. DEMANDES D'INTERVENTION");
        $this->line("─────────────────────────────────────────────────────────────");
        
        $demandesValidees = DemandeIntervention::where('statut', 'validée')
            ->whereNotNull('idIntervenant')
            ->get();
        
        $this->line("Total demandes validées avec intervenant: <fg=cyan>{$demandesValidees->count()}</>");
        
        $demandesTerminees = $demandesValidees->filter(function($demande) {
            if (!$demande->dateSouhaitee || !$demande->heureFin) {
                return false;
            }
            // Extraire seulement la partie date de dateSouhaitee si elle contient déjà un timestamp
            $dateOnly = explode(' ', $demande->dateSouhaitee)[0];
            $finIntervention = Carbon::parse($dateOnly . ' ' . $demande->heureFin);
            return Carbon::now()->greaterThan($finIntervention);
        });
        
        $this->line("Demandes terminées: <fg=cyan>{$demandesTerminees->count()}</>");
        
        if ($demandesTerminees->count() > 0) {
            $this->line("");
            $this->line("Dernières demandes terminées:");
            foreach ($demandesTerminees->take(5) as $demande) {
                $dateOnly = explode(' ', $demande->dateSouhaitee)[0];
                $finIntervention = Carbon::parse($dateOnly . ' ' . $demande->heureFin);
                $joursDepuis = Carbon::now()->diffInDays($finIntervention);
                
                $this->line("  • ID: {$demande->idDemande} | Client: {$demande->idClient} | Intervenant: {$demande->idIntervenant}");
                $this->line("    Date: {$demande->dateSouhaitee} | Jours écoulés: {$joursDepuis}");
            }
        }
        
        $this->line("");
    }

    private function section3_Feedbacks()
    {
        $this->info("⭐ 3. FEEDBACKS SOUMIS");
        $this->line("─────────────────────────────────────────────────────────────");
        
        $feedbacks = Feedback::orderBy('dateCreation', 'desc')->get();
        
        $this->line("Total feedbacks: <fg=cyan>{$feedbacks->count()}</>");
        
        $feedbacksClient = $feedbacks->where('typeAuteur', 'client')->count();
        $feedbacksIntervenant = $feedbacks->where('typeAuteur', 'intervenant')->count();
        
        $this->line("  - Par clients: <fg=green>{$feedbacksClient}</>");
        $this->line("  - Par intervenants: <fg=green>{$feedbacksIntervenant}</>");
        
        if ($feedbacks->count() > 0) {
            $this->line("");
            $this->line("Derniers feedbacks:");
            foreach ($feedbacks->take(5) as $feedback) {
                $this->line("  • ID: {$feedback->idFeedBack} | Demande: {$feedback->idDemande} | Type: {$feedback->typeAuteur}");
                $this->line("    Auteur: {$feedback->idAuteur} → Cible: {$feedback->idCible}");
            }
        }
        
        $this->line("");
    }

    private function section4_Rappels()
    {
        $this->info("📬 4. RAPPELS ENVOYÉS");
        $this->line("─────────────────────────────────────────────────────────────");
        
        $rappels = FeedbackRappel::orderBy('created_at', 'desc')->get();
        
        $this->line("Total rappels: <fg=cyan>{$rappels->count()}</>");
        
        $rappelsEnAttente = $rappels->where('feedback_fourni', false)->count();
        $rappelsTermines = $rappels->where('feedback_fourni', true)->count();
        
        $this->line("  - En attente: <fg=yellow>{$rappelsEnAttente}</>");
        $this->line("  - Terminés: <fg=green>{$rappelsTermines}</>");
        
        if ($rappels->count() > 0) {
            $this->line("");
            $this->line("Derniers rappels:");
            foreach ($rappels->take(10) as $rappel) {
                $status = $rappel->feedback_fourni ? '✅' : '⏳';
                $this->line("  {$status} Demande: {$rappel->idDemande} | Type: {$rappel->type_destinataire} | Rappel #{$rappel->rappel_number}");
                $this->line("     Envoyé: {$rappel->date_envoi}");
            }
        }
        
        $this->line("");
    }

    private function section5_ProchainsRappels()
    {
        $this->info("🔔 5. PROCHAINS RAPPELS À ENVOYER");
        $this->line("─────────────────────────────────────────────────────────────");
        
        // Demandes terminées sans feedback
        $demandesTerminees = DemandeIntervention::where('statut', 'validée')
            ->whereNotNull('idIntervenant')
            ->get()
            ->filter(function($demande) {
                if (!$demande->dateSouhaitee || !$demande->heureFin) {
                    return false;
                }
                $dateOnly = explode(' ', $demande->dateSouhaitee)[0];
                $finIntervention = Carbon::parse($dateOnly . ' ' . $demande->heureFin);
                return Carbon::now()->greaterThan($finIntervention);
            });
        
        $prochainsRappels = [];
        
        foreach ($demandesTerminees as $demande) {
            $dateOnly = explode(' ', $demande->dateSouhaitee)[0];
            $finIntervention = Carbon::parse($dateOnly . ' ' . $demande->heureFin);
            $joursDepuis = Carbon::now()->diffInDays($finIntervention);
            
            // Vérifier client
            $clientFeedback = Feedback::where('idDemande', $demande->idDemande)
                ->where('idAuteur', $demande->idClient)
                ->where('typeAuteur', 'client')
                ->exists();
            
            $clientRappel = FeedbackRappel::where('idDemande', $demande->idDemande)
                ->where('type_destinataire', 'client')
                ->where('feedback_fourni', false)
                ->first();
            
            if (!$clientFeedback) {
                if (!$clientRappel && $joursDepuis >= 1) {
                    $prochainsRappels[] = "Demande #{$demande->idDemande} - Client (J+{$joursDepuis}) - Premier rappel à envoyer";
                } elseif ($clientRappel && $clientRappel->rappel_number == 1 && $joursDepuis >= 3) {
                    $prochainsRappels[] = "Demande #{$demande->idDemande} - Client (J+{$joursDepuis}) - Deuxième rappel à envoyer";
                }
            }
            
            // Vérifier intervenant
            $intervenantFeedback = Feedback::where('idDemande', $demande->idDemande)
                ->where('idAuteur', $demande->idIntervenant)
                ->where('typeAuteur', 'intervenant')
                ->exists();
            
            $intervenantRappel = FeedbackRappel::where('idDemande', $demande->idDemande)
                ->where('type_destinataire', 'intervenant')
                ->where('feedback_fourni', false)
                ->first();
            
            if (!$intervenantFeedback) {
                if (!$intervenantRappel && $joursDepuis >= 1) {
                    $prochainsRappels[] = "Demande #{$demande->idDemande} - Intervenant (J+{$joursDepuis}) - Premier rappel à envoyer";
                } elseif ($intervenantRappel && $intervenantRappel->rappel_number == 1 && $joursDepuis >= 3) {
                    $prochainsRappels[] = "Demande #{$demande->idDemande} - Intervenant (J+{$joursDepuis}) - Deuxième rappel à envoyer";
                }
            }
        }
        
        if (count($prochainsRappels) > 0) {
            $this->line("<fg=yellow>Rappels qui seront envoyés lors de la prochaine exécution:</>");
            foreach ($prochainsRappels as $rappel) {
                $this->line("  • {$rappel}");
            }
        } else {
            $this->line("<fg=green>✅ Aucun rappel à envoyer pour le moment</>");
        }
        
        $this->line("");
    }
}

