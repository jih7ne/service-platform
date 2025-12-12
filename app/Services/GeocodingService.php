<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeocodingService
{
    public static function geocode($adresse, $ville, $pays = 'Morocco')
    {
        try {
            $query = trim("{$adresse}, {$ville}, {$pays}");
            
            $response = Http::withHeaders([
                'User-Agent' => config('app.name', 'Laravel') . '/1.0',
                'Accept-Language' => 'fr'
            ])
            ->timeout(10)
            ->get('https://nominatim.openstreetmap.org/search', [
                'q' => $query,
                'format' => 'json',
                'limit' => 1,
                'countrycodes' => 'ma',
                'addressdetails' => 1
            ]);

            if ($response->successful() && !empty($response->json())) {
                $result = $response->json()[0];
                
                return [
                    'latitude' => (float) $result['lat'],
                    'longitude' => (float) $result['lon']
                ];
            }

            if (empty($response->json())) {
                return self::geocodeCity($ville, $pays);
            }

            return null;

        } catch (\Exception $e) {
            Log::error('Erreur de géocodage: ' . $e->getMessage(), [
                'adresse' => $adresse,
                'ville' => $ville
            ]);
            
            return null;
        }
    }

    public static function geocodeCity($ville, $pays = 'Morocco')
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => config('app.name', 'Laravel') . '/1.0',
                'Accept-Language' => 'fr'
            ])
            ->timeout(10)
            ->get('https://nominatim.openstreetmap.org/search', [
                'city' => $ville,
                'country' => $pays,
                'format' => 'json',
                'limit' => 1
            ]);

            if ($response->successful() && !empty($response->json())) {
                $result = $response->json()[0];
                
                return [
                    'latitude' => (float) $result['lat'],
                    'longitude' => (float) $result['lon']
                ];
            }

            return null;

        } catch (\Exception $e) {
            Log::error('Erreur de géocodage ville: ' . $e->getMessage());
            return null;
        }
    }
}