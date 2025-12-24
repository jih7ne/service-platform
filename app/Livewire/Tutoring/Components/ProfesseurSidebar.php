<?php

namespace App\Livewire\Tutoring\Components;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfesseurSidebar extends Component
{
    public $currentPage;
    public $isCollapsed = false;
    
    // Infos utilisateur
    public $prenom;
    public $nom;
    public $photo;
    
    // Badge notifications
    public $enAttente = 0;

    public function mount($currentPage = null)
    {
        // Si une page est passée explicitement, on l'utilise
        // Sinon on détecte automatiquement
        $this->currentPage = $currentPage ?? $this->detectCurrentPage();
        $this->loadUserInfo();
        $this->loadNotifications();
    }

    /**
     * Détecte la page actuelle à partir de l'URL
     */
    private function detectCurrentPage()
    {
        $currentUrl = request()->path();
        
        // Hub intervenant
        if (str_contains($currentUrl, 'intervenant/hub')) {
            return 'intervenant-hub';
        }
        
        // Demandes (inclut aussi les détails de demande et profil candidat)
        if (str_contains($currentUrl, 'tutoring/demande/') || 
            str_contains($currentUrl, 'tutoring/profil-candidat/') ||
            str_contains($currentUrl, 'tutoring/requests')) {
            return 'tutoring-requests';
        }
        
        // Clients (inclut aussi les détails client)
        if (str_contains($currentUrl, 'tutoring/client/') || 
            str_contains($currentUrl, 'tutoring/mes-clients')) {
            return 'tutoring-clients';
        }
        
        // Disponibilités
        if (str_contains($currentUrl, 'tutoring/disponibilites')) {
            return 'tutoring-disponibilites';
        }
        
        // Cours
        if (str_contains($currentUrl, 'tutoring/mes-cours') || 
            str_contains($currentUrl, 'tutoring/courses')) {
            return 'tutoring-courses';
        }

        // Avis
        if (str_contains($currentUrl, 'tutoring/avis') || 
            str_contains($currentUrl, 'tutoring/mes-avis')) {
            return 'tutoring-avis';
        }

        // Réclamations
        if (str_contains($currentUrl, 'tutoring/mes-reclamations')) {
            return 'tutoring-mes-reclamations';
        }
        
        // Profil
        if (str_contains($currentUrl, 'tutoring/mon-profil') || 
            str_contains($currentUrl, 'tutoring/profile')) {
            return 'tutoring-profile';
        }
        
        // Dashboard (par défaut)
        if (str_contains($currentUrl, 'tutoring/dashboard')) {
            return 'tutoring-dashboard';
        }
        
        return 'tutoring-dashboard';
    }

    /**
     * Charge les infos utilisateur
     */
    private function loadUserInfo()
    {
        $user = Auth::user();
        if ($user) {
            $this->prenom = $user->prenom;
            $this->nom = $user->nom;
            $this->photo = $user->photo;
        }
    }

    /**
     * Charge le nombre de demandes en attente
     */
    private function loadNotifications()
    {
        $user = Auth::user();
        if ($user) {
            $this->enAttente = DB::table('demandes_intervention')
                ->where('idIntervenant', $user->idUser)
                ->where('statut', 'en_attente')
                ->count();
        }
    }

    public function toggleCollapse()
    {
        $this->isCollapsed = !$this->isCollapsed;
    }

    public function navigate($page)
    {
        $this->currentPage = $page;
        
        // Mapping des pages vers les routes
        $routeMapping = [
            'tutoring-dashboard' => 'tutoring.dashboard',
            'tutoring-requests' => 'tutoring.requests',
            'tutoring-disponibilites' => 'tutoring.disponibilites',
            'tutoring-clients' => 'tutoring.clients',
            'tutoring-courses' => 'tutoring.courses',
            'tutoring-avis' => 'tutoring.avis',
            'tutoring-mes-reclamations' => 'tutoring.mes-reclamations',
            'tutoring-profile' => 'tutoring.profile',
            'intervenant-hub' => 'intervenant.hub',
        ];
        
        $route = $routeMapping[$page] ?? 'tutoring.dashboard';
        
        return $this->redirect(route($route));
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return $this->redirect('/');
    }

    public function render()
    {
        return view('livewire.tutoring.components.professeur-sidebar');
    }
}