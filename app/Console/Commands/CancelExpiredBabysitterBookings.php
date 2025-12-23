<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Babysitting\DemandeIntervention;
use App\Mail\Babysitting\BookingAutoCancelled;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CancelExpiredBabysitterBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'babysitter:cancel-expired-bookings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Annule automatiquement les demandes de babysitting en attente depuis plus de 48 heures.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Vérification des demandes de babysitting expirées...');

        // Date limite : il y a 48 heures
        $limitDate = Carbon::now()->subHours(48);

        // Récupérer les demandes en attente et vieilles de plus de 48h
        // Note: On suppose que 'dateDemande' est le timestamp de création.
        // Si 'dateDemande' n'a pas d'heure, cela pourrait être imprécis, mais le modèle cast en 'datetime'.
        $expiredDemandes = DemandeIntervention::where('statut', 'en_attente')
            ->where('dateDemande', '<=', $limitDate)
            ->with(['client']) // Charger la relation client pour l'email
            ->get();

        if ($expiredDemandes->isEmpty()) {
            $this->info('Aucune demande expirée trouvée.');
            return;
        }

        $count = 0;

        foreach ($expiredDemandes as $demande) {
            try {
                // 1. Mettre à jour le statut
                $demande->statut = 'annulée'; // ou 'annulé' selon la convention exacte de la BDD
                $demande->raisonAnnulation = 'Délai d\'acceptation de 48h dépassé';
                $demande->save();

                // 2. Envoyer l'email au client
                if ($demande->client && $demande->client->email) {
                    Mail::to($demande->client->email)->send(new BookingAutoCancelled($demande));
                    $this->info("Demande #{$demande->idDemande} annulée. Email envoyé à {$demande->client->email}.");
                } else {
                    $this->warn("Demande #{$demande->idDemande} annulée, mais impossible d'envoyer l'email (Client ou Email introuvable).");
                }

                $count++;
            } catch (\Exception $e) {
                $this->error("Erreur lors du traitement de la demande #{$demande->idDemande} : " . $e->getMessage());
            }
        }

        $this->info("Total : {$count} demande(s) on été automatiquement annulée(s).");
    }
}
