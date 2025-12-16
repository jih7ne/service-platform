<?php

namespace App\Livewire\Tutoring;

use App\Livewire\Shared\GestionDisponibilites;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DisponibilitesPage extends GestionDisponibilites
{
    public $prenom;
    public $photo;

    // CORRECTION : On doit accepter le paramètre comme le parent ($intervenantId = null)
    public function mount($intervenantId = null)
    {
        $user = Auth::user();
        
        // 1. Charger les infos pour la Sidebar (Design)
        $this->prenom = $user->prenom;
        $this->photo = $user->photo;

        // 2. LOGIQUE SPÉCIALE : Récupérer le bon ID Intervenant
        // Le composant partagé s'attend à recevoir l'ID de la table 'intervenants'
        // Si aucun ID n'est passé, on le cherche via l'utilisateur connecté
        if (!$intervenantId) {
            $intervenantData = DB::table('intervenants')
                ->where('IdIntervenant', $user->idUser) // Lien User -> Intervenant
                ->first();

            if ($intervenantData) {
                $intervenantId = $intervenantData->id; // On prend la clé primaire (ex: 1)
            }
        }

        // 3. On appelle le parent avec le BON ID
        // Cela va charger $this->disponibilites, $this->viewMode, etc.
        parent::mount($intervenantId);
    }

    public function logout() {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }

    public function render()
    {
        // On utilise TA vue avec le design Bleu/Jaune
        return view('livewire.tutoring.disponibilites');
    }
}