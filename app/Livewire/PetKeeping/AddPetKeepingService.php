<?php

namespace App\Livewire\PetKeeping;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Shared\Service;
use App\Models\PetKeeping\PetKeeping;
use App\Models\Shared\OffreService;

class AddPetKeepingService extends Component
{
    public $number_of_services = 0;
    public $max_services = 2;
    public $user;
    public $user_id;

    // Form fields
    public $service_name;
    public $service_description;
    public $service_status = 'ACTIVE';
    public $service_category;
    public $service_payment_criteria;
    public $service_pet_type;
    public $service_base_price;
    public $service_accepts_aggressive_pets = false;
    public $service_accepts_untrained_pets = false;
    public $service_vaccination_required = false;

    public function mount()
    {
        $this->user = Auth::user();
        $this->user_id = Auth::id();

        if(!$this->user || $this->user->role != 'intervenant'){
            return redirect()->route('login');
        }
        
        
        $this->number_of_services = DB::table('offres_services')
            ->where('idIntervenant', $this->user_id)
            ->count();
    }

    protected function rules()
    {
        return [
            'service_name' => 'required|string|max:255',
            'service_description' => 'nullable|string|max:1000',
            'service_status' => 'nullable|string|in:ACTIVE,INACTIVE,ARCHIVED',
            'service_category' => 'required|string|max:255',
            'service_payment_criteria' => 'required|string|max:255',
            'service_pet_type' => 'required|string|max:255',
            'service_base_price' => 'required|numeric|min:0',
            'service_accepts_aggressive_pets' => 'sometimes|boolean',
            'service_accepts_untrained_pets' => 'sometimes|boolean',
            'service_vaccination_required' => 'sometimes|boolean',
        ];
    }

    public function submit()
    {
        // Validate input
        $this->validate();

        // Check if user has reached max services
        $currentServicesCount = DB::table('offres_services')
            ->where('idIntervenant', $this->user_id)
            ->count();

        if ($currentServicesCount >= $this->max_services) {
            session()->flash('error', 'Vous avez atteint le nombre maximum de services (' . $this->max_services . ').');
            return;
        }

        try {
            DB::beginTransaction();

            
            $g_service = Service::create([
                'nomService' => $this->service_name,
                'description' => $this->service_description,
            ]);

            
            PetKeeping::create([
                'idPetKeeping' => $g_service->idService,
                'idPetKeeper' => $this->user_id,
                'categorie_petkeeping' => $this->service_category,
                'accepts_aggressive_pets' => $this->service_accepts_aggressive_pets ?? false,
                'accepts_untrained_pets' => $this->service_accepts_untrained_pets ?? false,
                'vaccination_required' => $this->service_vaccination_required ?? false,
                'pet_type' => $this->service_pet_type,
                'payment_criteria' => $this->service_payment_criteria,
                'base_price' => $this->service_base_price,
            ]);

            

            OffreService::create([
                'idIntervenant' => $this->user_id,
                'idService' => $g_service->idService,
                'statut' => 'ACTIVE'
            ]);


           DB::commit();

            
           $this->number_of_services = $currentServicesCount + 1;

            
            $this->reset([
                'service_name',
                'service_description',
                'service_category',
                'service_payment_criteria',
                'service_pet_type',
                'service_base_price',
                'service_accepts_aggressive_pets',
                'service_accepts_untrained_pets',
                'service_vaccination_required',
            ]);

            session()->flash('success', 'Service créé avec succès!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            session()->flash('error', 'Erreur lors de la création du service: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.pet-keeping.add-pet-keeping-service');
    }
}