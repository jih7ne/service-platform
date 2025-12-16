<?php

namespace App\Http\Controllers\PetKeeping;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PetKeeperMissionController extends Controller
{
    /**
     * Liste des missions du petkeeper
     */
    public function index()
    {
        // 🔒 Sécurité simple (session)
        // if (!session()->has('idUser')) {
        //     return redirect('/connexion');
        // }

        $intervenantId = session('idUser');

        $missions = DB::table('demandes_intervention')
            ->join('utilisateurs', 'demandes_intervention.idClient', '=', 'utilisateurs.idUser')
            ->where('demandes_intervention.idIntervenant', $intervenantId)
            ->orderBy('dateSouhaitee', 'desc')
            ->select(
                'demandes_intervention.*',
                'utilisateurs.nom as nom_client',
                'utilisateurs.prenom as prenom_client'
            )
            ->get();

        return view('petkeeper.missions-index', compact('missions'));
    }

    /**
     * Détail d’une mission
     */
    public function show($id)
    {
        if (!session()->has('idUser')) {
            return redirect('/connexion');
        }

        $mission = DB::table('demandes_intervention')
            ->where('idDemande', $id)
            ->first();

        if (!$mission) {
            abort(404);
        }

        return view('petkeeper.mission-show', compact('mission'));
    }
}
