<?php

namespace App\Livewire\PetKeeping;

use App\Models\PetKeeping\PetKeeping;
use App\Models\PetKeeping\Animal;
use App\Models\Shared\DemandesIntervention; 
use App\Models\Shared\Localisation;
use App\Models\Shared\Service; 
use Livewire\Component;
use Illuminate\Support\Facades\DB;      
use Illuminate\Support\Facades\Log; 

class PetkeeperBooking extends Component
{
    public $currentStep = 1;
    public $totalSteps = 5;

    // Step 1: Service Selection
    public $selectedService = null;
    public $services = [];
        public $intervenantDetails = null; // ✅ AJOUTEZ CETTE LIGNE


    // Step 2: Dates & Availability
    public $dateDebut = null;
    public $dateFin = null;
    public $selectedSlots = [];
    public $availableDays = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

    // Step 3: Address
    public $adresseComplete = null;
    public $ville = null;

    // Step 4: Animals
    public $animals = [];
    public $animalTypes = ['Chien', 'Chat', 'Lapin', 'Hamster', 'Oiseau'];

   public function mount()
{
    
    $this->services = Service::where('statut', 'ACTIVE')->get();
}

   public function selectService($serviceId)
{
    $this->selectedService = $serviceId;
    $this->resetErrorBag('selectedService');
    
    // ✅ Récupérer le service avec son intervenant
    $service = Service::find($serviceId);
    
    if (!$service) {
        $this->intervenantDetails = null;
        return;
    }
    
    // ✅ Récupérer l'utilisateur via idIntervenant
    $intervenant = \App\Models\Shared\Intervenant::where('IdIntervenant', $service->idIntervenant)->first();
    
    if (!$intervenant) {
        $this->intervenantDetails = null;
        return;
    }
    
    // ✅ Récupérer les détails de l'utilisateur
    $user = \App\Models\Shared\Utilisateur::find($intervenant->IdIntervenant);
    
    if ($user) {
        $this->intervenantDetails = [
            'nom_complet' => $user->prenom . ' ' . $user->nom,
            'note' => $user->note ?? 0,
            'nbrAvis' => $user->nbrAvis ?? 0,
            'photo' => $user->photo ? asset('storage/' . $user->photo) : null,
        ];
    } else {
        $this->intervenantDetails = null;
    }
}
    public function toggleSlot($jour, $heureDebut, $heureFin)
    {
        $slotKey = $jour . '_' . $heureDebut;
        
        
        $existingIndex = null;
        foreach ($this->selectedSlots as $index => $slot) {
            if ($slot['jour'] === $jour && $slot['heureDebut'] === $heureDebut) {
                $existingIndex = $index;
                break;
            }
        }

        if ($existingIndex !== null) {
           
            unset($this->selectedSlots[$existingIndex]);
            $this->selectedSlots = array_values($this->selectedSlots);
        } else {
            
            $this->selectedSlots[] = [
                'jour' => $jour,
                'heureDebut' => $heureDebut,
                'heureFin' => $heureFin
            ];
        }
    }

    public function isSlotSelected($jour, $heureDebut)
    {
        foreach ($this->selectedSlots as $slot) {
            if ($slot['jour'] === $jour && $slot['heureDebut'] === $heureDebut) {
                return true;
            }
        }
        return false;
    }

