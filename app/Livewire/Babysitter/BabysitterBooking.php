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
    public $selectedDays = [];
    public $startTime = '';
    public $endTime = '';
    public $selectedDates = []; // Pour stocker les dates spécifiques sélectionnées
    public $selectedSlots = []; // Pour stocker les créneaux sélectionnés par jour
    public $currentStartTime = '';
    public $currentEndTime = '';
    public $address = '';
    public $useRegisteredAddress = false;
    public $babysitterLieuxPreference = [];
    public $babysitterAddress = '';
    public $adresseChoice = ''; // 'babysitter' ou 'client'
    public $clientAddresses = []; // Pour stocker toutes les adresses du client
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

    public function addTimeSlot()
    {
        if (!$this->currentStartTime || !$this->currentEndTime) {
            session()->flash('error', 'Veuillez remplir les heures de début et de fin');
            return;
        }
        
        // Valider que le créneau est dans les disponibilités du babysitter
        $validationMessage = $this->validateTimeSlot($this->currentStartTime, $this->currentEndTime);
        
        if ($validationMessage) {
            session()->flash('error', $validationMessage);
            return;
        }
        
        // Valider que le créneau ne chevauche pas les créneaux existants
        $overlapMessage = $this->validateNoOverlap($this->currentStartTime, $this->currentEndTime);
        
        if ($overlapMessage) {
            session()->flash('error', $overlapMessage);
            return;
        }
        
        foreach ($this->selectedDays as $day) {
            if (!isset($this->selectedSlots[$day])) {
                $this->selectedSlots[$day] = [];
            }
            
            $slot = $this->currentStartTime . '-' . $this->currentEndTime;
            
            // Vérifier si le créneau est déjà ajouté
            if (!in_array($slot, $this->selectedSlots[$day])) {
                $this->selectedSlots[$day][] = $slot;
            }
        }
        
        // Réinitialiser les champs
        $this->currentStartTime = '';
        $this->currentEndTime = '';
        
        $this->calculateTotalPrice();
    }

    public function validateNoOverlap($startTime, $endTime)
    {
        $newStartMinutes = $this->timeToMinutes($startTime);
        $newEndMinutes = $this->timeToMinutes($endTime);
        
        foreach ($this->selectedDays as $day) {
            $existingSlots = $this->selectedSlots[$day] ?? [];
            
            foreach ($existingSlots as $existingSlot) {
                [$existingStart, $existingEnd] = explode('-', $existingSlot);
                $existingStartMinutes = $this->timeToMinutes($existingStart);
                $existingEndMinutes = $this->timeToMinutes($existingEnd);
                
                // Vérifier si les créneaux se chevauchent
                if (($newStartMinutes < $existingEndMinutes && $newEndMinutes > $existingStartMinutes)) {
                    $dayName = $this->getDayName($day);
                    return "Le créneau $startTime-$endTime chevauche le créneau existant $existingSlot pour le $dayName. Les créneaux ne doivent pas se superposer.";
                }
            }
        }
        
        return null; // Pas de chevauchement
    }

    public function validateTimeSlot($startTime, $endTime)
    {
        $babysitter = $this->getBabysitter();
        
        \Log::info('validateTimeSlot called', [
            'startTime' => $startTime,
            'endTime' => $endTime,
            'selectedDays' => $this->selectedDays,
            'babysitterAvailability' => $babysitter['availability'] ?? []
        ]);
        
        // Convertir les heures en minutes pour la comparaison
        $startMinutes = $this->timeToMinutes($startTime);
        $endMinutes = $this->timeToMinutes($endTime);
        
        \Log::info('Time conversion', [
            'startMinutes' => $startMinutes,
            'endMinutes' => $endMinutes
        ]);
        
        // Vérifier que l'heure de fin est après l'heure de début
        if ($endMinutes <= $startMinutes) {
            return "L'heure de fin doit être après l'heure de début";
        }
        
        // Vérifier pour chaque jour sélectionné
        foreach ($this->selectedDays as $day) {
            $availableSlots = $babysitter['availability'][$day] ?? [];
            $isValidForDay = false;
            
            \Log::info('Checking day', [
                'day' => $day,
                'availableSlots' => $availableSlots
            ]);
            
            foreach ($availableSlots as $availableSlot) {
                [$availableStart, $availableEnd] = explode('-', $availableSlot);
                $availableStartMinutes = $this->timeToMinutes($availableStart);
                $availableEndMinutes = $this->timeToMinutes($availableEnd);
                
                \Log::info('Comparing slots', [
                    'availableSlot' => $availableSlot,
                    'availableStartMinutes' => $availableStartMinutes,
                    'availableEndMinutes' => $availableEndMinutes,
                    'newStartMinutes' => $startMinutes,
                    'newEndMinutes' => $endMinutes,
                    'condition1' => $startMinutes >= $availableStartMinutes,
                    'condition2' => $endMinutes <= $availableEndMinutes
                ]);
                
                // Vérifier si le créneau demandé est complètement dans un créneau disponible
                if ($startMinutes >= $availableStartMinutes && $endMinutes <= $availableEndMinutes) {
                    $isValidForDay = true;
                    \Log::info('Slot is valid for day', ['day' => $day]);
                    break;
                }
            }
            
            if (!$isValidForDay) {
                $dayName = $this->getDayName($day);
                \Log::info('Slot not valid for day', [
                    'day' => $day,
                    'dayName' => $dayName,
                    'availableSlots' => $availableSlots
                ]);
                return "Le créneau $startTime-$endTime n'est pas disponible pour le $dayName. Tous les créneaux non disponibles : " . implode(', ', $availableSlots);
            }
        }
        
        \Log::info('Slot is valid for all days');
        return null; // Pas d'erreur
    }

    public function timeToMinutes($time)
    {
        [$hours, $minutes] = explode(':', $time);
        return (int)$hours * 60 + (int)$minutes;
    }

    public function getDayName($dayId)
    {
        $days = [
            'lundi' => 'Lundi',
            'mardi' => 'Mardi', 
            'mercredi' => 'Mercredi',
            'jeudi' => 'Jeudi',
            'vendredi' => 'Vendredi',
            'samedi' => 'Samedi',
            'dimanche' => 'Dimanche'
        ];
        
        return $days[$dayId] ?? $dayId;
    }

    public function removeSlot($day, $slot)
    {
        if (isset($this->selectedSlots[$day])) {
            $this->selectedSlots[$day] = array_values(array_diff($this->selectedSlots[$day], [$slot]));
        }
        
        $this->calculateTotalPrice();
    }

    public function toggleSlot($day, $slot)
    {
        \Log::info('toggleSlot called', ['day' => $day, 'slot' => $slot, 'selectedSlots' => $this->selectedSlots]);
        
        if (!isset($this->selectedSlots[$day])) {
            $this->selectedSlots[$day] = [];
        }
        
        if (in_array($slot, $this->selectedSlots[$day])) {
            $this->selectedSlots[$day] = array_values(array_diff($this->selectedSlots[$day], [$slot]));
            \Log::info('Slot removed', ['day' => $day, 'slot' => $slot]);
        } else {
            $this->selectedSlots[$day][] = $slot;
            \Log::info('Slot added', ['day' => $day, 'slot' => $slot]);
        }
        
        \Log::info('Updated selectedSlots', ['selectedSlots' => $this->selectedSlots]);
        $this->calculateTotalPrice();
    }

    public function toggleDay($day)
    {
        if (in_array($day, $this->selectedDays)) {
            $this->selectedDays = array_values(array_diff($this->selectedDays, [$day]));
            // Retirer aussi la date correspondante
            unset($this->selectedDates[$day]);
        } else {
            $this->selectedDays[] = $day;
            // Ajouter la date correspondante
            $this->selectedDates[$day] = $this->getDateFromDay($day);
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
        \Log::info('nextStep() appelée', [
            'currentStep' => $this->currentStep,
            'canProceed' => $this->canProceed()
        ]);
        
        if ($this->currentStep < 5 && $this->canProceed()) {
            $this->currentStep++;
            \Log::info('Étape incrémentée', ['newStep' => $this->currentStep]);
            
            // Initialisation automatique au Step 3
            if ($this->currentStep === 3) {
                \Log::info('Initialisation étape 3');
                $babysitter = $this->getBabysitter();
                $preferencesDomicile = $babysitter['preference_domicil'] ?? '';
                
                \Log::info('Préférence domicile détectée', ['preferencesDomicile' => $preferencesDomicile]);
                
                // Si domicil_babysitter, pré-remplir automatiquement
                if ($preferencesDomicile === 'domicil_babysitter') {
                    if (isset($babysitter['utilisateur']) && $babysitter['utilisateur']->localisations) {
                        $localisation = $babysitter['utilisateur']->localisations->first();
                        $this->address = $localisation ? $localisation->adresse . ', ' . $localisation->ville : '';
                    }
                    $this->adresseChoice = 'babysitter';
                    \Log::info('Cas domicil_babysitter traité', ['address' => $this->address]);
                }
                
                // Si domicil_client, récupérer toutes les adresses du client authentifié
                if ($preferencesDomicile === 'domicil_client') {
                    $this->adresseChoice = 'client';
                    $this->clientAddresses = []; // Réinitialiser la liste d'adresses
                    
                    // Récupérer toutes les adresses du client authentifié
                    $clientId = auth()->id();
                    if ($clientId) {
                        $client = \App\Models\Shared\Utilisateur::find($clientId);
                        if ($client && $client->localisations && $client->localisations->count() > 0) {
                            $this->clientAddresses = $client->localisations->map(function($localisation) {
                                return [
                                    'id' => $localisation->idLocalisation,
                                    'adresse' => $localisation->adresse,
                                    'ville' => $localisation->ville,
                                    'adresse_complete' => $localisation->adresse . ', ' . $localisation->ville
                                ];
                            })->toArray();
                            
                            // Pré-remplir avec la première adresse
                            if (!empty($this->clientAddresses)) {
                                $firstAddress = $this->clientAddresses[0];
                                $this->address = $firstAddress['adresse_complete'];
                                \Log::info('Adresses client récupérées et première adresse pré-remplie', [
                                    'clientId' => $clientId,
                                    'totalAddresses' => count($this->clientAddresses),
                                    'selectedAddress' => $this->address
                                ]);
                            }
                        } else {
                            // Aucune adresse trouvée - permettre la saisie manuelle
                            $this->address = '';
                            \Log::info('Aucune adresse trouvée pour le client, saisie manuelle requise', [
                                'clientId' => $clientId,
                                'hasLocalisations' => $client ? ($client->localisations ? $client->localisations->count() : 0) : 0
                            ]);
                        }
                    } else {
                        $this->address = ''; // Réinitialiser si pas de client authentifié
                        \Log::warning('Aucun client authentifié trouvé pour récupérer les adresses');
                    }
                    \Log::info('Cas domicil_client traité', ['address' => $this->address, 'clientAddresses_count' => count($this->clientAddresses)]);
                }
            }
        } else {
            \Log::warning('nextStep() bloquée', [
                'currentStep' => $this->currentStep,
                'canProceed' => $this->canProceed(),
                'reason' => $this->currentStep >= 5 ? 'step >= 5' : 'canProceed() false'
            ]);
        }
    }

    public function selectClientAddress($addressIndex)
    {
        if (isset($this->clientAddresses[$addressIndex])) {
            $selectedAddress = $this->clientAddresses[$addressIndex];
            $this->address = $selectedAddress['adresse_complete'];
            \Log::info('Adresse client sélectionnée', [
                'addressIndex' => $addressIndex,
                'selectedAddress' => $this->address
            ]);
        }
    }

    public function updatedAddress()
    {
        // Permettre la modification manuelle de l'adresse
        \Log::info('Adresse modifiée manuellement', [
            'newAddress' => $this->address
        ]);
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
            
            // Récupérer l'ID du client depuis la session authentifiée
            $clientId = auth()->id();
            
            // Si aucun client n'est connecté, utiliser l'ID 1 pour les tests
            if (!$clientId) {
                $clientId = 1;
                \Log::warning('Aucun client authentifié trouvé, utilisation de l\'ID 1 pour les tests');
            } else {
                \Log::info('Client authentifié trouvé: ID ' . $clientId);
            }
            
            DB::beginTransaction();
            
            // Créer les demandes d'intervention pour chaque créneau sélectionné
            foreach ($this->selectedSlots as $day => $slots) {
                foreach ($slots as $slot) {
                    [$startTime, $endTime] = explode('-', $slot);
                    
                    $demande = DemandeIntervention::create([
                        'dateDemande' => now(),
                        'dateSouhaitee' => $this->selectedDates[$day] ?? $this->getDateFromDay($day),
                        'heureDebut' => $startTime,
                        'heureFin' => $endTime,
                        'lieu' => $this->getSelectedAddress(),
                        'note_speciales' => $this->message,
                        'idIntervenant' => $this->babysitterId,
                        'idClient' => $clientId,
                        'idService' => 2, // ID du service Babysitting
                        'statut' => 'en_attente'
                    ]);
                    
                    // Ajouter les enfants pour chaque demande
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
                        
                        // Normaliser le sexe pour la base de données
                        $sexeOriginal = $child['sexe'] ?? '';
                        $sexeNormalise = strtolower($sexeOriginal) === 'garçon' ? 'garcon' : 'fille';
                        
                        \Log::info('Traitement enfant - avant création', [
                            'sexe_original' => $sexeOriginal,
                            'sexe_normalise' => $sexeNormalise,
                            'id_client' => $clientId,
                            'child_data' => $child
                        ]);
                        
                        Enfant::create([
                            'nomComplet' => $nomComplet,
                            'dateNaissance' => $this->calculateBirthDate($child['age']),
                            'besoinsSpecifiques' => $besoinsSpecifiques,
                            'idDemande' => $demande->idDemande,
                            'id_client' => $clientId, // Stocker l'ID du client
                            'sexe' => $sexeNormalise // Stocker le sexe normalisé
                        ]);
                        
                        \Log::info('Enfant créé avec succès', [
                            'nomComplet' => $nomComplet,
                            'sexe' => $sexeNormalise,
                            'id_client' => $clientId,
                            'idDemande' => $demande->idDemande
                        ]);
                    }
                }
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
        
        $totalHours = 0;
        $numberOfChildren = max(1, count($this->children));
        
        // Calculer le nombre total d'heures pour tous les créneaux sélectionnés
        foreach ($this->selectedSlots as $day => $slots) {
            foreach ($slots as $slot) {
                [$startTime, $endTime] = explode('-', $slot);
                $start = new \DateTime($startTime);
                $end = new \DateTime($endTime);
                $interval = $start->diff($end);
                $hours = $interval->h + ($interval->i / 60);
                $totalHours += $hours;
            }
        }
        
        $this->totalPrice = $totalHours * $hourlyRate * $numberOfChildren;
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
                return count($this->selectedDays) > 0 && $this->hasSelectedSlots();
                
            case 3:
                // Log de débogage pour l'étape 3
                \Log::info('Validation étape 3 - canProceed()', [
                    'currentStep' => $this->currentStep,
                    'adresseChoice' => $this->adresseChoice,
                    'address' => $this->address,
                    'clientAddresses_count' => count($this->clientAddresses)
                ]);
                
                // Récupérer la préférence de domicile du babysitter
                $babysitter = $this->getBabysitter();
                $preferencesDomicile = $babysitter['preference_domicil'] ?? '';
                
                \Log::info('Préférence domicile babysitter', ['preferencesDomicile' => $preferencesDomicile]);
                
                // Cas 1: Si babysitter uniquement chez elle → toujours valide
                if ($preferencesDomicile === 'domicil_babysitter') {
                    \Log::info('Cas 1: babysitter uniquement chez elle - OK');
                    return true;
                }
                
                // Cas 2: Si babysitter uniquement chez client → vérifier que l'adresse est remplie
                if ($preferencesDomicile === 'domicil_client') {
                    $hasAddress = !empty($this->address);
                    \Log::info('Cas 2: babysitter uniquement chez client', ['hasAddress' => $hasAddress, 'address' => $this->address]);
                    return $hasAddress;
                }
                
                // Cas 3: Les deux options → vérifier selon le choix
                if ($preferencesDomicile === 'les_deux') {
                    // Si choix = babysitter → OK
                    if ($this->adresseChoice === 'babysitter') {
                        \Log::info('Cas 3a: les_deux + choix babysitter - OK');
                        return true;
                    }
                    // Si choix = client → vérifier adresse
                    if ($this->adresseChoice === 'client' && !empty($this->address)) {
                        \Log::info('Cas 3b: les_deux + choix client + adresse - OK');
                        return true;
                    }
                    // Si pas de choix fait encore
                    \Log::info('Cas 3c: les_deux + pas de choix/adresse - BLOQUÉ');
                    return false;
                }
                
                // Cas 4: Préférence vide/null → vérifier l'adresse ou le choix
                $canProceed = !empty($this->address) || $this->adresseChoice === 'babysitter';
                \Log::info('Cas 4: préférence vide/null', ['canProceed' => $canProceed]);
                return $canProceed;
                
            case 4:
                return count($this->children) > 0;
                
            case 5:
                return $this->agreedToTerms;
                
            default:
                return false;
        }
    }

    public function hasSelectedSlots()
    {
        foreach ($this->selectedSlots as $slots) {
            if (!empty($slots)) {
                return true;
            }
        }
        return false;
    }

    public function areTimeSlotsValid()
    {
        if (!$this->startTime || !$this->endTime || empty($this->selectedDays)) {
            return false;
        }

        $babysitter = $this->getBabysitter();
        
        foreach ($this->selectedDays as $day) {
            $availableSlots = $babysitter['availability'][$day] ?? [];

            $isValidForDay = false;
            foreach ($availableSlots as $slot) {
                [$slotStart, $slotEnd] = explode('-', $slot);
                
                $slotStartVal = (int)str_replace(':', '', $slotStart);
                $slotEndVal = (int)str_replace(':', '', $slotEnd);
                $selectedStartVal = (int)str_replace(':', '', $this->startTime);
                $selectedEndVal = (int)str_replace(':', '', $this->endTime);

                if ($selectedStartVal >= $slotStartVal && $selectedEndVal <= $slotEndVal) {
                    $isValidForDay = true;
                    break;
                }
            }
            
            if (!$isValidForDay) {
                return false;
            }
        }

        return true;
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