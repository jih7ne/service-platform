<?php

namespace App\Livewire\PetKeeping;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\PetKeeping\PetKeeper;
use App\Models\PetKeeping\PetKeeperCertification;
use App\Models\PetKeeping\PaymentCriteria;
use App\Models\PetKeeping\OptionSuppPetKeeping;
use App\Models\Shared\Utilisateur;
use App\Models\Shared\Intervenant;
use App\Models\Shared\Localisation;
use App\Models\Shared\Disponibilite;
use App\Models\Shared\Feedback;
use App\Models\Shared\Demandesintervention;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PetKeeperProfile extends Component
{
    use WithFileUploads;
    
    // État du profil
    public $petKeeper;
    public $user;
    public $intervenant;
    public $localisation;
    public $certifications = [];
    public $paymentCriteria;
    public $additionalOptions = [];
    public $availabilities = [];
    public $reviews = [];
    public $stats = [];
    
    // État d'édition
    public $isEditing = false;
    public $editingSection = null;
    public $tempPhoto;
    
    // Données éditables
    public $specialite;
    public $hourly_rate;
    public $certificationList = [];
    public $bio;
    public $years_of_experience;
    
    // Pour les disponibilités
    public $availabilitySlots = [];
    
    // Constantes
    public $days = [
        'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 
        'Vendredi', 'Samedi', 'Dimanche'
    ];
    
    protected $listeners = [
        'profileUpdated' => 'loadProfileData',
        'availabilityAdded' => 'loadAvailabilities'
    ];
    
    public function mount()
    {
        $this->loadProfileData();
        $this->initAvailabilitySlots();
        $this->initCertificationList();
    }
    
    private function initAvailabilitySlots()
    {
        foreach ($this->days as $day) {
            $this->availabilitySlots[$day] = [];
        }
    }
    
    private function initCertificationList()
    {
        $this->certificationList = [
            ['type' => '', 'file' => null]
        ];
    }
    
    public function loadProfileData()
    {
        $userId = Auth::id();
        
        if (!$userId) {
            return redirect('/connexion');
        }
        
        $this->user = Utilisateur::find($userId);
        
        if (!$this->user) {
            return redirect('/connexion');
        }
        
        // CORRECTION : Recherche avec 'IdIntervenant' (I majuscule)
        $this->intervenant = Intervenant::where('IdIntervenant', $userId)->first();
        
        if (!$this->intervenant) {
            // CORRECTION : Création avec 'IdIntervenant'
            $this->intervenant = Intervenant::create([
                'IdIntervenant' => $userId,
                'statut' => 'actif',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        // Récupérer le PetKeeper
        $this->petKeeper = PetKeeper::where('idPetKeeper', $this->intervenant->IdIntervenant)->first();
        
        if (!$this->petKeeper) {
            // Création simple sans colonne pet_type
            $this->petKeeper = PetKeeper::create([
                'idPetKeeper' => $this->intervenant->IdIntervenant,
                'nombres_services_demandes' => 0,
                'specialite' => 'Garde d\'animaux',
                'years_of_experience' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        // Charger la localisation
        $this->localisation = Localisation::where('idUser', $userId)->first();
        
        // Charger les certifications
        $this->certifications = PetKeeperCertification::where('idPetKeeper', $this->petKeeper->idPetKeeper)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Charger les critères de paiement
        $this->paymentCriteria = PaymentCriteria::where('idPetKeeper', $this->petKeeper->idPetKeeper)->first();
        
        if (!$this->paymentCriteria) {
            $this->paymentCriteria = PaymentCriteria::create([
                'idPetKeeper' => $this->petKeeper->idPetKeeper,
                'base_price' => 15.00,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        $this->additionalOptions = OptionSuppPetKeeping::where('idPetKeeper', $this->petKeeper->idPetKeeper)->get();
        
        $this->loadAvailabilities();
        $this->loadReviews();
        $this->calculateStats();
        $this->initEditingValues();
    }
    
    private function initEditingValues()
    {
        $this->specialite = $this->petKeeper->specialite ?? '';
        $this->hourly_rate = $this->paymentCriteria->base_price ?? 15.00;
        $this->years_of_experience = $this->petKeeper->years_of_experience ?? 0;
        $this->bio = $this->user->bio ?? '';
        
        // CORRECTION : Ne pas utiliser pet_type qui n'existe pas
        // On garde juste les valeurs de base
    }
    
    private function loadAvailabilities()
    {
        $availabilities = Disponibilite::where('idIntervenant', $this->intervenant->IdIntervenant)
            ->orderBy('jourSemaine')
            ->orderBy('heureDebut')
            ->get();
        
        $this->availabilities = [];
        foreach ($availabilities as $availability) {
            $this->availabilities[$availability->jourSemaine][] = [
                'heureDebut' => $availability->heureDebut,
                'heureFin' => $availability->heureFin,
                'id' => $availability->idDispo
            ];
        }
    }
    
    private function loadReviews()
    {
        $this->reviews = Feedback::where('idCible', $this->intervenant->IdIntervenant)
            ->with(['auteur'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }
    
    private function calculateStats()
    {
        $intervenantId = $this->intervenant->IdIntervenant;
        
        $completedMissions = Demandesintervention::where('idIntervenant', $intervenantId)
            ->where('statut', 'TERMINE')
            ->count();
        
        $ongoingMissions = Demandesintervention::where('idIntervenant', $intervenantId)
            ->whereIn('statut', ['CONFIRME', 'EN_COURS'])
            ->count();
        
        $pendingRequests = Demandesintervention::where('idIntervenant', $intervenantId)
            ->where('statut', 'EN_ATTENTE')
            ->count();
        
        $avgRating = Feedback::where('idCible', $intervenantId)
            ->avg('note');
        
        $totalEarnings = Demandesintervention::where('idIntervenant', $intervenantId)
            ->where('statut', 'TERMINE')
            ->with('facture')
            ->get()
            ->sum(function($mission) {
                return $mission->facture->montant_total ?? 0;
            });
        
        $requestedServices = $this->petKeeper->nombres_services_demandes ?? 0;
        
        $this->stats = [
            'completed_missions' => $completedMissions,
            'ongoing_missions' => $ongoingMissions,
            'pending_requests' => $pendingRequests,
            'requested_services' => $requestedServices,
            'avg_rating' => round($avgRating, 1) ?? 0,
            'total_earnings' => $totalEarnings,
            'response_rate' => $this->calculateResponseRate(),
            'repeat_clients' => $this->calculateRepeatClients(),
        ];
    }
    
    private function calculateResponseRate()
    {
        $intervenantId = $this->intervenant->IdIntervenant;
        
        $totalRequests = Demandesintervention::where('idIntervenant', $intervenantId)->count();
        $respondedRequests = Demandesintervention::where('idIntervenant', $intervenantId)
            ->whereIn('statut', ['CONFIRME', 'REFUSE'])
            ->count();
        
        return $totalRequests > 0 ? round(($respondedRequests / $totalRequests) * 100) : 100;
    }
    
    private function calculateRepeatClients()
    {
        $intervenantId = $this->intervenant->IdIntervenant;
        
        $repeatClients = Demandesintervention::where('idIntervenant', $intervenantId)
            ->where('statut', 'TERMINE')
            ->select('idClient')
            ->groupBy('idClient')
            ->havingRaw('COUNT(*) > 1')
            ->count();
        
        return $repeatClients;
    }
    
    public function startEditing($section = null)
    {
        $this->isEditing = true;
        $this->editingSection = $section;
        
        if ($section === 'certifications') {
            $this->initCertificationList();
        }
    }
    
    public function cancelEditing()
    {
        $this->isEditing = false;
        $this->editingSection = null;
        $this->initEditingValues();
        $this->loadAvailabilities();
        $this->certificationList = [['type' => '', 'file' => null]];
    }
    
    public function saveProfile()
    {
        // CORRECTION : Validation simplifiée sans pet_type
        $this->validate([
            'specialite' => 'required|string|max:255',
            'hourly_rate' => 'required|numeric|min:0',
            'years_of_experience' => 'required|integer|min:0|max:50',
            'bio' => 'nullable|string|max:1000',
        ]);
        
        DB::beginTransaction();
        try {
            // Mettre à jour le petkeeper sans pet_type
            $this->petKeeper->update([
                'specialite' => $this->specialite,
                'years_of_experience' => $this->years_of_experience,
                'updated_at' => now(),
            ]);
            
            // Mettre à jour les critères de paiement
            if ($this->paymentCriteria) {
                $this->paymentCriteria->update([
                    'base_price' => $this->hourly_rate,
                ]);
            }
            
            // Mettre à jour la bio de l'utilisateur
            $this->user->update([
                'bio' => $this->bio,
            ]);
            
            // Mettre à jour la photo si nécessaire
            if ($this->tempPhoto) {
                $this->saveProfilePhoto();
            }
            
            DB::commit();
            
            $this->isEditing = false;
            $this->editingSection = null;
            $this->loadProfileData();
            
            session()->flash('success', 'Profil mis à jour avec succès!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
    }
    
    // Le reste des méthodes reste IDENTIQUE...
    // (saveAvailability, addAvailabilitySlot, removeAvailabilitySlot,
    // uploadCertification, deleteCertification, etc.)
    
    public function render()
    {
        return view('livewire.pet-keeping.pet-keeper-profile');
    }
}