<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Planification de la tâche d'annulation automatique des réservations babysitter (toutes les heures)
// Assurez-vous que le cron est configuré sur le serveur (php artisan schedule:run)
\Illuminate\Support\Facades\Schedule::command('babysitter:cancel-expired-bookings')->hourly();

// Rappels de feedback quotidiens (Client & Babysitter)
\Illuminate\Support\Facades\Schedule::command('feedback:send-reminders')->dailyAt('13:59');

// Commande de test pour préparer les données (TEMPORAIRE)
\Illuminate\Support\Facades\Artisan::command('test:prepare-feedback-data', function () {
    $demande = \App\Models\Babysitting\DemandeIntervention::latest('idDemande')->first();
    if ($demande) {
        $demande->statut = 'validée';
        $demande->dateSouhaitee = \Carbon\Carbon::yesterday();
        $demande->save();
        $this->info("Demande #{$demande->idDemande} modifiée : Statut 'validée', Date 'Hier'.");
    } else {
        $this->error('Aucune demande trouvée.');
    }
});
