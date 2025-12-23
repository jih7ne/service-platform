<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Shared\Localisation;
use App\Observers\LocalisationObserver;
use App\Models\Shared\DemandesIntervention;
use App\Observers\DemandeInterventionObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Enregistrer l'observer pour le géocodage automatique 
        Localisation::observe(LocalisationObserver::class);
        
        // Enregistrer l'observer pour l'envoi d'email après intervention terminée
        DemandesIntervention::observe(DemandeInterventionObserver::class);
    }
}
