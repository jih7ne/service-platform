<?php

namespace App\Livewire\Babysitter;

use Livewire\Component;
use App\Models\Babysitting\DemandeIntervention;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Babysitter\DemandeAcceptedForBabysitter;
use App\Mail\Babysitter\DemandeAcceptedForClient;
use App\Mail\Babysitter\DemandeRefusedForClient;

class DemandesInterface extends Component
{
    public $selectedTab = 'en_attente';
    public $searchQuery = '';
    public $selectedDemande = null;
    public $showModal = false;
    public $babysitter;
    public $dateFilter = '';
    public $childrenCountFilter = null;
    public $cityFilter = '';
    public $minPriceFilter = null;
    public $maxPriceFilter = null;
    public $selectedServices = [];
    
    // Filtre pour l'onglet archive
    public $archiveFilter = 'all'; // all, confirmed, cancelled
    
    // Nouveaux filtres
    public $datePeriod = 'all'; // all, today, week, month, custom
    public $timePeriod = 'all'; // all, matin, apres_midi, soir
    public $locationType = 'all'; // all, domicile_client, chez_babysitter
    public $selectedAgeCategories = [];
    public $hasSpecialNeeds = false;
    public $clientMinRating = null;
    public $hasSpecialNotes = false;
    public $showAdvancedFilters = false;
    public $selectedSpecificNeeds = [];
    public $availableSpecificNeeds = [];
    public $availableCities = [];
    
    // Refusal Logic
    public $showRefusalModal = false;
    public $refusalReason = '';

    public function mount()
    {
        $user = Auth::user();
        if ($user && $user->role === 'intervenant') {
            $this->babysitter = $user->intervenant->babysitter ?? null;
        }

        $this->availableSpecificNeeds = \App\Models\Babysitting\ExperienceBesoinSpeciaux::all();
        $this->availableCities = \App\Models\Shared\Localisation::distinct()->pluck('ville')->filter()->values();
    }

