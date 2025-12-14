<?php

namespace App\Livewire\Babysitter;

use Livewire\Component;
use App\Models\Babysitting\Babysitter;
use App\Models\Babysitting\Disponibilite;
use App\Models\Babysitting\DemandeIntervention;
use App\Models\Babysitting\Enfant;
use App\Models\Babysitting\Superpouvoir;
use Illuminate\Support\Facades\DB;

class BabysitterBooking extends Component
{
    public $babysitterId;
    public $currentStep = 1;
    public $selectedServices = [];
    public $selectedDay = '';
    public $startTime = '';
    public $endTime = '';
    public $address = '';
    public $useRegisteredAddress = false;
    public $babysitterLieuxPreference = [];
    public $babysitterAddress = '';
    public $adresseChoice = ''; // 'babysitter' ou 'client'
    public $children = [];
    public $currentChild = ['age' => '', 'sexe' => '', 'besoinsSpeciaux' => [], 'autresBesoins' => ''];
    public $agreedToTerms = false;
    public $showSuccess = false;
    public $message = '';
    public $totalPrice = 0;

    protected $queryString = ['babysitterId'];

    public function mount($id = null)
    {
        $this->babysitterId = $id ?? 1;
        
        // Charger les préférences du babysitter
        $babysitter = $this->getBabysitter();
        if ($babysitter && isset($babysitter['lieux_preference'])) {
            $this->babysitterLieuxPreference = is_string($babysitter['lieux_preference']) ? json_decode($babysitter['lieux_preference'], true) : $babysitter['lieux_preference'];
            $this->babysitterLieuxPreference = $this->babysitterLieuxPreference ?: [];
            
            // Récupérer l'adresse du babysitter
            if (isset($babysitter['utilisateur']) && $babysitter['utilisateur']->localisations) {
                $localisation = $babysitter['utilisateur']->localisations->first();
                $this->babysitterAddress = $localisation ? $localisation->adresse . ', ' . $localisation->ville : '';
            }
        }
    }

    public function toggleService($serviceName)
    {
        if (in_array($serviceName, $this->selectedServices)) {
            $this->selectedServices = array_values(array_diff($this->selectedServices, [$serviceName]));
        } else {
            $this->selectedServices[] = $serviceName;
        }
    }

    public function addChild()
    {
        $age = trim($this->currentChild['age']);
        $sexe = trim($this->currentChild['sexe']);
        
        if (!empty($age) && is_numeric($age) && !empty($sexe)) {
            $this->children[] = [
                'id' => time() . rand(1000, 9999),
                'age' => (int)$age,
                'sexe' => $sexe,
                'besoinsSpeciaux' => $this->currentChild['besoinsSpeciaux'] ?? [],
                'autresBesoins' => trim($this->currentChild['autresBesoins'] ?? '')
            ];
            $this->currentChild = ['age' => '', 'sexe' => '', 'besoinsSpeciaux' => [], 'autresBesoins' => ''];
        }
    }

    public function removeChild($id)
    {
        $this->children = array_values(array_filter($this->children, function($child) use ($id) {
            return $child['id'] != $id;
        }));
    }

    public function nextStep()
    {
        if ($this->currentStep < 5) {
            $this->currentStep++;
            
            // Initialisation automatique au Step 3
            if ($this->currentStep === 3) {
                $babysitter = $this->getBabysitter();
                $preferencesDomicile = $babysitter['preference_domicil'] ?? '';
                
                // Si domicil_babysitter, pré-remplir automatiquement
                if ($preferencesDomicile === 'domicil_babysitter') {
                    if (isset($babysitter['utilisateur']) && $babysitter['utilisateur']->localisations) {
                        $localisation = $babysitter['utilisateur']->localisations->first();
                        $this->address = $localisation ? $localisation->adresse . ', ' . $localisation->ville : '';
                    }
                    $this->adresseChoice = 'babysitter';
                }
                
                // Si domicil_client, pré-définir le choix
                if ($preferencesDomicile === 'domicil_client') {
                    $this->adresseChoice = 'client';
                    $this->address = ''; // Réinitialiser pour forcer la saisie
                }
            }
        }
    }

