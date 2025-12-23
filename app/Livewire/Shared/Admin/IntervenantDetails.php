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
    public $serviceId;
    public $offre;
    public $intervenant;
    public $user;
    public $professeurData = null;
    public $babysitterData = null;
    public $petkeeperData = null;
    public $serviceType = null;
    public $refusalReason = '';
    public $showRefusalModal = false;

    public function mount($idintervenant, $idservice)
    {
        // Vérifier si l'utilisateur est admin
        if (!session()->has('is_admin')) {
            return redirect()->route('login')->with('error', 'Accès réservé aux administrateurs');
        }

        $this->intervenantId = $idintervenant;
        $this->serviceId = $idservice;

        // Résoudre un idService manquant selon la catégorie détectée
        if (empty($this->serviceId)) {
            $resolved = null;

            if (DB::table('babysitters')->where('idBabysitter', $this->intervenantId)->exists()) {
                $resolved = DB::table('services')->where('nomService', 'Babysitting')->value('idService');
            }

            if (!$resolved && DB::table('petkeepers')->where('idPetKeeper', $this->intervenantId)->exists()) {
                $resolved = DB::table('services')->where('nomService', 'Pet Keeping')->value('idService');
            }

            if (!$resolved && DB::table('professeurs')->where('intervenant_id', $this->intervenantId)->exists()) {
                $resolved = DB::table('services')->where('nomService', 'Soutien Scolaire')->value('idService');
            }

            $this->serviceId = $resolved;
        }

        $this->loadIntervenantData();
    }

    private function loadIntervenantData()
    {
        // Get the specific offer from offres_services (peut être absente pour certains flux)
        $this->offre = DB::table('offres_services')
            ->where('idintervenant', $this->intervenantId)
            ->when($this->serviceId, fn($q) => $q->where('idService', $this->serviceId))
            ->first();

        // Get intervenant data
        $this->intervenant = Intervenant::where('IdIntervenant', $this->intervenantId)->first();
        
        if (!$this->intervenant) {
            session()->flash('error', 'Intervenant non trouvé');
            return redirect()->route('admin.intervenants');
        }

        // Prioriser le statut de l'offre si elle existe et est EN_ATTENTE (cas d'ajout d'un 2ème service)
        // Sinon si l'intervenant est encore en attente, forcer l'affichage en attente
        if ($this->offre) {
            if ($this->offre->statut === 'EN_ATTENTE') {
                // L'offre est en attente (2ème service), garder EN_ATTENTE
                $this->offre->statut = 'EN_ATTENTE';
            } elseif ($this->intervenant->statut === 'EN_ATTENTE') {
                // L'intervenant est en attente, forcer l'offre aussi
                $this->offre->statut = 'EN_ATTENTE';
            }
        }

        // Si aucune offre n'existe, créer un stub minimal pour l'affichage
        if (!$this->offre && $this->serviceId) {
            $this->offre = (object) [
                'idintervenant' => $this->intervenantId,
                'idService' => $this->serviceId,
                'statut' => $this->intervenant->statut ?? 'EN_ATTENTE',
                'created_at' => $this->intervenant->created_at,
            ];
        }

        // Get user data
        $this->user = Utilisateur::leftJoin('localisations', 'utilisateurs.idUser', '=', 'localisations.idUser')
            ->where('utilisateurs.idUser', $this->intervenant->IdIntervenant)
            ->select('utilisateurs.*', 'localisations.ville', 'localisations.adresse')
            ->first();

        // Get service name to determine type
        $service = DB::table('services')->where('idService', $this->serviceId)->first();
        
        if ($service) {
            $this->loadIntervenantSpecificData($this->intervenant->IdIntervenant, $service->nomService);
        }
    }

    private function loadIntervenantSpecificData($idIntervenant, $serviceName)
    {
        $serviceName = strtolower($serviceName);
        
        if ($serviceName === 'soutien scolaire') {
            $professeur = DB::table('professeurs')
                ->where('intervenant_id', $idIntervenant)
                ->first();
            
            if ($professeur) {
                $this->serviceType = 'Soutien Scolaire';
                $this->professeurData = $professeur;
                
                $this->professeurData->matieres = DB::table('services_prof')
                    ->join('matieres', 'services_prof.matiere_id', '=', 'matieres.id_matiere')
                    ->where('services_prof.professeur_id', $professeur->id_professeur)
                    ->select('matieres.nom_matiere', 'services_prof.type_service', 'services_prof.prix_par_heure')
                    ->get();
            }
            return;
        }
        
        if ($serviceName === 'babysitting') {
            $babysitter = DB::table('babysitters')
                ->where('idBabysitter', $idIntervenant)
                ->first();
            
            if ($babysitter) {
                $this->serviceType = 'Babysitting';
                $this->babysitterData = $babysitter;
                // Normaliser l'affichage des langues pour éviter les chaînes JSON brutes
                if (!empty($this->babysitterData->langues)) {
                    $decoded = is_string($this->babysitterData->langues)
                        ? json_decode($this->babysitterData->langues, true)
                        : $this->babysitterData->langues;
                    $this->babysitterData->langues = is_array($decoded) ? $decoded : (array) $decoded;
                } else {
                    $this->babysitterData->langues = [];
                }

                // Champs supplémentaires : niveau d'études, préférence du lieu de travail, maladies, expériences besoins spéciaux
                $this->babysitterData->niveau_etudes = $babysitter->niveauEtudes ?? null;

                $prefMap = [
                    'domicil_babysitter' => 'Chez le/la babysitter',
                    'domicil_client' => 'Au domicile du client',
                    'les_deux' => 'Les deux (flexible)'
                ];
                $this->babysitterData->preference_domicil_human = $prefMap[$babysitter->preference_domicil ?? ''] ?? null;

                if (!empty($babysitter->maladies)) {
                    $this->babysitterData->maladies_list = collect(preg_split('/[,;\n]+/', $babysitter->maladies))
                        ->map(fn ($s) => trim($s))
                        ->filter()
                        ->values()
                        ->toArray();
                } else {
                    $this->babysitterData->maladies_list = [];
                }

                $this->babysitterData->experiences_speciaux = DB::table('choisir_experiences')
                    ->join('experience_besoins_speciaux', 'choisir_experiences.idExperience', '=', 'experience_besoins_speciaux.idExperience')
                    ->where('choisir_experiences.idBabysitter', $idIntervenant)
                    ->pluck('experience_besoins_speciaux.experience')
                    ->toArray();
                
                $this->babysitterData->superpouvoirs = DB::table('choisir_superpourvoirs')
                    ->join('superpouvoirs', 'choisir_superpourvoirs.idSuperpouvoir', '=', 'superpouvoirs.idSuperpouvoir')
                    ->where('choisir_superpourvoirs.idBabysitter', $idIntervenant)
                    ->pluck('superpouvoirs.superpouvoir')
                    ->toArray();
                
                $this->babysitterData->formations = DB::table('choisir_formations')
                    ->join('formations', 'choisir_formations.idFormation', '=', 'formations.idFormation')
                    ->where('choisir_formations.idBabysitter', $idIntervenant)
                    ->pluck('formations.formation')
                    ->toArray();
                
                $this->babysitterData->categories = DB::table('choisir_categories')
                    ->join('categorie_enfants', 'choisir_categories.idCategorie', '=', 'categorie_enfants.idCategorie')
                    ->where('choisir_categories.idBabysitter', $idIntervenant)
                    ->pluck('categorie_enfants.categorie')
                    ->toArray();

                // Documents uploadés lors de l'inscription babysitter
                $this->babysitterData->documents = collect([
                    ['label' => 'Casier judiciaire', 'path' => $babysitter->procedeJuridique ?? null],
                    ['label' => 'Radiographie thorax', 'path' => $babysitter->radiographieThorax ?? null],
                    ['label' => 'Coproculture des selles', 'path' => $babysitter->coprocultureSelles ?? null],
                    ['label' => "Certificat d'aptitude mentale", 'path' => $babysitter->certifAptitudeMentale ?? null],
                ])->filter(fn($doc) => !empty($doc['path']));
            }
            return;
        }
        
        if ($serviceName === 'pet keeping') {
            $petkeeper = DB::table('petkeepers')
                ->where('idPetKeeper', $idIntervenant)
                ->first();
            
            if ($petkeeper) {
                $this->serviceType = "Garde d'animaux";
                $this->petkeeperData = $petkeeper;
                
                $certifications = DB::table('petkeeper_certifications')
                    ->where('idPetKeeper', $petkeeper->idPetKeeper)
                    ->get();

                $this->petkeeperData->certifications = $certifications;

                // Documents obligatoires (casier judiciaire, justificatif de domicile) + reste des certificats
                $this->petkeeperData->documents = collect([
                    [
                        'label' => 'Extrait de casier judiciaire',
                        'path' => optional($certifications->firstWhere('certification', 'EXTRACT_DE_CASIER_JUDICIAIRE'))->document,
                    ],
                    [
                        'label' => 'Justificatif de domicile',
                        'path' => optional($certifications->firstWhere('certification', 'JUSTIFICATIF_DE_DOMICILE'))->document,
                    ],
                ])->filter(fn ($doc) => !empty($doc['path']));

                $this->petkeeperData->otherCertifications = $certifications->filter(
                    fn ($cert) => !in_array($cert->certification, [
                        'EXTRACT_DE_CASIER_JUDICIAIRE',
                        'JUSTIFICATIF_DE_DOMICILE',
                    ])
                );
            }
            return;
        }

        // Fallback: si le nom de service est personnalisé (ex: "Gardiennage de chiens"), détecter PetKeeper par table
        if (!$this->serviceType) {
            $petkeeper = DB::table('petkeepers')
                ->where('idPetKeeper', $idIntervenant)
                ->first();

            if ($petkeeper) {
                $this->serviceType = "Garde d'animaux";
                $this->petkeeperData = $petkeeper;

                $certifications = DB::table('petkeeper_certifications')
                    ->where('idPetKeeper', $petkeeper->idPetKeeper)
                    ->get();

                $this->petkeeperData->certifications = $certifications;

                $this->petkeeperData->documents = collect([
                    [
                        'label' => 'Extrait de casier judiciaire',
                        'path' => optional($certifications->firstWhere('certification', 'EXTRACT_DE_CASIER_JUDICIAIRE'))->document,
                    ],
                    [
                        'label' => 'Justificatif de domicile',
                        'path' => optional($certifications->firstWhere('certification', 'JUSTIFICATIF_DE_DOMICILE'))->document,
                    ],
                ])->filter(fn ($doc) => !empty($doc['path']));

                $this->petkeeperData->otherCertifications = $certifications->filter(
                    fn ($cert) => !in_array($cert->certification, [
                        'EXTRACT_DE_CASIER_JUDICIAIRE',
                        'JUSTIFICATIF_DE_DOMICILE',
                    ])
                );
            }
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
        // Update the offre status in offres_services
        DB::table('offres_services')
            ->where('idintervenant', $this->intervenantId)
            ->where('idService', $this->serviceId)
            ->update([
                'statut' => 'ACTIVE',

            ]);

        // Update intervenant status to VALIDE if not already
        if ($this->intervenant->statut !== 'VALIDE') {
            $this->intervenant->statut = 'VALIDE';
            $this->intervenant->idAdmin = session('admin_id');
            $this->intervenant->save();
        }

        try {
            Mail::to($this->user->email)->send(new IntervenantAccepte($this->user, $this->serviceType ?? 'Intervenant'));
        } catch (\Exception $e) {
            \Log::error('Erreur envoi email acceptation: ' . $e->getMessage());
        }

        session()->flash('success', 'Offre approuvée avec succès ! Un email de confirmation a été envoyé.');
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

        // Update the offre status in offres_services
        DB::table('offres_services')
            ->where('idintervenant', $this->intervenantId)
            ->where('idService', $this->serviceId)
            ->update([
                'statut' => 'ARCHIVED'
            ]);

        // Check if intervenant has any other active offers
        $hasActiveOffers = DB::table('offres_services')
            ->where('idintervenant', $this->intervenantId)
            ->where('statut', 'ACTIVE')
            ->exists();

        // Only mark intervenant as REFUSE if they have no other active offers
        if (!$hasActiveOffers && $this->intervenant->statut !== 'REFUSE') {
            $this->intervenant->statut = 'REFUSE';
            $this->intervenant->idAdmin = session('admin_id');
            $this->intervenant->save();
        }

        try {
            Mail::to($this->user->email)->send(new IntervenantRefuse($this->user, $this->refusalReason, $this->serviceType ?? 'Intervenant'));
        } catch (\Exception $e) {
            \Log::error('Erreur envoi email refus: ' . $e->getMessage());
        }

        session()->flash('success', 'Offre refusée. Un email d\'information a été envoyé à l\'intervenant.');
        return redirect()->route('admin.intervenants');
    }

    public function render()
    {
        return view('livewire.shared.admin.intervenant-details');
    }
}