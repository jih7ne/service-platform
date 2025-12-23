<?php

namespace App\Livewire\Tutoring;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class AvisPage extends Component
{
    public $intervenantId;
    public $professeur;
    public function mount()
    {
        $user = auth()->user();
        $userId = $user->idUser;

        // Load professor record for sidebar/context (if available)
        try {
            $this->professeur = DB::table('professeurs')->where('intervenant_id', $userId)->first();
        } catch (\Throwable $e) {
            \Log::warning('Unable to load professeur for tutoring avis page', ['error' => $e->getMessage()]);
            $this->professeur = null;
        }

        // For feedback queries we use the user id as idCible (keeps parity with existing behavior)
        $this->intervenantId = $userId;
    }

    public function render()
    {
        return view('livewire.tutoring.avis');
    }
}
