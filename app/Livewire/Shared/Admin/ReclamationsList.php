<?php

namespace App\Livewire\Shared\Admin;

use Livewire\Component;
use App\Models\Shared\Reclamation;
use Illuminate\Support\Facades\DB;

class ReclamationsList extends Component
{
    public $search = '';
    public $serviceFilter = 'tous';
    public $statutFilter = 'tous';
    public $prioriteFilter = 'toutes';

    public function mount()
    {
        if (!session()->has('is_admin')) {
            return redirect()->route('login')->with('error', 'Accès réservé aux administrateurs');
        }
    }

    public function getReclamationsProperty()
    {
        $query = Reclamation::with(['auteur', 'cible', 'feedback.demande.service'])
            ->orderBy('dateCreation', 'desc');

        // Recherche
        if ($this->search) {
            $query->where(function($q) {
                $q->where('sujet', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhereHas('auteur', function($q) {
                      $q->where('nom', 'like', '%' . $this->search . '%')
                        ->orWhere('prenom', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('cible', function($q) {
                      $q->where('nom', 'like', '%' . $this->search . '%')
                        ->orWhere('prenom', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Filtre par service
        if ($this->serviceFilter !== 'tous') {
            $query->whereHas('feedback.demande', function($q) {
                $serviceId = null;
                if ($this->serviceFilter === 'soutien') {
                    $serviceId = 1; // Soutien scolaire
                } elseif ($this->serviceFilter === 'babysitting') {
                    $serviceId = 2; // Babysitting
                } elseif ($this->serviceFilter === 'animaux') {
                    $serviceId = 3; // Pet Keeping
                }
                
                if ($serviceId) {
                    $q->where('idService', $serviceId);
                }
            });
        }

        // Filtre statut
        if ($this->statutFilter !== 'tous') {
            $query->where('statut', $this->statutFilter);
        }

        // Filtre priorité
        if ($this->prioriteFilter !== 'toutes') {
            $query->where('priorite', $this->prioriteFilter);
        }

        return $query->get();
    }

    public function getServiceType($reclamation)
    {
        // Vérifier d'abord si la réclamation a un feedback avec une demande
        if ($reclamation->feedback && $reclamation->feedback->demande && $reclamation->feedback->demande->service) {
            return $reclamation->feedback->demande->service->nomService;
        }

        // Sinon, essayer de déterminer via le type d'intervenant
        if (!$reclamation->cible) {
            return 'Non spécifié';
        }

        $professeur = DB::table('professeurs')
            ->join('intervenants', 'professeurs.intervenant_id', '=', 'intervenants.IdIntervenant')
            ->where('intervenants.IdIntervenant', $reclamation->cible->idUser)
            ->first();
        
        if ($professeur) {
            return 'Soutien scolaire';
        }

        $babysitter = DB::table('babysitters')
            ->join('intervenants', 'babysitters.idBabysitter', '=', 'intervenants.IdIntervenant')
            ->where('intervenants.IdIntervenant', $reclamation->cible->idUser)
            ->first();
        
        if ($babysitter) {
            return 'Babysitting';
        }

        $petkeeper = DB::table('petkeepers')
            ->join('intervenants', 'petkeepers.idPetKeeper', '=', 'intervenants.IdIntervenant')
            ->where('intervenants.IdIntervenant', $reclamation->cible->idUser)
            ->first();
        
        if ($petkeeper) {
            return "Garde d'animaux";
        }

        return 'Non spécifié';
    }

    public function getUserRole($userId)
    {
        // Vérifier si c'est un intervenant
        $isIntervenant = DB::table('intervenants')
            ->where('IdIntervenant', $userId)
            ->exists();

        return $isIntervenant ? 'Intervenant' : 'Client';
    }

    public function render()
    {
        $reclamations = $this->reclamations;
        
        $stats = [
            'total' => $reclamations->count(),
            'en_attente' => $reclamations->where('statut', 'en_attente')->count(),
            'resolues' => $reclamations->where('statut', 'resolue')->count(),
            'priorite_haute' => $reclamations->where('priorite', 'urgente')->count(),
        ];

        return view('livewire.shared.admin.reclamations-list', [
            'reclamations' => $reclamations,
            'stats' => $stats,
        ]);
    }
}