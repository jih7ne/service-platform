<!DOCTYPE html>
<html>
<head>
    <title>Mise à jour de votre demande</title>
</head>
<body>
    <h2>Mise à jour concernant votre demande de garde.</h2>
    
    <p>Bonjour {{ $demande->client->prenom }},</p>
    
    <p>Nous sommes désolés de vous informer que votre demande pour le {{ $demande->dateSouhaitee->format('d/m/Y') }} a été refusée par l'intervenant.</p>
    
    <p><strong>Motif du refus :</strong></p>
    <blockquote style="background: #f9f9f9; padding: 10px; border-left: 5px solid #ccc;">
        {{ $motif }}
    </blockquote>
    
    <p>Nous vous invitons à effectuer une nouvelle recherche sur notre plateforme.</p>
</body>
</html>
