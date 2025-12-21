<?php

namespace App\Livewire\Shared;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Shared\Intervenant;
use App\Models\Shared\OffreService;

class IntervenantHub extends Component
{
    public $services = [];
    public $prenom;
    public $canAddService = false;
    public $showAddServiceModal = false;
    public $allServicesActive = false;

    protected $listeners = ['openAddServiceModal' => 'openModal'];

    public function mount()
    {
        $user = Auth::user();
        $this->prenom = $user->prenom;

        $intervenant = Intervenant::where('IdIntervenant', $user->idUser)->first();

        if ($intervenant) {
            // Charger uniquement les services ACTIVE et ARCHIVED
            $this->services = \DB::table('offres_services')
                ->join('services', 'offres_services.idService', '=', 'services.idService')
                ->where('offres_services.idIntervenant', $intervenant->IdIntervenant)
                ->whereIn('offres_services.statut', ['ACTIVE', 'ARCHIVED'])
                ->select('services.*', 'offres_services.statut as offre_statut')
                ->get();
            
            // Vérifier si on peut ajouter un service
            $this->checkCanAddService();
        }
    }

    public function checkCanAddService()
    {
        $user = Auth::user();
        
        // Compter les services actifs
        $activeServicesCount = \DB::table('offres_services')
            ->where('idIntervenant', $user->idUser)
            ->where('statut', 'ACTIVE')
            ->count();
        
        // On peut ajouter un service si on a moins de 2 services actifs
        $this->canAddService = $activeServicesCount < 2;
    }

    public function archiveService($idService)
    {
        $user = Auth::user();
        $intervenant = Intervenant::where('idIntervenant', $user->idUser)->first();
        
        if ($intervenant) {
            \DB::table('offres_services')
                ->where('idService', $idService)
                ->where('idIntervenant', $intervenant->IdIntervenant)
                ->update(['statut' => 'ARCHIVED']);
            
            // Recharger les services
            $this->mount();
            
            session()->flash('success', 'Service archivé avec succès !');
        }
    }

