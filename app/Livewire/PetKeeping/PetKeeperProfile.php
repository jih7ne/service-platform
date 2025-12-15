<?php

namespace App\Livewire\PetKeeping;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\PetKeeping\PetKeeper;
use App\Models\PetKeeping\PetKeeperCertification;
use App\Models\PetKeeping\PetKeeping;
use App\Models\Shared\Utilisateur;
use App\Models\Shared\Intervenant;
use App\Models\Shared\Localisation;
use App\Models\Shared\Disponibilite;
use App\Models\Shared\Feedback;
use App\Models\Shared\DemandesIntervention;
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
        
        if (!$this->user || $this->user->role != 'intervenant') {
            return redirect('/connexion');
        }
        
       
        $this->intervenant = Intervenant::where('IdIntervenant', $userId)->first();

        if(!$this->intervenant){
            return redirect('/connexion');
        }
        

        $this->petKeeper = PetKeeper::where('idPetKeeper', $this->intervenant->IdIntervenant)->first();
        
        if (!$this->petKeeper) {
            return redirect('/connexion');
        }
        
        $this->localisation = Localisation::where('idUser', $userId)->first();
        
        
        $this->certifications = PetKeeperCertification::where('idPetKeeper', $this->petKeeper->idPetKeeper)
            ->orderBy('created_at', 'desc')
            ->get();
        
    
        
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
           // ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }
    
    private function calculateStats()
    {
        $intervenantId = $this->intervenant->IdIntervenant;
        
        $completedMissions = Demandesintervention::where('idIntervenant', $intervenantId)
            ->where('statut', 'validée')
            ->count();
        
        
        $pendingRequests = Demandesintervention::where('idIntervenant', $intervenantId)
            ->where('statut', 'en_attente')
            ->count();
        
        
        $avgRating = $this->user->note ?? 0;
        
        $totalEarnings = DemandesIntervention::where('idIntervenant', $intervenantId)
            ->where('statut', 'validée')
            ->with('facture')
            ->get()
            ->sum(function($mission) {
                return $mission->facture->montantTotal ?? 0;
            });

        $services_pet_keeping = PetKeeping::where('idPetKeeper', $intervenantId)->count();
        
        $requestedServices = $this->petKeeper->nombres_services_demandes ?? 0;
        
        $this->stats = [
            'completed_missions' => $completedMissions,
            'ongoing_missions' => $pendingRequests,
            'pending_requests' => $pendingRequests,
            'requested_services' => $requestedServices,
            'avg_rating' => round($avgRating, 1) ?? 0,
            'total_earnings' => $totalEarnings,
            'response_rate' => $this->calculateResponseRate(),
            'repeat_clients' => $this->calculateRepeatClients(),
            'nombres_services_pet_keeping' => $services_pet_keeping
        ];
    }
    
    private function calculateResponseRate()
    {
        $intervenantId = $this->intervenant->IdIntervenant;
        
        $totalRequests = DemandesIntervention::where('idIntervenant', $intervenantId)->count();
        $respondedRequests = DemandesIntervention::where('idIntervenant', $intervenantId)
            ->whereIn('statut', ['validée', 'refusée', 'annulée'])
            ->count();
        
        return $totalRequests > 0 ? round(($respondedRequests / $totalRequests) * 100) : 100;
    }
    
    private function calculateRepeatClients()
    {
        $intervenantId = $this->intervenant->IdIntervenant;
        
        $repeatClients = DemandesIntervention::where('idIntervenant', $intervenantId)
            ->where('statut', 'validée')
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


    public function deleteCertification($id)
    {
        DB::beginTransaction();

        try {
            $cert = PetKeeperCertification::findOrFail($id);

            if ($cert->document && Storage::disk('public')->exists($cert->document)) {
                Storage::disk('public')->delete($cert->document);
            }

            $cert->delete();

            DB::commit();

            $this->loadProfileData();

            session()->flash('success', 'Certification supprimée avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erreur: ' . $e->getMessage());
        }
    }


    private function saveProfilePhoto()
    {
        $this->validate([
            'tempPhoto' => 'image|max:2048',
        ]);

        if ($this->user->photo && Storage::disk('public')->exists($this->user->photo)) {
            Storage::disk('public')->delete($this->user->photo);
        }

        $filename = 'profile_' . $this->user->id . '_' . Str::uuid() . '.' . $this->tempPhoto->getClientOriginalExtension();

        $path = $this->tempPhoto->storeAs(
            'profile-photos',
            $filename,
            'public'
        );

        $this->user->update([
            'photo' => $path,
            'updated_at' => now(),
        ]);

        
        $this->tempPhoto = null;
    }


    public function saveAvailability()
    {
        try {
            Disponibilite::where('idIntervenant', $this->petKeeper->idPetKeeper)->delete();
            
            foreach ($this->availabilities as $day => $slots) {
                foreach ($slots as $slot) {
                    if (!empty($slot['heureDebut']) && !empty($slot['heureFin'])) {
                        Disponibilite::create([
                            'jourSemaine' => $day,
                            'heureDebut' => $slot['heureDebut'],
                            'heureFin' => $slot['heureFin'],
                            'est_reccurent' => true,
                            'idIntervenant' => $this->petKeeper->idPetKeeper,
                        ]);
                    }
                }
            }
            
            $this->loadAvailabilities();
            session()->flash('success', 'Disponibilités mises à jour!');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur: ' . $e->getMessage());
        }
    }


    public function addAvailabilitySlot($day)
    {
        if (!isset($this->availabilities[$day])) {
            $this->availabilities[$day] = [];
        }
        
        $this->availabilities[$day][] = [
            'heureDebut' => '09:00',
            'heureFin' => '17:00'
        ];
    }

    public function removeAvailabilitySlot($day, $index)
    {
        if (isset($this->availabilities[$day][$index])) {
            unset($this->availabilities[$day][$index]);
            $this->availabilities[$day] = array_values($this->availabilities[$day]);
        }
    }



    public function uploadCertification()
    {
        $cert = $this->certificationList[0] ?? null;

        if (!$cert || empty(trim($cert['type'])) || !$cert['file']) {
            session()->flash('error', 'Veuillez remplir le nom et sélectionner un fichier');
            return;
        }

        $this->validate([
            'certificationList.0.type' => 'required|string|max:255',
            'certificationList.0.file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        DB::beginTransaction();

        try {
            
            $path = $cert['file']->store('certifications', 'public');

           
            PetKeeperCertification::create([
                'idPetKeeper'  => $this->petKeeper->idPetKeeper,
                'certification'=> trim($cert['type']),
                'document'     => $path,
            ]);

            DB::commit();

            
            $this->certificationList = [['type' => '', 'file' => null]];
            $this->isEditing = false;
            $this->editingSection = null;

            $this->loadProfileData();

            session()->flash('success', 'Certification ajoutée avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();

            
            if (isset($path)) {
                Storage::disk('public')->delete($path);
            }

            session()->flash('error', 'Erreur: ' . $e->getMessage());
        }
    }


    public function downloadCertification($id)
    {
        try {
            $cert = PetKeeperCertification::find($id);
            
            if (!$cert) {
                session()->flash('error', 'Certification non trouvée');
                return null;
            }
            
            if (!$cert->document) {
                session()->flash('error', 'Aucun document associé à cette certification');
                return null;
            }
            
            $filePath = 'public/' . $cert->document;
            
            if (!Storage::exists($filePath)) {
                session()->flash('error', 'Fichier non trouvé sur le serveur');
                return null;
            }
            
            $extension = pathinfo($cert->document, PATHINFO_EXTENSION);
            $filename = Str::slug($cert->certification) . '.' . $extension;
            
            return Storage::download($filePath, $filename);
            
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors du téléchargement: ' . $e->getMessage());
            return null;
        }
    }

    public function addCertificationField()
    {
        $this->certificationList[] = [
            'type' => '',
            'file' => null
        ];
    }
    
    public function removeCertificationField($index)
    {
        if (isset($this->certificationList[$index])) {
            unset($this->certificationList[$index]);
            $this->certificationList = array_values($this->certificationList);
        }
    }


    

    
    public function saveProfile()
    {
        
        $this->validate([
            'specialite' => 'required|string|max:255',
            'hourly_rate' => 'required|numeric|min:0',
            'years_of_experience' => 'required|integer|min:0|max:50',
            'bio' => 'nullable|string|max:1000',
        ]);
        
        DB::beginTransaction();
        try {
           
            $this->petKeeper->update([
                'specialite' => $this->specialite,
                'years_of_experience' => $this->years_of_experience,
                'updated_at' => now(),
            ]);
            
            
            
            
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
    
    
    
    public function render()
    {
        return view('livewire.pet-keeping.pet-keeper-profile');
    }
}