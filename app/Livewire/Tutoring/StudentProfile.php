<?php

namespace App\Livewire\Tutoring;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentProfile extends Component
{
    public $eleve;
    public $feedbacks = [];
    public $prenom_prof;
    public $photo_prof;
    public $moyenne = 0;
    public $backUrl; 
    public $enAttente;

    public function mount($id)
    {
        $user = Auth::user();
        $this->prenom_prof = $user->prenom;
        $this->photo_prof = $user->photo;

         $source = request()->query('source');
        $demandeId = request()->query('demande_id');

        if ($source === 'details' && $demandeId) {
            // Si on vient des détails, on retourne vers la demande spécifique
            $this->backUrl = route('tutoring.request.details', $demandeId);
        } else {
            // Sinon (par défaut), on retourne vers la liste "Mes demandes"
            $this->backUrl = route('tutoring.requests');
        }

        // 1. Infos Élève (Simple)
        $this->eleve = DB::table('utilisateurs')
            ->leftJoin('localisations', 'utilisateurs.idUser', '=', 'localisations.idUser')
            ->where('utilisateurs.idUser', $id)
            ->select('utilisateurs.*', 'localisations.ville', 'localisations.adresse')
            ->first();

        if (!$this->eleve) {
            return redirect()->back();
        }

        // 2. Feedbacks (Ce que disent les autres profs)
        $this->feedbacks = DB::table('feedbacks')
            ->join('utilisateurs', 'feedbacks.idAuteur', '=', 'utilisateurs.idUser')
            ->where('feedbacks.idCible', $id) // Avis SUR l'élève
            ->select('feedbacks.*', 'utilisateurs.prenom as prof_prenom', 'utilisateurs.nom as prof_nom')
            ->orderBy('dateCreation', 'desc')
            ->get();
            
        // 3. Moyenne de l'élève (Sympathie, Ponctualité...)
        $this->moyenne = DB::table('feedbacks')
            ->where('idCible', $id)
            ->avg('sympathie'); // Ou une moyenne générale
    }

    public function logout() {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.tutoring.student-profile');
    }
}