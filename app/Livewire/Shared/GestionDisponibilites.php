<?php

namespace App\Livewire\Shared;

use Livewire\Component;
use App\Models\Shared\Disponibilite;
use Carbon\Carbon;
use Livewire\Attributes\On;

class GestionDisponibilites extends Component
{
    public $intervenantId;
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
    public $viewMode = 'weekly';
    public $selectedWeek = null;
    public $selectedDate = null;

    protected $rules = [
        'heureDebut' => 'required|date_format:H:i',
        'heureFin' => 'required|date_format:H:i|after:heureDebut',
        'jourSemaine' => 'required_if:estRecurrent,true|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi,Dimanche',
        'dateSpecifique' => 'required_if:estRecurrent,false|date',
    ];

    protected $messages = [
        'heureFin.after' => 'L\'heure de fin doit être après l\'heure de début.',
        'dateSpecifique.required_if' => 'La date est requise pour une disponibilité ponctuelle.',
        'dateSpecifique.date' => 'Format de date invalide.',
    ];

    public function mount($intervenantId = null)
    {
        $this->intervenantId = $intervenantId ?? auth()->id();
        $this->selectedWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        $this->selectedDate = Carbon::now()->format('Y-m-d');
        $this->loadDisponibilites();
    }

    public function loadDisponibilites()
    {
        $query = Disponibilite::forIntervenant($this->intervenantId);
        
        $this->disponibilites = $query->get();
        $this->disponibilitesRecurrentes = $query->recurrent()->get();
        $this->disponibilitesSpecifiques = $query->specific()->get();
        
        // Log pour debug
        \Log::info('Disponibilités chargées - Total: ' . $this->disponibilites->count() . 
                   ', Récurrentes: ' . $this->disponibilitesRecurrentes->count() . 
                   ', Ponctuelles: ' . $this->disponibilitesSpecifiques->count());
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
            // Mettre une valeur factice car la colonne n'accepte pas NULL ni chaîne vide
            $data['jourSemaine'] = 'N/A';
            $data['date_specifique'] = Carbon::parse($this->dateSpecifique)->format('Y-m-d');
        }

        try {
            if ($this->editingId) {
                $dispo = Disponibilite::find($this->editingId);
                $dispo->update($data);
                
                \Log::info('Disponibilité mise à jour:', [
                    'id' => $this->editingId,
                    'type' => $this->estRecurrent ? 'récurrente' : 'ponctuelle',
                    'date' => $data['date_specifique'] ?? $data['jourSemaine']
                ]);
                
                session()->flash('success', 'Disponibilité mise à jour avec succès');
            } else {
                $newDispo = Disponibilite::create($data);
                
                \Log::info('Nouvelle disponibilité créée:', [
                    'id' => $newDispo->idDispo,
                    'type' => $this->estRecurrent ? 'récurrente' : 'ponctuelle',
                    'date' => $data['date_specifique'] ?? $data['jourSemaine']
                ]);
                
                session()->flash('success', 'Disponibilité ajoutée avec succès');
            }

            $this->resetForm();
            $this->loadDisponibilites();
            $this->dispatch('disponibilite-saved');
            
        } catch (\Exception $e) {
            \Log::error('Erreur sauvegarde disponibilité: ' . $e->getMessage());
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
        $this->heureDebut = substr($dispo->heureDebut, 0, 5); // Enlever les secondes
        $this->heureFin = substr($dispo->heureFin, 0, 5);
        $this->estRecurrent = $dispo->est_reccurent;
        
        if ($dispo->est_reccurent) {
            $this->jourSemaine = $dispo->jourSemaine;
            $this->dateSpecifique = '';
        } else {
            $this->dateSpecifique = $dispo->date_specifique;
            $this->jourSemaine = 'Lundi';
        }
        
        \Log::info('Édition disponibilité:', [
            'id' => $id,
            'type' => $this->estRecurrent ? 'récurrente' : 'ponctuelle',
            'date' => $this->dateSpecifique ?: $this->jourSemaine
        ]);
    }

    public function deleteDisponibilite($id)
    {
        try {
            Disponibilite::find($id)->delete();
            session()->flash('success', 'Disponibilité supprimée avec succès');
            $this->loadDisponibilites();
            $this->dispatch('disponibilite-saved');
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
        if (!$this->selectedWeek) return [];

        $weekStart = Carbon::parse($this->selectedWeek)->startOfWeek();
        $weekEnd = $weekStart->copy()->endOfWeek();
        
        $weekDispos = [];
        
        for ($date = $weekStart->copy(); $date <= $weekEnd; $date->addDay()) {
            $dateStr = $date->format('Y-m-d');
            $dayName = $date->format('l');
            $dayNameFr = match($dayName) {
                'Monday' => 'Lundi',
                'Tuesday' => 'Mardi', 
                'Wednesday' => 'Mercredi',
                'Thursday' => 'Jeudi',
                'Friday' => 'Vendredi',
                'Saturday' => 'Samedi',
                'Sunday' => 'Dimanche',
                default => $dayName
            };

            $disposForDay = $this->disponibilites->filter(function($dispo) use ($dateStr, $dayNameFr) {
                if ($dispo->est_reccurent) {
                    return $dispo->jourSemaine === $dayNameFr;
                } else {
                    // Pour les ponctuels, jourSemaine vaut 'N/A'
                    if ($dispo->jourSemaine === 'N/A' || empty($dispo->jourSemaine) || is_null($dispo->jourSemaine)) {
                        // Convertir les deux dates au format Y-m-d pour comparaison
                        $dispoDate = Carbon::parse($dispo->date_specifique)->format('Y-m-d');
                        
                        // Log pour debug
                        \Log::info('Comparaison dates', [
                            'date_calendrier' => $dateStr,
                            'date_dispo_brute' => $dispo->date_specifique,
                            'date_dispo_formatee' => $dispoDate,
                            'match' => $dispoDate === $dateStr
                        ]);
                        
                        return $dispoDate === $dateStr;
                    }
                    return false;
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
        if (!$this->selectedDate) return [];

        $selectedDateFr = Carbon::parse($this->selectedDate)->locale('fr')->dayName;
        $dayNameFr = ucfirst($selectedDateFr);

        return $this->disponibilites->filter(function($dispo) use ($dayNameFr) {
            if ($dispo->est_reccurent) {
                return $dispo->jourSemaine === $dayNameFr;
            } else {
                // Pour les ponctuels, jourSemaine vaut 'N/A'
                if ($dispo->jourSemaine === 'N/A' || empty($dispo->jourSemaine) || is_null($dispo->jourSemaine)) {
                    // Convertir au même format pour comparaison
                    $dispoDate = Carbon::parse($dispo->date_specifique)->format('Y-m-d');
                    $selectedDate = Carbon::parse($this->selectedDate)->format('Y-m-d');
                    
                    \Log::info('Vue journée - Comparaison', [
                        'selected' => $selectedDate,
                        'dispo' => $dispoDate,
                        'match' => $dispoDate === $selectedDate
                    ]);
                    
                    return $dispoDate === $selectedDate;
                }
                return false;
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
        for ($i = 0; $i < 24; $i++) {
            $heures[] = sprintf('%02d:00', $i);
            $heures[] = sprintf('%02d:30', $i);
        }
        return $heures;
    }

    #[On('refresh-disponibilites')]
    public function refresh()
    {
        $this->loadDisponibilites();
    }

    public function render()
    {
        return view('livewire.shared.gestion-disponibilites');
    }
}