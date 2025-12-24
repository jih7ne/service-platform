<?php

namespace App\Livewire\PetKeeping;


use Livewire\Component;
use Illuminate\Support\Facades\DB;

class PetKeeperProfileClientView extends Component
{
    public $petkeeperId;
    public $serviceId;
    public $petkeeper;
    public $services;
    public $disponibilites;
    public $certifications;
    public $feedbacks;
    public $stats;
    public $localisation;
    public $service;

    public function mount($idPetKeeper, $idService){
        $this->petkeeperId = $idPetKeeper;
        $this->serviceId = $idService;
        $this->loadPetKeeperDetails();
    }

    public function loadPetKeeperDetails(){
        $petkeeperBase = DB::table('petkeepers')
            ->join('intervenants', 'petkeepers.idPetKeeper', '=', 'intervenants.IdIntervenant')
            ->join('utilisateurs', 'intervenants.IdIntervenant', '=', 'utilisateurs.idUser')
            ->leftJoin('localisations', 'utilisateurs.idUser', '=', 'localisations.idUser')
            ->select(
                'petkeepers.*',
                'utilisateurs.nom',
                'utilisateurs.prenom',
                'utilisateurs.email',
                'utilisateurs.telephone',
                'utilisateurs.photo',
                'utilisateurs.idUser',
                'localisations.ville',
                'localisations.adresse',
                'localisations.latitude',
                'localisations.longitude',
                'intervenants.IdIntervenant as intervenant_id_real'
            )
            ->where('petkeepers.idPetKeeper', $this->petkeeperId)
            ->first();

        if (!$petkeeperBase) {
            abort(404, 'PetKeeper non trouvé');
        }

        
        $avisData = DB::table('feedbacks')
            ->where('idCible', $petkeeperBase->idUser)
            ->where('estVisible', 1)
            ->selectRaw('AVG(moyenne) as note_moyenne, COUNT(*) as nombre_avis')
            ->first();

        
        $this->petkeeper = $petkeeperBase;
        $this->petkeeper->note = $avisData->note_moyenne ? round($avisData->note_moyenne, 2) : 0;
        $this->petkeeper->nbrAvis = $avisData->nombre_avis ?? 0;

        

        // Charger les disponibilités
        $intervenantId = $this->petkeeper->intervenant_id_real;

        $disponibilitesData = DB::table('disponibilites')
            ->where('idIntervenant', $intervenantId)
            ->get();

        if ($disponibilitesData->isNotEmpty()) {
            $disponibilitesData = $disponibilitesData->filter(function($dispo) {
                return $dispo->est_reccurent == true || 
                       ($dispo->date_specifique && $dispo->date_specifique >= now()->format('Y-m-d'));
            });

            $this->disponibilites = $disponibilitesData->groupBy('jourSemaine');
        } else {
            $this->disponibilites = collect([]);
        }

        $this->certifications = DB::table('petkeeper_certifications')
                                ->select(
                                    'petkeeper_certifications.certification'
                                )->get();

        $this->service = DB::table('services')
                         ->join('petkeeping', 'services.idService', '=', 'petkeeping.idPetKeeping')
                         ->where('services.idService', '=', $this->serviceId)->get();

        
        $this->feedbacks = DB::table('feedbacks')
            ->join('utilisateurs', 'feedbacks.idAuteur', '=', 'utilisateurs.idUser')
            ->where('feedbacks.idCible', $petkeeperBase->idUser)
            ->where('feedbacks.estVisible', 1)
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
            'latitude' => $this->petkeeper->latitude,
            'longitude' => $this->petkeeper->longitude,
            'ville' => $this->petkeeper->ville,
            'adresse' => $this->petkeeper->adresse
        ];
    }


    public function bookService($IdService)
    {
        return redirect()->route('pet-keeper.book', $IdService);
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
                'total_avis' => 0,
                'moyenne_generale' => 0
            ];
            return;
        }

        $this->stats = [
            'moyenne_credibilite' => round($this->feedbacks->avg('credibilite'), 1),
            'moyenne_sympathie' => round($this->feedbacks->avg('sympathie'), 1),
            'moyenne_ponctualite' => round($this->feedbacks->avg('ponctualite'), 1),
            'moyenne_proprete' => round($this->feedbacks->avg('proprete'), 1),
            'moyenne_qualite' => round($this->feedbacks->avg('qualiteTravail'), 1),
            'total_avis' => $this->feedbacks->count(),
            'moyenne_generale' => round($this->feedbacks->avg('moyenne'), 1)
        ];
    }


    
    public function render()
    {
        return view('livewire.pet-keeping.pet-keeper-profile-client-view')->with([
            'petkeeper' => $this->petkeeper,
            'disponibilites' => $this->disponibilites,
            'feedbacks' => $this->feedbacks,
            'service' => $this->service,
            'certifications' => $this->certifications,
            'stats' => $this->stats,
            'localisation' => $this->localisation
        ]);
    }
}
