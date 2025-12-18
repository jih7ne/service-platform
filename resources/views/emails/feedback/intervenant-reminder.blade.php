<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rappel Feedback</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #B82E6E; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .button { display: inline-block; background: #B82E6E; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Rappel : Évaluez votre expérience</h1>
        </div>
        <div class="content">
            <p>Bonjour {{ $user->prenom }},</p>
            
            <p>Nous espérons que votre mission de babysitting du {{ $demande->dateSouhaitee }} s'est bien passée.</p>
            
            <p>Votre feedback sur cette expérience est très précieux ! Il aide les autres familles à vous choisir et nous permet d'améliorer nos services.</p>
            
            @if($rappel_number > 1)
                <p><em>Ceci est votre rappel n°{{ $rappel_number }}. Prenez quelques instants pour partager votre avis !</em></p>
            @endif
            
            <div style="text-align: center;">
                <a href="{{ $feedback_url }}" class="button">Donner mon feedback</a>
            </div>
            
            <p>Merci pour votre excellent travail et votre engagement !</p>
            
            <p>L'équipe Helpora</p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} Helpora - Service de garde d'enfants de confiance</p>
            <p>Si vous ne souhaitez plus recevoir ces emails, merci de nous contacter.</p>
        </div>
    </div>
</body>
</html>
