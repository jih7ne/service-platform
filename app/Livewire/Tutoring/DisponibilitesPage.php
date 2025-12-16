<?php

namespace App\Livewire\Tutoring;

use App\Livewire\Shared\GestionDisponibilites;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Shared\Intervenant;
use Carbon\Carbon;

// On hérite de la classe partagée pour respecter les règles du groupe
class DisponibilitesPage extends GestionDisponibilites
{
    public $prenom;
    public $photo;

    // Variables Stats (Spécifiques à ton affichage)
    public $disponibilitesCount = 0;
    public $totalHeures = 0;
    public $joursDisponibles = 0;

    public function mount($intervenantId = null)
    {
        $user = Auth::user();
        $this->prenom = $user->prenom;
        $this->photo = $user->photo;

        // 1. Récupération de l'ID Intervenant (Ta logique spécifique)
        if (!$intervenantId) {
            $intervenantData = Intervenant::where('IdIntervenant', $user->idUser)->first();
            if ($intervenantData) {
                $intervenantId = $intervenantData->id; // ID table intervenants
            }
        }

        // 2. Appel du parent (Charge les disponibilités, initialise la semaine...)
        parent::mount($intervenantId);

        // 3. Calculer tes stats après le chargement
        $this->calculateStats();
    }

    // --- SURCHARGE : On ajoute le calcul des stats après chaque sauvegarde ---
    public function saveDisponibilite()
    {
        parent::saveDisponibilite(); // Fait le travail standard
        $this->calculateStats();     // Met à jour tes compteurs
    }

    public function deleteDisponibilite($id)
    {
        parent::deleteDisponibilite($id);
        $this->calculateStats();
    }

    // --- TA FONCTION DE STATS (Récupérée du code Babysitter) ---
    public function calculateStats()
    {
        // 1. Récupérer tous les créneaux affichés cette semaine
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

        // 2. Compter le nombre de créneaux
        $this->disponibilitesCount = $flatDispos->count();

        // 3. Calculer le cumul des heures (MÉTHODE MATHÉMATIQUE SÛRE)
        $totalMinutes = $flatDispos->sum(function ($dispo) {
            
            // On s'assure que c'est bien des objets Carbon ou on parse
            $debut = \Carbon\Carbon::parse($dispo->heureDebut);
            $fin = \Carbon\Carbon::parse($dispo->heureFin);

            // On convertit tout en minutes depuis minuit (ex: 14:00 = 840 min)
            $minutesDebut = ($debut->hour * 60) + $debut->minute;
            $minutesFin = ($fin->hour * 60) + $fin->minute;

            $duree = $minutesFin - $minutesDebut;

            // Gestion du cas "Nuit" (ex: 22h00 -> 01h00 du matin)
            // Si la durée est négative, ça veut dire qu'on a passé minuit, donc on ajoute 24h (1440 min)
            if ($duree < 0) {
                $duree += 1440;
            }

            return $duree;
        });

        // Conversion en heures avec 1 décimale (ex: 22.5) et VALEUR ABSOLUE par sécurité (abs)
        $this->totalHeures = abs(round($totalMinutes / 60, 1));

        // 4. Compter les jours actifs
        $joursUniques = $flatDispos->map(function ($dispo) {
            // Si c'est récurrent on prend le jour, sinon la date
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