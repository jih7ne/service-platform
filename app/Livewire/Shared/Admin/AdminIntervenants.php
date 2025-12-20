<?php

namespace App\Livewire\Shared\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Shared\Intervenant;
use App\Models\Shared\Utilisateur;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\IntervenantAccepte;
use App\Mail\IntervenantRefuse;

class AdminIntervenants extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $statusFilter = 'tous';
    public $showDetailModal = false;
    public $selectedIntervenant = null;
    public $selectedUser = null;
    public $professeurData = null;
    public $babysitterData = null;
    public $petkeeperData = null;
    public $serviceType = null;
    public $refusalReason = '';
    public $showRefusalModal = false;
    public $intervenantToRefuse = null;

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        // Vérifier si l'utilisateur est admin
        if (!session()->has('is_admin')) {
            return redirect()->route('login')->with('error', 'Accès réservé aux administrateurs');
        }
    }

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function viewDetails($intervenantId)
    {
        $this->selectedIntervenant = Intervenant::find($intervenantId);
        
        if ($this->selectedIntervenant) {
            $this->selectedUser = Utilisateur::leftJoin('localisations', 'utilisateurs.idUser', '=', 'localisations.idUser')
                ->where('utilisateurs.idUser', $this->selectedIntervenant->IdIntervenant)
                ->select('utilisateurs.*', 'localisations.ville', 'localisations.adresse')
                ->first();
            
            // Réinitialiser les données
            $this->professeurData = null;
            $this->babysitterData = null;
            $this->petkeeperData = null;
            $this->serviceType = null;
            
            // Charger les données spécifiques selon le type d'intervenant
            $this->loadIntervenantSpecificData($this->selectedIntervenant->IdIntervenant);
            
            $this->showDetailModal = true;
        }
    }

    private function loadIntervenantSpecificData($idIntervenant)
    {
        // Vérifier si c'est un professeur
        $professeur = DB::table('professeurs')
            ->where('intervenant_id', $idIntervenant)
            ->first();
        
        if ($professeur) {
            $this->serviceType = 'Soutien Scolaire';
            $this->professeurData = $professeur;
            
            // Charger les matières et niveaux
            $this->professeurData->matieres = DB::table('services_prof')
                ->join('matieres', 'services_prof.matiere_id', '=', 'matieres.id_matiere')
                ->where('services_prof.professeur_id', $professeur->id_professeur)
                ->select('matieres.nom_matiere', 'services_prof.type_service', 'services_prof.prix_par_heure')
                ->get();
            
            return;
        }
        
        // Vérifier si c'est un babysitter
        $babysitter = DB::table('babysitters')
            ->where('idBabysitter', $idIntervenant)
            ->first();
        
        if ($babysitter) {
            $this->serviceType = 'Babysitting';
            $this->babysitterData = $babysitter;
            
            // Charger les superpouvoirs
            $this->babysitterData->superpouvoirs = DB::table('choisir_superpourvoirs')
                ->join('superpouvoirs', 'choisir_superpourvoirs.idSuperpourvoirs', '=', 'superpouvoirs.idSuperpourvoirs')
                ->where('choisir_superpourvoirs.idBabysitter', $idIntervenant)
                ->pluck('superpouvoirs.nom')
                ->toArray();
            
            // Charger les formations
            $this->babysitterData->formations = DB::table('choisir_formations')
                ->join('formations', 'choisir_formations.idFormation', '=', 'formations.idFormation')
                ->where('choisir_formations.idBabysitter', $idIntervenant)
                ->pluck('formations.nom')
                ->toArray();
            
            // Charger les catégories d'enfants
            $this->babysitterData->categories = DB::table('choisir_categories')
                ->join('categorie_enfants', 'choisir_categories.idCategorieEnfant', '=', 'categorie_enfants.idCategorieEnfant')
                ->where('choisir_categories.idBabysitter', $idIntervenant)
                ->pluck('categorie_enfants.trancheAge')
                ->toArray();
            
            return;
        }
        
        // Vérifier si c'est un gardien d'animaux
        $petkeeper = DB::table('petkeepers')
            ->where('idPetKeeper', $idIntervenant)
            ->first();
        
        if ($petkeeper) {
            $this->serviceType = "Garde d'animaux";
            $this->petkeeperData = $petkeeper;
            
            // Charger les certifications
            $this->petkeeperData->certifications = DB::table('petkeeper_certifications')
                ->where('petkeeper_id', $petkeeper->id)
                ->get();
            
            return;
        }
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->selectedIntervenant = null;
        $this->selectedUser = null;
        $this->professeurData = null;
        $this->babysitterData = null;
        $this->petkeeperData = null;
        $this->serviceType = null;
    }

    public function approveIntervenant($intervenantId)
    {
        $intervenant = Intervenant::find($intervenantId);
        
        if ($intervenant) {
            $intervenant->statut = 'VALIDE';
            $intervenant->idAdmin = session('admin_id');
            $intervenant->save();

            // Récupérer l'utilisateur pour l'email
            $user = Utilisateur::find($intervenant->IdIntervenant);
            
            // Envoyer l'email d'acceptation
            try {
                Mail::to($user->email)->send(new IntervenantAccepte($user, $this->serviceType ?? 'Intervenant'));
            } catch (\Exception $e) {
                // Log l'erreur mais continue l'exécution
                \Log::error('Erreur envoi email acceptation: ' . $e->getMessage());
            }

            session()->flash('success', 'Intervenant approuvé avec succès ! Un email de confirmation a été envoyé.');
            $this->closeDetailModal();
        }
    }

    public function openRefusalModal($intervenantId)
    {
        $this->intervenantToRefuse = $intervenantId;
        $this->showRefusalModal = true;
        $this->refusalReason = '';
    }

    public function closeRefusalModal()
    {
        $this->showRefusalModal = false;
        $this->intervenantToRefuse = null;
        $this->refusalReason = '';
    }

    public function refuseIntervenant()
    {
        $this->validate([
            'refusalReason' => 'required|min:10'
        ], [
            'refusalReason.required' => 'Veuillez indiquer la raison du refus',
            'refusalReason.min' => 'La raison doit contenir au moins 10 caractères'
        ]);

        $intervenant = Intervenant::find($this->intervenantToRefuse);
        
        if ($intervenant) {
            $intervenant->statut = 'REFUSE';
            $intervenant->idAdmin = session('admin_id');
            $intervenant->save();

            // Récupérer l'utilisateur pour l'email
            $user = Utilisateur::find($intervenant->IdIntervenant);
            
            // Envoyer l'email de refus
            try {
                Mail::to($user->email)->send(new IntervenantRefuse($user, $this->refusalReason, $this->serviceType ?? 'Intervenant'));
            } catch (\Exception $e) {
                // Log l'erreur mais continue l'exécution
                \Log::error('Erreur envoi email refus: ' . $e->getMessage());
            }

            session()->flash('success', 'Demande refusée. Un email d\'information a été envoyé à l\'intervenant.');
            $this->closeRefusalModal();
            $this->closeDetailModal();
        }
    }

    public function render()
    {
        $query = Intervenant::join('utilisateurs', 'intervenants.IdIntervenant', '=', 'utilisateurs.idUser')
            ->leftJoin('localisations', 'utilisateurs.idUser', '=', 'localisations.idUser')
            ->select(
                'intervenants.*',
                'utilisateurs.nom',
                'utilisateurs.prenom',
                'utilisateurs.email',
                'utilisateurs.telephone',
                'utilisateurs.photo',
                'localisations.ville',
                'localisations.adresse'
            );

        // Filtre de recherche
        if ($this->searchTerm) {
            $query->where(function($q) {
                $q->where('utilisateurs.nom', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('utilisateurs.prenom', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('utilisateurs.email', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('localisations.ville', 'like', '%' . $this->searchTerm . '%');
            });
        }

        // Filtre de statut
        if ($this->statusFilter !== 'tous') {
            $query->where('intervenants.statut', strtoupper($this->statusFilter));
        }

        $intervenants = $query->orderBy('intervenants.created_at', 'desc')->paginate(10);

        // Charger les données spécifiques pour chaque intervenant
        foreach ($intervenants as $intervenant) {
            $this->loadIntervenantTypeData($intervenant);
        }

        // Statistiques
        $stats = [
            'total' => Intervenant::count(),
            'en_attente' => Intervenant::where('statut', 'EN_ATTENTE')->count(),
            'valides' => Intervenant::where('statut', 'VALIDE')->count(),
            'refuses' => Intervenant::where('statut', 'REFUSE')->count(),
        ];

        return view('livewire.shared.admin.admin-intervenants', [
            'intervenants' => $intervenants,
            'stats' => $stats
        ]);
    }

    private function loadIntervenantTypeData($intervenant)
    {
        // Vérifier si c'est un professeur
        $professeur = DB::table('professeurs')
            ->where('intervenant_id', $intervenant->IdIntervenant)
            ->first();
        
        if ($professeur) {
            $intervenant->service_type = 'Soutien scolaire';
            $intervenant->service_icon = '📚';
            
            // Charger la première matière comme aperçu
            $matiere = DB::table('services_prof')
                ->join('matieres', 'services_prof.matiere_id', '=', 'matieres.id_matiere')
                ->where('services_prof.professeur_id', $professeur->id_professeur)
                ->select('matieres.nom_matiere', 'services_prof.type_service')
                ->first();
            
            if ($matiere) {
                $intervenant->service_details = $matiere->nom_matiere . ' - ' . $matiere->type_service;
            } else {
                $intervenant->service_details = 'Cours de soutien scolaire';
            }
            
            return;
        }
        
        // Vérifier si c'est un babysitter
        $babysitter = DB::table('babysitters')
            ->where('idBabysitter', $intervenant->IdIntervenant)
            ->first();
        
        if ($babysitter) {
            $intervenant->service_type = 'Babysitting';
            $intervenant->service_icon = '👶';
            
            // Charger les catégories d'enfants
            $categories = DB::table('choisir_categories')
                ->join('categorie_enfants', 'choisir_categories.idCategorie', '=', 'categorie_enfants.idCategorie')
                ->where('choisir_categories.idBabysitter', $intervenant->IdIntervenant)
                ->pluck('categorie_enfants.categorie')
                ->toArray();
            
            if (!empty($categories)) {
                $intervenant->service_details = 'Garde d\'enfants (' . implode(', ', $categories) . ')';
            } else {
                $intervenant->service_details = 'Garde d\'enfants';
            }
            
            return;
        }
        
        // Vérifier si c'est un gardien d'animaux
        $petkeeper = DB::table('petkeepers')
            ->where('idPetKeeper', $intervenant->IdIntervenant)
            ->first();
        
        if ($petkeeper) {
            $intervenant->service_type = 'Garde d\'animaux';
            $intervenant->service_icon = '🐾';
            $intervenant->service_details = 'Spécialité: ' . ($petkeeper->specialite ?? 'Non spécifié');
            return;
        }
        
        // Par défaut
        $intervenant->service_type = 'Service général';
        $intervenant->service_icon = '💼';
        $intervenant->service_details = 'Intervenant';
    }
}
