<?php

namespace App\Livewire\Shared\Admin;

use Livewire\Component;
use App\Models\Shared\Intervenant;
use App\Models\Shared\Utilisateur;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\IntervenantAccepte;
use App\Mail\IntervenantRefuse;

class IntervenantDetails extends Component
{
    public $intervenantId;
    public $intervenant;
    public $user;
    public $professeurData = null;
    public $babysitterData = null;
    public $petkeeperData = null;
    public $serviceType = null;
    public $refusalReason = '';
    public $showRefusalModal = false;

    public function mount($id)
    {
        // Vérifier si l'utilisateur est admin
        if (!session()->has('is_admin')) {
            return redirect()->route('login')->with('error', 'Accès réservé aux administrateurs');
        }

        $this->intervenantId = $id;
        $this->loadIntervenantData();
    }

    private function loadIntervenantData()
    {
        $this->intervenant = Intervenant::find($this->intervenantId);
        
        if (!$this->intervenant) {
            session()->flash('error', 'Intervenant non trouvé');
            return redirect()->route('admin.intervenants');
        }

        $this->user = Utilisateur::leftJoin('localisations', 'utilisateurs.idUser', '=', 'localisations.idUser')
            ->where('utilisateurs.idUser', $this->intervenant->IdIntervenant)
            ->select('utilisateurs.*', 'localisations.ville', 'localisations.adresse')
            ->first();

        $this->loadIntervenantSpecificData($this->intervenant->IdIntervenant);
    }

    private function loadIntervenantSpecificData($idIntervenant)
    {
        // Vérifier si c'est un professeur
        $professeur = DB::table('professeurs')
            ->where('intervenant_id', $idIntervenant)
            ->first();
        
        if ($professeur) {
            $this->serviceType = 'Soutien Scolaire';
            $this->professeurData = $professeur;
            
            // Charger les matières et niveaux
            $this->professeurData->matieres = DB::table('services_prof')
                ->join('matieres', 'services_prof.matiere_id', '=', 'matieres.id_matiere')
                ->where('services_prof.professeur_id', $professeur->id_professeur)
                ->select('matieres.nom_matiere', 'services_prof.type_service', 'services_prof.prix_par_heure')
                ->get();
            
            return;
        }
        
        // Vérifier si c'est un babysitter
        $babysitter = DB::table('babysitters')
            ->where('idBabysitter', $idIntervenant)
            ->first();
        
        if ($babysitter) {
            $this->serviceType = 'Babysitting';
            $this->babysitterData = $babysitter;
            
            // Charger les superpouvoirs
            $this->babysitterData->superpouvoirs = DB::table('choisir_superpourvoirs')
                ->join('superpouvoirs', 'choisir_superpourvoirs.idSuperpouvoir', '=', 'superpouvoirs.idSuperpouvoir')
                ->where('choisir_superpourvoirs.idBabysitter', $idIntervenant)
                ->pluck('superpouvoirs.superpouvoir')
                ->toArray();
            
            // Charger les formations
            $this->babysitterData->formations = DB::table('choisir_formations')
                ->join('formations', 'choisir_formations.idFormation', '=', 'formations.idFormation')
                ->where('choisir_formations.idBabysitter', $idIntervenant)
                ->pluck('formations.formation')
                ->toArray();
            
            // Charger les catégories d'enfants
            $this->babysitterData->categories = DB::table('choisir_categories')
                ->join('categorie_enfants', 'choisir_categories.idCategorie', '=', 'categorie_enfants.idCategorie')
                ->where('choisir_categories.idBabysitter', $idIntervenant)
                ->pluck('categorie_enfants.categorie')
                ->toArray();
            
            return;
        }
        
        // Vérifier si c'est un gardien d'animaux
        $petkeeper = DB::table('petkeepers')
            ->where('idPetKeeper', $idIntervenant)
            ->first();
        
        if ($petkeeper) {
            $this->serviceType = "Garde d'animaux";
            $this->petkeeperData = $petkeeper;
            
            // Charger les certifications
            $this->petkeeperData->certifications = DB::table('petkeeper_certifications')
                ->where('idPetKeeper', $petkeeper->idPetKeeper)
                ->get();
            
            return;
        }
    }

    public function openRefusalModal()
    {
        $this->showRefusalModal = true;
        $this->refusalReason = '';
    }

    public function closeRefusalModal()
    {
        $this->showRefusalModal = false;
        $this->refusalReason = '';
    }

    public function approveIntervenant()
    {
        $this->intervenant->statut = 'VALIDE';
        $this->intervenant->idAdmin = session('admin_id');
        $this->intervenant->save();

        // Envoyer l'email d'acceptation
        try {
            Mail::to($this->user->email)->send(new IntervenantAccepte($this->user, $this->serviceType ?? 'Intervenant'));
        } catch (\Exception $e) {
            \Log::error('Erreur envoi email acceptation: ' . $e->getMessage());
        }

        session()->flash('success', 'Intervenant approuvé avec succès ! Un email de confirmation a été envoyé.');
        return redirect()->route('admin.intervenants');
    }

    public function refuseIntervenant()
    {
        $this->validate([
            'refusalReason' => 'required|min:10'
        ], [
            'refusalReason.required' => 'Veuillez indiquer la raison du refus',
            'refusalReason.min' => 'La raison doit contenir au moins 10 caractères'
        ]);

        $this->intervenant->statut = 'REFUSE';
        $this->intervenant->idAdmin = session('admin_id');
        $this->intervenant->save();

        // Envoyer l'email de refus
        try {
            Mail::to($this->user->email)->send(new IntervenantRefuse($this->user, $this->refusalReason, $this->serviceType ?? 'Intervenant'));
        } catch (\Exception $e) {
            \Log::error('Erreur envoi email refus: ' . $e->getMessage());
        }

        session()->flash('success', 'Demande refusée. Un email d\'information a été envoyé à l\'intervenant.');
        return redirect()->route('admin.intervenants');
    }

    public function render()
    {
        return view('livewire.shared.admin.intervenant-details');
    }
}
