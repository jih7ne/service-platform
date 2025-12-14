<?php

namespace App\Livewire\Babysitter;

use Livewire\Component;
use App\Models\Babysitting\Babysitter;
use App\Models\Babysitting\Disponibilite;
use App\Models\Babysitting\DemandeIntervention;
use App\Models\Babysitting\Enfant;
use App\Models\Babysitting\Superpouvoir;
use App\Models\Babysitting\ExperienceBesoinSpeciaux;
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
    public $children = [];
    public $currentChild = ['nom' => '', 'age' => '', 'besoinsSpeciaux' => []];
    public $agreedToTerms = false;
    public $showSuccess = false;
    public $message = '';
    public $totalPrice = 0;

    protected $queryString = ['babysitterId'];

    public function mount($id = null)
    {
        $this->babysitterId = $id ?? 1;
    }

    public function toggleService($serviceName)
    {
        if (in_array($serviceName, $this->selectedServices)) {
            $this->selectedServices = array_values(array_diff($this->selectedServices, [$serviceName]));
        } else {
            $this->selectedServices[] = $serviceName;
        }
        $this->calculateTotalPrice();
    }

    public function calculateTotalPrice()
    {
        $babysitter = $this->getBabysitter();
        if (!$babysitter) {
            $this->totalPrice = 0;
            return;
        }

        // Prix de base par heure
        $basePrice = 50; // Prix par défaut
        
        // Calculer le nombre d'heures
        $totalHours = 0;
        if ($this->startTime && $this->endTime) {
            $start = new \DateTime($this->startTime);
            $end = new \DateTime($this->endTime);
            $interval = $start->diff($end);
            $totalHours = $interval->h + ($interval->i / 60);
        }

        // Calculer le prix total
        $this->totalPrice = $basePrice * $totalHours * count($this->children);
        
        // Ajouter suppléments pour services spéciaux
        $serviceSupplements = [
            'Cuisine' => 5,
            'Tâches ménagères' => 8,
            'Aide aux devoirs' => 10,
            'Faire la lecture' => 5,
            'Musique' => 7,
            'Dessin' => 5
        ];

        foreach ($this->selectedServices as $service) {
            if (isset($serviceSupplements[$service])) {
                $this->totalPrice += $serviceSupplements[$service];
            }
        }
    }

    public function addChild()
    {
        $nom = trim($this->currentChild['nom']);
        $age = trim($this->currentChild['age']);
        
        if (!empty($nom) && !empty($age) && is_numeric($age)) {
            $this->children[] = [
                'id' => time() . rand(1000, 9999),
                'nom' => $nom,
                'age' => (int)$age,
                'besoinsSpeciaux' => $this->currentChild['besoinsSpeciaux']
            ];
            $this->currentChild = ['nom' => '', 'age' => '', 'besoinsSpeciaux' => []];
            $this->calculateTotalPrice();
        }
    }

    public function removeChild($id)
    {
        $this->children = array_values(array_filter($this->children, function($child) use ($id) {
            return $child['id'] != $id;
        }));
        $this->calculateTotalPrice();
    }

    public function nextStep()
    {
        if ($this->currentStep < 5) {
            $this->currentStep++;
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
        // Validation simple
        if (empty($this->children) || !$this->agreedToTerms) {
            session()->flash('error', 'Veuillez compléter toutes les informations.');
            return;
        }
        
        try {
            // Données minimales pour éviter les blocages
            $demande = new DemandeIntervention();
            $demande->dateDemande = now();
            $demande->dateSouhaitee = now()->addDays(7);
            $demande->heureDebut = '10:00';
            $demande->heureFin = '12:00';
            $demande->lieu = 'Adresse client';
            $demande->note_speciales = $this->message ?? '';
            $demande->idIntervenant = $this->babysitterId;
            $demande->idClient = 1;
            $demande->statut = 'en_attente';
            $demande->save();
            
            // Ajouter juste le premier enfant pour tester
            if (!empty($this->children[0])) {
                $enfant = new Enfant();
                $enfant->nomComplet = $this->children[0]['nom'] ?? 'Enfant';
                $enfant->dateNaissance = now()->subYears(5);
                $enfant->besoinsSpecifiques = '[]';
                $enfant->idDemande = $demande->idDemande;
                $enfant->save();
            }
            
            session()->flash('success', 'Demande envoyée ! Prix: ' . $this->totalPrice . ' MAD');
            $this->showSuccess = true;
            
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur: ' . $e->getMessage());
        }
    }

    public function canProceed()
    {
        switch ($this->currentStep) {
            case 1:
                return count($this->selectedServices) > 0;
            case 2:
                return !empty($this->selectedDay) && !empty($this->startTime) && !empty($this->endTime) && $this->isTimeSlotValid();
            case 3:
                return $this->useRegisteredAddress || !empty($this->address);
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
                'utilisateur',
                'disponibilites',
                'superpouvoirs'
            ])->find($this->babysitterId);
            
            if (!$babysitter) {
                return null;
            }
            
            // Debug: Vérifier les relations
            \Log::info('Babysitter trouvé: ' . $babysitter->idBabysitter);
            \Log::info('Intervenant: ' . ($babysitter->intervenant ? 'OK' : 'NULL'));
            \Log::info('Utilisateur: ' . ($babysitter->utilisateur ? 'OK' : 'NULL'));
            \Log::info('Superpouvoirs count: ' . $babysitter->superpouvoirs->count());
            \Log::info('Disponibilites count: ' . $babysitter->disponibilites->count());
            
            // Récupérer les créneaux déjà réservés
            $reservedSlots = $this->getReservedSlots($babysitter->idBabysitter);
            \Log::info('Créneaux réservés: ' . json_encode($reservedSlots));
            
            // Filtrer les disponibilités pour exclure les créneaux réservés
            $availableDispos = $babysitter->disponibilites->flatMap(function($dispo) use ($reservedSlots) {
                $jour = strtolower($dispo->jourFormatted);
                $originalRange = $dispo->plageHoraire;
                
                // Récupérer les créneaux réservés pour ce jour
                $dayReservedSlots = $reservedSlots[$jour] ?? [];
                
                if (empty($dayReservedSlots)) {
                    // Pas de réservation ce jour, garder le créneau original
                    return collect([$dispo]);
                }
                
                // Diviser le créneau original en créneaux disponibles
                $availableRanges = $this->splitAvailableTime($originalRange, $dayReservedSlots);
                
                if (empty($availableRanges)) {
                    // Tout le créneau est réservé
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
                // Garder seulement les créneaux qui ne sont pas vides
                return $dispo !== null && isset($dispo->plageHoraire);
            });
            
            // Transformer les données pour compatibilité avec la vue
            return [
                'id' => $babysitter->idBabysitter,
                'nom' => $babysitter->utilisateur->nom ?? $babysitter->intervenant->nom ?? 'Nom par défaut',
                'prenom' => $babysitter->utilisateur->prenom ?? $babysitter->intervenant->prenom ?? 'Prénom par défaut',
                'photo' => $babysitter->utilisateur->photo ? \Storage::url($babysitter->utilisateur->photo) : ($babysitter->intervenant->photo ? \Storage::url($babysitter->intervenant->photo) : null),
                'rating' => 4.9,
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
        // Récupérer toutes les demandes validées pour ce babysitter
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

    private function timeRangesOverlap($range1, $range2)
    {
        [$start1, $end1] = explode('-', $range1);
        [$start2, $end2] = explode('-', $range2);
        
        // Convertir en minutes pour comparaison
        $start1Min = $this->timeToMinutes($start1);
        $end1Min = $this->timeToMinutes($end1);
        $start2Min = $this->timeToMinutes($start2);
        $end2Min = $this->timeToMinutes($end2);
        
        // Vérifier si les plages se chevauchent
        return !($end1Min <= $start2Min || $end2Min <= $start1Min);
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
        
        // Convertir les créneaux réservés en minutes
        $reservedRanges = [];
        foreach ($reservedSlots as $slot) {
            [$slotStart, $slotEnd] = explode('-', $slot);
            $reservedStart = $this->timeToMinutes($slotStart);
            $reservedEnd = $this->timeToMinutes($slotEnd);
            
            // Vérifier si ce créneau réservé chevauche notre créneau original
            if ($reservedStart < $endMin && $reservedEnd > $startMin) {
                $reservedRanges[] = [
                    'start' => max($reservedStart, $startMin),
                    'end' => min($reservedEnd, $endMin)
                ];
            }
        }
        
        // S'il n'y a pas de chevauchement, retourner le créneau original
        if (empty($reservedRanges)) {
            return [$originalRange];
        }
        
        // Trier les créneaux réservés par heure de début
        usort($reservedRanges, function($a, $b) {
            return $a['start'] - $b['start'];
        });
        
        $availableRanges = [];
        $currentStart = $startMin;
        
        foreach ($reservedRanges as $reserved) {
            // Ajouter le créneau disponible avant la réservation
            if ($reserved['start'] > $currentStart) {
                $availableRanges[] = $this->minutesToTime($currentStart) . '-' . $this->minutesToTime($reserved['start']);
            }
            
            // Mettre à jour notre position actuelle après la réservation
            $currentStart = max($currentStart, $reserved['end']);
        }
        
        // Ajouter le créneau disponible après la dernière réservation
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

    // Méthodes utilitaires
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
        try {
            return now()->next($dayName)->format('Y-m-d');
        } catch (\Exception $e) {
            // Si next() échoue, utiliser une date par défaut
            return now()->addDays(7)->format('Y-m-d');
        }
    }

    private function getSelectedAddress()
    {
        if ($this->useRegisteredAddress) {
            return "23 Rue des Fleurs, Maârif - Casablanca"; // Adresse par défaut
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
        
        // Si le babysitter n'existe pas, afficher une page d'erreur
        if (!$babysitter) {
            return view('livewire.babysitter.babysitter-booking', [
                'babysitter' => null,
                'error' => 'Babysitter non trouvé'
            ]);
        }

        // CORRECTION: Utiliser directement les noms des services de la babysitter
        $serviceData = [
            'Cuisine' => ['icon' => '🍳', 'color' => '#5B4E9E'],
            'Tâches ménagères' => ['icon' => '🧹', 'color' => '#E87548'],
            'Aide aux devoirs' => ['icon' => '📚', 'color' => '#4A9E6D'],
            'Faire la lecture' => ['icon' => '📖', 'color' => '#4A9ECF'],
            'Musique' => ['icon' => '🎵', 'color' => '#7E5BA6'],
            'Dessin' => ['icon' => '✏️', 'color' => '#E87548'],
        ];

        // Créer un tableau simple des services disponibles
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

        // Récupérer la liste des besoins spéciaux depuis la base de données
        $besoinsSpeciauxList = ExperienceBesoinSpeciaux::orderBy('experience')->get();
        
        return view('livewire.babysitter.babysitter-booking', [
            'babysitter' => $babysitter,
            'availableServices' => $availableServices,
            'daysOfWeek' => $daysOfWeek,
            'steps' => $steps,
            'besoinsSpeciauxList' => $besoinsSpeciauxList
        ]);
    }
}