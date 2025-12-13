<?php

namespace App\Livewire\Babysitter;

use Livewire\Component;
use App\Models\Shared\Utilisateur;
use App\Models\Babysitting\DemandeIntervention;
use App\Models\Shared\Feedback;
use Carbon\Carbon;

class BabysitterDashboard extends Component
{
    public $babysitter;
    public $statistics;
    public $upcomingSittings;
    public $monthlyEarnings;
    public $ratingDistribution;
    public $recentActivities;

    public function mount()
    {
        // Mode normal avec authentification uniquement
        $this->loadDashboardData();
    }

    private function loadDashboardDataForUser($userId)
    {
        $user = Utilisateur::find($userId);
        if (!$user || $user->role !== 'intervenant') {
            $this->statistics = [
                'averageRating' => 0,
                'completedSittings' => 0,
                'pendingRequests' => 0,
                'totalEarnings' => 0,
                'responseRate' => 0,
                'onTimeRate' => 0,
            ];
            $this->upcomingSittings = collect([]);
            $this->monthlyEarnings = [];
            $this->ratingDistribution = [];
            $this->recentActivities = [];
            return;
        }

        $this->babysitter = $user->intervenant->babysitter ?? null;

        if (!$this->babysitter) {
            $this->statistics = [
                'averageRating' => 0,
                'completedSittings' => 0,
                'pendingRequests' => 0,
                'totalEarnings' => 0,
                'responseRate' => 0,
                'onTimeRate' => 0,
            ];
            $this->upcomingSittings = collect([]);
            $this->monthlyEarnings = [];
            $this->ratingDistribution = [];
            $this->recentActivities = [];
            return;
        }

        // Calculate statistics
        $this->statistics = $this->calculateStatisticsForUser($userId);

        // Get upcoming sittings
        $this->upcomingSittings = $this->getUpcomingSittings();

        // Get monthly earnings data for chart
        $this->monthlyEarnings = $this->getMonthlyEarnings();

        // Get rating distribution
        $this->ratingDistribution = $this->getRatingDistribution();

        // Get recent activities
        $this->recentActivities = $this->getRecentActivities();
    }

    private function calculateStatisticsForUser($userId)
    {
        // Average rating
        $feedbacks = Feedback::where('idCible', $userId)->get();

        $averageRating = $feedbacks->isEmpty() ? 0 : $feedbacks->avg(function ($feedback) {
            $ratings = array_filter([
                $feedback->credibilite,
                $feedback->sympathie,
                $feedback->ponctualite,
                $feedback->proprete,
                $feedback->qualiteTravail
            ]);
            return count($ratings) > 0 ? array_sum($ratings) / count($ratings) : 0;
        });

        // Completed sittings
        $completedSittings = DemandeIntervention::where('idIntervenant', $userId)
            ->whereIn('statut', ['validée', 'terminée'])
            ->count();

        // Pending requests
        $pendingRequests = DemandeIntervention::where('idIntervenant', $userId)
            ->where('statut', 'en_attente')
            ->count();

        // Total earnings
        $totalEarnings = DemandeIntervention::where('idIntervenant', $userId)
            ->whereIn('statut', ['validée', 'terminée'])
            ->get()
            ->sum(function ($intervention) {
                if ($intervention->heureDebut && $intervention->heureFin) {
                    $hours = Carbon::parse($intervention->heureFin)->diffInHours(Carbon::parse($intervention->heureDebut));
                    return ($this->babysitter->prixHeure ?? 0) * $hours;
                }
                return 0;
            });

        return [
            'averageRating' => round($averageRating, 1),
            'completedSittings' => $completedSittings,
            'pendingRequests' => $pendingRequests,
            'totalEarnings' => $totalEarnings,
            'responseRate' => $this->calculateResponseRateForUser($userId),
            'onTimeRate' => 95.5,
        ];
    }

    private function calculateResponseRateForUser($userId)
    {
        $totalRequests = DemandeIntervention::where('idIntervenant', $userId)->count();
        $respondedRequests = DemandeIntervention::where('idIntervenant', $userId)
            ->whereIn('statut', ['validée', 'refusée', 'terminée'])
            ->count();

        return $totalRequests > 0 ? round(($respondedRequests / $totalRequests) * 100, 1) : 0;
    }

