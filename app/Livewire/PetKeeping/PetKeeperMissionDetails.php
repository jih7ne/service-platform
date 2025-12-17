<?php

namespace App\Livewire\PetKeeping;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class PetKeeperMissionDetails extends Component
{
    public $demande; // This is a Collection
    public $user;
    public $prix_estime;

    public function mount($id)
    {
        $authUser = Auth::user();

        if ($authUser) {
            $this->user = DB::table('utilisateurs')
                ->where('email', $authUser->email)
                ->first();
        } else {
            $this->user = DB::table('utilisateurs')
                ->where('role', 'intervenant')
                ->first();
            return redirect()->route('login');
        }

        $this->demande = DB::table('demandes_intervention')
            ->join('utilisateurs', 'demandes_intervention.idClient', '=', 'utilisateurs.idUser')
            ->leftJoin('animal_demande', 'demandes_intervention.idDemande', '=', 'animal_demande.idDemande')
            ->leftJoin('factures', 'factures.idDemande', '=', 'demandes_intervention.idDemande')
            ->leftJoin('animals', 'animal_demande.idAnimal', '=', 'animals.idAnimale')
            ->select(
                'demandes_intervention.*',
                'demandes_intervention.idDemande as id_demande_reelle',
                'utilisateurs.nom as nom_client',
                'utilisateurs.prenom as prenom_client',
                'utilisateurs.note as note_client',
                'utilisateurs.photo as photo_client',
                'demandes_intervention.lieu as ville_client',
                'animals.nomAnimal as nom_animal',
                'animals.age',
                'animals.espece',
                'animals.race as race_animal',
                'animals.statutVaccination',
                'animals.note_comportementale',
                'factures.numFacture as numFac',
                'factures.montantTotal'
            )
            ->where('demandes_intervention.idDemande', $id)
            ->get();

        // Vérifications finales
        if ($this->demande->isEmpty()) {
            session()->flash('error', 'Mission introuvable');
            return redirect('/'); 
        }
    }

    public function parseCreneauxGrouped($json)
    {
        if (!$json) return [];
        
        try {
            $creneaux = json_decode($json, true) ?? [];
            
            $grouped = [];
            foreach ($creneaux as $creneau) {
                $date = $creneau['date'] ?? null;
                if ($date) {
                    if (!isset($grouped[$date])) {
                        $grouped[$date] = [];
                    }
                    $grouped[$date][] = [
                        'heureDebut' => $creneau['heureDebut'] ?? '',
                        'heureFin' => $creneau['heureFin'] ?? ''
                    ];
                }
            }
            
            return $grouped;
        } catch (\Exception $e) {
            return [];
        }
    }

    public function groupAnimalsByDemande($demandes)
    {
        
        if ($demandes instanceof \Illuminate\Support\Collection) {
            $demandes = $demandes->toArray();
        }
        
        $grouped = [];
        
        foreach ($demandes as $demande) {
            
            $demandeObj = (object) $demande;
            
            $idDemande = $demandeObj->idDemande ?? $demandeObj->id_demande_reelle ?? null;
            
            if (!$idDemande) {
                continue;
            }
            
            if (!isset($grouped[$idDemande])) {
                $grouped[$idDemande] = [
                    'demande' => $demandeObj,
                    'animals' => [],
                    'creneaux' => $this->parseCreneauxGrouped($demandeObj->note_speciales ?? '[]')
                ];
            }
            
            if ($demandeObj->nom_animal) {
                $grouped[$idDemande]['animals'][] = [
                    'nom' => $demandeObj->nom_animal,
                    'race' => $demandeObj->race_animal,
                    'age' => $demandeObj->age,
                    'espece' => $demandeObj->espece,
                    'statutVaccination' => $demandeObj->statutVaccination,
                    'note_comportementale' => $demandeObj->note_comportementale
                ];
            }
        }
        
        return array_values($grouped);
    }

    
    public function getFirstDemande()
    {
        if ($this->demande instanceof Collection && !$this->demande->isEmpty()) {
            return $this->demande->first();
        }
        return null;
    }

    public function render()
    {
        return view('livewire.pet-keeping.pet-keeper-mission-details', [
            'firstDemande' => $this->getFirstDemande()
        ]);
    }
}