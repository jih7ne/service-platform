<?php

namespace App\Livewire\PetKeeping;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\PetKeeping\PetKeeper;
use App\Models\PetKeeping\PetKeeperCertification;
use App\Models\PetKeeping\PaymentCriteria;
use App\Models\PetKeeping\OptionSuppPetKeeping;
use App\Models\Shared\Utilisateur;
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
    public $description;
    public $hourly_rate;
    public $accepted_animal_types = [];
    public $accepted_animal_sizes = [];
    public $services = [];
    public $certificationList = [];
    public $housing_type;
    public $has_outdoor_space = false;
    public $bio;
    
    // Pour les disponibilités
    public $availabilitySlots = [];
    
    // Constantes
    public $animalTypes = [
        'Chiens', 'Chats', 'Rongeurs', 'Oiseaux', 'Reptiles', 'Autres'
    ];
    
    public $animalSizes = [
        'Petit' => 'Petit',
        'Moyen' => 'Moyen', 
        'Grand' => 'Grand'
    ];
    
    public $serviceTypes = [
        'Garde à domicile (chez le client)',
        'Garde à domicile (chez moi)',
        'Promenade',
        'Visite à domicile',
        'Transport',
        'Garde de nuit',
        'Administration de médicaments',
        'Garde de jour'
    ];
    
    public $housingTypes = [
        'Appartement',
        'Maison',
        'Villa',
        'Ferme'
    ];
    
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
        
        // Récupérer le PetKeeper par idPetKeeper (pas par id)
        $this->petKeeper = PetKeeper::where('idPetKeeper', $userId)->first();
        
        if (!$this->petKeeper) {
            return redirect('/inscriptionPetkeeper');
        }
        
        // CHARGER LA LOCALISATION
        $this->localisation = Localisation::where('idUser', $userId)->first();
        
        // Charger les certifications avec une requête sûre
        $this->certifications = collect();
        try {
            $this->certifications = PetKeeperCertification::where('idPetKeeper', $this->petKeeper->idPetKeeper)
                ->orderBy('created_at', 'desc')
                ->get();
        } catch (\Exception $e) {
            // Si erreur, on garde la collection vide
        }
        
        $this->paymentCriteria = PaymentCriteria::where('idPetKeeper', $this->petKeeper->idPetKeeper)
            ->first();
        
        $this->additionalOptions = OptionSuppPetKeeping::where('idPetKeeper', $this->petKeeper->idPetKeeper)
            ->get();
        
        $this->loadAvailabilities();
        $this->loadReviews();
        $this->calculateStats();
        $this->initEditingValues();
    }
    
    private function initEditingValues()
    {
        $this->specialite = $this->petKeeper->specialite ?? '';
        $this->hourly_rate = $this->paymentCriteria->base_price ?? 0;
        
        $petKeeping = \App\Models\PetKeeping\PetKeeping::where('idPetKeeper', $this->petKeeper->idPetKeeper)->first();
        
        if ($petKeeping && $petKeeping->pet_type) {
            $this->accepted_animal_types = explode(',', $petKeeping->pet_type);
        } else {
            $this->accepted_animal_types = ['Chiens', 'Chats'];
        }
        
        $service = \App\Models\Shared\Service::where('nomService', 'LIKE', 'PetKeeping%')
            ->where('description', '!=', '')
            ->first();
            
        $this->description = $service->description ?? '';
        $this->bio = $this->user->bio ?? '';
    }
    
    private function loadAvailabilities()
    {
        $availabilities = Disponibilite::where('idIntervenant', $this->petKeeper->idPetKeeper)
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
        $this->reviews = Feedback::where('idCible', $this->petKeeper->idPetKeeper)
            ->with(['auteur'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }
    
    private function calculateStats()
    {
        $petKeeperId = $this->petKeeper->idPetKeeper;
        
        $completedMissions = Demandesintervention::where('idIntervenant', $petKeeperId)
            ->where('statut', 'TERMINE')
            ->count();
        
        $ongoingMissions = Demandesintervention::where('idIntervenant', $petKeeperId)
            ->whereIn('statut', ['CONFIRME', 'EN_COURS'])
            ->count();
        
        $pendingRequests = Demandesintervention::where('idIntervenant', $petKeeperId)
            ->where('statut', 'EN_ATTENTE')
            ->count();
        
        $avgRating = Feedback::where('idCible', $petKeeperId)
            ->avg('note');
        
        $totalEarnings = Demandesintervention::where('idIntervenant', $petKeeperId)
            ->where('statut', 'TERMINE')
            ->with('facture')
            ->get()
            ->sum(function($mission) {
                return $mission->facture->montant_total ?? 0;
            });
        
        $this->stats = [
            'completed_missions' => $completedMissions,
            'ongoing_missions' => $ongoingMissions,
            'pending_requests' => $pendingRequests,
            'avg_rating' => round($avgRating, 1) ?? 0,
            'total_earnings' => $totalEarnings,
            'response_rate' => $this->calculateResponseRate(),
            'repeat_clients' => $this->calculateRepeatClients(),
        ];
    }
    
    private function calculateResponseRate()
    {
        $petKeeperId = $this->petKeeper->idPetKeeper;
        
        $totalRequests = Demandesintervention::where('idIntervenant', $petKeeperId)->count();
        $respondedRequests = Demandesintervention::where('idIntervenant', $petKeeperId)
            ->whereIn('statut', ['CONFIRME', 'REFUSE'])
            ->count();
        
        return $totalRequests > 0 ? round(($respondedRequests / $totalRequests) * 100) : 100;
    }
    
    private function calculateRepeatClients()
    {
        $petKeeperId = $this->petKeeper->idPetKeeper;
        
        $repeatClients = Demandesintervention::where('idIntervenant', $petKeeperId)
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
        $this->validate([
            'specialite' => 'required|string|max:255',
            'description' => 'required|string|min:50|max:2000',
            'hourly_rate' => 'required|numeric|min:0',
            'accepted_animal_types' => 'required|array|min:1',
            'bio' => 'nullable|string|max:1000',
        ]);
        
        DB::beginTransaction();
        try {
            $this->petKeeper->update([
                'specialite' => $this->specialite,
            ]);
            
            if ($this->paymentCriteria) {
                $this->paymentCriteria->update([
                    'base_price' => $this->hourly_rate,
                ]);
            }
            
            $petKeeping = \App\Models\PetKeeping\PetKeeping::where('idPetKeeper', $this->petKeeper->idPetKeeper)->first();
            
            if ($petKeeping) {
                $petKeeping->update([
                    'pet_type' => implode(',', $this->accepted_animal_types),
                ]);
            }
            
            $service = \App\Models\Shared\Service::where('nomService', 'LIKE', 'PetKeeping%')
                ->where('description', '!=', '')
                ->first();
                
            if ($service) {
                $service->update([
                    'nomService' => 'PetKeeping - ' . $this->specialite,
                    'description' => $this->description,
                ]);
            }
            
            $this->user->update([
                'bio' => $this->bio,
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
        // Validation
        $cert = $this->certificationList[0] ?? null;
        
        if (!$cert || empty(trim($cert['type'])) || !$cert['file']) {
            session()->flash('error', 'Veuillez remplir le nom et sélectionner un fichier');
            return;
        }
        
        try {
            // DÉSACTIVER TEMPORAIREMENT les contraintes FOREIGN KEY pour SQLite
            DB::statement('PRAGMA foreign_keys = OFF;');
            
            // Stocker le fichier
            $path = $cert['file']->store('certifications', 'public');
            
            // 🔴 SOLUTION : Utiliser la VALEUR EXACTE qui existe dans la table petkeepers
            // On va chercher la valeur correcte de idPetKeeper dans la table petkeepers
            
            $petKeeperRecord = DB::table('petkeepers')
                ->where('idPetKeeper', $this->petKeeper->idPetKeeper)
                ->first();
            
            if (!$petKeeperRecord) {
                session()->flash('error', 'Profil PetKeeper non trouvé');
                DB::statement('PRAGMA foreign_keys = ON;');
                return;
            }
            
            // Utiliser la valeur EXACTE de idPetKeeper depuis la table
            $correctIdPetKeeper = $petKeeperRecord->idPetKeeper;
            
            // Insérer avec la valeur correcte
            DB::table('petkeeper_certifications')->insert([
                'idPetKeeper' => $correctIdPetKeeper,
                'certification' => trim($cert['type']),
                'document' => $path,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // RÉACTIVER les contraintes
            DB::statement('PRAGMA foreign_keys = ON;');
            
            // Réinitialiser et recharger
            $this->certificationList = [['type' => '', 'file' => null]];
            $this->isEditing = false;
            $this->editingSection = null;
            
            // Recharger les données
            $this->loadProfileData();
            
            session()->flash('success', 'Certification ajoutée avec succès !');
            
        } catch (\Exception $e) {
            // RÉACTIVER les contraintes en cas d'erreur
            DB::statement('PRAGMA foreign_keys = ON;');
            
            session()->flash('error', 'Erreur: ' . $e->getMessage());
        }
    }
    
    public function deleteCertification($id)
    {
        try {
            // DÉSACTIVER les contraintes
            DB::statement('PRAGMA foreign_keys = OFF;');
            
            $cert = PetKeeperCertification::find($id);
            
            if ($cert) {
                // Supprimer le fichier
                if ($cert->document && Storage::exists('public/' . $cert->document)) {
                    Storage::delete('public/' . $cert->document);
                }
                
                // Supprimer l'enregistrement
                $cert->delete();
                
                session()->flash('success', 'Certification supprimée avec succès !');
            }
            
            // RÉACTIVER les contraintes
            DB::statement('PRAGMA foreign_keys = ON;');
            
            // Recharger
            $this->loadProfileData();
            
        } catch (\Exception $e) {
            // RÉACTIVER les contraintes en cas d'erreur
            DB::statement('PRAGMA foreign_keys = ON;');
            
            session()->flash('error', 'Erreur: ' . $e->getMessage());
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
    
    private function saveProfilePhoto()
    {
        if ($this->tempPhoto) {
            if ($this->user->photo && Storage::exists('public/' . $this->user->photo)) {
                Storage::delete('public/' . $this->user->photo);
            }
            
            $path = $this->tempPhoto->store('profile-photos', 'public');
            $this->user->update(['photo' => $path]);
            $this->tempPhoto = null;
        }
    }
    
    public function updateOnlineStatus($status)
    {
        $this->user->update(['statut' => $status]);
        $this->loadProfileData();
        
        $statusText = $status === 'en_ligne' ? 'en ligne' : 'hors ligne';
        session()->flash('success', 'Statut mis à jour: ' . $statusText);
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
    
    public function render()
    {
        return view('livewire.pet-keeping.pet-keeper-profile');
    }
}