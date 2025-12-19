<?php

namespace App\Livewire\PetKeeping;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Mail\DemandeAccepteeMail;
use App\Mail\RefusDemandeMail;
use Livewire\Attributes\Computed;
use Livewire\WithFileUploads;
use App\Models\Shared\Reclamation;


class PetKeeperDashboard extends Component
{
    use WithFileUploads;
    public $feedbacksSidebar = [];

    public $user;
    public $isAvailable = false;

    public $showRefusalModal = false;
    public $selectedDemandeId = null;
    public $refusalReason = '';

    //Reclamation

    public $showReclamationModal = false;

    public $reclamationFeedbackId = null; // idFeedback
    public $reclamationCibleId = null;

    public $sujet;
    public $description;
    public $priorite = 'moyenne';
    public $preuves;

    
    public function mount()
    {
        
        $authUser = Auth::user();

       
        $authId = $authUser ? ($authUser->idUser ?? $authUser->id) : null;

        if ($authId) {
            $this->user = DB::table('utilisateurs')
                ->where('idUser', $authId)
                ->first();
        }

        if (!$this->user) {
            return redirect()->route('login');
        }

       
        $this->isAvailable = ($this->user->statut === 'actif');
        $this->loadFeedbacks();
        
    }


    public function openReclamationModal($idFeedback)
    {
        $this->reclamationFeedbackId = $idFeedback;
        

        $avis = DB::table('feedbacks')
            ->where('idFeedBack', $idFeedback)
            ->first();

        if (!$avis) {
            session()->flash('error', 'Avis introuvable.');
            return;
        }

        $this->reclamationFeedbackId  = $idFeedback;
        $this->reclamationCibleId = $avis->idAuteur;

        $this->reset([
            'sujet',
            'description',
            'priorite',
            'preuves',
        ]);

        $this->priorite = 'moyenne';
        $this->showReclamationModal = true;
    }

    public function closeReclamationModal()
    {
        $this->reset([
            'showReclamationModal',
            'reclamationFeedbackId',
            'reclamationCibleId',
            'sujet',
            'description',
            'priorite',
            'preuves',
        ]);
    }


    public function submitReclamation()
    {
        $this->validate([
            'sujet' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priorite' => 'required|in:faible,moyenne,urgente',
            'preuves' => 'nullable|file|max:2048',
        ]);

        $preuvePath = null;

        if ($this->preuves) {
            $preuvePath = $this->preuves->store('reclamations', 'public');
        }

        Reclamation::create([
            'idAuteur'    => $this->user->idUser,
            'idCible'     => $this->reclamationCibleId,
            'idFeedback'  => $this->reclamationFeedbackId,
            'sujet'       => $this->sujet,
            'description' => $this->description,
            'priorite'    => $this->priorite,
            'preuves'     => $preuvePath,
            'statut'      => 'en_attente',
        ]);

        $this->closeReclamationModal();

        session()->flash('success', 'Réclamation envoyée avec succès.');
    }


    private function loadFeedbacks()
    {
        $this->feedbacksSidebar = DB::table('feedbacks')
            ->join('utilisateurs', 'feedbacks.idAuteur', '=', 'utilisateurs.idUser')
            ->where('feedbacks.idCible', $this->user->idUser)
            ->where('feedbacks.estVisible', 1)
            ->orderBy('feedbacks.dateCreation', 'desc')
            ->select('feedbacks.commentaire', 'utilisateurs.prenom')
            ->get();
    }


    public function toggleAvailability()
    {
        $nouveauStatut = $this->isAvailable ? 'suspendue' : 'actif';
        
        DB::table('utilisateurs')
            ->where('idUser', $this->user->idUser)
            ->update(['statut' => $nouveauStatut]);

        $this->isAvailable = !$this->isAvailable;
        $this->user->statut = $nouveauStatut;
    }



    
    public function parseCreneauxGrouped($json)
    {
        if (!$json) return [];
        
        try {
            $creneaux = json_decode($json, true) ?? [];
            
            
            $grouped = [];
            foreach ($creneaux as $creneau) {
                $date = $creneau['date'] ?? null;
                if ($date) {
                    if (!isset($grouped[$date])) {
                        $grouped[$date] = [];
                    }
                    $grouped[$date][] = [
                        'heureDebut' => $creneau['heureDebut'] ?? '',
                        'heureFin' => $creneau['heureFin'] ?? ''
                    ];
                }
            }
            
            return $grouped;
        } catch (\Exception $e) {
            return [];
        }
    }

    
    public function groupAnimalsByDemande($demandes)
    {
        $grouped = [];
        
        foreach ($demandes as $demande) {
            $idDemande = $demande->idDemande;
            
            if (!isset($grouped[$idDemande])) {
                $grouped[$idDemande] = [
                    'demande' => $demande,
                    'animals' => [],
                    'creneaux' => $this->parseCreneauxGrouped($demande->note_speciales ?? '[]')
                ];
            }
            
            
            if ($demande->nom_animal) {
                $grouped[$idDemande]['animals'][] = [
                    'nom' => $demande->nom_animal,
                    'race' => $demande->race_animal,
                    'age' => $demande->age,
                    'espece' => $demande->espece,
                    'statutVaccination' => $demande->statutVaccination,
                    'note_comportementale' => $demande->note_comportementale
                ];
            }
        }
        
        return array_values($grouped);
    }

    
    


