<?php

namespace App\Livewire\PetKeeping;

use App\Models\PetKeeping\PetKeeper;
use App\Models\PetKeeping\PetKeeping as PetKeepingService;
use App\Constants\PetKeeping\Constants;
use Illuminate\Support\Facades\DB;
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


    public function mount()
    {
        $this->loadKeepers();
    }

    public function updated($property)
    {
        $this->loadKeepers(); 
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
                ->orWhere('s.description', 'like', "%{$this->searchQuery}%");
            });
        }

        //  Pet Type
        if ($this->petType !== 'all') {
            $query->where('pk.pet_type', 'like', "%{$this->petType}%");
        }

        

        //  Petkeeping Category 
        if ($this->serviceCategory !== 'all') {
            $query->where('pk.categorie_petkeeping', 'like', "%{$this->serviceCategory}%");
            
        }

        



        if ($this->criteria !== 'all') {
            $query->where('pk.payment_criteria', 'like', "%{$this->criteria}%");
        }

        //  Price Range
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


        
        if ($this->vaccinationRequired) {
            $query->where('pk.vaccination_required', '=', 1);
        }

        if ($this->acceptsAggressivePets) {
            $query->where('pk.accepts_aggressive_pets', '=', 1);
        }

        if ($this->acceptsUntrainedPets) {
            $query->where('pk.accepts_untrained_pets', '=', 1);
        }

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
            ];
        });
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

        $this->loadKeepers();
    }



    public function render()
    {
        return view('livewire.pet-keeping.search-service')->with([
            'services' => $this->services,
        ]);
    }
}
