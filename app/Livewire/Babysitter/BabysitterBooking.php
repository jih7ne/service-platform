<?php

namespace App\Livewire\Babysitter;

use Livewire\Component;

class BabysitterBooking extends Component
{
    public $babysitterId;
    public $currentStep = 1;
    public $selectedServices = [];
    public $selectedDay = '';
    public $startTime = '';
    public $endTime = '';
    public $address = '';
    public $useRegisteredAddress = false;
    public $children = [];
    public $currentChild = ['nom' => '', 'age' => '', 'besoins' => ''];
    public $agreedToTerms = false;
    public $showSuccess = false;
    public $message = '';
    public $isTimeValid = null; // null = pas encore testé / true / false


    protected $queryString = ['babysitterId'];

    public function mount($id = null)
    {
        $this->babysitterId = $id ?? 1;
    }

    public function toggleService($serviceId)
    {
        if (in_array($serviceId, $this->selectedServices)) {
            $this->selectedServices = array_values(array_diff($this->selectedServices, [$serviceId]));
        } else {
            $this->selectedServices[] = $serviceId;
        }
    }
    public function validateTime()
{
    if (!$this->selectedDay || !$this->startTime || !$this->endTime) {
        $this->isTimeValid = null;
        return;
    }

    if (strtotime($this->startTime) >= strtotime($this->endTime)) {
        $this->isTimeValid = false;
        return;
    }

    $babysitter = $this->getBabysitter();
    $availability = $babysitter['availability'] ?? [];

    if (!isset($availability[$this->selectedDay])) {
        $this->isTimeValid = false;
        return;
    }

    foreach ($availability[$this->selectedDay] as $slot) {
        $slot = trim($slot);

        if (!str_contains($slot, '-')) continue;

        [$slotStart, $slotEnd] = array_map('trim', explode('-', $slot));

        if (
            strtotime($this->startTime) >= strtotime($slotStart) &&
            strtotime($this->endTime) <= strtotime($slotEnd)
        ) {
            $this->isTimeValid = true;
            return;
        }
    }

    $this->isTimeValid = false;
}


    public function addChild()
    {
        if (!empty($this->currentChild['nom']) && !empty($this->currentChild['age'])) {
            $this->children[] = [
                'id' => time() . rand(1000, 9999),
                'nom' => $this->currentChild['nom'],
                'age' => (int)$this->currentChild['age'],
                'besoins' => $this->currentChild['besoins']
            ];
            $this->currentChild = ['nom' => '', 'age' => '', 'besoins' => ''];
        }
    }

    public function removeChild($id)
    {
        $this->children = array_values(array_filter($this->children, function($child) use ($id) {
            return $child['id'] != $id;
        }));
    }

    public function nextStep()
    {
        if ($this->currentStep < 5) {
            $this->currentStep++;
        }
    }

    public function prevStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function confirmBooking()
    {
        $this->showSuccess = true;
    }

    public function canProceed()
    {
        switch ($this->currentStep) {
            case 1:
                return count($this->selectedServices) > 0;
            case 2:
                return !empty($this->selectedDay) && !empty($this->startTime) && !empty($this->endTime) && $this->isTimeSlotValid();
            case 3:
                return $this->useRegisteredAddress || !empty($this->address);
            case 4:
                return count($this->children) > 0;
            case 5:
                return $this->agreedToTerms;
            default:
                return false;
        }
    }

   public function isTimeSlotValid()
{
    
    if (!$this->startTime || !$this->endTime || !$this->selectedDay) {
        return false;
    }

    // start < end obligatoire
    if (strtotime($this->startTime) >= strtotime($this->endTime)) {
        return false;
    }

    $babysitter = $this->getBabysitter();
    $availability = $babysitter['availability'] ?? [];

    if (!isset($availability[$this->selectedDay])) {
        return false;
    }

    foreach ($availability[$this->selectedDay] as $slot) {

        // Nettoyage des espaces invisibles éventuels
        $slot = trim($slot);

        if (!str_contains($slot, '-')) continue;

        [$slotStart, $slotEnd] = array_map('trim', explode('-', $slot));

        $slotStartTs = strtotime($slotStart);
        $slotEndTs = strtotime($slotEnd);
        $selectedStartTs = strtotime($this->startTime);
        $selectedEndTs = strtotime($this->endTime);

        // ➜ INCLUSIF SUR LES LIMITES
        if ($selectedStartTs >= $slotStartTs && $selectedEndTs <= $slotEndTs) {
            return true;
        }
    }

    return false;
}
public function updatedSelectedDay()
{
    $this->validateTime();
}

public function updatedStartTime()
{
    $this->validateTime();
}

public function updatedEndTime()
{
    $this->validateTime();
}