    private function loadDashboardData()
    {
        $user = auth()->user();
        if (!$user || $user->role !== 'intervenant') {
            // Initialiser avec des valeurs par défaut si pas d'utilisateur
            $this->statistics = [
                'averageRating' => 0,
                'completedSittings' => 0,
                'pendingRequests' => 0,
                'totalEarnings' => 0,
                'responseRate' => 0,
                'onTimeRate' => 0,
            ];
            $this->upcomingSittings = [];
            $this->monthlyEarnings = [];
            $this->ratingDistribution = [];
            $this->recentActivities = [];
            return;
        }

        $this->babysitter = $user->intervenant->babysitter ?? null;

        if (!$this->babysitter) {
            // Initialiser avec des valeurs par défaut si pas de babysitter
            $this->statistics = [
                'averageRating' => 0,
                'completedSittings' => 0,
                'pendingRequests' => 0,
                'totalEarnings' => 0,
                'responseRate' => 0,
                'onTimeRate' => 0,
            ];
            $this->upcomingSittings = [];
            $this->monthlyEarnings = [];
            $this->ratingDistribution = [];
            $this->recentActivities = [];
            return;
        }

        // Calculate statistics
        $this->statistics = $this->calculateStatistics();

        // Get upcoming sittings
        $this->upcomingSittings = $this->getUpcomingSittings();

        // Get monthly earnings data for chart
        $this->monthlyEarnings = $this->getMonthlyEarnings();

        // Get rating distribution
        $this->ratingDistribution = $this->getRatingDistribution();

        // Get recent activities
        $this->recentActivities = $this->getRecentActivities();
    }

    private function calculateStatistics()
    {
        $babysitterId = auth()->id();

        // Average rating
        $feedbacks = Feedback::where('idCible', $babysitterId)->get();

        $averageRating = $feedbacks->isEmpty() ? 0 : $feedbacks->avg(function ($feedback) {
            $ratings = array_filter([
                $feedback->credibilite,
                $feedback->sympathie,
                $feedback->ponctualite,
                $feedback->proprete,
                $feedback->qualiteTravail
            ]);
            return count($ratings) > 0 ? array_sum($ratings) / count($ratings) : 0;
        });

        // Completed sittings
        $completedSittings = DemandeIntervention::where('idIntervenant', $babysitterId)
            ->whereIn('statut', ['validée', 'terminée'])
            ->count();

        // Pending requests
        $pendingRequests = DemandeIntervention::where('idIntervenant', $babysitterId)
            ->where('statut', 'en_attente')
            ->count();

        // Total earnings
        $totalEarnings = DemandeIntervention::where('idIntervenant', $babysitterId)
            ->whereIn('statut', ['validée', 'terminée'])
            ->get()
            ->sum(function ($intervention) {
                if ($intervention->heureDebut && $intervention->heureFin) {
                    $hours = Carbon::parse($intervention->heureFin)->diffInHours(Carbon::parse($intervention->heureDebut));
                    return ($this->babysitter->prixHeure ?? 0) * $hours;
                }
                return 0;
            });

        return [
            'averageRating' => round($averageRating, 1),
            'completedSittings' => $completedSittings,
            'pendingRequests' => $pendingRequests,
            'totalEarnings' => $totalEarnings,
            'responseRate' => $this->calculateResponseRate(),
            'onTimeRate' => $this->calculateOnTimeRate(),
        ];
    }

    private function calculateResponseRate()
    {
        $totalRequests = DemandeIntervention::where('idIntervenant', auth()->id())->count();
        $respondedRequests = DemandeIntervention::where('idIntervenant', auth()->id())
            ->whereIn('statut', ['validée', 'refusée', 'terminée'])
            ->count();

        return $totalRequests > 0 ? round(($respondedRequests / $totalRequests) * 100, 1) : 0;
    }

    private function calculateOnTimeRate()
    {
        // This would need actual attendance data - for now, return a placeholder
        return 95.5;
    }