    private function parseCreneaux(?string $json)
    {
        if (!$json) return [];

        try {
            return json_decode($json, true) ?? [];
        } catch (\Exception $e) {
            return [];
        }
    }


   

    private function getAnimauxByDemande($idDemande)
    {
        return DB::table('animal_demande')
            ->join('animals', 'animal_demande.idAnimal', '=', 'animals.idAnimale')
            ->where('animal_demande.idDemande', $idDemande)
            ->select(
                'animals.nomAnimal',
                'animals.race',
                'animals.age',
                'animals.sexe',
                'animals.poids'
            )
            ->get();
    }


 
    public function openRefusalModal($idDemande)
    {
        $this->selectedDemandeId = $idDemande;
        $this->refusalReason = '';
        $this->showRefusalModal = true;
    }

    public function closeRefusalModal()
    {
        $this->showRefusalModal = false;
        $this->selectedDemandeId = null;
    }

    
    public function confirmRefusal()
    {
        $this->validate([
            'refusalReason' => 'required|min:5|max:255'
        ]);

        $demande = DB::table('demandes_intervention')
            ->where('idDemande', $this->selectedDemandeId)
            ->first();

        if (!$demande) {
            session()->flash('error', 'Demande introuvable');
            return;
        }

        $client = DB::table('utilisateurs')
            ->where('idUser', $demande->idClient)
            ->first();

       
        if ($client && $client->email) {
            Mail::to($client->email)->send(
                new RefusDemandeMail(
                    $demande,
                    $this->user,
                    $client,
                    $this->refusalReason
                )
            );
        }

        
        DB::table('demandes_intervention')
            ->where('idDemande', $this->selectedDemandeId)
            ->update([
                'statut' => 'refusée',
                'raisonAnnulation' => $this->refusalReason
            ]);

        $this->closeRefusalModal();
        session()->flash('success', 'Demande refusée avec succès.');
    }



