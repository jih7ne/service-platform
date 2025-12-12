<?php

namespace App\Livewire\Tutoring;

use Livewire\Component;
use App\Models\SoutienScolaire\Professeur;
use App\Models\Shared\Feedback;
use App\Models\Shared\Disponibilite;
use Illuminate\Support\Facades\DB;

class TutorDetails extends Component
{
    public $professeurId;
    public $professeur;
    public $services;
    public $disponibilites;
    public $feedbacks;
    public $stats;
    public $localisation;

    public function mount($id)
    {
        $this->professeurId = $id;
        $this->loadProfesseurDetails();
    }

    private function loadProfesseurDetails()
    {
        // Charger les données du professeur avec relations
        $this->professeur = DB::table('professeurs')
            ->join('intervenants', 'professeurs.intervenant_id', '=', 'intervenants.IdIntervenant')
            ->join('utilisateurs', 'intervenants.IdIntervenant', '=', 'utilisateurs.idUser')
            ->leftJoin('localisations', 'utilisateurs.idUser', '=', 'localisations.idUser')
            ->select(
                'professeurs.*',
                'utilisateurs.nom',
                'utilisateurs.prenom',
                'utilisateurs.email',
                'utilisateurs.telephone',
                'utilisateurs.photo',
                'utilisateurs.note',
                'utilisateurs.nbrAvis',
                'localisations.ville',
                'localisations.adresse',
                'localisations.latitude',
                'localisations.longitude',
                'intervenants.IdIntervenant as intervenant_id_real'
            )
            ->where('professeurs.id_professeur', $this->professeurId)
            ->where('intervenants.statut', 'VALIDE')
            ->first();

        if (!$this->professeur) {
            abort(404, 'Professeur non trouvé');
        }

        // Charger les services du professeur
        $this->services = DB::table('services_prof')
            ->join('matieres', 'services_prof.matiere_id', '=', 'matieres.id_matiere')
            ->join('niveaux', 'services_prof.niveau_id', '=', 'niveaux.id_niveau')
            ->where('services_prof.professeur_id', $this->professeurId)
            ->where('services_prof.status', 'actif')
            ->select(
                'services_prof.*',
                'matieres.nom_matiere',
                'matieres.description as description_matiere',
                'niveaux.nom_niveau'
            )
            ->get()
            ->groupBy('nom_matiere');

        // Charger les disponibilités - essayons différentes approches
        $intervenantId = $this->professeur->intervenant_id_real ?? $this->professeur->intervenant_id;

        // Charger toutes les disponibilités
        $disponibilitesData = DB::table('disponibilites')
            ->where('idIntervenant', $intervenantId)
            ->get();

        // Si on a des disponibilités, les filtrer et grouper
        if ($disponibilitesData->isNotEmpty()) {
            // Filtrer les récurrentes ou futures
            $disponibilitesData = $disponibilitesData->filter(function($dispo) {
                return $dispo->est_reccurent == true || 
                       ($dispo->date_specifique && $dispo->date_specifique >= now()->format('Y-m-d'));
            });

            $this->disponibilites = $disponibilitesData->groupBy('jourSemaine');
        } else {
            $this->disponibilites = collect([]);
        }

        // Charger les feedbacks
        $userId = DB::table('intervenants')
            ->where('IdIntervenant', $intervenantId)
            ->value('IdIntervenant');

        $this->feedbacks = DB::table('feedbacks')
            ->join('utilisateurs', 'feedbacks.idAuteur', '=', 'utilisateurs.idUser')
            ->where('feedbacks.idCible', $userId)
            ->where('feedbacks.estVisible', true)
            ->select(
                'feedbacks.*',
                'utilisateurs.nom as auteur_nom',
                'utilisateurs.prenom as auteur_prenom',
                'utilisateurs.photo as auteur_photo'
            )
            ->orderBy('feedbacks.dateCreation', 'desc')
            ->get();

        // Calculer les statistiques des avis
        $this->calculateStats();

        // Localisation pour la carte
        $this->localisation = [
            'latitude' => $this->professeur->latitude,
            'longitude' => $this->professeur->longitude,
            'ville' => $this->professeur->ville,
            'adresse' => $this->professeur->adresse
        ];
    }

    private function calculateStats()
    {
        if ($this->feedbacks->isEmpty()) {
            $this->stats = [
                'moyenne_credibilite' => 0,
                'moyenne_sympathie' => 0,
                'moyenne_ponctualite' => 0,
                'moyenne_proprete' => 0,
                'moyenne_qualite' => 0,
                'total_avis' => 0
            ];
            return;
        }

        $this->stats = [
            'moyenne_credibilite' => round($this->feedbacks->avg('credibilite'), 1),
            'moyenne_sympathie' => round($this->feedbacks->avg('sympathie'), 1),
            'moyenne_ponctualite' => round($this->feedbacks->avg('ponctualite'), 1),
            'moyenne_proprete' => round($this->feedbacks->avg('proprete'), 1),
            'moyenne_qualite' => round($this->feedbacks->avg('qualiteTravail'), 1),
            'total_avis' => $this->feedbacks->count()
        ];
    }

    public function reserverCours($serviceId)
    {
        // Logique de réservation à implémenter
        // Par exemple : rediriger vers une page de réservation avec l'ID du service
        return redirect()->route('reservation.create', [
            'professeur' => $this->professeurId,
            'service' => $serviceId
        ]);
    }

    public function render()
    {
        return view('livewire.tutoring.tutor-details', [
            'professeur' => $this->professeur,
            'services' => $this->services,
            'disponibilites' => $this->disponibilites,
            'feedbacks' => $this->feedbacks,
            'stats' => $this->stats,
            'localisation' => $this->localisation
        ]);
    }
}