    public function nextStep()
    {
        $validated = match($this->currentStep) {
            1 => $this->validateStep1(),
            2 => $this->validateStep2(),
            3 => $this->validateStep3(),
            4 => $this->validateStep4(),
            default => true,
        };

        if ($validated && $this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

  private function validateStep1()
{
    $this->validate([
        'selectedService' => 'required|exists:services,idService', 
    ], [
        'selectedService.required' => 'Veuillez sélectionner un service',
    ]);
    return true;
}

    private function validateStep2()
    {
        $this->validate([
            'dateDebut' => 'required|date|after_or_equal:today',
            'dateFin' => 'required|date|after_or_equal:dateDebut',
            'selectedSlots' => 'required|array|min:1',
        ], [
            'dateDebut.required' => 'La date de début est requise',
            'dateFin.required' => 'La date de fin est requise',
            'selectedSlots.required' => 'Sélectionnez au moins un créneau',
        ]);
        return true;
    }

    private function validateStep3()
    {
        $this->validate([
            'adresseComplete' => 'required|string|min:5',
            'ville' => 'required|string|min:2',
        ], [
            'adresseComplete.required' => 'L\'adresse complète est requise',
            'ville.required' => 'La ville est requise',
        ]);
        return true;
    }

    private function validateStep4()
    {
        $this->validate([
            'animals' => 'required|array|min:1',
            'animals.*.nomAnimal' => 'required|string|min:1',
            'animals.*.espece' => 'required|string|min:1',
            'animals.*.race' => 'required|string|min:1',
            'animals.*.age' => 'required|integer|min:0',
        ], [
            'animals.required' => 'Ajoutez au moins un animal',
            'animals.*.nomAnimal.required' => 'Le nom de l\'animal est requis',
            'animals.*.espece.required' => 'Le type d\'animal est requis',
            'animals.*.race.required' => 'La race est requise',
            'animals.*.age.required' => 'L\'âge est requis',
        ]);
        return true;
    }

    public function addAnimal()
    {
        $this->animals[] = [
            'nomAnimal' => '',
            'espece' => '',
            'race' => '',
            'age' => '',
            'sexe' => 'M',
            'poids' => 0,
            'taille' => 0,
            'note_comportementale' => '',
            'statutVaccination' => 'ONCE',
        ];
    }

    public function removeAnimal($index)
    {
        unset($this->animals[$index]);
        $this->animals = array_values($this->animals);
    }

    public function submitForm()
{
    $this->validateStep4();
 DB::statement('PRAGMA foreign_keys = OFF;');
    DB::beginTransaction(); // ← AJOUT 1

    try {
        
        $service = Service::find($this->selectedService);
        
        if (!$service) {
            throw new \Exception('Service non trouvé');
        }

        
        

$idIntervenant = $service->idIntervenant ?? 5;       
        $demande = DemandesIntervention::create([
            'dateDemande' => now()->format('Y-m-d'),
            'dateSouhaitee' => $this->dateDebut,
            'heureDebut' => $this->selectedSlots[0]['heureDebut'] ?? '09:00',
            'heureFin' => $this->selectedSlots[0]['heureFin'] ?? '18:00',
            'statut' => 'en_attente',
            'lieu' => $this->adresseComplete,
            'note_speciales' => 'Demande créée via formulaire de réservation',
            'idClient' => auth()->id() ?? 1,
            'idIntervenant' => $idIntervenant,
            'idService' => $this->selectedService,
        ]);

        
        Localisation::create([
            'adresse' => $this->adresseComplete,
            'ville' => $this->ville,
            'latitude' => 0.0, 
            'longitude' => 0.0, 
            'idUser' => auth()->id() ?? 1,
        ]);

        
        foreach ($this->animals as $animal) {
            Animal::create([
                'idDemande' => $demande->idDemande,
                'nomAnimal' => $animal['nomAnimal'],
                'espece' => $animal['espece'],
                'race' => $animal['race'],
                'age' => $animal['age'],
                'sexe' => $animal['sexe'] ?? 'M',
                'poids' => $animal['poids'] ?? 0,
                'taille' => $animal['taille'] ?? '',
                'note_comportementale' => $animal['note_comportementale'] ?? '',
                'statutVaccination' => $animal['statutVaccination'] ?? 'ONCE',
            ]);
        }

        DB::commit(); 

        session()->flash('success', 'Votre demande a été soumise avec succès !');
        
        
        $this->reset(['animals', 'selectedService', 'dateDebut', 'dateFin', 'selectedSlots', 'adresseComplete', 'ville']);
        $this->currentStep = 1;

    } catch (\Exception $e) {
        DB::rollBack(); // ← AJOUT 3
        session()->flash('error', 'Erreur lors de la soumission : ' . $e->getMessage());
        Log::error('Erreur booking: ' . $e->getMessage()); // ← AJOUT 4
    }
}

    public function render()
{
    return view('livewire.pet-keeping.petkeeper-booking', [
        'totalSteps' => $this->totalSteps,
        'currentStep' => $this->currentStep,
        'services' => $this->services,
        'selectedService' => $this->selectedService,
        'intervenantDetails' => $this->intervenantDetails, // ✅ AJOUTEZ CETTE LIGNE
        'dateDebut' => $this->dateDebut,
        'dateFin' => $this->dateFin,
        'selectedSlots' => $this->selectedSlots,
        'availableDays' => $this->availableDays,
        'adresseComplete' => $this->adresseComplete,
        'ville' => $this->ville,
        'animals' => $this->animals,
        'animalTypes' => $this->animalTypes,
    ])->layout('components.layouts.app');  // ✅ Changez ici
}}