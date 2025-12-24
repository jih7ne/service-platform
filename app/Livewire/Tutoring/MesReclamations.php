<?php

namespace App\Livewire\Tutoring;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Shared\Reclamation;
use Livewire\WithPagination;

class MesReclamations extends Component
{
    use WithPagination;

    public $prenom;
    
    // Filtres
    public $filtreStatut = 'tous';
    public $filtrePriorite = 'tous';
    public $recherche = '';

    public function mount()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $this->prenom = $user->prenom;
    }

    /**
     * Statistiques GLOBALES (toujours sans filtre)
     */
    public function getStatsProperty()
    {
        $userId = Auth::id();

        return [
            'totalReclamations' => Reclamation::where('idAuteur', $userId)->count(),
            'enAttente' => Reclamation::where('idAuteur', $userId)->where('statut', 'en_attente')->count(),
            'enCours' => 0, // ✅ Toujours 0 car 'en_cours' n'existe pas dans votre BDD
            'resolues' => Reclamation::where('idAuteur', $userId)->where('statut', 'resolue')->count(), // ✅ 'resolue' pas 'resolu'
        ];
    }

    /**
     * Reset pagination quand la recherche change
     */
    public function updatingRecherche()
    {
        $this->resetPage();
    }

    /**
     * Reset pagination quand le filtre statut change
     */
    public function updatingFiltreStatut()
    {
        $this->resetPage();
    }

    /**
     * Reset pagination quand le filtre priorité change
     */
    public function updatingFiltrePriorite()
    {
        $this->resetPage();
    }

    /**
     * Déconnexion
     */
    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }

    /**
     * Rendu de la vue avec les réclamations filtrées et paginées
     */
    public function render()
    {
        // Récupérer les réclamations du professeur connecté avec filtres
        $reclamations = Reclamation::where('idAuteur', Auth::id())
            // ✅ Filtre par statut - mapping vers les vraies valeurs BDD
            ->when($this->filtreStatut !== 'tous', function ($query) {
                // Mapper les valeurs du select vers les valeurs réelles de la BDD
                $statutMapping = [
                    'en_attente' => 'en_attente',
                    'resolu' => 'resolue', // ✅ Mapper vers 'resolue' (la vraie valeur BDD)
                ];
                
                $statutBDD = $statutMapping[$this->filtreStatut] ?? $this->filtreStatut;
                $query->where('statut', $statutBDD);
            })
            // ✅ Filtre par priorité - mapping vers les vraies valeurs BDD
            ->when($this->filtrePriorite !== 'tous', function ($query) {
                // Mapper les valeurs du select vers les valeurs réelles de la BDD
                $prioriteMapping = [
                    'faible' => 'faible',
                    'normal' => 'moyenne', // ✅ Mapper 'normal' vers 'moyenne'
                    'urgent' => 'urgente', // ✅ Mapper 'urgent' vers 'urgente'
                ];
                
                $prioriteBDD = $prioriteMapping[$this->filtrePriorite] ?? $this->filtrePriorite;
                $query->where('priorite', $prioriteBDD);
            })
            // Recherche par sujet ou description
            ->when($this->recherche, function ($query) {
                $query->where(function ($q) {
                    $q->where('sujet', 'like', '%' . $this->recherche . '%')
                      ->orWhere('description', 'like', '%' . $this->recherche . '%');
                });
            })
            // Trier par date de création décroissante
            ->orderBy('dateCreation', 'desc')
            // Paginer 10 réclamations par page
            ->paginate(10);

        // Récupérer les stats GLOBALES (sans filtres)
        $stats = $this->stats;

        return view('livewire.tutoring.mes-reclamations', [
            'reclamations' => $reclamations,
            'totalReclamations' => $stats['totalReclamations'],
            'enAttente' => $stats['enAttente'],
            'enCours' => $stats['enCours'],
            'resolues' => $stats['resolues'],
        ]);
    }
}