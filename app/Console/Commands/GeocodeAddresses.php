<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Shared\Localisation;
use App\Services\GeocodingService;

class GeocodeAddresses extends Command
{
    protected $signature = 'geocode:addresses {--force : Forcer le géocodage}';
    protected $description = 'Géocoder toutes les adresses';

    public function handle()
    {
        $force = $this->option('force');

        $query = Localisation::query();
        
        if (!$force) {
            $query->where(function($q) {
                $q->whereNull('latitude')
                  ->orWhereNull('longitude');
            });
        }

        $localisations = $query->get();
        
        if ($localisations->isEmpty()) {
            $this->info('✓ Toutes les adresses sont déjà géocodées!');
            return 0;
        }

        $this->info("🌍 Géocodage de {$localisations->count()} adresses...");
        $bar = $this->output->createProgressBar($localisations->count());
        $bar->start();

        $success = 0;
        $failed = 0;

        foreach ($localisations as $localisation) {
            if (empty($localisation->adresse) || empty($localisation->ville)) {
                $failed++;
                $bar->advance();
                continue;
            }

            $coordinates = GeocodingService::geocode(
                $localisation->adresse,
                $localisation->ville
            );

            if ($coordinates) {
                $localisation->update([
                    'latitude' => $coordinates['latitude'],
                    'longitude' => $coordinates['longitude']
                ]);
                $success++;
            } else {
                $failed++;
            }

            $bar->advance();
            sleep(1);
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("✓ Géocodage terminé!");
        $this->info("  • Succès: {$success}");
        if ($failed > 0) {
            $this->warn("  • Échecs: {$failed}");
        }

        return 0;
    }
}