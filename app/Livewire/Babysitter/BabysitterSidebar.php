<?php

namespace App\Livewire\Babysitter;

use Livewire\Component;
use App\Models\Shared\Utilisateur;
use App\Models\Babysitting\DemandeIntervention;

class BabysitterSidebar extends Component
{
    public $babysitter;
    public $pendingRequestsCount = 0;
    public $currentPage = 'dashboard';

    protected $listeners = ['refreshSidebar' => '$refresh'];

    public function mount($currentPage = 'dashboard')
    {
        $this->currentPage = $currentPage;
        $this->loadBabysitterData();
    }

    public function loadBabysitterData()
    {
        $user = auth()->user();
        if ($user && $user->role === 'intervenant') {
            $this->babysitter = $user->intervenant->babysitter ?? null;
            $this->pendingRequestsCount = DemandeIntervention::where('idIntervenant', $user->id)
                ->where('statut', 'en_attente')
                ->count();
        }
    }

    public function setActivePage($page)
    {
        $this->currentPage = $page;
        $this->dispatch('navigateTo', page: $page);
    }

    public function render()
    {
        return view('livewire.babysitter.babysitter-sidebar');
    }
}
