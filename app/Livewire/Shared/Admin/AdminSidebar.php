<?php

namespace App\Livewire\Shared\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AdminSidebar extends Component
{
    public $currentPage;
    public $isCollapsed = false;

    public function mount($currentPage = null)
    {
        // Détection automatique de la page courante depuis l'URL
        $this->currentPage = $this->detectCurrentPage();
    }

    /**
     * Détecte la page actuelle à partir de l'URL actuelle
     */
    private function detectCurrentPage()
    {
        $currentUrl = request()->path();
        
        // Mapping des URLs vers les noms de pages
        // IMPORTANT: Vérifier d'abord les URLs les plus spécifiques
        if (str_contains($currentUrl, 'admin/users')) {
            return 'admin-users';
        } elseif (str_contains($currentUrl, 'admin/reclamation')) {
            // Gère à la fois /admin/reclamations ET /admin/reclamations/{id}/details
            return 'admin-complaints';
        } elseif (str_contains($currentUrl, 'admin/intervenant')) {
            // Gère à la fois /admin/intervenants ET /admin/intervenant/{id}
            return 'admin-intervenants';
        } elseif (str_contains($currentUrl, 'admin/dashboard')) {
            return 'admin-dashboard';
        } elseif (str_contains($currentUrl, 'admin')) {
            return 'admin-dashboard';
        }
        
        return 'admin-dashboard';
    }

    public function toggleCollapse()
    {
        $this->isCollapsed = !$this->isCollapsed;
    }

    public function navigate($page)
    {
        $this->currentPage = $page;
        
        // Mapping des pages vers les URLs
        $urlMapping = [
            'admin-dashboard' => '/admin/dashboard',
            'admin-users' => '/admin/users',
            'admin-complaints' => '/admin/reclamations',
            'admin-intervenants' => '/admin/intervenants',
        ];

        $url = $urlMapping[$page] ?? '/admin/dashboard';
        
        return $this->redirect($url);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return $this->redirect(route('login'));
    }

    public function render()
    {
        return view('livewire.shared.admin.admin-sidebar');
    }
}