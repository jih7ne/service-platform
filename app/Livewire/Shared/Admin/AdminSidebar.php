<?php

namespace App\Livewire\Shared\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AdminSidebar extends Component
{
    public $currentPage;
    public $isCollapsed = false;

    public function mount($currentPage = 'admin-dashboard')
    {
        $this->currentPage = $currentPage;
    }

    public function toggleCollapse()
    {
        $this->isCollapsed = !$this->isCollapsed;
    }

    public function navigate($page)
    {
        $this->currentPage = $page;
        $this->dispatch('page-changed', page: $page);
        
        // Redirection selon la page
        return $this->redirect(route('admin.' . str_replace('admin-', '', $page)));
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