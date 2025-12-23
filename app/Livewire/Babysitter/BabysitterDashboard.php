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
    public $monthlyEarnings;
    public $ratingDistribution;

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

            ];
            $this->monthlyEarnings = [];
            $this->ratingDistribution = [];
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

            ];
            $this->monthlyEarnings = [];
            $this->ratingDistribution = [];
            return;
        }

        // Calculate statistics
        $this->statistics = $this->calculateStatisticsForUser($userId);

        // Get monthly earnings data for chart
        $this->monthlyEarnings = $this->getMonthlyEarnings();

        // Get rating distribution
        $this->ratingDistribution = $this->getRatingDistribution();
    }

    private function calculateStatisticsForUser($userId)
    {
        // Average rating
        $feedbacks = Feedback::where('idCible', $userId)->where('estVisible', true)->get();
        $reviewCount = $feedbacks->count();

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
            'reviewCount' => $reviewCount,
            'completedSittings' => $completedSittings,
            'pendingRequests' => $pendingRequests,
            'totalEarnings' => max(0, $totalEarnings), // Ensure no negative earnings
            'responseRate' => $this->calculateResponseRateForUser($userId),
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

            ];
            $this->monthlyEarnings = [];
            $this->ratingDistribution = [];
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

            ];
            $this->monthlyEarnings = [];
            $this->ratingDistribution = [];
            return;
        }

        // Calculate statistics
        $this->statistics = $this->calculateStatistics();

        // Get monthly earnings data for chart
        $this->monthlyEarnings = $this->getMonthlyEarnings();

        // Get rating distribution
        $this->ratingDistribution = $this->getRatingDistribution();
    }

    private function calculateStatistics()
    {
        $babysitterId = auth()->id();

        // Average rating
        $feedbacks = Feedback::where('idCible', $babysitterId)->where('estVisible', true)->get();
        $reviewCount = $feedbacks->count();

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
            ->whereIn('statut', ['validée', 'terminée', 'payée'])
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
                    $start = Carbon::parse($intervention->heureDebut);
                    $end = Carbon::parse($intervention->heureFin);

                    // Handle overnight shifts (if end is before start)
                    if ($end->lt($start)) {
                        $end->addDay();
                    }

                    $hours = $start->diffInHours($end); // Returns absolute difference
                    return ($this->babysitter->prixHeure ?? 0) * abs($hours);
                }
                return 0;
            });

        return [
            'averageRating' => round($averageRating, 1),
            'reviewCount' => $reviewCount,
            'completedSittings' => $completedSittings,
            'pendingRequests' => $pendingRequests,
            'totalEarnings' => $totalEarnings,
            'responseRate' => $this->calculateResponseRate(),
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





    private function getMonthlyEarnings()
    {
        $earnings = [];
        $currentYear = Carbon::now()->year;
        $babysitterId = auth()->id();

        // Fetch all relevant interventions for the year in one query
        $interventions = DemandeIntervention::where('idIntervenant', $babysitterId)
            ->whereIn('statut', ['validée', 'terminée', 'payée'])
            ->whereYear('dateSouhaitee', $currentYear)
            ->get();

        for ($month = 1; $month <= 12; $month++) {
            $monthDate = Carbon::create($currentYear, $month, 1);
            $monthName = $monthDate->format('M');

            $monthlyTotal = $interventions->filter(function ($intervention) use ($month) {
                return Carbon::parse($intervention->dateSouhaitee)->month === $month;
            })->sum(function ($intervention) {
                if ($intervention->heureDebut && $intervention->heureFin) {
                    $start = Carbon::parse($intervention->heureDebut);
                    $end = Carbon::parse($intervention->heureFin);

                    if ($end->lt($start)) {
                        $end->addDay();
                    }

                    $hours = $start->diffInHours($end);
                    return ($this->babysitter->prixHeure ?? 0) * abs($hours);
                }
                return 0;
            });

            $earnings[] = [
                'month' => $monthName,
                'earnings' => $monthlyTotal
            ];
        }

        return $earnings;
    }

    private function getRatingDistribution()
    {
        $distribution = [];
        $babysitterId = auth()->id();

        $feedbacks = Feedback::where('idCible', $babysitterId)->where('estVisible', true)->get();

        for ($rating = 5; $rating >= 1; $rating--) {
            $count = $feedbacks->filter(function ($feedback) use ($rating) {
                $ratings = array_filter([
                    $feedback->credibilite,
                    $feedback->sympathie,
                    $feedback->ponctualite,
                    $feedback->proprete,
                    $feedback->qualiteTravail
                ]);

                if (count($ratings) === 0)
                    return false;

                $avg = array_sum($ratings) / count($ratings);
                return round($avg) == $rating;
            })->count();

            $distribution[] = [
                'rating' => $rating,
                'count' => $count,
                'label' => $rating . ' étoiles'
            ];
        }

        return $distribution;
    }



    public function refreshData()
    {
        $this->loadDashboardData();
        $this->dispatch('updateCharts', [
            'monthlyEarnings' => $this->monthlyEarnings,
            'ratingDistribution' => $this->ratingDistribution
        ]);
    }

    public function render()
    {
        return view('livewire.babysitter.babysitter-dashboard');
    }
}