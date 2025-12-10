<?php

namespace App\Livewire\Tutoring\Steps;

use Livewire\Component;

class InformationsPersonnelles extends Component
{
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $telephone;
    public $dateNaissance;
    public $showPassword = false;

    public function mount($firstName, $lastName, $email, $password, $telephone, $dateNaissance)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->telephone = $telephone;
        $this->dateNaissance = $dateNaissance;
    }

    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function render()
    {
        return view('livewire.tutoring.steps.informations-personnelles');
    }
}