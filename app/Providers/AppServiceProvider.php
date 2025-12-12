<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Shared\Localisation;
use App\Observers\LocalisationObserver;

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
    }
}
