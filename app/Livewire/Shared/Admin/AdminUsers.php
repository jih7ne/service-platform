<?php

namespace App\Livewire\Shared\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Shared\Utilisateur;
use App\Models\Shared\Intervenant;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\AccountSuspendedMail;
use App\Mail\AccountReactivatedMail;

class AdminUsers extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = 'all';
    public $statutFilter = 'all';
    public $showSuspendModal = false;
    public $showReactivateModal = false;
    public $selectedUser = null;
    public $suspensionReason = '';
    public $reactivationNote = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'roleFilter' => ['except' => 'all'],
        'statutFilter' => ['except' => 'all'],
    ];

    protected $listeners = [
        'close-all-modals' => 'closeAllModals'
    ];

    public function mount()
    {
        if (!session()->has('is_admin')) {
            return redirect()->route('login')->with('error', 'Accès réservé aux administrateurs');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function updatingStatutFilter()
    {
        $this->resetPage();
    }

    // ✅ CORRECTION : Décommenter cette méthode
    public function openSuspendModal($userId)
    {
        \Log::info('=== OUVERTURE MODAL SUSPENSION ===');
        \Log::info('User ID reçu: ' . $userId);
        
        $this->selectedUser = Utilisateur::find($userId);
        
        \Log::info('User trouvé: ' . ($this->selectedUser ? 'OUI' : 'NON'));
        if ($this->selectedUser) {
            \Log::info('User details - ID: ' . $this->selectedUser->idUser . ', Nom: ' . $this->selectedUser->nom . ', Statut: ' . $this->selectedUser->statut);
        }
        
        $this->suspensionReason = '';
        $this->showSuspendModal = true;
        
        \Log::info('Modal ouvert: ' . ($this->showSuspendModal ? 'OUI' : 'NON'));
        
        $this->dispatch('modalOpened');
    }

    public function closeSuspendModal()
    {
        \Log::info('=== FERMETURE MODAL SUSPENSION ===');
        $this->showSuspendModal = false;
        $this->selectedUser = null;
        $this->suspensionReason = '';
        $this->resetValidation();
        $this->dispatch('modalClosed');
    }

    // ✅ CORRECTION : Décommenter cette méthode
    public function openReactivateModal($userId)
    {
        \Log::info('=== OUVERTURE MODAL REACTIVATION ===');
        \Log::info('User ID reçu: ' . $userId);
        
        $this->selectedUser = Utilisateur::find($userId);
        
        \Log::info('User trouvé: ' . ($this->selectedUser ? 'OUI' : 'NON'));
        if ($this->selectedUser) {
            \Log::info('User details - ID: ' . $this->selectedUser->idUser . ', Nom: ' . $this->selectedUser->nom . ', Statut: ' . $this->selectedUser->statut);
        }
        
        $this->reactivationNote = '';
        $this->showReactivateModal = true;
        
        \Log::info('Modal ouvert: ' . ($this->showReactivateModal ? 'OUI' : 'NON'));
        \Log::info('SelectedUser existe: ' . ($this->selectedUser ? 'OUI' : 'NON'));
        
        $this->dispatch('modalOpened');
    }

    public function closeReactivateModal()
    {
        \Log::info('=== FERMETURE MODAL REACTIVATION ===');
        $this->showReactivateModal = false;
        $this->selectedUser = null;
        $this->reactivationNote = '';
        $this->resetValidation();
        $this->dispatch('modalClosed');
    }

    public function closeAllModals()
    {
        \Log::info('Fermeture de tous les modals');
        $this->closeSuspendModal();
        $this->closeReactivateModal();
    }

    public function suspendUser()
    {
        $this->validate([
            'suspensionReason' => 'required|min:10',
        ], [
            'suspensionReason.required' => 'Veuillez indiquer la raison de la suspension',
            'suspensionReason.min' => 'La raison doit contenir au moins 10 caractères',
        ]);

        if (!$this->selectedUser) {
            session()->flash('error', 'Utilisateur introuvable.');
            return;
        }

        DB::beginTransaction();
        
        try {
            $this->selectedUser->statut = 'suspendue';
            $this->selectedUser->save();

            \Log::info('Utilisateur suspendu - ID: ' . $this->selectedUser->idUser . ', Nouveau statut: ' . $this->selectedUser->statut);

            if ($this->selectedUser->role === 'intervenant') {
                $intervenant = Intervenant::where('IdIntervenant', $this->selectedUser->idUser)->first();
                
                if ($intervenant) {
                    \Log::info('Intervenant trouvé - ID: ' . $intervenant->IdIntervenant);
                    
                    $updated = DB::table('offres_services')
                        ->where('idIntervenant', $intervenant->IdIntervenant)
                        ->update(['statut' => 'INACTIVE']);
                    
                    \Log::info('Offres suspendues: ' . $updated);
                }
            }

            try {
                Mail::to($this->selectedUser->email)->send(
                    new AccountSuspendedMail($this->selectedUser, $this->suspensionReason)
                );
                \Log::info('Email de suspension envoyé');
            } catch (\Exception $e) {
                \Log::error('Erreur envoi email suspension: ' . $e->getMessage());
            }

            DB::commit();
            session()->flash('success', 'L\'utilisateur a été suspendu avec succès. Toutes ses offres de services ont été désactivées.');
            $this->closeSuspendModal();
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('=== ERREUR SUSPENSION ===');
            \Log::error('Message: ' . $e->getMessage());
            \Log::error('Trace: ' . $e->getTraceAsString());
            session()->flash('error', 'Une erreur est survenue lors de la suspension: ' . $e->getMessage());
        }
    }

    public function reactivateUser()
    {
        \Log::info('');
        \Log::info('==========================================================');
        \Log::info('=== DEBUT FONCTION REACTIVATION (BOUTON CLIQUÉ !) ===');
        \Log::info('==========================================================');
        \Log::info('');
        
        if ($this->reactivationNote && strlen($this->reactivationNote) < 10) {
            \Log::warning('Note trop courte');
            $this->addError('reactivationNote', 'La note doit contenir au moins 10 caractères');
            return;
        }

        if (!$this->selectedUser) {
            \Log::error('selectedUser est NULL - ABANDON');
            session()->flash('error', 'Utilisateur introuvable.');
            return;
        }

        \Log::info('User ID: ' . $this->selectedUser->idUser);
        \Log::info('Statut actuel: ' . $this->selectedUser->statut);

        DB::beginTransaction();
        
        try {
            $this->selectedUser->statut = 'actif';
            $saved = $this->selectedUser->save();
            
            \Log::info('Save retourné: ' . ($saved ? 'true' : 'false'));
            
            $this->selectedUser->refresh();
            \Log::info('Statut après refresh: ' . $this->selectedUser->statut);

            $userFromDb = DB::table('utilisateurs')
                ->where('idUser', $this->selectedUser->idUser)
                ->first();
            \Log::info('Statut en DB: ' . ($userFromDb ? $userFromDb->statut : 'NULL'));

            if ($this->selectedUser->role === 'intervenant') {
                $intervenant = Intervenant::where('IdIntervenant', $this->selectedUser->idUser)->first();
                
                \Log::info('Intervenant trouvé: ' . ($intervenant ? 'OUI (ID: '.$intervenant->IdIntervenant.')' : 'NON'));
                
                if ($intervenant) {
                    $updated = DB::table('offres_services')
                        ->where('idIntervenant', $intervenant->IdIntervenant)
                        ->where('statut', 'INACTIVE')
                        ->update(['statut' => 'ACTIVE']);
                    
                    \Log::info('Offres réactivées: ' . $updated);
                    
                    $offresActives = DB::table('offres_services')
                        ->where('idIntervenant', $intervenant->IdIntervenant)
                        ->where('statut', 'ACTIVE')
                        ->count();
                    \Log::info('Offres actives après update: ' . $offresActives);
                }
            }

            try {
                Mail::to($this->selectedUser->email)->send(
                    new AccountReactivatedMail($this->selectedUser, $this->reactivationNote)
                );
                \Log::info('Email de réactivation envoyé');
            } catch (\Exception $e) {
                \Log::error('Erreur envoi email réactivation: ' . $e->getMessage());
            }

            DB::commit();
            \Log::info('=== REACTIVATION REUSSIE ===');
            
            session()->flash('success', 'L\'utilisateur a été réactivé avec succès. Toutes ses offres de services ont été réactivées.');
            $this->closeReactivateModal();
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('=== ERREUR REACTIVATION ===');
            \Log::error('Message: ' . $e->getMessage());
            \Log::error('File: ' . $e->getFile() . ' Line: ' . $e->getLine());
            \Log::error('Trace: ' . $e->getTraceAsString());
            session()->flash('error', 'Une erreur est survenue lors de la réactivation: ' . $e->getMessage());
        }
    }

    public function getUserTypeLabel($user)
    {
        if ($user->role === 'client') {
            return 'Client';
        }

        $intervenant = Intervenant::where('IdIntervenant', $user->idUser)->first();
        
        if (!$intervenant) {
            return 'Intervenant';
        }

        if ($intervenant->babysitter) {
            return 'Babysitter';
        } elseif (\App\Models\SoutienScolaire\Professeur::where('intervenant_id', $intervenant->IdIntervenant)->exists()) {
            return 'Professeur';
        } elseif (\App\Models\PetKeeping\PetKeeper::where('idPetKeeper', $intervenant->IdIntervenant)->exists()) {
            return 'Gardien d\'animaux';
        }

        return 'Intervenant';
    }

    public function render()
    {
        $query = Utilisateur::query()
            ->where('role', '!=', 'admin')
            ->with(['intervenant']);

        if ($this->search) {
            $query->where(function($q) {
                $q->where('nom', 'like', '%' . $this->search . '%')
                  ->orWhere('prenom', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('telephone', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->roleFilter !== 'all') {
            $query->where('role', $this->roleFilter);
        }

        if ($this->statutFilter !== 'all') {
            $query->where('statut', $this->statutFilter);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('livewire.shared.admin.admin-users', [
            'users' => $users,
        ])->layout('layouts.admin');
    }
}