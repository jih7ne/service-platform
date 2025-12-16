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
use App\Mail\Tutoring\SubmitBooking;
use Illuminate\Support\Facades\Mail;

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
    public $currentMonth; // Mois actuel pour la navigation

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
        $this->currentMonth = now(); // Initialiser au mois actuel
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

    public function previousMonth()
    {
        $this->currentMonth = Carbon::parse($this->currentMonth)->subMonth();
        // Réinitialiser la sélection si la date n'est plus dans le mois affiché
        if ($this->selectedDate && !Carbon::parse($this->selectedDate)->isSameMonth($this->currentMonth)) {
            $this->selectedDate = null;
            $this->selectedTimeSlots = [];
            $this->availableSlots = [];
        }
    }

    public function nextMonth()
    {
        $this->currentMonth = Carbon::parse($this->currentMonth)->addMonth();
        // Réinitialiser la sélection si la date n'est plus dans le mois affiché
        if ($this->selectedDate && !Carbon::parse($this->selectedDate)->isSameMonth($this->currentMonth)) {
            $this->selectedDate = null;
            $this->selectedTimeSlots = [];
            $this->availableSlots = [];
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
        $dateFormatted = $carbonDate->format('Y-m-d');

        // Récupérer les disponibilités pour ce jour
        $dispos = $this->disponibilites->filter(function($dispo) use ($jourSemaine, $dateFormatted) {
            // Disponibilités récurrentes
            if ($dispo->est_reccurent && $dispo->jourSemaine === $jourSemaine) {
                return true;
            }
            
            // Disponibilités ponctuelles
            // Vérifier que c'est bien une dispo ponctuelle (jourSemaine = N/A ou null ou vide)
            if (!$dispo->est_reccurent) {
                if ($dispo->jourSemaine === 'N/A' || empty($dispo->jourSemaine) || is_null($dispo->jourSemaine)) {
                    // Comparer les dates au format Y-m-d
                    $dispoDate = Carbon::parse($dispo->date_specifique)->format('Y-m-d');
                    
                    \Log::info('BookingProcess - Comparaison date ponctuelle', [
                        'date_recherchee' => $dateFormatted,
                        'date_dispo_brute' => $dispo->date_specifique,
                        'date_dispo_formatee' => $dispoDate,
                        'match' => $dispoDate === $dateFormatted
                    ]);
                    
                    return $dispoDate === $dateFormatted;
                }
            }
            
            return false;
        });

        // Log pour debug
        \Log::info('Disponibilités trouvées pour la date', [
            'date' => $dateFormatted,
            'jour_semaine' => $jourSemaine,
            'nombre_dispos' => $dispos->count()
        ]);

        // Récupérer les créneaux déjà réservés et validés pour ce professeur à cette date
        $reservedSlots = $this->getReservedSlots($dateFormatted);

        // Générer des créneaux d'une heure
        $this->availableSlots = [];
        foreach ($dispos as $dispo) {
            $start = Carbon::parse($dispo->heureDebut);
            $end = Carbon::parse($dispo->heureFin);
            
            while ($start->lt($end)) {
                $slotEnd = $start->copy()->addHour();
                if ($slotEnd->lte($end)) {
                    $slotStart = $start->format('H:i');
                    $slotEndFormatted = $slotEnd->format('H:i');
                    
                    // Vérifier si ce créneau est réservé
                    $isReserved = $this->isSlotReserved($slotStart, $slotEndFormatted, $reservedSlots);
                    
                    // Ajouter tous les créneaux (disponibles ET réservés)
                    $this->availableSlots[] = [
                        'start' => $slotStart,
                        'end' => $slotEndFormatted,
                        'display' => $slotStart . ' - ' . $slotEndFormatted,
                        'isReserved' => $isReserved
                    ];
                }
                $start->addHour();
            }
        }
        
        \Log::info('Créneaux générés', [
            'date' => $dateFormatted,
            'nombre_creneaux' => count($this->availableSlots)
        ]);
    }

    /**
     * Récupère tous les créneaux réservés pour le professeur à une date donnée
     * Statuts considérés : 'validee' et 'en_attente'
     */
    private function getReservedSlots($date)
    {
        return DemandesIntervention::where('idIntervenant', $this->professeur->intervenant_id)
            ->where('dateSouhaitee', $date)
            ->whereIn('statut', ['validee', 'en_attente']) // On bloque aussi les demandes en attente
            ->select('heureDebut', 'heureFin')
            ->get()
            ->toArray();
    }

    /**
     * Vérifie si un créneau chevauche avec des créneaux réservés
     */
    private function isSlotReserved($slotStart, $slotEnd, $reservedSlots)
    {
        $slotStartTime = Carbon::parse($slotStart);
        $slotEndTime = Carbon::parse($slotEnd);

        foreach ($reservedSlots as $reserved) {
            $reservedStart = Carbon::parse($reserved['heureDebut']);
            $reservedEnd = Carbon::parse($reserved['heureFin']);

            // Vérifier si les créneaux se chevauchent
            // Un créneau chevauche si :
            // - Il commence avant la fin du créneau réservé ET
            // - Il se termine après le début du créneau réservé
            if ($slotStartTime->lt($reservedEnd) && $slotEndTime->gt($reservedStart)) {
                return true; // Le créneau est réservé
            }
        }

        return false; // Le créneau est disponible
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
        // Empêcher la sélection si le créneau est réservé
        if (isset($slot['isReserved']) && $slot['isReserved']) {
            return; // Ne rien faire si le créneau est réservé
        }

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

        // Vérifier une dernière fois que les créneaux sont toujours disponibles
        $reservedSlots = $this->getReservedSlots($this->selectedDate);
        
        foreach ($this->selectedTimeSlots as $slot) {
            $times = explode('-', $slot);
            $heureDebut = trim($times[0]);
            $heureFin = trim($times[1]);
            
            if ($this->isSlotReserved($heureDebut, $heureFin, $reservedSlots)) {
                DB::rollBack();
                session()->flash('error', 'Désolé, un ou plusieurs créneaux ont été réservés entre temps. Veuillez sélectionner d\'autres créneaux.');
                $this->loadAvailableSlotsForDate($this->selectedDate);
                $this->selectedTimeSlots = [];
                $this->currentStep = 2;
                return;
            }
        }

        // Créer le lieu
        $lieu = $this->typeService === 'domicile' 
            ? ($this->ville && $this->adresse ? $this->ville . ',' . $this->adresse : 'Domicile de l\'étudiant')
            : 'En ligne';

        // Tableau pour stocker toutes les demandes créées
        $demandesCreees = [];

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
                'montant_total' => $this->service->prix_par_heure,
                'service_prof_id' => $this->serviceId,
                'demande_id' => $demande->idDemande
            ]);

            $demandesCreees[] = $demande;
        }

        // Récupérer le client connecté
        $client = Auth::user();

        // Récupérer l'email du professeur
        $professeurUser = DB::table('utilisateurs')
            ->join('intervenants', 'utilisateurs.idUser', '=', 'intervenants.IdIntervenant')
            ->where('intervenants.IdIntervenant', $this->professeur->intervenant_id)
            ->first();

        // Envoyer l'email au professeur
        if ($professeurUser && $professeurUser->email) {
            Mail::to($professeurUser->email)->send(new SubmitBooking(
                $this->professeur,
                $client,
                $this->service,
                $demandesCreees,
                $this->selectedDate,
                $this->typeService,
                $this->ville,
                $this->adresse,
                $this->noteSpeciales,
                $this->montantTotal,
                $this->nombreHeures
            ));
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
            'currentMonthDisplay' => Carbon::parse($this->currentMonth)->locale('fr')->translatedFormat('F Y'),
            'calendarDays' => $this->generateCalendar()
        ]);
    }

    private function generateCalendar()
    {
        $start = Carbon::parse($this->currentMonth)->startOfMonth();
        $end = Carbon::parse($this->currentMonth)->endOfMonth();
        $days = [];

        // Ajouter les jours vides au début pour aligner avec le jour de la semaine
        $startDayOfWeek = $start->dayOfWeek;
        // Ajuster pour que Lundi = 0, Dimanche = 6
        $startDayOfWeek = $startDayOfWeek == 0 ? 6 : $startDayOfWeek - 1;
        
        for ($i = 0; $i < $startDayOfWeek; $i++) {
            $days[] = [
                'date' => null,
                'day' => null,
                'isEmpty' => true,
                'isToday' => false,
                'isPast' => false,
                'dayOfWeek' => null,
                'hasAvailability' => false
            ];
        }

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $days[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->day,
                'isEmpty' => false,
                'isToday' => $date->isToday(),
                'isPast' => $date->isPast() && !$date->isToday(),
                'dayOfWeek' => $date->dayOfWeek,
                'hasAvailability' => $this->checkIfDayHasAvailability($date)
            ];
        }

        return $days;
    }

    /**
     * Vérifie si un jour a des créneaux disponibles (non réservés)
     */
 private function checkIfDayHasAvailability($date)
    {
        $carbonDate = Carbon::parse($date);
        $jourSemaine = $this->getJourSemaine($carbonDate->dayOfWeek);
        $dateString = $carbonDate->format('Y-m-d');

        // Récupérer les disponibilités pour ce jour
        $dispos = $this->disponibilites->filter(function($dispo) use ($jourSemaine, $dateString) {
            // Disponibilités récurrentes
            if ($dispo->est_reccurent && $dispo->jourSemaine === $jourSemaine) {
                return true;
            }
            
            // Disponibilités ponctuelles
            if (!$dispo->est_reccurent) {
                if ($dispo->jourSemaine === 'N/A' || empty($dispo->jourSemaine) || is_null($dispo->jourSemaine)) {
                    $dispoDate = Carbon::parse($dispo->date_specifique)->format('Y-m-d');
                    return $dispoDate === $dateString;
                }
            }
            
            return false;
        });

        // S'il n'y a pas de disponibilités, retourner false
        if ($dispos->isEmpty()) {
            return false;
        }

        // Récupérer les créneaux réservés pour ce jour
        $reservedSlots = $this->getReservedSlots($dateString);

        // Vérifier s'il existe au moins un créneau disponible (non réservé)
        foreach ($dispos as $dispo) {
            $start = Carbon::parse($dispo->heureDebut);
            $end = Carbon::parse($dispo->heureFin);
            
            while ($start->lt($end)) {
                $slotEnd = $start->copy()->addHour();
                if ($slotEnd->lte($end)) {
                    $slotStart = $start->format('H:i');
                    $slotEndFormatted = $slotEnd->format('H:i');
                    
                    // Si ce créneau n'est pas réservé, le jour a de la disponibilité
                    if (!$this->isSlotReserved($slotStart, $slotEndFormatted, $reservedSlots)) {
                        return true;
                    }
                }
                $start->addHour();
            }
        }

        return false;
    }
}