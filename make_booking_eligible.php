<?php

use App\Models\Babysitting\DemandeIntervention;
use Carbon\Carbon;

$demande = DemandeIntervention::latest('idDemande')->first();

if ($demande) {
    $demande->statut = 'validée';
    // Date souhaitée = Hier pour déclencher le rappel
    $demande->dateSouhaitee = Carbon::yesterday();
    $demande->save();
    
    echo "SUCCESS: Demande #{$demande->idDemande} modifiée pour être éligible au rappel (Date: " . $demande->dateSouhaitee->format('Y-m-d') . ")\n";
} else {
    echo "ERROR: Aucune demande trouvée dans la base de données.\n";
}
