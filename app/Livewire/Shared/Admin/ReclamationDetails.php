<?php

namespace App\Livewire\Shared\Admin;

use Livewire\Component;
use App\Models\Shared\Reclamation;
use Illuminate\Support\Facades\DB;

class ReclamationDetails extends Component
{
    public $reclamationId;
    public $reclamation;
    public $serviceType;
    public $auteurRole;
    public $cibleRole;

    public function mount($id)
    {
        if (!session()->has('is_admin')) {
            return redirect()->route('login')->with('error', 'Accès réservé aux administrateurs');
        }

        $this->reclamationId = $id;
        $this->reclamation = Reclamation::with(['auteur', 'cible', 'feedback.demande.service'])
            ->findOrFail($id);

        $this->serviceType = $this->getServiceType();
        $this->auteurRole = $this->getUserRole($this->reclamation->idAuteur);
        $this->cibleRole = $this->getUserRole($this->reclamation->idCible);
    }

    public function getServiceType()
    {
        // Vérifier d'abord si la réclamation a un feedback avec une demande
        if ($this->reclamation->feedback && $this->reclamation->feedback->demande && $this->reclamation->feedback->demande->service) {
            return $this->reclamation->feedback->demande->service->nomService;
        }

        // Sinon, essayer de déterminer via le type d'intervenant
        if (!$this->reclamation->cible) {
            return 'Non spécifié';
        }

        $professeur = DB::table('professeurs')
            ->join('intervenants', 'professeurs.intervenant_id', '=', 'intervenants.IdIntervenant')
            ->where('intervenants.IdIntervenant', $this->reclamation->cible->idUser)
            ->first();
        
        if ($professeur) {
            return 'Soutien Scolaire';
        }

        $babysitter = DB::table('babysitters')
            ->join('intervenants', 'babysitters.idBabysitter', '=', 'intervenants.IdIntervenant')
            ->where('intervenants.IdIntervenant', $this->reclamation->cible->idUser)
            ->first();
        
        if ($babysitter) {
            return 'Babysitting';
        }

        $petkeeper = DB::table('petkeepers')
            ->join('intervenants', 'petkeepers.idPetKeeper', '=', 'intervenants.IdIntervenant')
            ->where('intervenants.IdIntervenant', $this->reclamation->cible->idUser)
            ->first();
        
        if ($petkeeper) {
            return "Pet Keeping";
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
        return view('livewire.shared.admin.reclamation-details', [
            'reclamation' => $this->reclamation,
            'serviceType' => $this->serviceType,
            'auteurRole' => $this->auteurRole,
            'cibleRole' => $this->cibleRole,
        ]);
    }
}