<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Babysitting\Babysitter;
use App\Models\Babysitting\DemandeIntervention;
use App\Models\Babysitting\Enfant;
use App\Models\Babysitting\Disponibilite;
use App\Models\Intervenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BabysitterController extends Controller
{
    /**
     * Lister tous les babysitters validés
     */
    public function index(Request $request)
    {
        $query = Babysitter::with([
            'intervenant.utilisateur.localisation',
            'intervenant.disponibilites',
            'formations',
            'superpourvoirs',
            'categoriesEnfants',
            'preferencesDomicil'
        ])->valide();

        // Filtres
        if ($request->has('prix_min') || $request->has('prix_max')) {
            $query->parPrix($request->prix_min, $request->prix_max);
        }

        if ($request->has('experience')) {
            $query->parExperience($request->experience);
        }

        if ($request->has('langue')) {
            $query->avecLangue($request->langue);
        }

        if ($request->has('ville')) {
            $query->whereHas('intervenant.utilisateur.localisation', function($q) use ($request) {
                $q->where('ville', 'LIKE', '%' . $request->ville . '%');
            });
        }

        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if ($sortBy === 'prix') {
            $query->orderBy('prixHeure', $sortOrder);
        } elseif ($sortBy === 'note') {
            $query->join('utilisateurs', 'babysitters.idBabysitter', '=', 'utilisateurs.idUser')
                  ->orderBy('utilisateurs.note', $sortOrder)
                  ->select('babysitters.*');
        } else {
            $query->orderBy('babysitters.created_at', $sortOrder);
        }

        $babysitters = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $babysitters
        ]);
    }

    /**
     * Afficher un babysitter spécifique
     */
    public function show($id)
    {
        $babysitter = Babysitter::with([
            'intervenant.utilisateur.localisation',
            'intervenant.disponibilites',
            'formations',
            'superpourvoirs',
            'categoriesEnfants',
            'preferencesDomicil',
            'experiencesBesoinsSpeciaux'
        ])->findOrFail($id);

        // Calculer le taux d'acceptation (à implémenter selon votre logique)
        $utilisateur = $babysitter->intervenant->utilisateur;

        return response()->json([
            'success' => true,
            'data' => [
                'babysitter' => $babysitter,
                'utilisateur' => $utilisateur,
                'statistiques' => [
                    'note_moyenne' => $utilisateur->note,
                    'nombre_avis' => $utilisateur->nbrAvis,
                ]
            ]
        ]);
    }

    /**
     * Mettre à jour le profil babysitter
     */
    public function update(Request $request, $id)
    {
        $babysitter = Babysitter::findOrFail($id);

      

        $validator = Validator::make($request->all(), [
            'prixHeure' => 'sometimes|numeric|min:0',
            'description' => 'sometimes|string|max:1000',
            'niveauEtudes' => 'sometimes|string|max:500',
            'langues' => 'sometimes|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $babysitter->update($request->only([
            'prixHeure', 'description', 'niveauEtudes'
        ]));

        if ($request->has('langues')) {
            $babysitter->langues = json_encode($request->langues);
            $babysitter->save();
        }

        // Mettre à jour les relations si fournies
        if ($request->has('formations')) {
            $babysitter->formations()->sync($request->formations);
        }

        if ($request->has('superpourvoirs')) {
            $babysitter->superpourvoirs()->sync($request->superpourvoirs);
        }

        if ($request->has('categories_enfants')) {
            $babysitter->categoriesEnfants()->sync($request->categories_enfants);
        }

        return response()->json([
            'success' => true,
            'message' => 'Profil mis à jour avec succès',
            'data' => $babysitter->fresh()
        ]);
    }

    /**
     * Recherche avancée de babysitters
     */
    public function search(Request $request)
    {
        $query = Babysitter::with([
            'intervenant.utilisateur.localisation',
            'intervenant.disponibilites',
            'formations',
            'superpourvoirs',
            'categoriesEnfants'
        ])->valide();

        // Recherche par localisation (rayon)
        if ($request->has('latitude') && $request->has('longitude')) {
            $lat = $request->latitude;
            $lng = $request->longitude;
            $radius = $request->get('radius', 10); // km

            $query->whereHas('intervenant.utilisateur.localisation', function($q) use ($lat, $lng, $radius) {
                $q->whereRaw(
                    "(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) <= ?",
                    [$lat, $lng, $lat, $radius]
                );
            });
        }

        // Filtre par disponibilité (jour spécifique)
        if ($request->has('jour')) {
            $query->whereHas('intervenant.disponibilites', function($q) use ($request) {
                $q->where('jourSemaine', $request->jour);
                
                if ($request->has('heure_debut') && $request->has('heure_fin')) {
                    $q->where('heureDebut', '<=', $request->heure_debut)
                      ->where('heureFin', '>=', $request->heure_fin);
                }
            });
        }

        // Filtre par formations
        if ($request->has('formations')) {
            $query->whereHas('formations', function($q) use ($request) {
                $q->whereIn('idFormation', $request->formations);
            });
        }

        // Filtre par catégories d'enfants
        if ($request->has('categories')) {
            $query->whereHas('categoriesEnfants', function($q) use ($request) {
                $q->whereIn('idCategorie', $request->categories);
            });
        }

        // Filtre par caractéristiques
        if ($request->has('non_fumeur')) {
            $query->where('estFumeur', false);
        }

        if ($request->has('avec_voiture')) {
            $query->where('mobilite', true);
        }

        if ($request->has('permis_conduire')) {
            $query->where('permisConduite', true);
        }

        $babysitters = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $babysitters
        ]);
    }

    /**
     * Obtenir les statistiques d'un babysitter
     */
    public function statistics($id)
    {
        $babysitter = Babysitter::with('intervenant.utilisateur')->findOrFail($id);
        
        // Vous pouvez ajouter plus de statistiques selon vos besoins
        $stats = [
            'total_heures' => 0, // À calculer depuis demandes_intervention
            'total_clients' => 0, // À calculer
            'note_moyenne' => $babysitter->intervenant->utilisateur->note,
            'nombre_avis' => $babysitter->intervenant->utilisateur->nbrAvis,
            'membre_depuis' => $babysitter->created_at->diffForHumans(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Créer une demande de réservation (booking)
     */
    public function createBooking(Request $request, $babysitterId)
    {
        $validator = Validator::make($request->all(), [
            'dateSouhaitee' => 'required|date|after:today',
            'heureDebut' => 'required|date_format:H:i',
            'heureFin' => 'required|date_format:H:i|after:heureDebut',
            'lieu' => 'required|string|max:255',
            'enfants' => 'required|array|min:1',
            'enfants.*.nomComplet' => 'required|string|max:255',
            'enfants.*.dateNaissance' => 'required|date|before:today',
            'enfants.*.besoinsSpecifiques' => 'nullable|string|max:500',
            'services' => 'required|array|min:1',
            'services.*' => 'exists:superpouvoirs,idSuperpouvoir',
            'message' => 'nullable|string|max:300'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Vérifier si le babysitter existe et est valide
            $babysitter = Babysitter::with(['intervenant', 'disponibilites'])->findOrFail($babysitterId);
            
            // Vérifier la disponibilité
            $dayOfWeek = ucfirst(strftime('%A', strtotime($request->dateSouhaitee)));
            $isAvailable = $babysitter->disponibilites()
                ->where('jourSemaine', $dayOfWeek)
                ->where('heureDebut', '<=', $request->heureDebut)
                ->where('heureFin', '>=', $request->heureFin)
                ->exists();

            if (!$isAvailable) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le babysitter n\'est pas disponible à cette date et heure'
                ], 422);
            }

            // Créer la demande d'intervention
            $demande = DemandeIntervention::create([
                'dateSouhaitee' => $request->dateSouhaitee,
                'heureDebut' => $request->heureDebut,
                'heureFin' => $request->heureFin,
                'lieu' => $request->lieu,
                'note_speciales' => $request->message,
                'idIntervenant' => $babysitterId,
                'idClient' => auth()->id(),
                'statut' => 'en_attente'
            ]);

            // Ajouter les enfants
            foreach ($request->enfants as $enfantData) {
                Enfant::create([
                    'nomComplet' => $enfantData['nomComplet'],
                    'dateNaissance' => $enfantData['dateNaissance'],
                    'besoinsSpecifiques' => $enfantData['besoinsSpecifiques'] ?? null,
                    'idDemande' => $demande->idDemande
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Demande de réservation envoyée avec succès',
                'data' => [
                    'idDemande' => $demande->idDemande,
                    'statut' => $demande->statut,
                    'babysitter' => [
                        'nom' => $babysitter->intervenant->nom,
                        'prenom' => $babysitter->intervenant->prenom
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la réservation',
                'error' => config('app.debug') ? $e->getMessage() : 'Veuillez réessayer'
            ], 500);
        }
    }

    /**
     * Obtenir les demandes d'un babysitter
     */
    public function getMyRequests(Request $request)
    {
        $babysitterId = auth()->user()->babysitter->idBabysitter ?? null;
        
        if (!$babysitterId) {
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'êtes pas un babysitter'
            ], 403);
        }

        $demandes = DemandeIntervention::with([
            'client',
            'enfants',
            'intervenant'
        ])
        ->where('idIntervenant', $babysitterId)
        ->orderBy('dateDemande', 'desc')
        ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $demandes
        ]);
    }

    /**
     * Répondre à une demande de réservation
     */
    public function respondToRequest(Request $request, $demandeId)
    {
        $validator = Validator::make($request->all(), [
            'statut' => 'required|in:validée,refusée',
            'raisonAnnulation' => 'required_if:statut,refusée|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $babysitterId = auth()->user()->babysitter->idBabysitter ?? null;
        
        if (!$babysitterId) {
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'êtes pas un babysitter'
            ], 403);
        }

        $demande = DemandeIntervention::where('idIntervenant', $babysitterId)
            ->where('idDemande', $demandeId)
            ->where('statut', 'en_attente')
            ->firstOrFail();

        $demande->update([
            'statut' => $request->statut,
            'raisonAnnulation' => $request->raisonAnnulation
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Demande ' . $request->statut . ' avec succès',
            'data' => $demande->fresh()
        ]);
    }

    /**
     * Obtenir les disponibilités d'un babysitter
     */
    public function getDisponibilites($babysitterId)
    {
        $babysitter = Babysitter::findOrFail($babysitterId);
        
        $disponibilites = $babysitter->disponibilites()
            ->where('est_reccurent', true)
            ->orderByRaw("FIELD(jourSemaine, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche')")
            ->get()
            ->groupBy('jourFormatted');

        return response()->json([
            'success' => true,
            'data' => $disponibilites
        ]);
    }
}