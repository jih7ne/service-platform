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
    
    // Refusal Logic
    public $showRefusalModal = false;
    public $refusalReason = '';

    public function mount()
    {
        $user = Auth::user();
        if ($user && $user->role === 'intervenant') {
            $this->babysitter = $user->intervenant->babysitter ?? null;
        }
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
            
            // Send Emails
            if ($demande->client && $demande->client->email) {
                Mail::to($demande->client->email)->send(new DemandeAcceptedForClient($demande));
            }
            
            if ($demande->intervenant && $demande->intervenant->user && $demande->intervenant->user->email) {
                Mail::to($demande->intervenant->user->email)->send(new DemandeAcceptedForBabysitter($demande));
            }

            $this->closeModal();
            session()->flash('message', 'Demande acceptée avec succès. Les emails de confirmation ont été envoyés.');
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
                // 'motif_refus' => $this->refusalReason // Assuming there is a column for this, or just log it
            ]);
            
            // Send Email
            if ($this->selectedDemande->client && $this->selectedDemande->client->email) {
                Mail::to($this->selectedDemande->client->email)->send(new DemandeRefusedForClient($this->selectedDemande, $this->refusalReason));
            }

            $this->showRefusalModal = false;
            $this->refusalReason = '';
            $this->closeModal();
            session()->flash('message', 'Demande refusée. Le client a été notifié.');
        }
    }

    public function closeRefusalModal()
    {
        $this->showRefusalModal = false;
        $this->refusalReason = '';
    }

    public function giveFeedback($id)
    {
        // Rediriger vers la page de feedback pour la demande spécifiée
        return redirect()->route('babysitter.feedback', ['id' => $id]);
    }

    public function setTab($tab)
    {
        $this->selectedTab = $tab;
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
                'label' => 'Refusées/Annulées',
                'value' => DemandeIntervention::where('idIntervenant', $userId)->where('idService', 2)->whereIn('statut', ['refusée', 'annulée'])->count(),
                'color' => '#EF4444',
                'bgColor' => '#FEE2E2'
            ]
        ];
    }

    public function getDemandesProperty()
    {
        $userId = Auth::id();
        $query = DemandeIntervention::with(['client', 'service', 'enfants'])
            ->where('idIntervenant', $userId)
            ->where('idService', 2) // Filtrer uniquement les services de babysitting
            ->orderBy('dateDemande', 'desc');

        if ($this->selectedTab === 'en_attente') {
            $query->where('statut', 'en_attente');
        } elseif ($this->selectedTab === 'validee') {
            $query->where('statut', 'validée');
        } elseif ($this->selectedTab === 'archive') {
            // Afficher uniquement les demandes passées confirmées et les demandes annulées/refusées
            $query->where(function($q) {
                $q->where(function($subQ) {
                    // Demandes confirmées dont la date est passée
                    $subQ->where('statut', 'validée')
                         ->where('dateSouhaitee', '<', now()->format('Y-m-d'));
                })->orWhere(function($subQ) {
                    // Demandes annulées ou refusées (peu importe la date)
                    $subQ->whereIn('statut', ['annulée', 'refusée']);
                });
            });
            
            // Appliquer le filtre supplémentaire si spécifié
            if ($this->archiveFilter === 'confirmed') {
                $query->where('statut', 'validée')
                      ->where('dateSouhaitee', '<', now()->format('Y-m-d'));
            } elseif ($this->archiveFilter === 'cancelled') {
                $query->whereIn('statut', ['annulée', 'refusée']);
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

        $demandes = $query->get();

        // Post-query filtering for Price (since it depends on duration and babysitter rate)
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

    public function setArchiveFilter($filter)
    {
        $this->archiveFilter = $filter;
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