    private function getBabysitter()
    {
        return [
            'id' => 1,
            'nom' => 'Bennani',
            'prenom' => 'Khadija',
            'photo' => 'https://images.unsplash.com/photo-1758525862933-73398157e165?w=400',
            'rating' => 4.9,
            'services' => ['Cuisine', 'Tâches ménagères', 'Aide aux devoirs', 'Faire la lecture', 'Musique', 'Dessin'],
            'availability' => [
                'lundi' => ['09:00-11:00', '14:00-16:00', '17:00-19:00'],
                'mardi' => ['08:00-10:00', '14:00-16:00', '18:00-20:00'],
                'mercredi' => [],
                'jeudi' => ['14:00-16:00', '17:00-19:00'],
                'vendredi' => ['09:00-11:00', '15:00-17:00'],
                'samedi' => ['09:00-11:00', '14:00-16:00', '18:00-20:00'],
                'dimanche' => ['18:00-20:00']
            ]
        ];
    }

    public function render()
    {
        $babysitter = $this->getBabysitter();

        $allServices = [
            ['id' => 'Cuisine', 'name' => 'Cuisine', 'icon' => '🍳', 'color' => '#5B4E9E'],
            ['id' => 'Tâches ménagères', 'name' => 'Tâches ménagères', 'icon' => '🧹', 'color' => '#E87548'],
            ['id' => 'Aide aux devoirs', 'name' => 'Aide aux devoirs', 'icon' => '📚', 'color' => '#4A9E6D'],
            ['id' => 'Faire la lecture', 'name' => 'Faire la lecture', 'icon' => '📖', 'color' => '#4A9ECF'],
            ['id' => 'Musique', 'name' => 'Musique', 'icon' => '🎵', 'color' => '#7E5BA6'],
            ['id' => 'Dessin', 'name' => 'Dessin', 'icon' => '✏️', 'color' => '#E87548'],
            ['id' => 'Jeux créatifs', 'name' => 'Jeux créatifs', 'icon' => '🎨', 'color' => '#E8A548'],
            ['id' => 'Travaux manuels', 'name' => 'Travaux manuels', 'icon' => '🛠️', 'color' => '#6B9E4A']
        ];

        $availableServices = array_values(array_filter($allServices, function($service) use ($babysitter) {
            return in_array($service['name'], $babysitter['services']);
        }));

        $daysOfWeek = [
            ['id' => 'lundi', 'label' => 'Lundi'],
            ['id' => 'mardi', 'label' => 'Mardi'],
            ['id' => 'mercredi', 'label' => 'Mercredi'],
            ['id' => 'jeudi', 'label' => 'Jeudi'],
            ['id' => 'vendredi', 'label' => 'Vendredi'],
            ['id' => 'samedi', 'label' => 'Samedi'],
            ['id' => 'dimanche', 'label' => 'Dimanche']
        ];

        $steps = [
            ['number' => 1, 'label' => 'Service'],
            ['number' => 2, 'label' => 'Date & Heure'],
            ['number' => 3, 'label' => 'Lieu'],
            ['number' => 4, 'label' => 'Enfants'],
            ['number' => 5, 'label' => 'Confirmation']
        ];

        return view('livewire.shared.babysitter-booking', [
            'babysitter' => $babysitter,
            'availableServices' => $availableServices,
            'daysOfWeek' => $daysOfWeek,
            'steps' => $steps
        ]);
    }
}