<?php

namespace App\Livewire\PetKeeping;

use App\Constants\PetKeeping\Constants;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\PetKeeping\PetKeeping;
use Illuminate\Support\Facades\Auth;
use App\Models\Shared\Service;

class SingleService extends Component
{
    public $serviceId;
    public $service;
    public $user;
    
    // Services Table
    public string $service_name = '';
    public string $service_description = '';

    // PetKeeping Table 
    public string $service_category = '';
    public float $service_base_price = 0;
    public string $service_pet_type = '';
    public string $service_payment_criteria = '';

    // PetKeeping Table Boolean Values
    public $vaccination_required = false;
    public $accepts_untrained_pets = false;
    public $accepts_aggressive_pets = false;

    public $isEditing = false;

    public function mount($serviceId)
    {
        $user = Auth::user();
        if(!$user || $user->role != 'intervenant'){
            return redirect()->route('login');
        }
        $this->user = $user;
        $this->serviceId = $serviceId;
        $this->loadService();
    }

    public function loadService()
    {
        $query = DB::table('petkeeping as pk')
            ->join('services as s', 's.idService', '=', 'pk.idPetKeeping')
            ->where('idPetKeeping', '=', $this->serviceId)
            ->select(
                's.nomService as service_name',
                's.description as service_desc',
                'pk.categorie_petkeeping as service_category',
                'pk.accepts_aggressive_pets as accepts_aggressive_pets',
                'pk.accepts_untrained_pets as accepts_untrained_pets',
                'pk.vaccination_required as vaccination_required',
                'pk.pet_type as service_pet_type',
                'pk.base_price as service_base_price',
                'pk.payment_criteria as service_payment_criteria'
            )->first();

        $this->service = $query;
        
        
        $this->service_name = $query->service_name;
        $this->service_description = $query->service_desc;
        $this->service_category = Constants::getCategoryLabel($query->service_category);
        $this->vaccination_required = (bool)$query->vaccination_required;
        $this->accepts_untrained_pets = (bool)$query->accepts_untrained_pets;
        $this->accepts_aggressive_pets = (bool)$query->accepts_aggressive_pets;
        $this->service_pet_type = Constants::getLabel($query->service_pet_type);
        $this->service_base_price = $query->service_base_price;
        $this->service_payment_criteria = Constants::getCriteriaLabel($query->service_payment_criteria);
    }

    public function toggleEdit()
    {
        $this->isEditing = !$this->isEditing;
    }

    public function updateService()
    {
       
        $this->validate([
            'service_name' => 'required|string|max:255',
            'service_description' => 'required|string',
            'service_category' => 'required|string',
            'service_pet_type' => 'required|string',
            'service_payment_criteria' => 'required|string',
            'service_base_price' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            
            Service::where('idService', $this->serviceId)->update([
                'nomService' => $this->service_name,
                'description' => $this->service_description,
            ]);

            
            PetKeeping::where('idPetKeeping', $this->serviceId)->update([
                'categorie_petkeeping' => $this->service_category,
                'pet_type' => $this->service_pet_type,
                'payment_criteria' => $this->service_payment_criteria,
                'base_price' => $this->service_base_price,
                'vaccination_required' => $this->vaccination_required,
                'accepts_untrained_pets' => $this->accepts_untrained_pets,
                'accepts_aggressive_pets' => $this->accepts_aggressive_pets,
            ]);

            DB::commit();

            $this->isEditing = false;
            $this->loadService(); 
            
            session()->flash('success', 'Service updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to update service: ' . $e->getMessage());
        }
    }

    public function cancelEdit()
    {
        $this->loadService();
        $this->isEditing = false;
    }

    public function render()
    {
        return view('livewire.pet-keeping.single-service');
    }
}