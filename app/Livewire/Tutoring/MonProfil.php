<?php

namespace App\Livewire\Tutoring;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads; // Pour gérer l'upload de photo si besoin

class MonProfil extends Component
{
    use WithFileUploads;

    public $user;
    public $professeur;
    public $localisation;
    public $note = 0;
    public $nbMissions = 0;
    public $enAttente = 0;

    // --- VARIABLES POUR LE FORMULAIRE ---
    public $showEditModal = false;
    public $edit_telephone;
    public $edit_adresse;
    public $edit_ville;
    public $edit_niveau;
    public $niveauxDispo = [];
   public function goToHub()
    {
        return redirect()->route('intervenant.hub');
    }
    public function mount()
    {
        $this->refreshData();
        $this->niveauxDispo = DB::table('niveaux')->get(); // Pour la liste déroulante
        $this->refreshPendingRequests();
    }

    // Fonction pour recharger les données fraîches
    public function refreshData()
    {
        $userId = Auth::id();
        $this->user = DB::table('utilisateurs')->where('idUser', $userId)->first();
        $this->professeur = DB::table('professeurs')->where('intervenant_id', $userId)->first();
        $this->localisation = DB::table('localisations')->where('idUser', $userId)->first();
        
        $this->note = DB::table('feedbacks')->where('idCible', $userId)->avg('qualiteTravail') ?? 0;
        $this->nbMissions = DB::table('demandes_intervention')
            ->where('idIntervenant', $userId)
            ->whereIn('statut', ['validée', 'terminée'])
            ->count();
    }

    public function refreshPendingRequests(): void
    {
        $user = Auth::user();
        if (!$user) { $this->enAttente = 0; return; }

        $this->enAttente = (int) DB::table('demandes_intervention')
            ->where('idIntervenant', $user->idUser)
            ->where('statut', 'en_attente')
            ->count();
    }

    public function hydrate(): void
    {
        $this->refreshPendingRequests();
    }

    // --- ACTION : OUVRIR LA POPUP ---
    public function openEditModal()
    {
        // On pré-remplit les champs avec les valeurs actuelles
        $this->edit_telephone = $this->user->telephone;
        $this->edit_adresse = $this->localisation->adresse ?? '';
        $this->edit_ville = $this->localisation->ville ?? '';
        $this->edit_niveau = $this->professeur->niveau_etudes ?? '';
        
        $this->showEditModal = true;
    }

    public function closeModal()
    {
        $this->showEditModal = false;
    }

    // --- ACTION : SAUVEGARDER ---
    public function updateProfile()
    {
        $userId = Auth::id();

        // 1. Validation
        $this->validate([
            'edit_telephone' => 'required|min:10',
            'edit_ville' => 'required|string',
            'edit_adresse' => 'nullable|string',
            'edit_niveau' => 'nullable|string',
        ]);

        // 2. Mise à jour Table UTILISATEURS (Téléphone)
        DB::table('utilisateurs')
            ->where('idUser', $userId)
            ->update(['telephone' => $this->edit_telephone]);

        // 3. Mise à jour Table LOCALISATIONS (Adresse/Ville)
        // On utilise updateOrInsert car la ligne peut ne pas exister
        DB::table('localisations')->updateOrInsert(
            ['idUser' => $userId],
            ['ville' => $this->edit_ville, 'adresse' => $this->edit_adresse]
        );

        // 4. Mise à jour Table PROFESSEURS (Niveau d'étude)
        if ($this->professeur) {
            DB::table('professeurs')
                ->where('id_professeur', $this->professeur->id_professeur)
                ->update(['niveau_etudes' => $this->edit_niveau]);
        }

        // 5. Fin
        $this->showEditModal = false;
        $this->refreshData(); // On recharge l'affichage
        session()->flash('success', 'Profil mis à jour avec succès !');
    }

    public function logout() {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.tutoring.mon-profil');
    }
}