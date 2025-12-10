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

    protected $queryString = ['babysitterId'];

    public function mount($id = null)
    {
        $this->babysitterId = $id ?? 1;
    }

    public function toggleService($serviceName)
    {
        if (in_array($serviceName, $this->selectedServices)) {
            $this->selectedServices = array_values(array_diff($this->selectedServices, [$serviceName]));
        } else {
            $this->selectedServices[] = $serviceName;
        }
    }

    public function addChild()
    {
        $nom = trim($this->currentChild['nom']);
        $age = trim($this->currentChild['age']);
        
        if (!empty($nom) && !empty($age) && is_numeric($age)) {
            $this->children[] = [
                'id' => time() . rand(1000, 9999),
                'nom' => $nom,
                'age' => (int)$age,
                'besoins' => trim($this->currentChild['besoins'])
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

        $babysitter = $this->getBabysitter();
        $availableSlots = $babysitter['availability'][$this->selectedDay] ?? [];

        foreach ($availableSlots as $slot) {
            [$slotStart, $slotEnd] = explode('-', $slot);
            
            $slotStartVal = (int)str_replace(':', '', $slotStart);
            $slotEndVal = (int)str_replace(':', '', $slotEnd);
            $selectedStartVal = (int)str_replace(':', '', $this->startTime);
            $selectedEndVal = (int)str_replace(':', '', $this->endTime);

            if ($selectedStartVal >= $slotStartVal && $selectedEndVal <= $slotEndVal) {
                return true;
            }
        }

        return false;
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

        // CORRECTION: Utiliser directement les noms des services de la babysitter
        $serviceData = [
            'Cuisine' => ['icon' => '🍳', 'color' => '#5B4E9E'],
            'Tâches ménagères' => ['icon' => '🧹', 'color' => '#E87548'],
            'Aide aux devoirs' => ['icon' => '📚', 'color' => '#4A9E6D'],
            'Faire la lecture' => ['icon' => '📖', 'color' => '#4A9ECF'],
            'Musique' => ['icon' => '🎵', 'color' => '#7E5BA6'],
            'Dessin' => ['icon' => '✏️', 'color' => '#E87548'],
        ];

        // Créer un tableau simple des services disponibles
        $availableServices = [];
        foreach ($babysitter['services'] as $serviceName) {
            if (isset($serviceData[$serviceName])) {
                $availableServices[] = [
                    'name' => $serviceName,
                    'icon' => $serviceData[$serviceName]['icon'],
                    'color' => $serviceData[$serviceName]['color']
                ];
            }
        }

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

        return view('livewire.babysitter.babysitter-booking', [
            'babysitter' => $babysitter,
            'availableServices' => $availableServices,
            'daysOfWeek' => $daysOfWeek,
            'steps' => $steps
        ]);
    }
}