    public function unarchiveService($idService)
    {
        $user = Auth::user();
        $intervenant = Intervenant::where('idIntervenant', $user->idUser)->first();
        
        if ($intervenant) {
            // Vérifier si on peut désarchiver (max 2 services actifs)
            $activeServicesCount = \DB::table('offres_services')
                ->where('idIntervenant', $intervenant->IdIntervenant)
                ->where('statut', 'ACTIVE')
                ->count();
            
            if ($activeServicesCount >= 2) {
                session()->flash('error', 'Vous ne pouvez pas avoir plus de 2 services actifs.');
                return;
            }
            
            \DB::table('offres_services')
                ->where('idService', $idService)
                ->where('idIntervenant', $intervenant->IdIntervenant)
                ->update(['statut' => 'ACTIVE']);
            
            // Recharger les services
            $this->mount();
            
            session()->flash('success', 'Service réactivé avec succès !');
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/');
    }

    public function openModal()
    {
        $this->showAddServiceModal = true;
        $this->checkAllServicesActive();
    }

    public function closeAddServiceModal()
    {
        $this->showAddServiceModal = false;
    }

    public function checkAllServicesActive()
    {
        $user = Auth::user();
        $activeServices = \DB::table('offres_services')
            ->join('services', 'offres_services.idService', '=', 'services.idService')
            ->where('offres_services.idIntervenant', $user->idUser)
            ->where('offres_services.statut', 'ACTIVE')
            ->pluck('services.nomService')
            ->toArray();

        $allServices = ['soutien', 'baby', 'pet'];
        $hasAll = true;
        foreach ($allServices as $service) {
            if (!$this->hasServiceInArray($service, $activeServices)) {
                $hasAll = false;
                break;
            }
        }
        $this->allServicesActive = $hasAll;
    }

    public function hasService($type)
    {
        $user = Auth::user();
        $services = \DB::table('offres_services')
            ->join('services', 'offres_services.idService', '=', 'services.idService')
            ->where('offres_services.idIntervenant', $user->idUser)
            ->where('offres_services.statut', 'ACTIVE')
            ->pluck('services.nomService')
            ->toArray();

        return $this->hasServiceInArray($type, $services);
    }

    private function hasServiceInArray($type, $services)
    {
        foreach ($services as $service) {
            $serviceLower = strtolower($service);
            if ($type === 'soutien' && (str_contains($serviceLower, 'soutien') || str_contains($serviceLower, 'scolaire'))) {
                return true;
            }
            if ($type === 'baby' && str_contains($serviceLower, 'baby')) {
                return true;
            }
            if ($type === 'pet' && (str_contains($serviceLower, 'pet') || str_contains($serviceLower, 'animaux'))) {
                return true;
            }
        }
        return false;
    }

    public function addService($type)
    {
        $user = Auth::user();
        $intervenant = Intervenant::where('idIntervenant', $user->idUser)->first();
        
        if (!$intervenant) {
            session()->flash('error', 'Intervenant non trouvé.');
            return;
        }

        // Vérifier la limite de 2 services actifs
        $activeCount = \DB::table('offres_services')
            ->where('idIntervenant', $intervenant->IdIntervenant)
            ->where('statut', 'ACTIVE')
            ->count();

        if ($activeCount >= 2) {
            session()->flash('error', 'Vous ne pouvez pas avoir plus de 2 services actifs.');
            $this->closeAddServiceModal();
            return;
        }

        // Vérifier si le service existe déjà
        $serviceMap = [
            'soutien' => 'Soutien Scolaire',
            'baby' => 'Babysitting',
            'pet' => 'Pet Keeping'
        ];

        $serviceName = $serviceMap[$type] ?? null;
        if (!$serviceName) {
            session()->flash('error', 'Service invalide.');
            return;
        }

        $service = \DB::table('services')
            ->where('nomService', 'LIKE', '%' . $serviceName . '%')
            ->first();

        if (!$service) {
            session()->flash('error', 'Service non trouvé dans la base de données.');
            return;
        }

        $existingOffer = \DB::table('offres_services')
            ->where('idIntervenant', $intervenant->IdIntervenant)
            ->where('idService', $service->idService)
            ->first();

        // Si le service existe et est actif, afficher un message d'erreur
        if ($existingOffer && $existingOffer->statut === 'ACTIVE') {
            session()->flash('error', 'Vous proposez déjà ce service.');
            $this->closeAddServiceModal();
            return;
        }

        // Si le service existe mais est archivé, le réactiver et rediriger vers le dashboard
        if ($existingOffer && $existingOffer->statut === 'ARCHIVED') {
            \DB::table('offres_services')
                ->where('idIntervenant', $intervenant->IdIntervenant)
                ->where('idService', $service->idService)
                ->update(['statut' => 'ACTIVE']);
            
            session()->flash('success', 'Service réactivé avec succès !');
            $this->closeAddServiceModal();
            
            // Rediriger vers le tableau de bord approprié (utiliser les routes existantes)
            if ($type === 'soutien') {
                return redirect()->route('tutoring.dashboard');
            } elseif ($type === 'baby') {
                return redirect()->route('babysitter.dashboard');
            } elseif ($type === 'pet') {
                return redirect()->route('petkeeper.dashboard');
            }
            
            return;
        }

        // Si le service n'existe pas du tout, rediriger vers le formulaire d'inscription
        $this->closeAddServiceModal();

        if ($type === 'soutien') {
            return redirect()->route('register.professeur');
        } elseif ($type === 'baby') {
            return redirect()->route('inscription.babysitter');
        } elseif ($type === 'pet') {
            return redirect()->route('petkeeper.inscription');
        }
    }

    public function render()
    {
        return view('livewire.shared.intervenant-hub');
    }
}