    public function prevStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function confirmBooking()
    {
        try {
            // Validation
            if (empty($this->children) || !$this->agreedToTerms) {
                session()->flash('error', 'Veuillez compléter toutes les informations.');
                return;
            }
            
            // Calculer le prix total
            $this->calculateTotalPrice();
            
            // Pour les tests, on utilise directement l'ID 1
            $clientId = auth()->id() ?? 1;
            
            DB::beginTransaction();
            
            // Créer la demande d'intervention
            $demande = DemandeIntervention::create([
                'dateDemande' => now(),
                'dateSouhaitee' => $this->getDateFromDay($this->selectedDay),
                'heureDebut' => $this->startTime,
                'heureFin' => $this->endTime,
                'lieu' => $this->getSelectedAddress(),
                'note_speciales' => $this->message,
                'idIntervenant' => $this->babysitterId,
                'idClient' => $clientId,
                'statut' => 'en_attente'
            ]);
            
            // Ajouter les enfants
            foreach ($this->children as $child) {
                $besoinsSpecifiques = '';
                if (!empty($child['besoinsSpeciaux'])) {
                    $besoinsSpecifiques = json_encode($child['besoinsSpeciaux']);
                }
                if (!empty($child['autresBesoins'])) {
                    $besoinsSpecifiques .= ($besoinsSpecifiques ? ', ' : '') . $child['autresBesoins'];
                }
                
                // Créer un nom fictif basé sur le sexe et l'âge
                $nomComplet = ($child['sexe'] === 'Garçon' ? 'Garçon' : 'Fille') . ' de ' . $child['age'] . ' ans';
                
                Enfant::create([
                    'nomComplet' => $nomComplet,
                    'dateNaissance' => $this->calculateBirthDate($child['age']),
                    'besoinsSpecifiques' => $besoinsSpecifiques,
                    'idDemande' => $demande->idDemande
                ]);
            }
            
            DB::commit();
            $this->showSuccess = true;
            
            session()->flash('success', 'Votre demande de réservation a été envoyée avec succès ! Prix total: ' . $this->totalPrice . ' MAD');
            
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Une erreur est survenue lors de la réservation. Veuillez réessayer.');
            \Log::error('Erreur lors de la réservation: ' . $e->getMessage());
        }
    }
    
    public function calculateTotalPrice()
    {
        // Récupérer le babysitter pour obtenir son prix horaire
        $babysitter = $this->getBabysitter();
        $hourlyRate = 50; // Prix par défaut si non trouvé
        
        if ($babysitter && isset($babysitter['prix_horaire'])) {
            $hourlyRate = $babysitter['prix_horaire'];
        }
        
        // Calculer la durée en heures
        if ($this->startTime && $this->endTime) {
            $start = new \DateTime($this->startTime);
            $end = new \DateTime($this->endTime);
            $interval = $start->diff($end);
            $hours = $interval->h + ($interval->i / 60);
            
            $this->totalPrice = $hours * $hourlyRate * max(1, count($this->children));
        } else {
            $this->totalPrice = 0;
        }
    }
    
    public function updatedStartTime()
    {
        $this->calculateTotalPrice();
    }
    
    public function updatedEndTime()
    {
        $this->calculateTotalPrice();
    }
    
    public function updatedChildren()
    {
        $this->calculateTotalPrice();
    }

