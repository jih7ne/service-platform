<?php

namespace App\Livewire\PetKeeping;

use App\Constants\PetKeeping\Constants;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class MyServices extends Component
{
    use WithPagination;

    
    
    public $search = '';
    public $categoryFilter = '';
    public $petTypeFilter = '';
    public $perPage = 10;
    public $user;
    public $user_id;

    public function mount(){
        $user = Auth::user();
        if(!$user || $user->role != 'intervenant'){
            return redirect()->route('login');
        }
        $this->user = $user;
        $this->user_id = $user->idUser;
    }

    public function updateServiceStatus($serviceId, $newStatus)
    {
        try {
            DB::beginTransaction();
            
            
            $updated = DB::table('offres_services')
                ->where('idService', $serviceId)
                ->where('idIntervenant', $this->user_id) 
                ->update([
                    'statut' => $newStatus,
                ]);
            
            if ($updated) {
                DB::commit();
                session()->flash('success', 'Statut du service mis à jour avec succès!');
            } else {
                DB::rollBack();
                session()->flash('error', 'Service non trouvé ou non autorisé.');
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        

        $user = Auth::user();

        if(!$user || $user->role != 'intervenant'){
            return redirect()->route('login');
        }

        $userId = Auth::id();

        $query = DB::table('petkeeping as pk')
            ->join('services as s', 's.idService', '=', 'pk.idPetKeeping')
            ->where('idPetKeeper', '=', $userId)
            ->select(
                's.idService as service_id',
                's.nomService as service_name',
                's.description as service_description',
                'pk.categorie_petkeeping as service_category',
                'pk.pet_type as service_pet_type',
                'pk.base_price as service_base_price',
                'pk.payment_criteria as service_payment_criteria',
                'pk.vaccination_required as vaccination_required',
                'pk.accepts_untrained_pets as accepts_untrained_pets',
                'pk.accepts_aggressive_pets as accepts_aggressive_pets',
                'pk.created_at as created_at',
                'pk.updated_at as updated_at'
            );

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('s.nomService', 'like', '%' . $this->search . '%')
                  ->orWhere('s.description', 'like', '%' . $this->search . '%');
            });
        }

        // Apply category filter
        if ($this->categoryFilter) {
            $query->where('pk.categorie_petkeeping', $this->categoryFilter);
        }

        // Apply pet type filter
        if ($this->petTypeFilter) {
            $query->where('pk.pet_type', $this->petTypeFilter);
        }

        $services = $query->orderBy('s.nomService', 'asc')
                         ->paginate($this->perPage);

        return view('livewire.pet-keeping.my-services', [
            'services' => $services,
            'categories' => $this->getCategories(),
            'petTypes' => $this->getPetTypes(),
        ]);
    }

    public function getCategories()
    {
        return Constants::forSelect();  
    }

    public function getPetTypes()
    {
        return Constants::getSelectOptions();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->categoryFilter = '';
        $this->petTypeFilter = '';
        $this->perPage = 10;
        $this->resetPage();
    }

    public function viewService($serviceId)
    {
        // Redirect to the single service page
        return redirect()->route('petkeeper.services.show', ['serviceId' => $serviceId]);
    }
}