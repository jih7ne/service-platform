<!DOCTYPE html>
<html>
<head>
    <title>Votre intervention Helpora est terminée</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: #2b6cb0;">Votre intervention est maintenant terminée !</h2>
        
        <p>Bonjour <strong>{{ $userName }}</strong>,</p>
        
        <p>Nous espérons que tout s'est bien passé ! L'intervention du <strong>{{ $dateIntervention }}</strong> avec <strong>{{ $targetName }}</strong> est maintenant terminée.</p>
        
        <p>Pour nous aider à améliorer la qualité de service sur Helpora et pour aider la communauté, nous vous invitons à partager votre expérience en laissant un avis.</p>
        
        <p>Votre feedback est très important pour nous et pour les autres utilisateurs de la plateforme.</p>
        
        <p style="margin-top: 30px; text-align: center;">
            <a href="{{ $feedbackUrl }}" style="background-color: #38a169; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;">Donner mon avis</a>
        </p>
        
        <p style="margin-top: 20px;">
            Si le lien ne fonctionne pas, copiez-collez l'adresse suivante dans votre navigateur :<br>
            <span style="color: #718096; font-size: 12px;">{{ $feedbackUrl }}</span>
        </p>
        
        <hr style="margin-top: 30px; border: 0; border-top: 1px solid #eee;">
        
        <p style="font-size: 12px; color: #718096;">
            Merci de faire confiance à Helpora pour vos besoins de service.<br>
            Ceci est un message automatique. Merci de ne pas y répondre directement.
        </p>
    </div>
</body>
</html>
