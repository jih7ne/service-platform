<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Inscription Babysitter</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #B82E6E; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .info-box { background: #fff; border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 5px; }
        .info-label { font-weight: bold; color: #B82E6E; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
        .btn { display: inline-block; background: #B82E6E; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>👶 Nouvelle Inscription Babysitter</h1>
        </div>
        <div class="content">
            <p>Bonjour Administrateur,</p>
            
            <p>Une nouvelle babysitter vient de s'inscrire sur la plateforme Helpora. Voici ses informations :</p>
            
            <div class="info-box">
                <p><span class="info-label">Nom complet :</span> {{ $babysitter->nom }} {{ $babysitter->prenom }}</p>
                <p><span class="info-label">Email :</span> {{ $babysitter->email }}</p>
                <p><span class="info-label">Téléphone :</span> {{ $babysitter->telephone }}</p>
                <p><span class="info-label">Date de naissance :</span> {{ $babysitter->dateNaissance }}</p>
                <p><span class="info-label">Ville :</span> {{ $babysitter->ville ?? 'Non spécifiée' }}</p>
                <p><span class="info-label">Date d'inscription :</span> {{ $babysitter->created_at->format('d/m/Y H:i') }}</p>
                
                @if($babysitter->intervenant)
                    <p><span class="info-label">Statut intervenant :</span> {{ $babysitter->intervenant->statut ?? 'En attente' }}</p>
                @endif
                
                @if($babysitter->babysitter)
                    <p><span class="info-label">Prix par heure :</span> {{ $babysitter->babysitter->prixHeure ?? 'Non spécifié' }} MAD</p>
                    <p><span class="info-label">Expérience :</span> {{ $babysitter->babysitter->expAnnee ?? 0 }} année(s)</p>
                @endif
            </div>
            
            <div style="text-align: center; margin: 20px 0;">
                <p style="color: #666; font-size: 14px;">
                    Connectez-vous à votre panneau d'administration pour gérer cette inscription.
                </p>
                <p style="color: #B82E6E; font-weight: bold;">
                    ID Babysitter: {{ $babysitter->idUser }}
                </p>
            </div>
            
            <p>Merci de vérifier cette inscription et de valider le profil si nécessaire.</p>
            
            <p>Cordialement,<br>L'équipe Helpora</p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} Helpora - Service de garde d'enfants de confiance</p>
            <p>Cet email a été envoyé automatiquement suite à une nouvelle inscription.</p>
        </div>
    </div>
</body>
</html>
