<?php

namespace App\Livewire\PetKeeping;

use App\Models\PetKeeping\PetKeeper;
use App\Models\PetKeeping\PetKeeping as PetKeepingService;
use App\Constants\PetKeeping\Constants;
use App\Constants\Shared\Countries;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class SearchService extends Component
{
    public $searchQuery = '';
    public $petType = 'all';
    public $serviceType = 'all';
    public $location = '';
    public $minPrice = 0;
    public $maxPrice = 100;
    public $minRating = 0;
    public $minRatingPetKeeper = 0;
    public $serviceCategory = '';
    public $criteria = '';
    public $vaccinationRequired = false;
    public $acceptsUntrainedPets = false;
    public $acceptsAggressivePets = false;

    public $services = [];
    
    // Sorting
    public $sortBy = 'relevance';

    // Map View Attributes
    public $viewMode = 'list'; 
    public $locationQuery = '';
    public $selectedCountry = '';
    public $selectedCity = '';
    public $searchRadius = 25; 
    public $mapMarkers = [];
    public $countries = [];
    public $cities = [];
    public $currentLocation = null;





    // For OpenStreetMap center
    public $mapCenter = ['lat' => 33.5731, 'lng' => -7.5898]; // Default: Casablanca, Morocco
    public $mapZoom = 10;



    //Pagination
    public $currentPage = 1;
    public $perPage = 3;

    public function mount()
    {
        $this->loadKeepers();
        $this->loadCountries();
        $this->loadCities();
    }


    public function getPaginatedServicesProperty()
    {
        return collect($this->services)->forPage($this->currentPage, $this->perPage);
    }

    public function nextPage()
    {
        $this->currentPage++;
    }

    public function previousPage()
    {
        if ($this->currentPage > 1) {
            $this->currentPage--;
        }
    }

    public function gotoPage($page)
    {
        $this->currentPage = $page;
    }


    public function updated($property)
    {
        // Don't trigger loadKeepers when updating map view properties
        $mapProperties = ['viewMode', 'locationQuery', 'selectedCountry', 'selectedCity', 'searchRadius'];
        
        if (!in_array($property, $mapProperties)) {
            $this->loadKeepers();
        }
        
        // If switching to map view, update map markers
        if ($property === 'viewMode' && $this->viewMode === 'map') {
            $this->updateMapMarkers();
        }
    }

    public function evaluer($id)
    {
        return redirect()->route('petkeeping.evaluate', ['id' => $id]);
    }

    public function loadKeepers()
    {
        $query = DB::table('petkeeping as pk')
            ->join('services as s', 's.idService', '=', 'pk.idPetKeeping')
            ->join('petkeepers as k', 'k.idPetKeeper', '=', 'pk.idPetKeeper')
            ->join('utilisateurs as ut', 'ut.idUser', '=', 'pk.idPetKeeper')
            ->select();

        // Search
        if (!empty($this->searchQuery)) {
            $query->where(function ($q) {
                $q->where('s.nomService', 'like', "%{$this->searchQuery}%")
                    ->orWhere('s.description', 'like', "%{$this->searchQuery}%")
                    ->orWhere('ut.prenom', 'like', "%{$this->searchQuery}%")
                    ->orWhere('ut.nom', 'like', "%{$this->searchQuery}%");
            });
        }

        // Pet Type
        if ($this->petType !== 'all') {
            $query->where('pk.pet_type', 'like', "%{$this->petType}%");
        }

        // Petkeeping Category 
        if ($this->serviceCategory !== '' && $this->serviceCategory !== 'all') {
            $query->where('pk.categorie_petkeeping', 'like', "%{$this->serviceCategory}%");
        }

        // Payment Criteria
        if ($this->criteria !== '' && $this->criteria !== 'all') {
            $query->where('pk.payment_criteria', 'like', "%{$this->criteria}%");
        }

        // Price Range
        if (!empty($this->minPrice)) {
            $query->where('pk.base_price', '>=', $this->minPrice);
        }
        if (!empty($this->maxPrice)) {
            $query->where('pk.base_price', '<=', $this->maxPrice);
        }

        // Service Rating
        if (!empty($this->minRating)) {
            $query->where('pk.note', '>=', $this->minRating);
        }

        // PetKeeper Rating
        if (!empty($this->minRatingPetKeeper)) {
            $query->where('ut.note', '>=', $this->minRatingPetKeeper);
        }

        // Additional filters
        if ($this->vaccinationRequired) {
            $query->where('pk.vaccination_required', '=', 1);
        }

        if ($this->acceptsAggressivePets) {
            $query->where('pk.accepts_aggressive_pets', '=', 1);
        }

        if ($this->acceptsUntrainedPets) {
            $query->where('pk.accepts_untrained_pets', '=', 1);
        }

        // Apply sorting
        $this->applySorting($query);

        // Fetch and map results
        $this->services = $query->get()->map(function ($service) {
            return [
                "id" => $service->idPetKeeping,
                "nomService" => $service->nomService,
                "avatar" => $service->photo ?? "https://api.dicebear.com/7.x/avataaars/svg?seed=" . urlencode($service->prenom . $service->nom),
                "note" => $service->note,
                "nbrAvis" => $service->nbrAvis,
                "location" => "", 
                "base_price" => $service->base_price,
                "petType" => $service->pet_type, 
                "description" => $service->description,
                "status" => $service->statut, 
                "verified" => ($service->statut === 'actif') ? 1 : 0, 
                "experience" => round($service->note * 2), 
                "responseTime" => rand(1, 4), 
                "availability" => ($service->statut === 'actif') ? "available" : "booked",
                "providerName" => $service->prenom . ' ' . $service->nom,
                "providerId" => $service->idUser,
                "serviceId" => $service->idService,
                "serviceType" => $service->nomService,
                "category" => Constants::getCategoryLabel($service->categorie_petkeeping),
                "acceptsAggressivePets" => (bool)$service->accepts_aggressive_pets,
                "acceptsUntrainedPets" => (bool)$service->accepts_untrained_pets,
                "vaccinationRequired" => (bool)$service->vaccination_required,
                "paymentCriteria" => Constants::getCriteriaLabel($service->payment_criteria),
                "speciality" => $service->specialite ?? '',
                "nombres_services_demandes" => $service->nombres_services_demandes,
                "city" => $service->ville ?? '',
                "country" => $service->pays ?? '',
                "latitude" => $service->latitude ?? null,
                "longitude" => $service->longitude ?? null,
                "photo" => $service->photo ?? "https://api.dicebear.com/7.x/avataaars/svg?seed=" . urlencode($service->prenom . $service->nom),
            ];
        })->toArray();

        // If in map view, also update map markers
        if ($this->viewMode === 'map') {
            $this->updateMapMarkers();
        }
    }

    private function applySorting($query)
    {
        switch ($this->sortBy) {
            case 'rating':
                $query->orderByDesc('ut.note');
                break;
            case 'price':
                $query->orderBy('pk.base_price');
                break;
            case 'dateAsc':
                $query->orderBy('pk.created_at');
                break;
            case 'dateDsc':
                $query->orderByDesc('pk.created_at')
                    ->orderByDesc('pk.note');
                break;
        }
    }

    public function updateMapMarkers()
    {
        // Start with filtered services
        $filteredServices = collect($this->services);

        // Apply location filters
        if ($this->locationQuery) {
            $filteredServices = $filteredServices->filter(function ($service) {
                $serviceLocation = strtolower($service['ville']);
                $searchLocation = strtolower($this->locationQuery);
                return str_contains($serviceLocation, $searchLocation);
            });
        }

        if ($this->selectedCountry) {
            $filteredServices = $filteredServices->filter(function ($service) {
                return strtolower($service['country']) === strtolower($this->selectedCountry);
            });
        }

        if ($this->selectedCity) {
            $filteredServices = $filteredServices->filter(function ($service) {
                return strtolower($service['ville']) === strtolower($this->selectedCity);
            });
        }

        // Filter out services without coordinates
        $filteredServices = $filteredServices->filter(function ($service) {
            return !empty($service['latitude']) && !empty($service['longitude']);
        });

        // Apply radius filter if we have current location
        if ($this->currentLocation && $this->searchRadius > 0) {
            $filteredServices = $filteredServices->filter(function ($service) {
                $distance = $this->calculateDistance(
                    $this->currentLocation['lat'],
                    $this->currentLocation['lng'],
                    $service['latitude'],
                    $service['longitude']
                );
                
                return $distance <= $this->searchRadius;
            })->map(function ($service) {
                $service['distance'] = $this->calculateDistance(
                    $this->currentLocation['lat'],
                    $this->currentLocation['lng'],
                    $service['latitude'],
                    $service['longitude']
                );
                return $service;
            });
        }

        // Transform to map markers format
        $this->mapMarkers = $filteredServices->map(function ($service) {
            return [
                'id' => $service['id'],
                'name' => $service['providerName'],
                'photo' => $service['photo'],
                'rating' => $service['note'],
                'status' => $service['status'],
                'price' => $service['base_price'],
                'criteria' => $service['paymentCriteria'],
                'services' => [$service['category']],
                'lat' => $service['latitude'],
                'lng' => $service['longitude'],
                'distance' => $service['distance'] ?? null,
                'city' => $service['city'],
                'address' => $service['address'],
                'description' => Str::limit($service['description'], 100),
            ];
        })->toArray();

        // Update map center based on filtered markers
        if (!empty($this->mapMarkers)) {
            $lats = array_column($this->mapMarkers, 'lat');
            $lngs = array_column($this->mapMarkers, 'lng');
            
            $this->mapCenter = [
                'lat' => array_sum($lats) / count($lats),
                'lng' => array_sum($lngs) / count($lngs)
            ];
            
            if (count($this->mapMarkers) === 1) {
                $this->mapZoom = 14;
            } elseif (count($this->mapMarkers) <= 5) {
                $this->mapZoom = 12;
            } else {
                $this->mapZoom = 10;
            }
        }

        // Dispatch event to update map in frontend
        $this->dispatch('refresh-map', [
            'markers' => $this->mapMarkers,
            'center' => $this->mapCenter,
            'zoom' => $this->mapZoom
        ]);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // kilometers

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) + 
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * 
             sin($dLon/2) * sin($dLon/2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        
        return $earthRadius * $c;
    }

    public function loadCountries()
    {
        $cacheKey = 'countries_list';
        $cacheDuration = now()->addDays(30); 
        
        $this->countries = Cache::remember($cacheKey, $cacheDuration, function () {
            try {
                $response = Http::withoutVerifying()->timeout(10)->get('https://restcountries.com/v3.1/all?fields=name');
                
                if ($response->successful()) {
                    $countries = $response->json();
                    return collect($countries)
                        ->map(function ($country) {
                            return $country['name']['common'];
                        })
                        ->sort()
                        ->values()
                        ->toArray();
                }
            } catch (\Exception $e) {
               
                Log::warning('Failed to fetch countries from API', ['error' => $e->getMessage()]);
            }
            
            
            return Countries::getStaticCountries();
        });
    }

    public function loadCities()
    {
        if (!$this->selectedCountry) {
            $this->cities = [];
            return;
        }
        
        $cacheKey = "cities_{$this->selectedCountry}";
        $cacheDuration = now()->addDays(7); 
        
        $this->cities = Cache::remember($cacheKey, $cacheDuration, function () {
            try {
    
                $countryCode = $this->getCountryCodeFromApi($this->selectedCountry);
                
                if (!$countryCode) {
                    return Countries::getStaticCities($this->selectedCountry);
                }
                
                
                $username = $username = config('services.geonames.username', 'demo');
                $response = Http::timeout(10)->get("http://api.geonames.org/searchJSON", [
                    'country' => $countryCode,
                    'featureClass' => 'P',
                    'maxRows' => 200, 
                    'username' => $username,
                ]);
                
                if ($response->successful()) {
                    $data = $response->json();
                    return collect($data['geonames'] ?? [])
                        ->pluck('name')
                        ->sort()
                        ->values()
                        ->toArray();
                }
            } catch (\Exception $e) {
                Log::warning('Failed to fetch cities from API', [
                    'country' => $this->selectedCountry,
                    'error' => $e->getMessage()
                ]);

                
            }
            
            return Countries::getStaticCities($this->selectedCountry);
        });
    }


    private function getCountryCodeFromApi($countryName)
    {
        try {
            $response = Http::timeout(5)->get("https://restcountries.com/v3.1/name/{$countryName}");
            
            if ($response->successful()) {
                $data = $response->json();
                return $data[0]['cca2'] ?? null; // ISO 3166-1 alpha-2 code
            }
        } catch (\Exception $e) {
            
        }
        
        return Countries::getStaticCode($countryName);
    }

    public function updatedSelectedCountry()
    {
        $this->loadCities();
        $this->selectedCity = '';
        
        if ($this->viewMode === 'map') {
            $this->updateMapMarkers();
        }
    }

    public function updatedSelectedCity()
    {
        if ($this->viewMode === 'map') {
            $this->updateMapMarkers();
        }
    }

    public function updatedLocationQuery()
    {
        if ($this->viewMode === 'map') {
            $this->updateMapMarkers();
        }
    }

    public function updatedSearchRadius()
    {
        if ($this->viewMode === 'map') {
            $this->updateMapMarkers();
        }
    }

    public function bookService($IdService)
    {
        return redirect()->route('pet-keeper.book', $IdService);
    }

    public function zoomIn()
    {
        $this->dispatch('zoom-in');
    }

    public function zoomOut()
    {
        $this->dispatch('zoom-out');
    }

    public function locateMe()
    {
        $this->dispatch('locate-me');
    }

    public function userLocated($lat, $lng)
    {
        $this->currentLocation = [
            'lat' => $lat,
            'lng' => $lng
        ];
        
        if ($this->viewMode === 'map') {
            $this->updateMapMarkers();
        }
    }

    public function viewDetails($id)
    {
        // Find the service and switch to list view with details
        $service = collect($this->services)->firstWhere('id', $id);
        
        if ($service) {
            // You could implement a detailed view modal here
            $this->dispatch('show-service-details', service: $service);
        }
    }

    public function switchedToMapView()
    {
        $this->updateMapMarkers();
        $this->dispatch('switched-to-map-view');
    }

    public function resetFilters()
    {
        $this->searchQuery = '';
        $this->petType = 'all';
        $this->serviceType = 'all';
        $this->location = '';
        $this->minPrice = 0;
        $this->maxPrice = 100;
        $this->minRating = 0;
        $this->minRatingPetKeeper = 0;
        $this->serviceCategory = '';
        $this->criteria = '';
        $this->vaccinationRequired = false;
        $this->acceptsUntrainedPets = false;
        $this->acceptsAggressivePets = false;
        $this->sortBy = 'relevance';

        // Reset map filters
        $this->locationQuery = '';
        $this->selectedCountry = '';
        $this->selectedCity = '';
        $this->searchRadius = 25;

        $this->resetPage();
        $this->perPage = 3;

        $this->loadKeepers();
        $this->loadCountries();
        $this->loadCities();
    }

    public function render()
    {
        return view('livewire.pet-keeping.search-service')->with([
            'services' => $this->services,
            'totalPages' => ceil(count($this->services) / $this->perPage),
            'mapMarkers' => $this->mapMarkers,
            'countries' => $this->countries,
            'cities' => $this->cities,
        ]);
    }
}