<?php

namespace App\Livewire\PetKeeping;

use App\Constants\PetKeeping\Constants;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use Livewire\Component;

class PetKeepingServiceBooking extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $totalSteps = 4;
    
    public $petkeepingId;
    public $serviceId;
    public $intervenantId;
    public $clientId;

    public $result;
    
    // Étape 1: Infos Client
    public $nom = '';
    public $prenom = '';
    public $email = '';
    public $telephone = '';
    public $ville = '';
    public $adresse = '';
    
    // Étape 2: Dates et Créneaux  
    public $dateDebut;
    public $dateFin;
    public $selectedSlots = [];
    public $availableSlotsByDate = [];
    
    // Étape 3: Animaux
    public $animals = [];
    public $existingAnimals = [];
    public $editingAnimalIndex = null;
    public $animalTypes = ['Chien', 'Chat', 'Oiseau', 'Lapin', 'Hamster', 'Poisson', 'Reptile'];
    public $racesByType = [];
    public $vaccinationCertificates = [];
    
    // Détails
    public $serviceDetails = [];
    public $intervenantDetails = [];
    public $tarifHoraire = 0;
    public $prixTotal = 0;
    public $prixDetails = [];
    public $payment_criteria = '';




    

    protected $rules = [
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|email',
        'telephone' => 'required|string',
        'ville' => 'required|string',
        'adresse' => 'required|string',
        'dateDebut' => 'required|date',
        'dateFin' => 'required|date|after_or_equal:dateDebut',
        'animals.*.nomAnimal' => 'required|string',
        'animals.*.espece' => 'required|string',
        'animals.*.race' => 'required|string',
        'animals.*.age' => 'required|numeric',
        'animals.*.sexe' => 'required|string',
        'animals.*.poids' => 'required|numeric',
        'animals.*.taille' => 'required|string',
        'animals.*.statutVaccination' => 'required|string',
    ];

    public function mount($IdService)
    {
        $this->petkeepingId = $IdService;
        
        $this->loadServiceWithPetkeeping();
        
        if (Auth::check()) {
            $user = Auth::user();
            $this->clientId = $user->idUser;
            $this->nom = $user->nom;
            $this->prenom = $user->prenom;
            $this->email = $user->email;
            $this->telephone = $user->telephone;
            
            $this->loadClientLocation();
            
            $this->loadExistingAnimals();
        }
        
        $this->loadRacesByType();
        
        if (empty($this->animals)) {
            $this->addAnimal();
        }
    }

    private function loadServiceWithPetkeeping()
    {
        $result = DB::table('petkeeping')
            ->join('services', 'petkeeping.idPetKeeping', '=', 'services.idService')
            ->join('petkeepers', 'petkeeping.idPetKeeper', '=', 'petkeepers.idPetKeeper')
            ->join('intervenants', 'petkeepers.idPetKeeper', '=', 'intervenants.idIntervenant')
            ->join('utilisateurs', 'intervenants.idIntervenant', '=', 'utilisateurs.idUser')
            ->leftJoin('localisations', 'utilisateurs.idUser', '=', 'localisations.idUser')
            ->where('petkeeping.idPetKeeping', $this->petkeepingId)
            ->select(
                'petkeeping.*',
                'services.idService',
                'services.nomService',
                'services.description',
                'petkeepers.idPetKeeper',
                'utilisateurs.nom',
                'utilisateurs.prenom',
                'utilisateurs.photo',
                'utilisateurs.note',
                'utilisateurs.nbrAvis',
                'utilisateurs.email',
                'localisations.ville as intervenant_ville'
            )
            ->first();

        $this->payment_criteria = $result->payment_criteria;

        if (!$result) {
            abort(404, 'Service non trouvé');
        }

        $this->serviceId = $result->idService;
        $this->intervenantId = $result->idPetKeeper;
        
        $this->serviceDetails = [
            'nom' => $result->nomService,
            'description' => $result->description,
        ];
        
        $this->intervenantDetails = [
            'nom_complet' => $result->prenom . ' ' . $result->nom,
            'email' => $result->email,
            'photo' => $result->photo,
            'note' => $result->note ?? 4.9,
            'nbrAvis' => $result->nbrAvis ?? 156,
            'ville' => $result->intervenant_ville,
        ];
        
        $this->tarifHoraire = $result->base_price ?? 100;
    }

    private function loadClientLocation()
    {
        $location = DB::table('localisations')
            ->where('idUser', $this->clientId)
            ->first();
            
        if ($location) {
            $this->ville = $location->ville ?? '';
            $this->adresse = $location->adresse ?? '';
        }
    }

    private function loadExistingAnimals()
    {
        $this->existingAnimals = DB::table('animals')
            ->where('idClient', $this->clientId)
            ->select('animals.*')
            ->distinct()
            ->get()
            ->toArray();
    }

    private function loadRacesByType()
    {
        $this->racesByType = [
            'Chien' => ['Labrador', 'Golden Retriever', 'Berger Allemand', 'Bulldog', 'Beagle', 'Chihuahua', 'Husky', 'Boxer', 'Caniche', 'Autre'],
            'Chat' => ['Persan', 'Siamois', 'Maine Coon', 'British Shorthair', 'Ragdoll', 'Bengale', 'Sphynx', 'Européen', 'Autre'],
            'Oiseau' => ['Perroquet', 'Perruche', 'Canari', 'Inséparable', 'Cacatoès', 'Autre'],
            'Lapin' => ['Lapin Nain', 'Lapin Bélier', 'Lapin Rex', 'Autre'],
            'Hamster' => ['Hamster Doré', 'Hamster Russe', 'Hamster Roborovski', 'Autre'],
            'Poisson' => ['Poisson Rouge', 'Betta', 'Guppy', 'Poisson Clown', 'Autre'],
            'Reptile' => ['Tortue', 'Serpent', 'Lézard', 'Gecko', 'Iguane', 'Autre'],
        ];
    }

   

    public function updatedDateDebut()
    {
        if ($this->dateDebut && $this->dateFin) {
            $this->generateAvailableSlots();
        }
    }

    public function updatedDateFin()
    {
        if ($this->dateDebut && $this->dateFin) {
            $this->generateAvailableSlots();
        }
    }

    private function generateAvailableSlots()
    {
        $this->availableSlotsByDate = [];
        
        $reservedSlots = DB::table('demandes_intervention')
            ->where('idIntervenant', $this->intervenantId)
            ->whereIn('statut', ['validée', 'en_attente'])
            ->whereBetween('dateSouhaitee', [$this->dateDebut, $this->dateFin])
            ->select('dateSouhaitee', 'heureDebut', 'heureFin')
            ->get()
            ->toArray();
        
        $start = Carbon::parse($this->dateDebut);
        $end = Carbon::parse($this->dateFin);
        
        while ($start->lte($end)) {
            $dateString = $start->format('Y-m-d');
            $jourSemaine = $start->locale('fr')->dayName;
            
            $disponibilites = DB::table('disponibilites')
                ->where('idIntervenant', $this->intervenantId)
                ->where('jourSemaine', $jourSemaine)
                ->get();
            
            if ($disponibilites->isEmpty()) {
                $start->addDay();
                continue;
            }
            
            $slots = [];
            
            foreach ($disponibilites as $dispo) {
                $heureDebut = Carbon::parse($dispo->heureDebut);
                $heureFin = Carbon::parse($dispo->heureFin);
                
                while ($heureDebut->lt($heureFin)) {
                    $slotStart = $heureDebut->format('H:i');
                    $slotEnd = $heureDebut->copy()->addHour()->format('H:i');
                    
                    $isReserved = false;
                    foreach ($reservedSlots as $reserved) {
                        if ($reserved->dateSouhaitee == $dateString && $reserved->heureDebut && $reserved->heureFin) {
                            $reservedStart = Carbon::parse($reserved->heureDebut)->format('H:i');
                            $reservedEnd = Carbon::parse($reserved->heureFin)->format('H:i');
                            
                            if (($slotStart >= $reservedStart && $slotStart < $reservedEnd) ||
                                ($slotEnd > $reservedStart && $slotEnd <= $reservedEnd) ||
                                ($slotStart <= $reservedStart && $slotEnd >= $reservedEnd)) {
                                $isReserved = true;
                                break;
                            }
                        }
                    }
                    
                    if (!$isReserved && $slotEnd <= $heureFin->format('H:i')) {
                        $slots[] = [
                            'heureDebut' => $slotStart,
                            'heureFin' => $slotEnd,
                        ];
                    }
                    
                    $heureDebut->addHour();
                }
            }
            
            if (!empty($slots)) {
                $this->availableSlotsByDate[] = [
                    'date' => $dateString,
                    'jour' => ucfirst($jourSemaine) . ' ' . $start->format('d/m/Y'),
                    'slots' => $slots,
                ];
            }
            
            $start->addDay();
        }
        
        $this->calculatePrice();
    }

    public function toggleSlot($date, $heureDebut, $heureFin)
    {
        $slotKey = $date . '_' . $heureDebut;
        
        $existingIndex = null;
        foreach ($this->selectedSlots as $index => $slot) {
            if ($slot['date'] == $date && $slot['heureDebut'] == $heureDebut) {
                $existingIndex = $index;
                break;
            }
        }
        
        if ($existingIndex !== null) {
            unset($this->selectedSlots[$existingIndex]);
            $this->selectedSlots = array_values($this->selectedSlots);
        } else {
            $this->selectedSlots[] = [
                'date' => $date,
                'heureDebut' => $heureDebut,
                'heureFin' => $heureFin,
            ];
        }
        
        $this->calculatePrice();
    }

    public function isSlotSelected($date, $heureDebut)
    {
        foreach ($this->selectedSlots as $slot) {
            if ($slot['date'] == $date && $slot['heureDebut'] == $heureDebut) {
                return true;
            }
        }
        return false;
    }

    private function calculatePrice()
    {
        switch ($this->payment_criteria) {
            case 'PER_HOUR':
            case 'par heure':
                $totalHeures = count($this->selectedSlots);
                $this->prixTotal = $totalHeures * $this->tarifHoraire;
                $this->prixDetails = [
                    'critere' => 'Par heure',
                    'tarif_horaire' => $this->tarifHoraire,
                    'heures' => $totalHeures,
                    'total' => $this->prixTotal,
                ];
                break;
                
            case 'PER_DAY':
            case 'par jour':
                $dates = array_unique(array_column($this->selectedSlots, 'date'));
                $totalJours = count($dates);
                $this->prixTotal = $totalJours * $this->tarifHoraire;
                $this->prixDetails = [
                    'critere' => 'Par jour',
                    'tarif_journalier' => $this->tarifHoraire,
                    'jours' => $totalJours,
                    'total' => $this->prixTotal,
                ];
                break;
                
            case 'PER_PET':
            case 'par animal':
                $totalAnimaux = count($this->animals);
                $dates = array_unique(array_column($this->selectedSlots, 'date'));
                $totalJours = count($dates);
                $this->prixTotal = $totalAnimaux * $this->tarifHoraire * $totalJours;
                $this->prixDetails = [
                    'critere' => 'Par animal',
                    'tarif_par_animal' => $this->tarifHoraire,
                    'animaux' => $totalAnimaux,
                    'jours' => $totalJours,
                    'total' => $this->prixTotal,
                ];
                break;
                
            case 'PER_VISIT':
            case 'par visite':
                $totalVisites = count($this->selectedSlots);
                $this->prixTotal = $totalVisites * $this->tarifHoraire;
                $this->prixDetails = [
                    'critere' => 'Par visite',
                    'tarif_par_visite' => $this->tarifHoraire,
                    'visites' => $totalVisites,
                    'total' => $this->prixTotal,
                ];
                break;
                
            default:
                // Default to fixed price
                $this->prixTotal = $this->tarifHoraire;
                $this->prixDetails = [
                    'critere' => 'Prix fixe',
                    'tarif' => $this->tarifHoraire,
                    'total' => $this->prixTotal,
                ];
                break;
        }
    }

    public function addAnimal()
    {
        $this->animals[] = [
            'nomAnimal' => '',
            'espece' => '',
            'race' => '',
            'age' => '',
            'sexe' => 'M',
            'poids' => '',
            'taille' => '',
            'note_comportementale' => '',
            'statutVaccination' => 'Non',
        ];
    }

    public function removeAnimal($index)
    {
        unset($this->animals[$index]);
        $this->animals = array_values($this->animals);
    }

    public function loadExistingAnimal($index, $animalId)
    {
        foreach ($this->existingAnimals as $animal) {
            if ($animal->idAnimale == $animalId) {
                $this->animals[$index] = [
                    'idAnimale' => $animal->idAnimale,
                    'nomAnimal' => $animal->nomAnimal,
                    'espece' => $animal->espece,
                    'race' => $animal->race,
                    'age' => $animal->age,
                    'sexe' => $animal->sexe,
                    'poids' => $animal->poids,
                    'taille' => $animal->taille ?? '',
                    'note_comportementale' => $animal->note_comportementale ?? '',
                    'statutVaccination' => $animal->statutVaccination ?? 'Non',
                    'existing' => true,
                ];
                break;
            }
        }
    }

    public function editAnimal($index)
    {
        $this->editingAnimalIndex = $index;
    }

    public function cancelEdit()
    {
        $this->editingAnimalIndex = null;
    }

    public function nextStep()
    {
        $this->validateCurrentStep();
        
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    private function validateCurrentStep()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'nom' => 'required',
                'prenom' => 'required',
                'email' => 'required|email',
                'telephone' => 'required',
                'ville' => 'required',
                'adresse' => 'required',
            ]);
        }
        
        if ($this->currentStep == 2) {
            if (empty($this->selectedSlots)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'selectedSlots' => 'Veuillez sélectionner au moins un créneau horaire'
                ]);
            }
        }
        
        if ($this->currentStep == 3) {
            if (empty($this->animals)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'animals' => 'Veuillez ajouter au moins un animal'
                ]);
            }
            
            foreach ($this->animals as $index => $animal) {
                $this->validate([
                    "animals.$index.nomAnimal" => 'required',
                    "animals.$index.espece" => 'required',
                    "animals.$index.race" => 'required',
                    "animals.$index.age" => 'required',
                ]);
            }
        }
    }

    public function submitBooking()
    {
        //$this->validateCurrentStep();
        
        DB::beginTransaction();
        
        try {
            $creneauxJson = json_encode($this->selectedSlots);
            
            // Prendre le premier créneau pour dateDebut/dateFin de la demande principale
            $firstSlot = $this->selectedSlots[0];
            $lastSlot = $this->selectedSlots[count($this->selectedSlots) - 1];

            
            $demandeId = DB::table('demandes_intervention')->insertGetId([
                'dateDemande' => now(),
                'dateSouhaitee' => $firstSlot['date'],
                'heureDebut' => $firstSlot['heureDebut'] . ':00',
                'heureFin' => $lastSlot['heureFin'] . ':00',
                'statut' => 'en_attente',
                'lieu' => $this->ville . ', ' . $this->adresse,
                'note_speciales' => $creneauxJson,
                'idClient' => $this->clientId,
                'idIntervenant' => $this->intervenantId,
                'idService' => $this->serviceId,
            ]);

            foreach ($this->animals as $animalData) {
                if (isset($animalData['existing']) && $animalData['existing']) {
                    DB::table('animal_demande')->insert([
                        'idDemande' => $demandeId,
                        'idAnimal' => $animalData['idAnimale'],
                    ]);
                } else {
                    $animalId = DB::table('animals')->insertGetId([
                        'nomAnimal' => $animalData['nomAnimal'],
                        'espece' => $animalData['espece'],
                        'race' => $animalData['race'],
                        'age' => $animalData['age'],
                        'sexe' => $animalData['sexe'],
                        'poids' => $animalData['poids'],
                        'taille' => $animalData['taille'] ?? null,
                        'note_comportementale' => $animalData['note_comportementale'] ?? null,
                        'statutVaccination' => $animalData['statutVaccination'] ?? 'Non',
                        'idClient' => $this->clientId, 
                    ]);
                    
                    DB::table('animal_demande')->insert([
                        'idDemande' => $demandeId,
                        'idAnimal' => $animalId,
                    ]);
                }
            }

            $numFacture = intval(date('Ymd') . str_pad($demandeId, 6, '0', STR_PAD_LEFT));

            DB::table('factures')->insert([
                'montantTotal' => $this->prixTotal,
                'numFacture' => $numFacture,
                'idDemande' => $demandeId,
            ]);

            DB::table('localisations')->updateOrInsert(
                ['idUser' => $this->clientId],
                [
                    'ville' => $this->ville,
                    'adresse' => $this->adresse,
                    'latitude' => 0,
                    'longitude' => 0,
                    'updated_at' => now(),
                ]
            );

            DB::commit();

            session()->flash('success', 'Votre demande a été envoyée avec succès !');
           
            $this->sendIntervenantNotification($demandeId);

            
            return redirect()->route('pet-keeping.search-service');

        } catch (\Exception $e) {
            // DB::rollBack();
            // session()->flash('error', 'Une erreur est survenue : ' . $e->getMessage());

             DB::rollBack();

            dd(
                $e->getMessage(),
                $e->getTraceAsString()
            );
        }
    }


    private function sendIntervenantNotification($demandeId)
    {
        try {
            $intervenantEmail = $this->intervenantDetails['email'];
            $intervenantNom = $this->intervenantDetails['nom_complet'];
            $serviceName = $this->serviceDetails['nom'];
            $clientName = $this->prenom . ' ' . $this->nom;
            
            Mail::send('emails.nouvelle-demande', [
                'intervenantNom' => $intervenantNom,
                'serviceName' => $serviceName,
                'clientName' => $clientName,
                'demandeId' => $demandeId,
                'dateDebut' => $this->selectedSlots[0]['date'],
                'nombreCreneaux' => count($this->selectedSlots),
                'nombreAnimaux' => count($this->animals),
                'montantTotal' => $this->prixTotal,
            ], function ($message) use ($intervenantEmail, $serviceName) {
                $message->to($intervenantEmail)
                        ->subject('Nouvelle demande de réservation - ' . $serviceName);
            });
        } catch (\Exception $e) {
            Log::error('Erreur envoi email intervenant: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.pet-keeping.pet-keeping-service-booking');
    }
}
