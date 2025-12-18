<?php

namespace App\Livewire\Babysitter;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\BabysitterRegistrationMail;
use App\Models\shared\Intervenant;
use App\Models\shared\Utilisateur;
use App\Models\Babysitting\Babysitter;
use App\Models\Babysitting\PreferenceDomicil;
use App\Models\Babysitting\CategorieEnfant;
use App\Models\Shared\Disponibilite;
use App\Models\Babysitting\ExperienceBesoinSpeciaux;
use App\Models\Babysitting\Formation;
use App\Models\Babysitting\Superpouvoir;
use App\Models\shared\Localisation;
use Illuminate\Support\Facades\Cache;

class BabysitterRegistration extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $totalSteps = 6; // Ajout d'une étape pour la vérification email

    // Étape 1
    public $prenom, $nom, $email, $date_naissance;
    public $mot_de_passe, $mot_de_passe_confirmation;
    public $je_fume = false, $jai_enfants = false;
    public $permis_conduire = false, $jai_voiture = false;

    // Vérification email
    public $verification_code = '';
    public $email_verified = false;
    public $verification_sent = false;

    // Étape 2
    public $telephone, $adresse, $photo_profil;
    public $latitude, $longitude, $ville;
    public $auto_localisation = false;

    // Étape 3
    public $prix_horaire, $annees_experience, $niveau_etudes, $autre_formation;
    public $description, $experience_detaillee;
    public $a_maladies = '';
    public $maladies_selectionnees = [];
    public $autres_maladies = '';
    public $langues = [];
    public $categories_enfants = [];
    public $preferences_domicile = '';
    public $besoins_speciaux = [];

    // Étape 4
    public $certifications = [];
    public $superpowers = [];
    public $disponibilites = [];

    // Étape 5
    public $radiographie_thorax, $coproculture_selles;
    public $certificat_aptitude, $casier_judiciaire;

    // Données pour les formulaires
    public $documents = [
        ['name' => 'casier_judiciaire', 'label' => 'Casier judiciaire', 'required' => true],
        ['name' => 'radiographie_thorax', 'label' => 'Radiographie thorax', 'required' => false],
        ['name' => 'coproculture_selles', 'label' => 'Coproculture des selles', 'required' => false],
        ['name' => 'certificat_aptitude', 'label' => 'Certificat d\'aptitude mentale', 'required' => false],
    ];

    public $besoins_list = [
        "Troubles de l'anxiété",
        "Trouble du Déficit de l'Attention avec ou sans Hyperactivité (TDAH)",
        "Trouble du Spectre de l'Autisme (TSA)",
        "Asthme",
        "Sourds et malentendants",
        "Diabète",
        "Troubles du langage",
        "Épilepsie",
        "Allergies alimentaires",
        "Troubles Obsessionnels Compulsifs (TOC)",
        "Handicap physique",
        "Déficience visuelle",
    ];

    public $superpouvoirs_list = [
        ['name' => 'Dessin', 'icon' => '🎨'],
        ['name' => 'Travaux manuels', 'icon' => '✂️'],
        ['name' => 'Langues', 'icon' => '🌍'],
        ['name' => 'Faire la lecture', 'icon' => '📚'],
        ['name' => 'Jeux', 'icon' => '🎲'],
        ['name' => 'Musique', 'icon' => '🎵'],
    ];

    public $langues_list = ['Français', 'Anglais', 'Arabe', 'Espagnol', 'Allemand'];
    
    public $categories_enfants_list = ['Nouveau-né (0-6 mois)', 'Bébé (6-18 mois)', 'Tout-petit (18-36 mois)', 'Enfant (3-6 ans)', 'Enfant plus âgé (6-12 ans)'];
    
    public $preferences_domicile_list = [
        ['label' => 'Chez moi', 'value' => 'domicile_babysitter', 'icon' => '🏠'],
        ['label' => 'Chez la famille', 'value' => 'domicile_client', 'icon' => '🚗'],
    ];
    
    public $certifications_list = ['Premiers secours', 'Sauvetage aquatique', 'Garde d\'enfants', 'Assistant maternel', 'Éducation spécialisée'];

    public function mount()
    {
        $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
        foreach ($jours as $jour) {
            $this->disponibilites[$jour] = [];
        }
    }

    public function updatedAutoLocalisation($value)
    {
        // Quand l'utilisateur active la géolocalisation, on déclenche le JS
        if ($value) {
            $this->dispatch('getLocation');
        }
    }

    public function setLocation($latitude, $longitude, $ville)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->ville = $ville;
    }

    public function rules()
    {
        $rules = [];

        if ($this->currentStep == 1) {
            $rules = [
                'prenom' => 'required|string|max:255',
                'nom' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    'unique:utilisateurs,email',
                    function ($attribute, $value, $fail) {
                        // Vérifier si l'email est valide
                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $fail('L\'adresse email n\'est pas valide.');
                            return;
                        }
                    }
                ],
                'date_naissance' => 'required|date|before:today',
                'mot_de_passe' => 'required|min:8|confirmed',
            ];
        }

        if ($this->currentStep == 2) {
            $rules = [
                'telephone' => 'required|string|max:20',
                'photo_profil' => 'nullable|image|max:5120',
            ];
            
            // L'adresse n'est requise que si la géolocalisation automatique n'est pas activée
            if (!$this->auto_localisation) {
                $rules['adresse'] = 'required|string|max:500';
            }
        }

        if ($this->currentStep == 3) {
            $rules = [
                'telephone' => 'required|string|max:20',
                'adresse' => 'required|string|max:500',
                'photo_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ];
            
            // Si géolocalisation automatique, l'adresse n'est pas obligatoire
            if ($this->auto_localisation) {
                unset($rules['adresse']);
            }
        }

        if ($this->currentStep == 4) {
            $rules = [
                'prix_horaire' => 'required|numeric|min:0',
                'annees_experience' => 'required|string',
                'niveau_etudes' => 'required|string|max:500',
                'description' => 'required|string|max:1000',
                'experience_detaillee' => 'nullable|string|max:2000',
                'langues' => 'required|array|min:1',
                'preferences_domicile' => 'required|string|in:domicile_babysitter,domicile_client,les_deux',
                'a_maladies' => 'required|string|in:oui,non',
            ];
            
            // Si "Autre formation" est sélectionné, le champ autre_formation est requis
            if ($this->niveau_etudes === 'Autre formation') {
                $rules['autre_formation'] = 'required|string|max:500';
            }
            
            // Si "Oui" pour maladies, au moins une maladie doit être sélectionnée
            if ($this->a_maladies === 'oui') {
                $rules['maladies_selectionnees'] = 'nullable|array';
            }
        }

        if ($this->currentStep == 5) {
            // Étape 5 - Compétences et disponibilités (créneaux)
            // Valider que les créneaux non récurrents ont une date spécifique
            if (!empty($this->disponibilites)) {
                foreach ($this->disponibilites as $jour => $creneaux) {
                    if (!empty($creneaux)) {
                        foreach ($creneaux as $index => $creneau) {
                            if (!($creneau['est_reccurent'] ?? false)) {
                                $rules["disponibilites.{$jour}.{$index}.date_specifique"] = 'required|date|after_or_equal:today';
                            }
                        }
                    }
                }
            }
        }

        if ($this->currentStep == 6) {
            $rules = [
                'casier_judiciaire' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'radiographie_thorax' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'coproculture_selles' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'certificat_aptitude' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'prenom.required' => 'Le prénom est obligatoire',
            'nom.required' => 'Le nom est obligatoire',
            'email.required' => "L'email est obligatoire",
            'email.email' => "L'email doit être valide",
            'email.unique' => 'Cet email est déjà utilisé',
            'date_naissance.required' => 'La date de naissance est obligatoire',
            'date_naissance.before' => "La date de naissance doit être antérieure à aujourd'hui",
            'mot_de_passe.required' => 'Le mot de passe est obligatoire',
            'mot_de_passe.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'mot_de_passe.confirmed' => 'Les mots de passe ne correspondent pas',
            'telephone.required' => 'Le téléphone est obligatoire',
            'adresse.required' => "L'adresse est obligatoire",
            'prix_horaire.required' => 'Le prix horaire est obligatoire',
            'annees_experience.required' => "Les années d'expérience sont obligatoires",
            'niveau_etudes.required' => "Le niveau d'études est obligatoire",
            'description.required' => 'La description est obligatoire',
            // 'experience_detaillee.required' => "L'expérience détaillée est obligatoire",
            'langues.required' => 'Sélectionnez au moins une langue',
            'preferences_domicile.required' => 'Sélectionnez au moins une préférence de domicile',
            'casier_judiciaire.required' => 'Le casier judiciaire est obligatoire',
        ];
    }

    public function suivant()
    {
        \Log::info('BabysitterRegistration - Method suivant() called');
        \Log::info('Current step: ' . $this->currentStep . ' / Total steps: ' . $this->totalSteps);
        
        // Si on est à l'étape 1, envoyer le code et passer à l'étape 2
        if ($this->currentStep == 1) {
            \Log::info('Step 1 - validating and sending verification code');
            $rules = $this->rules();
            \Log::info('Rules retrieved: ' . (empty($rules) ? 'no rules' : 'has rules'));
            
            if (!empty($rules)) {
                \Log::info('Validating form data...');
                try {
                    $this->validate();
                    \Log::info('Validation passed');
                } catch (\Exception $e) {
                    \Log::error('Validation failed: ' . $e->getMessage());
                    throw $e;
                }
            }
            
            $this->sendVerificationCode();
            return;
        }
        
        // Si on est à l'étape 2, vérifier le code
        if ($this->currentStep == 2) {
            \Log::info('Step 2 - verifying email code');
            $this->verifyEmailCode();
            return;
        }
        
        // Pour les autres étapes, validation normale
        $rules = $this->rules();
        \Log::info('Rules retrieved: ' . (empty($rules) ? 'no rules' : 'has rules'));
        
        if (!empty($rules)) {
            \Log::info('Validating form data...');
            try {
                $this->validate();
                \Log::info('Validation passed');
            } catch (\Exception $e) {
                \Log::error('Validation failed: ' . $e->getMessage());
                throw $e;
            }
        }
        
        if ($this->currentStep < $this->totalSteps) {
            $oldStep = $this->currentStep;
            $this->currentStep++;
            \Log::info('Step changed from ' . $oldStep . ' to ' . $this->currentStep);
        } else {
            \Log::info('Cannot advance - already at maximum step');
        }
        
        \Log::info('suivant() method completed');
    }

    public function sendVerificationCode()
    {
        try {
            \Log::info('Sending verification code to email: ' . $this->email);
            
            // Générer un code à 5 chiffres
            $code = str_pad(random_int(0, 99999), 5, '0', STR_PAD_LEFT);
            \Log::info('Generated code: ' . $code);
            
            // Stocker dans le cache pendant 30 minutes
            Cache::put("email_verification_{$this->email}", $code, now()->addMinutes(30));
            \Log::info('Code stored in cache for 30 minutes');
            
            // Envoyer l'email avec le code
            \Log::info('Attempting to send email...');
            \Mail::raw("Votre code de vérification est : {$code}", function($message) {
                $message->to($this->email)
                    ->subject('Code de vérification - Inscription Babysitter');
            });
            \Log::info('Email sent successfully');
            
            $this->verification_sent = true;
            $this->currentStep = 2; // Passer à l'étape de vérification
            
            session()->flash('success', 'Un code de vérification à 5 chiffres a été envoyé à votre email.');
            \Log::info('Verification code process completed successfully');
            
        } catch (\Exception $e) {
            \Log::error('Error sending verification code: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            session()->flash('error', 'Erreur lors de l\'envoi du code de vérification.');
        }
    }
    
    public function verifyEmailCode()
    {
        \Log::info('Verifying email code: ' . $this->verification_code . ' for email: ' . $this->email);
        
        $this->validate([
            'verification_code' => 'required|digits:5'
        ], [
            'verification_code.required' => 'Le code de vérification est obligatoire',
            'verification_code.digits' => 'Le code doit contenir exactement 5 chiffres'
        ]);
        
        // Vérifier le code dans le cache
        $storedCode = Cache::get("email_verification_{$this->email}");
        \Log::info('Stored code in cache: ' . ($storedCode ?? 'null'));
        
        if ($storedCode && $storedCode === $this->verification_code) {
            \Log::info('Code verification successful');
            // Supprimer le code du cache après vérification
            Cache::forget("email_verification_{$this->email}");
            
            $this->email_verified = true;
            $this->currentStep = 3; // Passer à l'étape suivante
            session()->flash('success', 'Email vérifié avec succès !');
        } else {
            \Log::info('Code verification failed - codes do not match');
            session()->flash('error', 'Code invalide ou expiré. Veuillez réessayer.');
        }
    }
    
    public function resendCode()
    {
        $this->verification_sent = false;
        $this->sendVerificationCode();
    }

    public function ajouterDisponibilite($jour)
    {
        $this->disponibilites[$jour][] = [
            'debut' => '', 
            'fin' => '',
            'est_reccurent' => true
        ];
    }

    public function supprimerDisponibilite($jour, $index)
    {
        unset($this->disponibilites[$jour][$index]);
        $this->disponibilites[$jour] = array_values($this->disponibilites[$jour]);
    }

    public function toggleReccurent($jour, $index)
    {
        $this->disponibilites[$jour][$index]['est_reccurent'] = !$this->disponibilites[$jour][$index]['est_reccurent'];
    }

    public function finaliser()
    {
        \Log::info('Babysitter registration started');
        \Log::info('Current step: ' . $this->currentStep);
        
        // Vérifier que l'email est bien vérifié
        if (!$this->email_verified) {
            session()->flash('error', 'Veuillez vérifier votre email avant de finaliser l\'inscription.');
            return;
        }
        
        $this->validate();
        \Log::info('Validation passed');

        DB::beginTransaction();
        \Log::info('Database transaction started');

        try {
            // 1. Upload photo profil
            $photoPath = null;
            if ($this->photo_profil) {
                \Log::info('Uploading profile photo');
                $photoPath = $this->photo_profil->store('images', 'public');
                \Log::info('Photo uploaded: ' . $photoPath);
            }

            // 2. Créer l'utilisateur
            \Log::info('Creating user with email: ' . $this->email);
            $utilisateur = Utilisateur::create([
                'nom' => $this->nom,
                'prenom' => $this->prenom,
                'email' => $this->email,
                'password' => Hash::make($this->mot_de_passe),
                'telephone' => $this->telephone,
                'dateNaissance' => $this->date_naissance,
                'role' => 'intervenant',
                'statut' => 'actif',
                'photo' => $photoPath,
            ]);
            \Log::info('User created with ID: ' . $utilisateur->idUser);

            // 3. Créer la localisation
            \Log::info('Creating location for user ID: ' . $utilisateur->idUser);
            Localisation::create([
                'idUser' => $utilisateur->idUser,
                'latitude' => $this->latitude ?? 0,
                'longitude' => $this->longitude ?? 0,
                'ville' => $this->ville ?? '',
                'adresse' => $this->adresse ?? ($this->ville ?? 'Adresse non spécifiée'),
            ]);
            \Log::info('Location created');

            // 4. Créer l'intervenant
            \Log::info('Creating intervenant for user ID: ' . $utilisateur->idUser);
            $intervenant = new Intervenant();
            $intervenant->IdIntervenant = $utilisateur->idUser;
            $intervenant->statut = 'EN_ATTENTE';
            $intervenant->save();
            \Log::info('Intervenant created');

            // 5. Upload des documents
            $procedeJuridique = $this->casier_judiciaire ? 
                $this->casier_judiciaire->store('babysitters/documents', 'public') : null;
            $coprocultureSelles = $this->coproculture_selles ? 
                $this->coproculture_selles->store('babysitters/documents', 'public') : null;
            $certifAptitude = $this->certificat_aptitude ? 
                $this->certificat_aptitude->store('babysitters/documents', 'public') : null;
            $radiographieThorax = $this->radiographie_thorax ? 
                $this->radiographie_thorax->store('babysitters/documents', 'public') : null;

            // 6. Convertir années d'expérience
            $expAnneeInt = 0;
            switch($this->annees_experience) {
                case '0-1': $expAnneeInt = 0; break;
                case '1-3': $expAnneeInt = 2; break;
                case '3-5': $expAnneeInt = 4; break;
                case '5+': $expAnneeInt = 5; break;
            }

            // 7. Déterminer preference_domicil
            $preferenceDomicil = $this->preferences_domicile;
            
            // Mapper les valeurs du formulaire vers les valeurs de la base de données
            if ($preferenceDomicil == 'domicile_babysitter') {
                $preferenceDomicil = 'domicil_babysitter';
            } elseif ($preferenceDomicil == 'domicile_client') {
                $preferenceDomicil = 'domicil_client';
            } else {
                $preferenceDomicil = 'les_deux';
            }

            // 8. Créer le profil babysitter
            \Log::info('Creating babysitter profile for intervenant ID: ' . $intervenant->IdIntervenant);
            $babysitter = new Babysitter();
            $babysitter->idBabysitter = $intervenant->IdIntervenant;
            $babysitter->prixHeure = $this->prix_horaire;
            $babysitter->expAnnee = $expAnneeInt;
            $babysitter->niveauEtudes = $this->niveau_etudes;
            $babysitter->description = $this->description;
            $babysitter->langues = json_encode($this->langues);
            $babysitter->procedeJuridique = $procedeJuridique;
            $babysitter->coprocultureSelles = $coprocultureSelles;
            $babysitter->certifAptitudeMentale = $certifAptitude;
            $babysitter->radiographieThorax = $radiographieThorax;
            $babysitter->estFumeur = $this->je_fume;
            $babysitter->mobilite = $this->jai_voiture;
            $babysitter->possedeEnfant = $this->jai_enfants;
            $babysitter->permisConduite = $this->permis_conduire;
            $babysitter->maladies = $this->experience_detaillee;
            $babysitter->preference_domicil = $preferenceDomicil;
            \Log::info('Saving babysitter with data: ' . json_encode([
                'idBabysitter' => $babysitter->idBabysitter,
                'prixHeure' => $babysitter->prixHeure,
                'expAnnee' => $babysitter->expAnnee,
                'preference_domicil' => $babysitter->preference_domicil
            ]));
            $babysitter->save();
            \Log::info('Babysitter profile saved successfully');

            $idBabysitter = $intervenant->IdIntervenant;

            // 9. Associer les catégories d'enfants
            if (!empty($this->categories_enfants)) {
                foreach ($this->categories_enfants as $categorieNom) {
                    $categorie = CategorieEnfant::firstOrCreate(['categorie' => $categorieNom]);
                    DB::table('choisir_categories')->insert([
                        'idCategorie' => $categorie->idCategorie,
                        'idBabysitter' => $idBabysitter,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // 10. Associer les besoins spéciaux
            if (!empty($this->besoins_speciaux)) {
                foreach ($this->besoins_speciaux as $besoinNom) {
                    $besoin = ExperienceBesoinSpeciaux::where('experience', $besoinNom)->first();
                    if ($besoin) {
                        DB::table('choisir_experiences')->insert([
                            'idExperience' => $besoin->idExperience,
                            'idBabysitter' => $idBabysitter,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            // 11. Associer les formations/certifications
            if (!empty($this->certifications)) {
                foreach ($this->certifications as $formationNom) {
                    $formation = Formation::firstOrCreate(['formation' => $formationNom]);
                    DB::table('choisir_formations')->insert([
                        'idFormation' => $formation->idFormation,
                        'idBabysitter' => $idBabysitter,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // 12. Associer les superpouvoirs
            if (!empty($this->superpowers)) {
                foreach ($this->superpowers as $superpouvoirNom) {
                    $superpouvoir = Superpouvoir::firstOrCreate(['superpouvoir' => $superpouvoirNom]);
                    DB::table('choisir_superpourvoirs')->insert([
                        'idSuperpouvoir' => $superpouvoir->idSuperpouvoir,
                        'idBabysitter' => $idBabysitter,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // 13. Créer les disponibilités
            $jourMapping = [
                'lundi' => 'Lundi',
                'mardi' => 'Mardi',
                'mercredi' => 'Mercredi',
                'jeudi' => 'Jeudi',
                'vendredi' => 'Vendredi',
                'samedi' => 'Samedi',
                'dimanche' => 'Dimanche',
            ];

            foreach ($this->disponibilites as $jour => $plages) {
                if (!empty($plages)) {
                    foreach ($plages as $plage) {
                        if (!empty($plage['debut']) && !empty($plage['fin'])) {
                            Disponibilite::create([
                                'idIntervenant' => $intervenant->IdIntervenant,
                                'jourSemaine' => $jourMapping[$jour],
                                'heureDebut' => $plage['debut'],
                                'heureFin' => $plage['fin'],
                                'est_reccurent' => $plage['est_reccurent'] ?? false,
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            \Log::info('Database transaction committed successfully');

            // Envoyer l'email de confirmation
            try {
                \Log::info('Tentative envoi email à: ' . $this->email);
                
                // Envoyer à l'email du babysitter
                Mail::to($this->email)->send(new BabysitterRegistrationMail($this->nom, $this->prenom));
                
                \Log::info('Email envoyé avec succès à: ' . $this->email);
            } catch (\Exception $e) {
                // Continue même si l'email échoue
                \Log::error('Erreur envoi email babysitter: ' . $e->getMessage());
            }

            \Log::info('Redirecting to success page');
            return redirect()->route('babysitter-registration-success');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error in babysitter registration: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            session()->flash('error', 'Une erreur est survenue lors de l\'inscription: ' . $e->getMessage());
            
            return;
        }
    }

    public function render()
    {
        return view('livewire.babysitter.babysitter-registration');
    }
}