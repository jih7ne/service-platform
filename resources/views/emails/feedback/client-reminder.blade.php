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
            <h1>Rappel : Partagez votre expérience</h1>
        </div>
        <div class="content">
            <p>Bonjour {{ $user->prenom }},</p>
            
            <p>Nous espérons que vous avez été satisfait(e) du service de babysitting du {{ $demande->dateSouhaitee }}.</p>
            
            <p>Votre feedback est très important pour nous et pour aider les autres parents à faire leur choix. Il ne vous prendra que 2 minutes !</p>
            
            @if($rappel_number > 1)
                <p><em>Ceci est votre rappel n°{{ $rappel_number }}. N'attendez plus pour partager votre expérience !</em></p>
            @endif
            
            <div style="text-align: center;">
                <a href="{{ $feedback_url }}" class="button">Donner mon feedback</a>
            </div>
            
            <p>Merci de votre confiance et à bientôt sur Helpora !</p>
            
            <p>L'équipe Helpora</p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} Helpora - Service de garde d'enfants de confiance</p>
            <p>Si vous ne souhaitez plus recevoir ces emails, merci de nous contacter.</p>
        </div>
    </div>
</body>
</html>
