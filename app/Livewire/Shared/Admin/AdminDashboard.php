<?php

namespace App\Livewire\Shared\Admin;

use Carbon\Carbon;
use App\Models\Service;
use Livewire\Component;
use App\Models\Shared\Intervenant;
use App\Models\Reclamation;
use App\Models\Shared\Utilisateur;
use Illuminate\Support\Facades\DB;

class AdminDashboard extends Component
{
    public $stats = [];
    public $servicesData = [];
    public $serviceDistribution = [];
    public $revenueData = [];
    public $quickStats = [];

    public function mount()
    {
        // Vérifier si l'utilisateur est admin
        if (!session()->has('is_admin')) {
            return redirect()->route('login')->with('error', 'Accès réservé aux administrateurs');
        }

        $this->loadStats();
        $this->loadServicesData();
        $this->loadServiceDistribution();
        $this->loadRevenueData();
        $this->loadQuickStats();
    }

    private function loadStats()
    {
        // Total utilisateurs
        $totalUsers = Utilisateur::count();
        $usersThisMonth = Utilisateur::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $usersLastMonth = Utilisateur::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $usersChange = $usersLastMonth > 0 
            ? round((($usersThisMonth - $usersLastMonth) / $usersLastMonth) * 100, 1) 
            : ($usersThisMonth > 0 ? 100 : 0);

        // Réclamations en attente
        $pendingComplaints = DB::table('reclamantions')->where('statut', 'en_attente')->count();
        $complaintsThisMonth = DB::table('reclamantions')
            ->where('statut', 'en_attente')
            ->whereMonth('dateCreation', now()->month)
            ->count();
        $complaintsLastMonth = DB::table('reclamantions')
            ->where('statut', 'en_attente')
            ->whereMonth('dateCreation', now()->subMonth()->month)
            ->count();
        $complaintsChange = $complaintsLastMonth > 0 
            ? -round((($complaintsThisMonth - $complaintsLastMonth) / $complaintsLastMonth) * 100, 1) 
            : 0;

        // Intervenants actifs (validés)
        $activeIntervenants = Intervenant::where('statut', 'VALIDE')->count();
        $intervenantsThisMonth = Intervenant::where('statut', 'VALIDE')
            ->whereMonth('created_at', now()->month)
            ->count();
        $intervenantsLastMonth = Intervenant::where('statut', 'VALIDE')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->count();
        $intervenantsChange = $intervenantsLastMonth > 0 
            ? round((($intervenantsThisMonth - $intervenantsLastMonth) / $intervenantsLastMonth) * 100, 1) 
            : ($intervenantsThisMonth > 0 ? 100 : 0);

        // Demandes du mois (remplace les revenus)
        $monthlyDemands = DB::table('demandes_intervention')
            ->whereMonth('dateDemande', now()->month)
            ->whereYear('dateDemande', now()->year)
            ->count();
        
        $lastMonthDemands = DB::table('demandes_intervention')
            ->whereMonth('dateDemande', now()->subMonth()->month)
            ->whereYear('dateDemande', now()->subMonth()->year)
            ->count();
        
        $demandsChange = $lastMonthDemands > 0 
            ? round((($monthlyDemands - $lastMonthDemands) / $lastMonthDemands) * 100, 1) 
            : ($monthlyDemands > 0 ? 100 : 0);

        $this->stats = [
            [
                'label' => 'Utilisateurs totaux',
                'value' => number_format($totalUsers),
                'change' => ($usersChange >= 0 ? '+' : '') . $usersChange . '%',
                'icon' => 'users',
                'color' => '#2B5AA8',
                'bgColor' => '#2B5AA815',
            ],
            [
                'label' => 'Réclamations en attente',
                'value' => (string)$pendingComplaints,
                'change' => ($complaintsChange >= 0 ? '+' : '') . $complaintsChange . '%',
                'icon' => 'message-square',
                'color' => '#C78500',
                'bgColor' => '#C7850015',
            ],
            [
                'label' => 'Intervenants actifs',
                'value' => number_format($activeIntervenants),
                'change' => ($intervenantsChange >= 0 ? '+' : '') . $intervenantsChange . '%',
                'icon' => 'briefcase',
                'color' => '#B82E6E',
                'bgColor' => '#B82E6E15',
            ],
            [
    'label' => 'Demandes d\'intervention',
    'value' => number_format($monthlyDemands),
    'change' => ($demandsChange >= 0 ? '+' : '') . $demandsChange . '%',
    'icon' => 'trending-up',
    'color' => '#059669',
    'bgColor' => '#05966915',
],
        ];
    }

    private function loadServicesData()
    {
        // Services par mois (6 derniers mois) - Données réelles
        $servicesData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $this->getFrenchMonth($date->month);

            // Compter les demandes par type de service
            $soutienCount = DB::table('demandes_intervention')
                ->where('idService', 1) // Soutien Scolaire
                ->whereMonth('dateDemande', $date->month)
                ->whereYear('dateDemande', $date->year)
                ->count();

            $babysittingCount = DB::table('demandes_intervention')
                ->where('idService', 2) // Babysitting
                ->whereMonth('dateDemande', $date->month)
                ->whereYear('dateDemande', $date->year)
                ->count();

            $petKeepingCount = DB::table('demandes_intervention')
                ->where('idService', 3) // Pet Keeping
                ->whereMonth('dateDemande', $date->month)
                ->whereYear('dateDemande', $date->year)
                ->count();

            $servicesData[] = [
                'month' => $monthName,
                'Soutien scolaire' => $soutienCount,
                'Babysitting' => $babysittingCount,
                'Garde d\'animaux' => $petKeepingCount
            ];
        }

