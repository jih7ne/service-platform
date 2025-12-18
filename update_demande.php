<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\DemandeIntervention;

// Mettre à jour la demande #1 avec une date et heure passées
$demande = DemandeIntervention::find(1);
if ($demande) {
    $demande->dateSouhaitee = '2025-12-17'; // Hier
    $demande->heureFin = '10:00:00'; // Heure passée
    $demande->save();
    echo "Demande #1 mise à jour avec date et heure passées\n";
} else {
    echo "Demande #1 non trouvée\n";
}

echo "Test terminé\n";
