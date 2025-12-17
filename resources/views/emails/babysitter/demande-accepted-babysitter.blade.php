<!DOCTYPE html>
<html>
<head>
    <title>Nouvelle mission confirmée</title>
</head>
<body>
    <h2>Félicitations ! Vous avez une nouvelle mission confirmée.</h2>
    
    <h3>Détails du client :</h3>
    <p><strong>Nom :</strong> {{ $demande->client->nom }} {{ $demande->client->prenom }}</p>
    <p><strong>Téléphone :</strong> {{ $demande->client->telephone }}</p>
    <p><strong>Email :</strong> {{ $demande->client->email }}</p>
    
    <h3>Détails de la mission :</h3>
    <p><strong>Date :</strong> {{ $demande->dateSouhaitee->format('d/m/Y') }}</p>
    <p><strong>Heure :</strong> {{ $demande->heureDebut->format('H:i') }} - {{ $demande->heureFin->format('H:i') }}</p>
    <p><strong>Lieu :</strong> {{ $demande->lieu }}</p>
    <p><strong>Enfants :</strong> {{ $demande->enfants->count() }}</p>
    
    <p>Merci d'utiliser notre plateforme !</p>
</body>
</html>
