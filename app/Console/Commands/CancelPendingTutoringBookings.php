<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Shared\DemandesIntervention;
use App\Models\SoutienScolaire\DemandeProf;
use App\Mail\Tutoring\BookingAutoCancelledTutoring;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CancelPendingTutoringBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tutoring:cancel-pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Annule automatiquement les demandes de soutien scolaire en attente depuis plus de 48 heures';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Recherche des demandes de soutien scolaire en attente depuis plus de 48 heures...');

        // Calculer la date limite (48 heures en arrière)
        $dateLimite = Carbon::now()->subHours(48);

        // Récupérer les IDs des demandes de soutien scolaire
        $demandesProfIds = DemandeProf::pluck('demande_id')->toArray();
        
        // Récupérer les demandes en attente depuis plus de 48 heures
        // qui sont des demandes de soutien scolaire
        $demandes = DemandesIntervention::where('statut', 'en_attente')
            ->where('dateDemande', '<=', $dateLimite)
            ->whereIn('idDemande', $demandesProfIds) // S'assurer que c'est une demande de soutien scolaire
            ->with('client')
            ->get();

        if ($demandes->isEmpty()) {
            $this->info('✅ Aucune demande à annuler.');
            return 0;
        }

        $count = 0;

        foreach ($demandes as $demande) {
            try {
                // Mettre à jour le statut de la demande
                $demande->statut = 'annulée';
                $demande->raisonAnnulation = 'Aucune réponse du professeur dans les 48 heures';
                $demande->save();

                // Envoyer l'email au client
                Mail::to($demande->client->email)
                    ->send(new BookingAutoCancelledTutoring($demande));

                $count++;
                
                $this->info("📧 Demande #{$demande->idDemande} annulée - Email envoyé à {$demande->client->email}");
            } catch (\Exception $e) {
                $this->error("❌ Erreur lors de l'annulation de la demande #{$demande->idDemande}: {$e->getMessage()}");
            }
        }

        $this->info("✅ Total: {$count} demande(s) de soutien scolaire annulée(s).");
        
        return 0;
    }
}