    private function getUpcomingSittings()
    {
        $userId = auth()->id();
        if (!$this->babysitter) {
            return collect([]);
        }

        return DemandeIntervention::where('idIntervenant', $userId)
            ->whereIn('statut', ['validée', 'en_attente'])
            ->where('dateSouhaitee', '>=', Carbon::today())
            ->with(['client', 'enfants'])
            ->orderBy('dateSouhaitee')
            ->orderBy('heureDebut')
            ->take(5)
            ->get()
            ->map(function ($sitting) {
                return [
                    'id' => $sitting->idDemande,
                    'clientName' => $sitting->client?->prenom . ' ' . $sitting->client?->nom ?? 'Client',
                    'children' => $sitting->enfants->map(function ($enfant) {
                        return $enfant->prenom . ' (' . $enfant->age . ' ans)';
                    })->implode(', '),
                    'date' => Carbon::parse($sitting->dateSouhaitee)->format('d/m/Y'),
                    'time' => Carbon::parse($sitting->heureDebut)->format('H:i') . ' - ' .
                        Carbon::parse($sitting->heureFin)->format('H:i'),
                    'location' => $sitting->lieu,
                    'status' => $sitting->statut,
                    'price' => $this->babysitter->prixHeure *
                        Carbon::parse($sitting->heureFin)->diffInHours(Carbon::parse($sitting->heureDebut)),
                ];
            });
    }

    private function getMonthlyEarnings()
    {
        $earnings = [];
        $currentYear = Carbon::now()->year;

        for ($month = 1; $month <= 12; $month++) {
            $monthStart = Carbon::create($currentYear, $month, 1);
            $monthEnd = $monthStart->copy()->endOfMonth();

            $monthlyTotal = DemandeIntervention::where('idIntervenant', auth()->id())
                ->whereIn('statut', ['validée', 'terminée'])
                ->whereBetween('dateSouhaitee', [$monthStart, $monthEnd])
                ->get()
                ->sum(function ($sitting) {
                    if ($sitting->heureDebut && $sitting->heureFin) {
                        $hours = Carbon::parse($sitting->heureFin)->diffInHours(Carbon::parse($sitting->heureDebut));
                        return ($this->babysitter->prixHeure ?? 0) * $hours;
                    }
                    return 0;
                });

            $earnings[] = [
                'month' => $monthStart->format('M'),
                'earnings' => $monthlyTotal
            ];
        }

        return $earnings;
    }

    private function getRatingDistribution()
    {
        $distribution = [];

        $feedbacks = Feedback::where('idCible', auth()->id())
            ->get();

        for ($rating = 5; $rating >= 1; $rating--) {
            $count = $feedbacks->filter(function ($feedback) use ($rating) {
                $ratings = array_filter([
                    $feedback->credibilite,
                    $feedback->sympathie,
                    $feedback->ponctualite,
                    $feedback->proprete,
                    $feedback->qualiteTravail
                ]);
                $avg = count($ratings) > 0 ? array_sum($ratings) / count($ratings) : 0;
                return $avg >= ($rating - 0.5) && $avg < ($rating + 0.5);
            })->count();

            $distribution[] = [
                'rating' => $rating,
                'count' => $count,
            ];
        }

        return $distribution;
    }

    private function getRecentActivities()
    {
        return DemandeIntervention::where('idIntervenant', auth()->id())
            ->with(['client'])
            ->orderBy('dateDemande', 'desc')
            ->take(10)
            ->get()
            ->map(function ($activity) {
                return [
                    'type' => $this->getActivityType($activity->statut),
                    'description' => $this->getActivityDescription($activity),
                    'date' => Carbon::parse($activity->dateDemande)->format('d/m/Y H:i'),
                    'status' => $activity->statut,
                ];
            });
    }

    private function getActivityType($statut)
    {
        return match ($statut) {
            'en_attente' => 'Nouvelle demande',
            'validée' => 'Garde acceptée',
            'refusée' => 'Garde refusée',
            'terminée' => 'Garde terminée',
            'annulée' => 'Garde annulée',
            default => 'Activité'
        };
    }

    private function getActivityDescription($activity)
    {
        $clientName = $activity->client?->prenom . ' ' . $activity->client?->nom ?? 'Client';
        $date = Carbon::parse($activity->dateSouhaitee)->format('d/m/Y');

        return match ($activity->statut) {
            'en_attente' => "Nouvelle demande de {$clientName} pour le {$date}",
            'validée' => "Garde acceptée pour {$clientName} le {$date}",
            'refusée' => "Garde refusée pour {$clientName} le {$date}",
            'terminée' => "Garde terminée pour {$clientName} le {$date}",
            'annulée' => "Garde annulée pour {$clientName} le {$date}",
            default => "Activité avec {$clientName}"
        };
    }

    public function refreshData()
    {
        $this->loadDashboardData();
    }

    public function render()
    {
        return view('livewire.babysitter.babysitter-dashboard');
    }
}