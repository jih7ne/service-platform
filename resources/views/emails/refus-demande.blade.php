<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; margin: 0; padding: 0; }
        .email-container { max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .header { background: #B91C1C; padding: 20px; text-align: center; } /* Rouge pour le refus */
        .header h1 { color: #ffffff; margin: 0; font-size: 24px; }
        .content { padding: 30px; }
        .info-box { background-color: #FFF5F5; border-left: 4px solid #F87171; padding: 15px; margin: 20px 0; border-radius: 4px; }
        .motif-title { font-weight: bold; color: #991B1B; margin-bottom: 5px; display: block; }
        .footer { background-color: #f9fafb; padding: 20px; text-align: center; font-size: 12px; color: #6b7280; border-top: 1px solid #e5e7eb; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #4B5563; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- En-tête -->
        <div class="header">
            <h1>Mise à jour de votre demande</h1>
        </div>

        <!-- Contenu -->
        <div class="content">
            <p>Bonjour <strong>{{ $client->prenom }}</strong>,</p>

            <p>Nous vous informons que le PetKeeper <strong>{{ $intervenant->prenom }} {{ $intervenant->nom }}</strong> ne peut malheureusement pas accepter votre demande de garde pour le moment.</p>

            <div class="info-box">
                <span class="motif-title">Raison indiquée par le PetKeeper :</span>
                <p style="margin: 0; font-style: italic;">"{{ $motif }}"</p>
            </div>

            <p><strong>Détails de la demande concernée :</strong></p>
            <ul style="list-style-type: none; padding-left: 0; color: #555;">
                <li>📅 Date : {{ \Carbon\Carbon::parse($demande->dateSouhaitee)->format('d/m/Y') }}</li>
                <li>⏰ Horaire : {{ substr($demande->heureDebut, 0, 5) }} - {{ substr($demande->heureFin, 0, 5) }}</li>
                <li>📍 Lieu : {{ $demande->lieu ?? 'À domicile' }}</li>
            </ul>

            <p>Ne vous découragez pas ! D'autres PetKeepers sont disponibles sur Helpora pour s'occuper de votre animal.</p>

            <center>
                <a href="{{ url('/') }}" class="btn">Trouver un autre PetKeeper</a>
            </center>
        </div>

        <!-- Pied de page -->
        <div class="footer">
            &copy; {{ date('Y') }} Helpora. Tous droits réservés.<br>
            Ceci est un message automatique, merci de ne pas y répondre.
        </div>
    </div>
</body>
</html>