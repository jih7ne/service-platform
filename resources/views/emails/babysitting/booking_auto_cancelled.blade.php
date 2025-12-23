<!DOCTYPE html>
<html>
<head>
    <title>Annulation de votre réservation</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: #e53e3e;">Réservation Annulée - Délai dépassé</h2>
        
        <p>Bonjour <strong>{{ $clientName }}</strong>,</p>
        
        <p>Nous vous informons que votre demande de réservation pour le service de babysitting n'a pas reçu de réponse de la part du babysitter dans le délai imparti de 48 heures.</p>
        
        <div style="background-color: #f7fafc; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p><strong>Détails de la demande :</strong></p>
            <ul>
                <li><strong>Date de la demande :</strong> {{ $dateDemande }}</li>
                <li><strong>Date souhaitée :</strong> {{ $dateSouhaitee }}</li>
            </ul>
        </div>

        <p>En conséquence, votre demande a été automatiquement <strong>annulée</strong>.</p>
        
        <p>Nous vous invitons à effectuer une nouvelle recherche pour trouver un autre babysitter disponible.</p>
        
        <p style="margin-top: 30px;">
            <a href="{{ route('liste.babysitter') }}" style="background-color: #3182ce; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">Trouver un autre babysitter</a>
        </p>
        
        <hr style="margin-top: 30px; border: 0; border-top: 1px solid #eee;">
        <p style="font-size: 12px; color: #718096;">Ceci est un message automatique, merci de ne pas y répondre directement.</p>
    </div>
</body>
</html>