    public function canProceed()
    {
        switch ($this->currentStep) {
            case 1:
                return count($this->selectedServices) > 0;
                
            case 2:
                return !empty($this->selectedDay) && !empty($this->startTime) && !empty($this->endTime) && $this->isTimeSlotValid();
                
            case 3:
                // Récupérer la préférence de domicile du babysitter
                $babysitter = $this->getBabysitter();
                $preferencesDomicile = $babysitter['preference_domicil'] ?? '';
                
                // Cas 1: Si babysitter uniquement chez elle → toujours valide
                if ($preferencesDomicile === 'domicil_babysitter') {
                    return true;
                }
                
                // Cas 2: Si babysitter uniquement chez client → vérifier que l'adresse est remplie
                if ($preferencesDomicile === 'domicil_client') {
                    return !empty($this->address);
                }
                
                // Cas 3: Les deux options → vérifier selon le choix
                if ($preferencesDomicile === 'les_deux') {
                    // Si choix = babysitter → OK
                    if ($this->adresseChoice === 'babysitter') {
                        return true;
                    }
                    // Si choix = client → vérifier adresse
                    if ($this->adresseChoice === 'client' && !empty($this->address)) {
                        return true;
                    }
                    // Si pas de choix fait encore
                    return false;
                }
                
                // Cas 4: Préférence vide/null → vérifier l'adresse ou le choix
                return $this->useRegisteredAddress || !empty($this->address) || $this->adresseChoice === 'babysitter';
                
            case 4:
                return count($this->children) > 0;
                
            case 5:
                return $this->agreedToTerms;
                
            default:
                return false;
        }
    }

    public function isTimeSlotValid()
    {
        if (!$this->startTime || !$this->endTime || !$this->selectedDay) {
            return false;
        }

        $babysitter = $this->getBabysitter();
        $availableSlots = $babysitter['availability'][$this->selectedDay] ?? [];

        foreach ($availableSlots as $slot) {
            [$slotStart, $slotEnd] = explode('-', $slot);
            
            $slotStartVal = (int)str_replace(':', '', $slotStart);
            $slotEndVal = (int)str_replace(':', '', $slotEnd);
            $selectedStartVal = (int)str_replace(':', '', $this->startTime);
            $selectedEndVal = (int)str_replace(':', '', $this->endTime);

            if ($selectedStartVal >= $slotStartVal && $selectedEndVal <= $slotEndVal) {
                return true;
            }
        }

        return false;
    }

    private function getBabysitter()
    {
        try {
            $babysitter = Babysitter::with([
                'intervenant',
                'utilisateur.localisations',
                'disponibilites',
                'superpouvoirs',
                'categoriesEnfants', // Relation avec les catégories d'enfants acceptées
                'experiencesBesoinsSpeciaux' // Relation avec les besoins spéciaux acceptés
            ])->find($this->babysitterId);
            
            if (!$babysitter) {
                return null;
            }
            
            // Récupérer les créneaux déjà réservés
            $reservedSlots = $this->getReservedSlots($babysitter->idBabysitter);
            
            // Filtrer les disponibilités pour exclure les créneaux réservés
            $availableDispos = $babysitter->disponibilites->flatMap(function($dispo) use ($reservedSlots) {
                $jour = strtolower($dispo->jourFormatted);
                $originalRange = $dispo->plageHoraire;
                
                // Récupérer les créneaux réservés pour ce jour
                $dayReservedSlots = $reservedSlots[$jour] ?? [];
                
                if (empty($dayReservedSlots)) {
                    return collect([$dispo]);
                }
                
                // Diviser le créneau original en créneaux disponibles
                $availableRanges = $this->splitAvailableTime($originalRange, $dayReservedSlots);
                
                if (empty($availableRanges)) {
                    return collect([]);
                }
                
                // Créer de nouvelles disponibilités pour chaque créneau disponible
                $newDispos = collect([]);
                foreach ($availableRanges as $range) {
                    $newDispo = new \stdClass();
                    $newDispo->idDispo = $dispo->idDispo;
                    $newDispo->jourSemaine = $dispo->jourSemaine;
                    $newDispo->est_reccurent = $dispo->est_reccurent;
                    $newDispo->date_specifique = $dispo->date_specifique;
                    $newDispo->idIntervenant = $dispo->idIntervenant;
                    $newDispo->plageHoraire = $range;
                    $newDispo->heureDebut = \Carbon\Carbon::createFromFormat('H:i', explode('-', $range)[0]);
                    $newDispo->heureFin = \Carbon\Carbon::createFromFormat('H:i', explode('-', $range)[1]);
                    $newDispo->jourFormatted = $dispo->jourFormatted;
                    $newDispos->push($newDispo);
                }
                
                return $newDispos;
            })->filter(function($dispo) {
                return $dispo !== null && isset($dispo->plageHoraire);
            });
            
            // Transformer les données pour compatibilité avec la vue
            return [
                'id' => $babysitter->idBabysitter,
                'nom' => $babysitter->utilisateur->nom ?? $babysitter->intervenant->nom ?? 'Nom par défaut',
                'prenom' => $babysitter->utilisateur->prenom ?? $babysitter->intervenant->prenom ?? 'Prénom par défaut',
                'photo' => $babysitter->utilisateur->photo ? \Storage::url($babysitter->utilisateur->photo) : ($babysitter->intervenant->photo ? \Storage::url($babysitter->intervenant->photo) : null),
                'rating' => 4.9,
                'prix_horaire' => $babysitter->prixHeure ?? 50,
                'preference_domicil' => $babysitter->preference_domicil,
                'utilisateur' => $babysitter->utilisateur,
                'categories_enfants' => $babysitter->categoriesEnfants->pluck('categorie')->toArray(),
                'besoins_speciaux' => $babysitter->experiencesBesoinsSpeciaux->pluck('experience')->toArray(),
                'services' => $babysitter->superpouvoirs->isNotEmpty() 
                    ? $babysitter->superpouvoirs->pluck('superpouvoir')->toArray()
                    : ['Cuisine', 'Tâches ménagères', 'Aide aux devoirs'],
                'availability' => $this->formatDisponibilites($availableDispos)
            ];
        } catch (\Exception $e) {
            \Log::error('Erreur getBabysitter: ' . $e->getMessage());
            return null;
        }
    }

