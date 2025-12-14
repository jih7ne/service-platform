<?php

namespace App\Livewire\Babysitter;

use Livewire\Component;
use App\Models\Babysitting\Babysitter;
use Carbon\Carbon;

class BabysitterProfilePage extends Component
{
    public $id;
    public $babysitter;
    public $availability = [];
    public $reviews = [];
    public $similarProfiles = [];
    public $langues = [];
    public $maladies = [];
    public $experiencesBesoins = [];

    public function mount($id)
    {
        $this->id = $id;
        $this->loadBabysitter();
    }

    public function loadBabysitter()
    {
        $this->babysitter = Babysitter::with([
            'intervenant.utilisateur.localisations',
            'intervenant.utilisateur.feedbacksRecus',
            'intervenant.disponibilites',
            'intervenant.services',
            'formations',
            'superpouvoirs',
            'categoriesEnfants',
            'experiencesBesoinsSpeciaux',
            'disponibilites' // Ajouter cette relation directe aussi
        ])->findOrFail($this->id);

        // Charger les langues
        $this->langues = $this->babysitter->langues;
        // Charger les maladies
        $this->maladies = $this->babysitter->maladies_list;
        // Charger les expériences besoins spéciaux
        $this->experiencesBesoins = $this->babysitter->experiencesBesoinsSpeciaux;
        $this->formatAvailability();
        $this->loadReviews();
    }

    public function formatAvailability()
    {
        $days = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
        
        // Initialize all days
        foreach ($days as $day) {
            $this->availability[$day] = [];
        }

        // CORRECTION: Essayer d'abord la relation directe, puis celle via intervenant
        $disponibilites = collect([]);

        // Essayer la relation directe d'abord (plus fiable)
        if ($this->babysitter->disponibilites && $this->babysitter->disponibilites->count() > 0) {
            $disponibilites = $this->babysitter->disponibilites;
            \Log::info('Disponibilités trouvées via relation directe: ' . $disponibilites->count());
        } 
        // Sinon essayer via intervenant
        elseif ($this->babysitter->intervenant && $this->babysitter->intervenant->disponibilites) {
            $disponibilites = $this->babysitter->intervenant->disponibilites;
            \Log::info('Disponibilités trouvées via intervenant: ' . $disponibilites->count());
        }

        if ($disponibilites->isEmpty()) {
            \Log::warning('Aucune disponibilité trouvée pour babysitter ID: ' . $this->id);
            return;
        }

        foreach ($disponibilites as $dispo) {
            try {
                // Nettoyer et normaliser le jour
                $dayRaw = trim($dispo->jourSemaine);
                $dayLower = strtolower($dayRaw);

                // Map pour les différents formats possibles
                $dayMap = [
                    'monday' => 'lundi',
                    'tuesday' => 'mardi',
                    'wednesday' => 'mercredi',
                    'thursday' => 'jeudi',
                    'friday' => 'vendredi',
                    'saturday' => 'samedi',
                    'sunday' => 'dimanche',
                    // Aussi gérer les versions capitalisées
                    'lundi' => 'lundi',
                    'mardi' => 'mardi',
                    'mercredi' => 'mercredi',
                    'jeudi' => 'jeudi',
                    'vendredi' => 'vendredi',
                    'samedi' => 'samedi',
                    'dimanche' => 'dimanche',
                ];

                if (isset($dayMap[$dayLower])) {
                    $dayLower = $dayMap[$dayLower];
                }

                if (array_key_exists($dayLower, $this->availability)) {
                    // CORRECTION: Utiliser les propriétés datetime correctement
                    $start = $dispo->heureDebut instanceof \Carbon\Carbon 
                        ? $dispo->heureDebut->format('H:i')
                        : Carbon::parse($dispo->heureDebut)->format('H:i');
                        
                    $end = $dispo->heureFin instanceof \Carbon\Carbon
                        ? $dispo->heureFin->format('H:i')
                        : Carbon::parse($dispo->heureFin)->format('H:i');
                    
                    $timeSlot = "{$start}-{$end}";
                    
                    // Éviter les doublons
                    if (!in_array($timeSlot, $this->availability[$dayLower])) {
                        $this->availability[$dayLower][] = $timeSlot;
                        \Log::info("Ajouté: {$dayLower} -> {$timeSlot}");
                    }
                } else {
                    \Log::warning("Jour non reconnu: {$dayLower} (original: {$dayRaw})");
                }
            } catch (\Exception $e) {
                \Log::error("Erreur lors du formatage de la disponibilité: " . $e->getMessage());
                continue;
            }
        }

        \Log::info('Availability finale: ' . json_encode($this->availability));
    }

    public function loadReviews()
    {
        if ($this->babysitter->intervenant && $this->babysitter->intervenant->utilisateur) {
            $this->reviews = $this->babysitter->intervenant->utilisateur->feedbacksRecus()
                ->with('auteur')
                ->latest('dateCreation')
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.babysitter.babysitter-profile-page');
    }
}