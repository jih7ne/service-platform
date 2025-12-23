<?php

namespace App\Livewire\Shared;

use Livewire\Component;

class HeaderBabysitting extends Component
{
    public $menuOpen = false;

    public function toggleMenu()
    {
        $this->menuOpen = !$this->menuOpen;
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.shared.header-babysitting');
    }
}