    private function getReservedSlots($babysitterId)
    {
        $validatedDemands = DemandeIntervention::where('idIntervenant', $babysitterId)
            ->where('statut', 'validee')
            ->where('dateSouhaitee', '>=', now()->format('Y-m-d'))
            ->get();

        $reservedSlots = [];
        
        foreach ($validatedDemands as $demand) {
            $dayName = strtolower(date('l', strtotime($demand->dateSouhaitee)));
            $dayMap = [
                'monday' => 'lundi',
                'tuesday' => 'mardi',
                'wednesday' => 'mercredi',
                'thursday' => 'jeudi',
                'friday' => 'vendredi',
                'saturday' => 'samedi',
                'sunday' => 'dimanche'
            ];
            
            $jour = $dayMap[$dayName] ?? 'lundi';
            $plage = $demand->heureDebut->format('H:i') . '-' . $demand->heureFin->format('H:i');
            
            if (!isset($reservedSlots[$jour])) {
                $reservedSlots[$jour] = [];
            }
            $reservedSlots[$jour][] = $plage;
        }
        
        return $reservedSlots;
    }

    private function timeToMinutes($time)
    {
        [$hours, $minutes] = explode(':', $time);
        return $hours * 60 + $minutes;
    }

    private function splitAvailableTime($originalRange, $reservedSlots)
    {
        [$start, $end] = explode('-', $originalRange);
        $startMin = $this->timeToMinutes($start);
        $endMin = $this->timeToMinutes($end);
        
        $reservedRanges = [];
        foreach ($reservedSlots as $slot) {
            [$slotStart, $slotEnd] = explode('-', $slot);
            $reservedStart = $this->timeToMinutes($slotStart);
            $reservedEnd = $this->timeToMinutes($slotEnd);
            
            if ($reservedStart < $endMin && $reservedEnd > $startMin) {
                $reservedRanges[] = [
                    'start' => max($reservedStart, $startMin),
                    'end' => min($reservedEnd, $endMin)
                ];
            }
        }
        
        if (empty($reservedRanges)) {
            return [$originalRange];
        }
        
        usort($reservedRanges, function($a, $b) {
            return $a['start'] - $b['start'];
        });
        
        $availableRanges = [];
        $currentStart = $startMin;
        
        foreach ($reservedRanges as $reserved) {
            if ($reserved['start'] > $currentStart) {
                $availableRanges[] = $this->minutesToTime($currentStart) . '-' . $this->minutesToTime($reserved['start']);
            }
            $currentStart = max($currentStart, $reserved['end']);
        }
        
        if ($currentStart < $endMin) {
            $availableRanges[] = $this->minutesToTime($currentStart) . '-' . $this->minutesToTime($endMin);
        }
        
        return $availableRanges;
    }

