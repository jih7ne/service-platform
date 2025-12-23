<?php

namespace App\Livewire\Babysitter;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Babysitting\Babysitter;

class AvisPage extends Component
{
    public $intervenantId;
    public $babysitter;

    public function mount()
    {
        $userId = auth()->id();

        try {
            // Load babysitter model for sidebar and related info (guarded against DB errors)
            $this->babysitter = Babysitter::where('idBabysitter', $userId)->first();
        } catch (\Exception $e) {
            \Log::error('Unable to load babysitter model', ['exception' => $e]);
            $this->babysitter = null;
            session()->flash('error', "Impossible de charger votre profil pour le moment.");
        }

        // Determine intervenant id (prefer the intervenant relation if present)
        $this->intervenantId = $this->babysitter?->idBabysitter ?? $userId;
    }

    public function render()
    {
        // Explicitly pass $babysitter to the blade so the sidebar never sees an undefined variable
        return view('livewire.babysitter.avis', ['babysitter' => $this->babysitter])
            ->layout('layouts.babysitter');
    }
}
