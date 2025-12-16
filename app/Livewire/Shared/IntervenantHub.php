<?php

namespace App\Livewire\Shared;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Shared\Intervenant;
use App\Models\Shared\OffreService;

class IntervenantHub extends Component
{
    public $services = [];
    public $prenom;
    

    public function mount()
    {
        $user = Auth::user();
        $this->prenom = $user->prenom;

        
        $intervenant = Intervenant::where('IdIntervenant', $user->idUser)->first();

        if ($intervenant) {
            // On charge les services associés
            $this->services = $intervenant->services;
        }
    }

    public function archiveService($idService)
    {
        $user = Auth::user();
        $intervenant = Intervenant::where('idIntervenant', $user->idUser)->first();
        
        if ($intervenant) {
            \DB::table('offres_services')
                ->where('idService', $idService)
                ->where('idIntervenant', $intervenant->IdIntervenant)
                ->update(['statut' => 'ARCHIVED']);
            
            // Recharger les services
            $this->services = $intervenant->services;
            
            session()->flash('success', 'Service archivé avec succès !');
        }
    }

    public function unarchiveService($idService)
    {
        $user = Auth::user();
        $intervenant = Intervenant::where('idIntervenant', $user->idUser)->first();
        
        if ($intervenant) {
            \DB::table('offres_services')
                ->where('idService', $idService)
                ->where('idIntervenant', $intervenant->IdIntervenant)
                ->update(['statut' => 'ACTIVE']);
            
            // Recharger les services
            $this->services = $intervenant->services;
            
            session()->flash('success', 'Service désarchivé avec succès !');
        }
    }

    public function logout()
    {
        Auth::logout(); // Déconnecte l'utilisateur
        session()->invalidate(); // Détruit la session (sécurité)
        session()->regenerateToken(); // Régénère le token CSRF

        return redirect('/'); // Redirige vers l'accueil
    }

    public function render()
    {
        return view('livewire.shared.intervenant-hub');
    }
}