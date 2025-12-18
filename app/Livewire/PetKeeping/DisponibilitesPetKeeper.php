<?php

namespace App\Livewire\PetKeeping;

use App\Models\PetKeeping\PetKeeper;
use Livewire\Component;
use App\Models\Shared\Disponibilite;
use App\Models\Shared\Intervenant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DisponibilitesPetKeeper extends Component
{
    public $petKeeper;
    public $intervenant;
    public $intervenantId;
    public $user;
    
    // User info for template
    public $petKeeperName;
    public $petKeeperPhoto;

    // Stats
    public $disponibilitesCount = 0;
    public $totalHeures = 0;
    public $joursDisponibles = 0;

    // Data lists
    public $disponibilites = [];
    public $disponibilitesRecurrentes = [];
    public $disponibilitesSpecifiques = [];

    // Form properties
    public $heureDebut = '';
    public $heureFin = '';
    public $jourSemaine = 'Lundi';
    public $estRecurrent = true;
    public $dateSpecifique = '';
    public $editingId = null;

    // View properties
    public $viewMode = 'weekly'; // 'weekly' or 'calendar'
    public $selectedWeek = null;
    public $selectedDate = null;

    protected $rules = [
        'heureDebut' => 'required|date_format:H:i',
        'heureFin' => 'required|date_format:H:i|after:heureDebut',
        'jourSemaine' => 'required_if:estRecurrent,true|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi,Dimanche',
        'dateSpecifique' => 'required_if:estRecurrent,false|date|after_or_equal:today',
    ];

    protected $messages = [
        'heureFin.after' => 'L\'heure de fin doit être après l\'heure de début.',
        'dateSpecifique.after_or_equal' => 'La date doit être aujourd\'hui ou dans le futur.',
    ];

    public function mount()
    {
        $userId = Auth::id();
        
        // Get user data
        $this->user = Auth::user();
        $this->petKeeperName = ($this->user->prenom . ' ' . $this->user->nom) ?? 'Pet Keeper';
        $this->petKeeperPhoto = $user->photo ?? null;

        $this->petKeeper = PetKeeper::where('idPetKeeper', $userId)->first();
        $this->intervenant = Intervenant::where('IdIntervenant', $userId)->first();
        $this->intervenantId = $this->intervenant?->idIntervenant ?? $userId;

        $this->selectedWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        $this->selectedDate = Carbon::now()->format('Y-m-d');

        $this->loadDisponibilites();
        $this->calculateStats();
    }

    public function loadDisponibilites()
    {
        $query = Disponibilite::forIntervenant($this->intervenantId);

        $this->disponibilites = $query->get();
        $this->disponibilitesRecurrentes = $query->recurrent()->get();
        $this->disponibilitesSpecifiques = $query->specific()->get();
    }

    public function calculateStats()
    {
        // Stats basées sur les disponibilités de la semaine en cours
        $weekDispos = $this->getDisponibilitesForWeekProperty();
        $flatDispos = collect();

        foreach ($weekDispos as $day) {
            foreach ($day['disponibilites'] as $dispo) {
                $flatDispos->push($dispo);
            }
        }

        $this->disponibilitesCount = $flatDispos->count();

        $this->totalHeures = $flatDispos->sum(function ($dispo) {
            $debut = Carbon::parse($dispo->heureDebut);
            $fin = Carbon::parse($dispo->heureFin);
            return $fin->diffInHours($debut);
        });

        $joursUniques = $flatDispos->map(function ($dispo) {
            return $dispo->jourSemaine ?? Carbon::parse($dispo->date_specifique)->format('l');
        })->unique();

        $this->joursDisponibles = $joursUniques->count();
    }

    public function saveDisponibilite()
    {
        $this->validate();

        $data = [
            'heureDebut' => $this->heureDebut,
            'heureFin' => $this->heureFin,
            'idIntervenant' => $this->intervenantId,
            'est_reccurent' => $this->estRecurrent,
        ];

        if ($this->estRecurrent) {
            $data['jourSemaine'] = $this->jourSemaine;
            $data['date_specifique'] = null;
        } else {
            $data['jourSemaine'] = null;
            $data['date_specifique'] = $this->dateSpecifique;
        }

        try {
            if ($this->editingId) {
                Disponibilite::find($this->editingId)->update($data);
                session()->flash('success', 'Disponibilité mise à jour avec succès');
            } else {
                Disponibilite::create($data);
                session()->flash('success', 'Disponibilité ajoutée avec succès');
            }

            $this->resetForm();
            $this->loadDisponibilites();
            $this->calculateStats();

        } catch (\Exception $e) {
            session()->flash('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    public function editDisponibilite($id)
    {
        $dispo = Disponibilite::find($id);

        if (!$dispo) {
            session()->flash('error', 'Disponibilité introuvable');
            return;
        }

        $this->editingId = $id;
        $this->heureDebut = $dispo->heureDebut;
        $this->heureFin = $dispo->heureFin;
        $this->estRecurrent = $dispo->est_reccurent;

        if ($dispo->est_reccurent) {
            $this->jourSemaine = $dispo->jourSemaine;
        } else {
            $this->dateSpecifique = $dispo->date_specifique;
        }
    }

    public function deleteDisponibilite($id)
    {
        try {
            Disponibilite::find($id)->delete();
            session()->flash('success', 'Disponibilité supprimée avec succès');
            $this->loadDisponibilites();
            $this->calculateStats();
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la suppression');
        }
    }

    public function resetForm()
    {
        $this->reset(['heureDebut', 'heureFin', 'jourSemaine', 'estRecurrent', 'dateSpecifique', 'editingId']);
        $this->estRecurrent = true;
        
        $this->jourSemaine = 'Lundi';
    }

    public function getDisponibilitesForWeekProperty()
    {
        if (!$this->selectedWeek)
            return [];

        $weekStart = Carbon::parse($this->selectedWeek)->startOfWeek();
        $weekEnd = $weekStart->copy()->endOfWeek();

        $weekDispos = [];

        for ($date = $weekStart->copy(); $date <= $weekEnd; $date->addDay()) {
            $dateStr = $date->format('Y-m-d');
            $dayName = $date->format('l');
            $dayNameFr = match ($dayName) {
                'Monday' => 'Lundi',
                'Tuesday' => 'Mardi',
                'Wednesday' => 'Mercredi',
                'Thursday' => 'Jeudi',
                'Friday' => 'Vendredi',
                'Saturday' => 'Samedi',
                'Sunday' => 'Dimanche',
                default => $dayName
            };

            
            $disposForDay = $this->disponibilites->filter(function ($dispo) use ($dateStr, $dayNameFr) {
                if ($dispo->est_reccurent) {
                    return $dispo->jourSemaine === $dayNameFr;
                } else {
                    return $dispo->date_specifique === $dateStr;
                }
            });

            $weekDispos[$dateStr] = [
                'date' => $dateStr,
                'dayName' => $dayNameFr,
                'disponibilites' => $disposForDay
            ];
        }

        return $weekDispos;
    }

    public function getDisponibilitesForDateProperty()
    {
        if (!$this->selectedDate)
            return [];

        

        $targetDate = Carbon::parse($this->selectedDate);
        $dayNameFr = match ($targetDate->format('l')) {
            'Monday' => 'Lundi',
            'Tuesday' => 'Mardi',
            'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi',
            'Friday' => 'Vendredi',
            'Saturday' => 'Samedi',
            'Sunday' => 'Dimanche',
            default => $targetDate->format('l')
        };
        $dateStr = $targetDate->format('Y-m-d');

        return $this->disponibilites->filter(function ($dispo) use ($dateStr, $dayNameFr) {
            if ($dispo->est_reccurent) {
                return $dispo->jourSemaine === $dayNameFr;
            } else {
                return $dispo->date_specifique === $dateStr;
            }
        });
    }

    public function previousWeek()
    {
        $this->selectedWeek = Carbon::parse($this->selectedWeek)->subWeek()->format('Y-m-d');
    }

    public function nextWeek()
    {
        $this->selectedWeek = Carbon::parse($this->selectedWeek)->addWeek()->format('Y-m-d');
    }

    public function previousDay()
    {
        $this->selectedDate = Carbon::parse($this->selectedDate)->subDay()->format('Y-m-d');
    }

    public function nextDay()
    {
        $this->selectedDate = Carbon::parse($this->selectedDate)->addDay()->format('Y-m-d');
    }

    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
    }

    public function getJoursSemaineProperty()
    {
        return ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    }

    public function getHeuresProperty()
    {
        $heures = [];
        for ($i = 6; $i < 24; $i++) { // Start from 6am to be more relevant
            $heures[] = sprintf('%02d:00', $i);
            $heures[] = sprintf('%02d:30', $i);
        }
        // Add late night / early morning if needed, but 06-23:30 is standard for babysitters
        return $heures;
    }

    public function render()
    {
        return view('livewire.pet-keeping.disponibilites-pet-keeper');
    }
}