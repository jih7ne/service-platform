<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f4f7; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; margin-top: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .header { background-color: #1E40AF; padding: 20px; text-align: center; color: white; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 30px; }
        .status-box { text-align: center; padding: 15px; border-radius: 6px; margin-bottom: 25px; }
        .success { background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .error { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .details-table td { padding: 12px 0; border-bottom: 1px solid #eee; }
        .label { font-weight: bold; color: #555; width: 40%; }
        .value { color: #000; font-weight: 500; }
        .footer { background-color: #f9fafb; padding: 20px; text-align: center; font-size: 12px; color: #888; }
        .contact-box { background: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 6px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Helpora</h1>
        </div>
        
        <div class="content">
            <p>Bonjour <strong>{{ $data['client_nom'] }}</strong>,</p>

            @if($data['statut'] === 'validée')
                <div class="status-box success">
                    <strong>Bonne nouvelle !</strong><br>
                    Le professeur {{ $data['prof_nom'] }} a accepté votre demande.
                </div>

                <p>Voici le récapitulatif de votre séance :</p>

                <table class="details-table">
                    <tr>
                        <td class="label">Matière</td>
                        <td class="value">{{ $data['matiere'] }} ({{ $data['niveau'] }})</td>
                    </tr>
                    <tr>
                        <td class="label">Date & Heure</td>
                        <td class="value">{{ $data['date'] }} de {{ $data['heure_debut'] }} à {{ $data['heure_fin'] }}</td>
                    </tr>
                    <tr>
                        <td class="label">Lieu</td>
                        <td class="value">
                            @if($data['type_service'] === 'enligne')
                                En ligne 
                            @else
                                À votre domicile
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Tarif Total</td>
                        <td class="value">{{ $data['prix'] }} DH</td>
                    </tr>
                </table>

                <div class="contact-box">
                    <strong> Coordonnées de votre professeur :</strong><br>
                    Email : <a href="mailto:{{ $data['prof_email'] }}">{{ $data['prof_email'] }}</a>
                </div>

                <p style="margin-top: 20px; font-size: 14px; color: #666;">
                    Le professeur prendra contact avec vous rapidement pour finaliser les détails.
                </p>

            @else
                <div class="status-box error">
                    <strong>Demande refusée</strong><br>
                    Le professeur n'est malheureusement pas disponible pour ce créneau.
                </div>
                <p>Ne vous découragez pas ! D'autres professeurs compétents sont disponibles sur Helpora.</p>
                <p><a href="#" style="color: #1E40AF; text-decoration: none; font-weight: bold;">Chercher un autre professeur </a></p>
            @endif
        </div>

        <div class="footer">
            © {{ date('Y') }} Helpora Inc. Tous droits réservés.<br>
            Ceci est un email automatique, merci de ne pas y répondre.
        </div>
    </div>
</body>
</html>