    private function minutesToTime($minutes)
    {
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;
        return sprintf('%02d:%02d', $hours, $mins);
    }

    private function formatDisponibilites($disponibilites)
    {
        $formatted = [];
        foreach ($disponibilites as $dispo) {
            $jour = strtolower($dispo->jourFormatted);
            if (!isset($formatted[$jour])) {
                $formatted[$jour] = [];
            }
            $formatted[$jour][] = $dispo->plageHoraire;
        }
        return $formatted;
    }

    private function getDateFromDay($day)
    {
        $daysMap = [
            'lundi' => 'Monday',
            'mardi' => 'Tuesday', 
            'mercredi' => 'Wednesday',
            'jeudi' => 'Thursday',
            'vendredi' => 'Friday',
            'samedi' => 'Saturday',
            'dimanche' => 'Sunday'
        ];
        
        $dayName = $daysMap[$day] ?? 'Monday';
        return now()->next($dayName)->format('Y-m-d');
    }

    private function getSelectedAddress()
    {
        if (!empty($this->address)) {
            return $this->address;
        }
        
        if ($this->adresseChoice === 'babysitter' || $this->useRegisteredAddress) {
            $babysitter = $this->getBabysitter();
            if (isset($babysitter['utilisateur']) && $babysitter['utilisateur']->localisations) {
                $localisation = $babysitter['utilisateur']->localisations->first();
                return $localisation ? $localisation->adresse . ', ' . $localisation->ville : '';
            }
            return "23 Rue des Fleurs, Maârif - Casablanca";
        }
        
        return $this->address;
    }

    private function calculateBirthDate($age)
    {
        return now()->subYears($age)->format('Y-m-d');
    }

    public function render()
    {
        $babysitter = $this->getBabysitter();
        
        if (!$babysitter) {
            return view('livewire.babysitter.babysitter-booking', [
                'babysitter' => null,
                'error' => 'Babysitter non trouvé'
            ]);
        }

        $serviceData = [
            'Cuisine' => ['icon' => '🍳', 'color' => '#5B4E9E'],
            'Tâches ménagères' => ['icon' => '🧹', 'color' => '#E87548'],
            'Aide aux devoirs' => ['icon' => '📚', 'color' => '#4A9E6D'],
            'Faire la lecture' => ['icon' => '📖', 'color' => '#4A9ECF'],
            'Musique' => ['icon' => '🎵', 'color' => '#7E5BA6'],
            'Dessin' => ['icon' => '✏️', 'color' => '#E87548'],
        ];

        $availableServices = [];
        foreach ($babysitter['services'] as $serviceName) {
            if (isset($serviceData[$serviceName])) {
                $availableServices[] = [
                    'name' => $serviceName,
                    'icon' => $serviceData[$serviceName]['icon'],
                    'color' => $serviceData[$serviceName]['color']
                ];
            }
        }

        $daysOfWeek = [
            ['id' => 'lundi', 'label' => 'Lundi'],
            ['id' => 'mardi', 'label' => 'Mardi'],
            ['id' => 'mercredi', 'label' => 'Mercredi'],
            ['id' => 'jeudi', 'label' => 'Jeudi'],
            ['id' => 'vendredi', 'label' => 'Vendredi'],
            ['id' => 'samedi', 'label' => 'Samedi'],
            ['id' => 'dimanche', 'label' => 'Dimanche']
        ];

        $steps = [
            ['number' => 1, 'label' => 'Service'],
            ['number' => 2, 'label' => 'Date & Heure'],
            ['number' => 3, 'label' => 'Lieu'],
            ['number' => 4, 'label' => 'Enfants'],
            ['number' => 5, 'label' => 'Confirmation']
        ];

        return view('livewire.babysitter.babysitter-booking', [
            'babysitter' => $babysitter,
            'availableServices' => $availableServices,
            'daysOfWeek' => $daysOfWeek,
            'steps' => $steps
        ]);
    }
}