   public function accepterDemande($idDemande)
    {
        try {
            $demande = DB::table('demandes_intervention')
                ->where('idDemande', $idDemande)
                ->first();

            if (!$demande) {
                session()->flash('error', 'Demande introuvable.');
                return;
            }

         
            if ($demande->idClient == $this->user->idUser) {
                session()->flash('error', 'Vous ne pouvez pas accepter vos propres demandes.');
                return;
            }

            $client = DB::table('utilisateurs')
                ->where('idUser', $demande->idClient)
                ->first();

            if (!$client) {
                session()->flash('error', 'Client introuvable.');
                return;
            }

           
            if ($this->user->role !== 'intervenant') {
                session()->flash('error', 'Vous devez être intervenant pour accepter des demandes.');
                return;
            }

            
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            
            DB::table('demandes_intervention')
                ->where('idDemande', $idDemande)
                ->update([
                    'statut' => 'validée',
                    'idIntervenant' => $this->user->idUser
                ]);
                
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            

            if ($client->email) {
                try {
                    Mail::to($client->email)->send(
                        new DemandeAccepteeMail($demande, $this->user, $client)
                    );
                } catch (\Exception $e) {
                    \Log::error('Erreur envoi email: ' . $e->getMessage());
                }
            }

            session()->flash('success', 'Demande acceptée avec succès !');
            
        } catch (\Exception $e) {
            \Log::error('Erreur acceptation demande: ' . $e->getMessage());
            session()->flash('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    #[Computed]
    public function totalRevenue()
    {
        return DB::table('demandes_intervention')
            ->join('factures', 'factures.idDemande', '=', 'demandes_intervention.idDemande')
            ->where('idIntervenant', Auth::id())
            ->whereIn('demandes_intervention.statut', ['validée', 'terminée'])
            ->sum('factures.montantTotal');
    }

   
    public function render()
    {
        $intervenantId = $this->user->idUser;

        
        $missionsCount = DB::table('demandes_intervention')
            ->where('idIntervenant', $intervenantId)
            ->where('statut', 'validée')
            ->count();

        $attenteCount = DB::table('demandes_intervention')
            ->where('statut', 'en_attente')
            ->count();

        
        $missionsTotales = DB::table('demandes_intervention')
            ->where('idIntervenant', $intervenantId)
            ->count();
        
        $missionsTerminees = DB::table('demandes_intervention')
            ->where('idIntervenant', $intervenantId)
            ->where('statut', 'terminée')
            ->count();
        
        $pourcentageMissions = $missionsTotales > 0 
            ? round(($missionsTerminees / $missionsTotales) * 100) 
            : 0;

        
        $noteMoyenne = DB::table('feedbacks')
            ->where('idCible', $this->user->idUser)
            ->selectRaw('AVG((credibilite + sympathie + ponctualite + proprete + qualiteTravail) / 5)')
            ->value(DB::raw('AVG((credibilite + sympathie + ponctualite + proprete + qualiteTravail) / 5)'));

        if (!$noteMoyenne) {
            $noteMoyenne = $this->user->note ?? 4.8;
        }

        
        $demandesUrgentes = [];

        if ($this->isAvailable) {
            $demandesUrgentes = DB::table('demandes_intervention')
                ->join('utilisateurs', 'demandes_intervention.idClient', '=', 'utilisateurs.idUser')
                ->leftJoin('animal_demande', 'demandes_intervention.idDemande', '=', 'animal_demande.idDemande')
                ->leftJoin('factures', 'factures.idDemande', '=', 'demandes_intervention.idDemande')
                ->leftJoin('animals', 'animal_demande.idAnimal', '=', 'animals.idAnimale')
                ->select(
                    'demandes_intervention.*',
                    'demandes_intervention.idDemande as id_demande_reelle',
                    'utilisateurs.nom as nom_client',
                    'utilisateurs.prenom as prenom_client',
                    'utilisateurs.note as note_client',
                    'utilisateurs.photo as photo_client',
                    'demandes_intervention.lieu as ville_client',
                    'animals.nomAnimal as nom_animal',
                    'animals.age',
                    'animals.espece',
                    'animals.race as race_animal',
                    'animals.statutVaccination',
                    'animals.note_comportementale',
                    'factures.numFacture as numFac',
                    'factures.montantTotal'
                )
                ->where('demandes_intervention.statut', 'en_attente')
                ->whereDate('demandes_intervention.dateSouhaitee', '>=', Carbon::today())
                ->orderBy('demandes_intervention.dateDemande', 'asc')
                ->limit(5)
                ->get();
        }

        
        $missionsAVenir = DB::table('demandes_intervention')
            ->join('utilisateurs', 'demandes_intervention.idClient', '=', 'utilisateurs.idUser')
            ->leftJoin('animal_demande', 'demandes_intervention.idDemande', '=', 'animal_demande.idDemande')
            ->leftJoin('factures', 'factures.idDemande', '=', 'demandes_intervention.idDemande')
            ->leftJoin('animals', 'animal_demande.idAnimal', '=', 'animals.idAnimale')
            ->select(
                'demandes_intervention.*',
                'demandes_intervention.idDemande as id_demande_reelle',
                'utilisateurs.nom as nom_client',
                'utilisateurs.prenom as prenom_client',
                'utilisateurs.note as note_client',
                'utilisateurs.photo as photo_client',
                'demandes_intervention.lieu as ville_client',
                'animals.nomAnimal as nom_animal',
                'animals.age',
                'animals.espece',
                'animals.race as race_animal',
                'animals.statutVaccination',
                'animals.note_comportementale',
                'factures.numFacture as numFac',
                'factures.montantTotal'
            )
            ->where('demandes_intervention.idIntervenant', $intervenantId)
            ->whereIn('demandes_intervention.statut', ['validée', 'en_cours'])
            ->whereDate('demandes_intervention.dateSouhaitee', '>=', Carbon::today())
            ->orderBy('demandes_intervention.dateSouhaitee', 'asc')
            ->limit(3)
            ->get();

        
        $avisRecents = DB::table('feedbacks')
            ->join('utilisateurs', 'feedbacks.idAuteur', '=', 'utilisateurs.idUser')
            ->select(
                'feedbacks.*',
                'utilisateurs.prenom',
                'utilisateurs.photo',
                DB::raw('ROUND((credibilite + sympathie + ponctualite + proprete + qualiteTravail) / 5, 1) as note_moyenne')
            )
            ->where('feedbacks.idCible', $intervenantId)
            ->where('feedbacks.estVisible', 1)
            ->orderBy('feedbacks.dateCreation', 'desc')
            ->limit(2)
            ->get();

        //  dd($demandesUrgentes);

        return view('livewire.pet-keeping.pet-keeper-dashboard', [
            'stats' => [
                'missions' => $missionsCount,
                'attente' => $attenteCount,
                'note' => round($noteMoyenne, 1),
                'revenu' => $this->totalRevenue(),
                'clients_fideles' => 0, 
                'pourcentage_missions' => $pourcentageMissions
            ],
            'demandesUrgentes' => $demandesUrgentes,
            'missionsAVenir' => $missionsAVenir,
            'avisRecents' => $avisRecents,
            'groupedDemandesUrgentes' => $this->groupAnimalsByDemande($demandesUrgentes),
            'groupedMissionsAVenir' => $this->groupAnimalsByDemande($missionsAVenir)
        ]);
    }
}