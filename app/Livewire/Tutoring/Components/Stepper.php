<?php

namespace App\Livewire\Tutoring\Components;

use Livewire\Component;

class Stepper extends Component
{
    public $currentStep;
    public $steps = [
        1 => 'Infos',
        2 => 'Lieu',
        3 => 'Matières',
        4 => 'Finaliser'
    ];

    public function mount($currentStep = 1)
    {
        $this->currentStep = $currentStep;
    }

    public function render()
    {
        return view('livewire.tutoring.components.stepper');
    }
}