        $this->servicesData = $servicesData;
    }

    private function loadServiceDistribution()
    {
        // Distribution totale des services (demandes par type)
        $soutienTotal = DB::table('demandes_intervention')
            ->where('idService', 1)
            ->count();

        $babysittingTotal = DB::table('demandes_intervention')
            ->where('idService', 2)
            ->count();

        $petKeepingTotal = DB::table('demandes_intervention')
            ->where('idService', 3)
            ->count();

        $this->serviceDistribution = [
            ['name' => 'Soutien scolaire', 'value' => $soutienTotal, 'color' => '#2B5AA8'],
            ['name' => 'Babysitting', 'value' => $babysittingTotal, 'color' => '#B82E6E'],
            ['name' => 'Garde d\'animaux', 'value' => $petKeepingTotal, 'color' => '#C78500'],
        ];
    }

    private function loadRevenueData()
    {
        // Nombre de demandes des 6 derniers mois (remplace les revenus)
        $demandsByMonth = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $this->getFrenchMonth($date->month);

            $demands = DB::table('demandes_intervention')
                ->whereMonth('dateDemande', $date->month)
                ->whereYear('dateDemande', $date->year)
                ->count();

            $demandsByMonth[] = [
                'month' => $monthName,
                'revenue' => $demands // Garde le même nom pour la compatibilité avec le chart
            ];
        }

        $this->revenueData = $demandsByMonth;
    }

    private function loadQuickStats()
    {
        // Statistiques rapides avec changement mensuel
        $soutienThisMonth = DB::table('demandes_intervention')
            ->where('idService', 1)
            ->whereMonth('dateDemande', now()->month)
            ->count();

        $soutienLastMonth = DB::table('demandes_intervention')
            ->where('idService', 1)
            ->whereMonth('dateDemande', now()->subMonth()->month)
            ->count();

        $soutienChange = $soutienLastMonth > 0 
            ? round((($soutienThisMonth - $soutienLastMonth) / $soutienLastMonth) * 100, 1) 
            : ($soutienThisMonth > 0 ? 100 : 0);

        $babysittingThisMonth = DB::table('demandes_intervention')
            ->where('idService', 2)
            ->whereMonth('dateDemande', now()->month)
            ->count();

        $babysittingLastMonth = DB::table('demandes_intervention')
            ->where('idService', 2)
            ->whereMonth('dateDemande', now()->subMonth()->month)
            ->count();

        $babysittingChange = $babysittingLastMonth > 0 
            ? round((($babysittingThisMonth - $babysittingLastMonth) / $babysittingLastMonth) * 100, 1) 
            : ($babysittingThisMonth > 0 ? 100 : 0);

        $petKeepingThisMonth = DB::table('demandes_intervention')
            ->where('idService', 3)
            ->whereMonth('dateDemande', now()->month)
            ->count();

        $petKeepingLastMonth = DB::table('demandes_intervention')
            ->where('idService', 3)
            ->whereMonth('dateDemande', now()->subMonth()->month)
            ->count();

        $petKeepingChange = $petKeepingLastMonth > 0 
            ? round((($petKeepingThisMonth - $petKeepingLastMonth) / $petKeepingLastMonth) * 100, 1) 
            : ($petKeepingThisMonth > 0 ? 100 : 0);

        $soutienTotal = DB::table('demandes_intervention')->where('idService', 1)->count();
        $babysittingTotal = DB::table('demandes_intervention')->where('idService', 2)->count();
        $petKeepingTotal = DB::table('demandes_intervention')->where('idService', 3)->count();

        $this->quickStats = [
            [
                'label' => 'Soutien scolaire',
                'value' => number_format($soutienTotal),
                'change' => ($soutienChange >= 0 ? '+' : '') . $soutienChange . '% ce mois',
                'icon' => 'book-open',
                'color' => '#2B5AA8',
                'bgColor' => '#2B5AA815',
            ],
            [
                'label' => 'Babysitting',
                'value' => number_format($babysittingTotal),
                'change' => ($babysittingChange >= 0 ? '+' : '') . $babysittingChange . '% ce mois',
                'icon' => 'baby',
                'color' => '#B82E6E',
                'bgColor' => '#B82E6E15',
            ],
            [
                'label' => 'Garde d\'animaux',
                'value' => number_format($petKeepingTotal),
                'change' => ($petKeepingChange >= 0 ? '+' : '') . $petKeepingChange . '% ce mois',
                'icon' => 'paw-print',
                'color' => '#C78500',
                'bgColor' => '#C7850015',
            ],
        ];
    }

    private function getFrenchMonth($monthNumber)
    {
        $months = [
            1 => 'Jan', 2 => 'Fév', 3 => 'Mar', 4 => 'Avr',
            5 => 'Mai', 6 => 'Juin', 7 => 'Juil', 8 => 'Aoû',
            9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Déc'
        ];
        return $months[$monthNumber];
    }

    public function render()
    {
        return view('livewire.shared.admin.admin-dashboard')
            ->layout('layouts.admin');
    }
}