<?php

namespace App\Livewire\Tutoring;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;

class MesCours extends Component
{
    public $enAttente = 0;
    public $prenom;
    public $photo;

    // Modals
    public $showEditModal = false;
    public $showDetailModal = false;
    public $showCreateModal = false; // NOUVEAU

    // Listes pour les menus déroulants
    public $matieresDispo = [];
    public $niveauxDispo = [];

    // Données Formulaire AJOUT
    public $newMatiereId = '';
    public $newNiveauId = '';
    public $newPrix = '';
    public $newType = 'enligne'; // Par défaut

    // Données Formulaire MODIFICATION
    public $currentId;
    public $titre;
    public $prix;
    public $type;
    public $niveau;

    // Données Stats
    public $detailCours;
    public $statsClients = 0;
    public $statsHeures = 0;
   public function goToHub()
    {
        return redirect()->route('intervenant.hub');
    }
    public function mount()
    {
        $user = Auth::user();
        $this->prenom = $user->prenom;
        $this->photo = $user->photo;
        // Sidebar badge count
        $this->refreshPendingRequests();
        
        // On charge les listes pour les formulaires
        $this->niveauxDispo = DB::table('niveaux')->get();
        $this->matieresDispo = DB::table('matieres')->orderBy('nom_matiere')->get();
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

    #[Computed]
    public function cours()
    {
        $user = Auth::user();

        $professeur = DB::table('professeurs')
            ->where('intervenant_id', $user->idUser) 
            ->first();

        if (!$professeur) return [];

        return DB::table('services_prof')
            ->join('matieres', 'services_prof.matiere_id', '=', 'matieres.id_matiere')
            ->join('niveaux', 'services_prof.niveau_id', '=', 'niveaux.id_niveau')
            ->where('services_prof.professeur_id', $professeur->id_professeur)
            ->select('services_prof.*', 'matieres.nom_matiere', 'niveaux.nom_niveau')
            ->orderBy('services_prof.date_creation', 'desc')
            ->get();
    }

    // --- ACTION : OUVRIR POPUP CRÉATION ---
    public function openCreateModal()
    {
        $this->reset(['newMatiereId', 'newNiveauId', 'newPrix', 'newType']);
        $this->newType = 'enligne'; // Remettre par défaut
        $this->showCreateModal = true;
    }

    // --- ACTION : ENREGISTRER LE NOUVEAU COURS ---
    public function create()
    {
        $this->validate([
            'newMatiereId' => 'required|exists:matieres,id_matiere',
            'newNiveauId' => 'required|exists:niveaux,id_niveau',
            'newPrix' => 'required|numeric|min:50',
            'newType' => 'required|in:enligne,domicile',
        ], [
            'newMatiereId.required' => 'Veuillez choisir une matière.',
            'newNiveauId.required' => 'Veuillez choisir un niveau.',
            'newPrix.required' => 'Le tarif est obligatoire.',
        ]);

        $user = Auth::user();
        $professeur = DB::table('professeurs')->where('intervenant_id', $user->idUser)->first();

        // On récupère le nom de la matière pour le titre automatique
        $nomMatiere = DB::table('matieres')->where('id_matiere', $this->newMatiereId)->value('nom_matiere');

        DB::table('services_prof')->insert([
            'titre' => $nomMatiere, // On utilise le nom de la matière comme titre
            'description' => null,  // On laisse vide comme demandé
            'prix_par_heure' => $this->newPrix,
            'status' => 'actif',
            'type_service' => $this->newType,
            'professeur_id' => $professeur->id_professeur,
            'matiere_id' => $this->newMatiereId,
            'niveau_id' => $this->newNiveauId,
            'date_creation' => now(),
            'date_modification' => now(),
        ]);

        $this->showCreateModal = false;
        session()->flash('success', 'Nouveau cours ajouté avec succès !');
    }

    // --- AUTRES ACTIONS (inchangées) ---
    public function toggleStatus($idService)
    {
        $service = DB::table('services_prof')->where('id_service', $idService)->first();
        if ($service) {
            $newStatus = ($service->status === 'actif') ? 'inactif' : 'actif';
            DB::table('services_prof')->where('id_service', $idService)->update(['status' => $newStatus]);
            session()->flash('success', $newStatus === 'actif' ? 'Cours visible.' : 'Cours masqué.');
        }
    }

    public function edit($idService)
    {
        $service = DB::table('services_prof')
            ->join('matieres', 'services_prof.matiere_id', '=', 'matieres.id_matiere')
            ->where('id_service', $idService)
            ->select('services_prof.*', 'matieres.nom_matiere')
            ->first();

        if ($service) {
            $this->currentId = $service->id_service;
            $this->titre = $service->nom_matiere;
            $this->prix = $service->prix_par_heure;
            $this->type = $service->type_service;
            $this->niveau = $service->niveau_id;
            $this->showEditModal = true;
        }
    }

    public function update()
    {
        $this->validate([
            'prix' => 'required|numeric|min:0',
            'niveau' => 'required|exists:niveaux,id_niveau',
            'type' => 'required'
        ]);

        DB::table('services_prof')
            ->where('id_service', $this->currentId)
            ->update([
                'prix_par_heure' => $this->prix,
                'type_service' => $this->type,
                'niveau_id' => $this->niveau,
                'date_modification' => now()
            ]);

        $this->showEditModal = false;
        session()->flash('success', 'Cours mis à jour.');
    }

    public function showDetails($idService)
    {
        // 1. Infos du cours (Titre, Matière...)
        $this->detailCours = DB::table('services_prof')
            ->join('matieres', 'services_prof.matiere_id', '=', 'matieres.id_matiere')
            ->where('services_prof.id_service', $idService)
            ->select('services_prof.titre', 'services_prof.date_creation', 'matieres.nom_matiere')
            ->first();

        // 2. Nombre d'élèves (Clients uniques)
        // On compte tous ceux qui ont réservé (même futur), c'est logique pour la popularité
        $this->statsClients = DB::table('demandes_prof')
            ->join('demandes_intervention', 'demandes_prof.demande_id', '=', 'demandes_intervention.idDemande')
            ->where('demandes_prof.service_prof_id', $idService)
            ->whereIn('demandes_intervention.statut', ['validée', 'terminée'])
            ->distinct('demandes_intervention.idClient')
            ->count('demandes_intervention.idClient');

        // 3. Heures Enseignées (CORRECTION ICI)
        // On récupère toutes les demandes validées
        $coursFaits = DB::table('demandes_prof')
            ->join('demandes_intervention', 'demandes_prof.demande_id', '=', 'demandes_intervention.idDemande')
            ->where('demandes_prof.service_prof_id', $idService)
            ->whereIn('demandes_intervention.statut', ['validée', 'terminée'])
            ->select('demandes_intervention.dateSouhaitee', 'demandes_intervention.heureDebut', 'demandes_intervention.heureFin')
            ->get();

        $minutes = 0;
        $maintenant = now(); // Date et heure actuelles

        foreach ($coursFaits as $c) {
            // On reconstruit la date de fin exacte (Date du cours + Heure de fin)
            $dateCours = \Carbon\Carbon::parse($c->dateSouhaitee);
            $heureFin = \Carbon\Carbon::parse($c->heureFin);
            
            // On crée un timestamp complet "YYYY-MM-DD HH:MM:SS" pour la fin du cours
            $finDuCours = $dateCours->copy()->setTime($heureFin->hour, $heureFin->minute, 0);

            // ON COMPTE L'HEURE SEULEMENT SI LE COURS EST FINI (DANS LE PASSÉ)
            if ($finDuCours->isPast()) {
                $debut = \Carbon\Carbon::parse($c->heureDebut);
                $fin = \Carbon\Carbon::parse($c->heureFin);
                
                // diffInMinutes calcule la durée absolue (toujours positive)
                $minutes += $fin->diffInMinutes($debut);
            }
        }

        // Conversion en heures (arrondi à 1 chiffre après la virgule)
        $this->statsHeures = round($minutes / 60, 1);

        $this->showDetailModal = true;
    }

    public function closeModal()
    {
        $this->showEditModal = false;
        $this->showDetailModal = false;
        $this->showCreateModal = false;
    }

    public function logout() {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.tutoring.mes-cours');
    }
}