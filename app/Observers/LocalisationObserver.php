<?php

namespace App\Observers;

use App\Models\Shared\Localisation;
use App\Services\GeocodingService;

class LocalisationObserver
{
    public function creating(Localisation $localisation)
    {
        if (empty($localisation->latitude) || empty($localisation->longitude)) {
            $this->geocodeLocalisation($localisation);
        }
    }

    public function updating(Localisation $localisation)
    {
        if ($localisation->isDirty(['adresse', 'ville'])) {
            $this->geocodeLocalisation($localisation);
        }
    }

    private function geocodeLocalisation(Localisation $localisation)
    {
        if (!empty($localisation->adresse) && !empty($localisation->ville)) {
            $coordinates = GeocodingService::geocode(
                $localisation->adresse,
                $localisation->ville
            );

            if ($coordinates) {
                $localisation->latitude = $coordinates['latitude'];
                $localisation->longitude = $coordinates['longitude'];
            }
        }
    }
}