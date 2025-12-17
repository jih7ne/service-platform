<?php

namespace App\Livewire\Tutoring;

use App\Livewire\Shared\GestionDisponibilites;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Shared\Intervenant;
use Carbon\Carbon;

class DisponibilitesPage extends GestionDisponibilites
{
    public $enAttente = 0;
    public $prenom;
    public $photo;

    public $disponibilitesCount = 0;
    public $totalHeures = 0;
    public $joursDisponibles = 0;

    public function refreshPendingRequests(): void
    {
        $user = Auth::user();
        if (!$user) { $this->enAttente = 0; return; }

        $this->enAttente = (int) DB::table('demandes_intervention')
            ->where('idIntervenant', $user->idUser)
            ->where('statut', 'en_attente')
            ->count();
    }

    public function mount($intervenantId = null)
    {
        $user = Auth::user();
        $this->prenom = $user->prenom;
        $this->photo = $user->photo;

        // Sidebar badge count
        $this->refreshPendingRequests();

        if (!$intervenantId) {
            $intervenantData = Intervenant::where('IdIntervenant', $user->idUser)->first();
            if ($intervenantData) {
                // UTILISE user->idUser au lieu de intervenantData->id
                $intervenantId = $user->idUser;
            }
        }

        parent::mount($intervenantId);
        $this->calculateStats();
    }

    public function hydrate(): void
    {
        $this->refreshPendingRequests();
    }

    public function saveDisponibilite()
    {
        parent::saveDisponibilite();
        $this->calculateStats();
    }

    public function deleteDisponibilite($id)
    {
        parent::deleteDisponibilite($id);
        $this->calculateStats();
    }

    public function calculateStats()
    {
        $weekDispos = $this->disponibilitesForWeek; 
        $flatDispos = collect();

        if (!empty($weekDispos)) {
            foreach ($weekDispos as $day) {
                if (isset($day['disponibilites'])) {
                    foreach ($day['disponibilites'] as $dispo) {
                        $flatDispos->push($dispo);
                    }
                }
            }
        }

        $this->disponibilitesCount = $flatDispos->count();

        $totalMinutes = $flatDispos->sum(function ($dispo) {
            $debut = \Carbon\Carbon::parse($dispo->heureDebut);
            $fin = \Carbon\Carbon::parse($dispo->heureFin);

            $minutesDebut = ($debut->hour * 60) + $debut->minute;
            $minutesFin = ($fin->hour * 60) + $fin->minute;

            $duree = $minutesFin - $minutesDebut;

            if ($duree < 0) {
                $duree += 1440;
            }

            return $duree;
        });

        $this->totalHeures = abs(round($totalMinutes / 60, 1));

        $joursUniques = $flatDispos->map(function ($dispo) {
            return $dispo->est_reccurent ? $dispo->jourSemaine : \Carbon\Carbon::parse($dispo->date_specifique)->format('l');
        })->unique();

        $this->joursDisponibles = $joursUniques->count();
    }

    public function logout() {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.tutoring.disponibilites-page');
    }
}