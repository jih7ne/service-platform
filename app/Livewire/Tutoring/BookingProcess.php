<?php

namespace App\Livewire\Tutoring;

use Livewire\Component;
use App\Models\SoutienScolaire\ServiceProf;
use App\Models\SoutienScolaire\Professeur;
use App\Models\Shared\DemandesIntervention;
use App\Models\SoutienScolaire\DemandeProf;
use App\Models\Shared\Disponibilite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingProcess extends Component
{
    // Étape actuelle
    public $currentStep = 1;

    // Données du service
    public $serviceId;
    public $service;
    public $professeur;

    // Étape 1 : Détails
    public $noteSpeciales = '';
    public $typeService = 'enligne'; // 'enligne' ou 'domicile'

    // Étape 2 : Disponibilité
    public $selectedDate;
    public $selectedTimeSlots = [];
    public $disponibilites = [];
    public $availableSlots = [];

    // Étape 3 : Confirmation
    public $montantTotal = 0;
    public $nombreHeures = 0;
    public $ville = '';
    public $adresse = '';

    protected $rules = [
        'typeService' => 'required|in:enligne,domicile',
        'selectedDate' => 'required|date|after_or_equal:today',
        'selectedTimeSlots' => 'required|array|min:1',
        'ville' => 'required_if:typeService,domicile|string|max:100',
        'adresse' => 'required_if:typeService,domicile|string|max:255',
    ];


    public function mount($service)
    {
        $this->serviceId = $service;
        $this->loadServiceDetails();
    }

    private function loadServiceDetails()
    {
        $this->service = ServiceProf::with(['professeur.intervenant.user', 'matiere', 'niveau'])
            ->findOrFail($this->serviceId);

        $this->professeur = DB::table('professeurs')
            ->join('intervenants', 'professeurs.intervenant_id', '=', 'intervenants.IdIntervenant')
            ->join('utilisateurs', 'intervenants.IdIntervenant', '=', 'utilisateurs.idUser')
            ->select(
                'professeurs.*',
                'utilisateurs.nom',
                'utilisateurs.prenom',
                'utilisateurs.photo',
                'utilisateurs.note',
                'intervenants.IdIntervenant as intervenant_id'
            )
            ->where('professeurs.id_professeur', $this->service->professeur_id)
            ->first();

        // Charger les disponibilités du professeur
        $this->loadDisponibilites();
    }

    private function loadDisponibilites()
    {
        $this->disponibilites = Disponibilite::where('idIntervenant', $this->professeur->intervenant_id)
            ->where(function($query) {
                $query->where('est_reccurent', true)
                      ->orWhere('date_specifique', '>=', now()->format('Y-m-d'));
            })
            ->get();
    }

    public function nextStep()
    {
        if ($this->currentStep === 1) {
            $this->validate([
                'typeService' => 'required|in:enligne,domicile',
            ]);
            $this->currentStep = 2;
        } elseif ($this->currentStep === 2) {
            $this->validate([
                'selectedDate' => 'required|date|after_or_equal:today',
                'selectedTimeSlots' => 'required|array|min:1',
            ]);
            $this->calculateTotal();
            $this->currentStep = 3;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
        $this->selectedTimeSlots = [];
        $this->loadAvailableSlotsForDate($date);
    }

    private function loadAvailableSlotsForDate($date)
    {
        $carbonDate = Carbon::parse($date);
        $jourSemaine = $this->getJourSemaine($carbonDate->dayOfWeek);

        // Récupérer les disponibilités pour ce jour
        $dispos = $this->disponibilites->filter(function($dispo) use ($jourSemaine, $date) {
            if ($dispo->est_reccurent && $dispo->jourSemaine === $jourSemaine) {
                return true;
            }
            if ($dispo->date_specifique === $date) {
                return true;
            }
            return false;
        });

        // Générer des créneaux d'une heure
        $this->availableSlots = [];
        foreach ($dispos as $dispo) {
            $start = Carbon::parse($dispo->heureDebut);
            $end = Carbon::parse($dispo->heureFin);
            
            while ($start->lt($end)) {
                $slotEnd = $start->copy()->addHour();
                if ($slotEnd->lte($end)) {
                    $this->availableSlots[] = [
                        'start' => $start->format('H:i'),
                        'end' => $slotEnd->format('H:i'),
                        'display' => $start->format('H:i') . ' - ' . $slotEnd->format('H:i')
                    ];
                }
                $start->addHour();
            }
        }
    }

    private function getJourSemaine($dayOfWeek)
    {
        $jours = [
            0 => 'Dimanche',
            1 => 'Lundi',
            2 => 'Mardi',
            3 => 'Mercredi',
            4 => 'Jeudi',
            5 => 'Vendredi',
            6 => 'Samedi'
        ];
        return $jours[$dayOfWeek];
    }

    public function toggleTimeSlot($slot)
    {
        $slotString = $slot['start'] . '-' . $slot['end'];
        
        if (in_array($slotString, $this->selectedTimeSlots)) {
            $this->selectedTimeSlots = array_filter($this->selectedTimeSlots, function($s) use ($slotString) {
                return $s !== $slotString;
            });
        } else {
            $this->selectedTimeSlots[] = $slotString;
        }

        $this->selectedTimeSlots = array_values($this->selectedTimeSlots);
    }

    public function removeTimeSlot($slot)
    {
        $this->selectedTimeSlots = array_filter($this->selectedTimeSlots, function($s) use ($slot) {
            return $s !== $slot;
        });
        $this->selectedTimeSlots = array_values($this->selectedTimeSlots);
    }

    private function calculateTotal()
    {
        $this->nombreHeures = count($this->selectedTimeSlots);
        $this->montantTotal = $this->nombreHeures * $this->service->prix_par_heure;
    }

    public function submitBooking()
{
    if (!Auth::check()) {
        session()->flash('error', 'Vous devez être connecté pour réserver un cours.');
        return redirect()->route('connexion');
    }

    // Validation
    $validationRules = [
        'typeService' => 'required|in:enligne,domicile',
        'selectedDate' => 'required|date|after_or_equal:today',
        'selectedTimeSlots' => 'required|array|min:1',
    ];
    
    if ($this->typeService === 'domicile') {
        $validationRules['ville'] = 'required|string|max:100';
        $validationRules['adresse'] = 'required|string|max:255';
    }
    
    $this->validate($validationRules);

    try {
        DB::beginTransaction();

        // Créer le lieu
        $lieu = $this->typeService === 'domicile' 
            ? ($this->ville && $this->adresse ? $this->ville . ',' . $this->adresse : 'Domicile de l\'étudiant')
            : 'En ligne';

        // Créer une demande pour CHAQUE créneau horaire
        foreach ($this->selectedTimeSlots as $slot) {
            $times = explode('-', $slot);
            $heureDebut = trim($times[0]);
            $heureFin = trim($times[1]);

            // Créer la demande d'intervention
            $demande = DemandesIntervention::create([
                'dateDemande' => now(),
                'dateSouhaitee' => $this->selectedDate,
                'heureDebut' => $heureDebut,
                'heureFin' => $heureFin,
                'statut' => 'en_attente',
                'lieu' => $lieu,
                'note_speciales' => $this->noteSpeciales,
                'idIntervenant' => $this->professeur->intervenant_id,
                'idClient' => Auth::id(),
                'idService' => null
            ]);

            // Créer la demande professeur pour chaque créneau
            DemandeProf::create([
                'montant_total' => $this->service->prix_par_heure, // Prix pour 1 heure
                'service_prof_id' => $this->serviceId,
                'demande_id' => $demande->idDemande
            ]);
        }

        DB::commit();

        session()->flash('success', 'Votre demande de réservation a été envoyée avec succès !');
        return redirect()->route('professeurs.details', ['id' => $this->service->professeur_id]);

    } catch (\Exception $e) {
        DB::rollBack();
        session()->flash('error', 'Une erreur est survenue lors de la réservation : ' . $e->getMessage());
    }
}

    public function cancel()
    {
        return redirect()->route('professeurs.details', ['id' => $this->service->professeur_id]);
    }

    public function render()
    {
        return view('livewire.tutoring.booking-process', [
            'currentMonth' => now()->locale('fr')->translatedFormat('F Y'),
            'calendarDays' => $this->generateCalendar()
        ]);
    }

    private function generateCalendar()
    {
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();
        $days = [];

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $days[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->day,
                'isToday' => $date->isToday(),
                'isPast' => $date->isPast() && !$date->isToday(),
                'dayOfWeek' => $date->dayOfWeek
            ];
        }

        return $days;
    }
}