    public function viewDemande($id)
    {
        $this->selectedDemande = DemandeIntervention::with(['client.localisations', 'service', 'enfants.categorie'])->find($id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedDemande = null;
    }

    public function acceptDemande($id)
    {
        $demande = DemandeIntervention::with(['client', 'intervenant.user'])->find($id);
        
        if ($demande && $demande->idIntervenant == Auth::id()) {
            $demande->update(['statut' => 'validée']);
            
            $emailsSent = true;
            
            // Send Emails with error handling
            try {
                if ($demande->client && $demande->client->email) {
                    Mail::to($demande->client->email)->send(new DemandeAcceptedForClient($demande));
                }
                
                if ($demande->intervenant && $demande->intervenant->user && $demande->intervenant->user->email) {
                    Mail::to($demande->intervenant->user->email)->send(new DemandeAcceptedForBabysitter($demande));
                }
            } catch (\Exception $e) {
                $emailsSent = false;
                \Log::error('Erreur lors de l\'envoi des emails: ' . $e->getMessage());
            }

            $this->closeModal();
            
            if ($emailsSent) {
                session()->flash('message', 'Demande acceptée avec succès. Les emails de confirmation ont été envoyés.');
            } else {
                session()->flash('message', 'Demande acceptée avec succès. (Les emails n\'ont pas pu être envoyés - vérifiez la configuration SMTP)');
            }
        }
    }

    public function refuseDemande($id)
    {
        $this->selectedDemande = DemandeIntervention::find($id);
        $this->showRefusalModal = true;
    }

    public function confirmRefusal()
    {
        if ($this->selectedDemande && $this->selectedDemande->idIntervenant == Auth::id()) {
            $this->validate([
                'refusalReason' => 'required|string|min:5',
            ]);

            $this->selectedDemande->update([
                'statut' => 'refusée',
                'raisonAnnulation' => $this->refusalReason
            ]);
            
            $emailSent = true;
            
            // Send Email with error handling
            try {
                if ($this->selectedDemande->client && $this->selectedDemande->client->email) {
                    Mail::to($this->selectedDemande->client->email)->send(new DemandeRefusedForClient($this->selectedDemande, $this->refusalReason));
                }
            } catch (\Exception $e) {
                $emailSent = false;
                \Log::error('Erreur lors de l\'envoi de l\'email de refus: ' . $e->getMessage());
            }

            $this->showRefusalModal = false;
            $this->refusalReason = '';
            $this->closeModal();
            
            if ($emailSent) {
                session()->flash('message', 'Demande refusée. Le client a été notifié.');
            } else {
                session()->flash('message', 'Demande refusée. (L\'email n\'a pas pu être envoyé - vérifiez la configuration SMTP)');
            }
        }
    }

    public function closeRefusalModal()
    {
        $this->showRefusalModal = false;
        $this->refusalReason = '';
    }

    public function giveFeedback($id)
    {
        return redirect()->route('babysitter.feedback', ['id' => $id]);
    }

    public function setTab($tab)
    {
        $this->selectedTab = $tab;
        // Réinitialiser le filtre archive quand on change d'onglet
        if ($tab !== 'archive') {
            $this->archiveFilter = 'all';
        }
    }

    public function setArchiveFilter($filter)
    {
        $this->archiveFilter = $filter;
    }

    public function setChildrenFilter($count)
    {
        $this->childrenCountFilter = $this->childrenCountFilter === $count ? null : $count;
    }

    public function getStatsProperty()
    {
        $userId = Auth::id();
        
        return [
            [
                'label' => 'En attente',
                'value' => DemandeIntervention::where('idIntervenant', $userId)->where('idService', 2)->where('statut', 'en_attente')->count(),
                'color' => '#F59E0B',
                'bgColor' => '#FEF3C7'
            ],
            [
                'label' => 'Validées',
                'value' => DemandeIntervention::where('idIntervenant', $userId)->where('idService', 2)->where('statut', 'validée')->count(),
                'color' => '#10B981',
                'bgColor' => '#D1FAE5'
            ],
            [
                'label' => 'Historique',
                'value' => DemandeIntervention::where('idIntervenant', $userId)
                    ->where('idService', 2)
                    ->count(),
                'color' => '#EF4444',
                'bgColor' => '#FEE2E2'
            ]
        ];
    }

    public function getDemandesProperty()
    {
        $userId = Auth::id();
        $query = DemandeIntervention::with(['client.localisations', 'service', 'enfants.categorie'])
            ->where('idIntervenant', $userId)
            ->where('idService', 2) // Filtrer uniquement les services de babysitting
            ->orderBy('dateDemande', 'desc');

        if ($this->selectedTab === 'en_attente') {
            $query->where('statut', 'en_attente');
        } elseif ($this->selectedTab === 'validee') {
            $query->where('statut', 'validée');
        } elseif ($this->selectedTab === 'archive') {
            // Historique : Affiche TOUTES les demandes (aucune restriction de statut)
            
            // Appliquer le filtre supplémentaire si spécifié (optionnel, si vous voulez garder le sous-filtre)
            if ($this->archiveFilter === 'confirmed') {
                $query->where('statut', 'validée');
            } elseif ($this->archiveFilter === 'cancelled') {
                $query->where('statut', 'annulée');
            } elseif ($this->archiveFilter === 'refused') {
                $query->where('statut', 'refusée');
            }
        }

        if ($this->searchQuery) {
            $query->where(function($q) {
                $q->whereHas('client', function($sq) {
                      $sq->where('nom', 'like', "%{$this->searchQuery}%")
                        ->orWhere('prenom', 'like', "%{$this->searchQuery}%");
                  });
            });
        }

        // Filtre Date (Période)
        if ($this->datePeriod !== 'all') {
            if ($this->datePeriod === 'today') {
                $query->whereDate('dateSouhaitee', now());
            } elseif ($this->datePeriod === 'week') {
                $query->whereBetween('dateSouhaitee', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($this->datePeriod === 'month') {
                $query->whereMonth('dateSouhaitee', now()->month);
            } elseif ($this->datePeriod === 'custom' && $this->dateFilter) {
                $query->whereDate('dateSouhaitee', $this->dateFilter);
            }
        }

        // Filtre Heure (Période de la journée)
        if ($this->timePeriod !== 'all') {
            if ($this->timePeriod === 'matin') {
                $query->whereTime('heureDebut', '<', '12:00');
            } elseif ($this->timePeriod === 'apres_midi') {
                $query->whereTime('heureDebut', '>=', '12:00')->whereTime('heureDebut', '<', '18:00');
            } elseif ($this->timePeriod === 'soir') {
                $query->whereTime('heureDebut', '>=', '18:00');
            }
        }

        // Filtre Nombre d'enfants
        if ($this->childrenCountFilter) {
            if ($this->childrenCountFilter === '4+') {
                $query->has('enfants', '>=', 4);
            } else {
                $query->has('enfants', '=', $this->childrenCountFilter);
            }
        }

        // Filtre Ville
        if ($this->cityFilter) {
            $query->whereHas('client.localisations', function($q) {
                $q->where('ville', 'like', "%{$this->cityFilter}%");
            });
        }

        // Filtre Catégories d'âge
        if (!empty($this->selectedAgeCategories)) {
            $categoryMap = [
                'nourrisson' => 1,
                'bambin' => 2,
                'maternelle' => 3,
                'ecolier' => 4,
                'adolescent' => 5,
            ];
            
            $selectedIds = array_map(fn($cat) => $categoryMap[$cat] ?? null, $this->selectedAgeCategories);
            $selectedIds = array_filter($selectedIds);

            if (!empty($selectedIds)) {
                $query->whereHas('enfants', function($q) use ($selectedIds) {
                    $q->whereIn('id_categorie', $selectedIds);
                });
            }
        }

        // Filtre Besoins Spécifiques
        if ($this->hasSpecialNeeds) {
            $query->whereHas('enfants', function($q) {
                $q->whereNotNull('besoinsSpecifiques')->where('besoinsSpecifiques', '!=', '');
            });
        }

        // Filtre Note Client
        if ($this->clientMinRating) {
            $query->whereHas('client', function($q) {
                $q->where('note', '>=', $this->clientMinRating);
            });
        }

        // Filtre Notes Spéciales
        if ($this->hasSpecialNotes) {
            $query->whereNotNull('note_speciales')->where('note_speciales', '!=', '');
        }

        // Filtre Services (Mots-clés)
        if (!empty($this->selectedServices)) {
            $query->where(function($q) {
                foreach ($this->selectedServices as $service) {
                    $q->orWhere('note_speciales', 'like', "%{$service}%")
                      ->orWhereHas('enfants', function($sq) use ($service) {
                          $sq->where('besoinsSpecifiques', 'like', "%{$service}%");
                      });
                }
            });
        }

        // Filtre Besoins Spécifiques (depuis la table experience_besoins_speciaux)
        if (!empty($this->selectedSpecificNeeds)) {
            $query->whereHas('enfants', function($q) {
                $q->where(function($sq) {
                    foreach ($this->selectedSpecificNeeds as $need) {
                        $sq->orWhere('besoinsSpecifiques', 'like', "%{$need}%");
                    }
                });
            });
        }

        $demandes = $query->get();

        // Post-query filtering for Price (babysitter price * number of children * duration)
        if ($this->minPriceFilter || $this->maxPriceFilter) {
            $demandes = $demandes->filter(function ($demande) {
                $hourlyRate = $this->babysitter->prixHeure ?? 50;
                $duration = 0;
                if($demande->heureDebut && $demande->heureFin) {
                    $duration = $demande->heureDebut->diffInHours($demande->heureFin);
                }
                $childrenCount = $demande->enfants->count();
                $totalPrice = $duration * $hourlyRate * ($childrenCount > 0 ? $childrenCount : 1);

                if ($this->minPriceFilter && $totalPrice < $this->minPriceFilter) return false;
                if ($this->maxPriceFilter && $totalPrice > $this->maxPriceFilter) return false;

                return true;
            });
        }

        return $demandes;
    }

    public function toggleAgeCategory($category)
    {
        if (in_array($category, $this->selectedAgeCategories)) {
            $this->selectedAgeCategories = array_diff($this->selectedAgeCategories, [$category]);
        } else {
            $this->selectedAgeCategories[] = $category;
        }
    }

    public function toggleAdvancedFilters()
    {
        $this->showAdvancedFilters = !$this->showAdvancedFilters;
    }

    public function toggleService($service)
    {
        if (in_array($service, $this->selectedServices)) {
            $this->selectedServices = array_diff($this->selectedServices, [$service]);
        } else {
            $this->selectedServices[] = $service;
        }
    }

    public function toggleSpecificNeed($need)
    {
        if (in_array($need, $this->selectedSpecificNeeds)) {
            $this->selectedSpecificNeeds = array_diff($this->selectedSpecificNeeds, [$need]);
        } else {
            $this->selectedSpecificNeeds[] = $need;
        }
    }

    public function getStatusBadge($statut)
    {
        $badges = [
            'en_attente' => ['label' => 'En attente', 'color' => '#F59E0B', 'bgColor' => '#FEF3C7'],
            'validée' => ['label' => 'Validée', 'color' => '#10B981', 'bgColor' => '#D1FAE5'],
            'refusée' => ['label' => 'Refusée', 'color' => '#EF4444', 'bgColor' => '#FEE2E2'],
            'annulée' => ['label' => 'Annulée', 'color' => '#6B7280', 'bgColor' => '#F3F4F6'],
            'terminée' => ['label' => 'Terminée', 'color' => '#3B82F6', 'bgColor' => '#DBEAFE'],
        ];
        return $badges[$statut] ?? ['label' => ucfirst($statut), 'color' => '#6B7280', 'bgColor' => '#F3F4F6'];
    }

    public function render()
    {
        return view('livewire.babysitter.demandes-interface', [
            'babysitter' => $this->babysitter
        ]);
    }
}