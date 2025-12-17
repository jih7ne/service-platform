<!DOCTYPE html>
<html>
<head>
    <title>Demande acceptée</title>
</head>
<body>
    <h2>Bonne nouvelle ! Votre demande de garde a été acceptée.</h2>
    
    <h3>Détails de l'intervenant :</h3>
    <p><strong>Nom :</strong> {{ $demande->intervenant->user->nom }} {{ $demande->intervenant->user->prenom }}</p>
    <p><strong>Téléphone :</strong> {{ $demande->intervenant->user->telephone }}</p>
    <p><strong>Email :</strong> {{ $demande->intervenant->user->email }}</p>
    
    <h3>Rappel de la mission :</h3>
    <p><strong>Date :</strong> {{ $demande->dateSouhaitee->format('d/m/Y') }}</p>
    <p><strong>Heure :</strong> {{ $demande->heureDebut->format('H:i') }} - {{ $demande->heureFin->format('H:i') }}</p>
    
    <p>L'intervenant prendra contact avec vous sous peu.</p>
</body>
</html>
