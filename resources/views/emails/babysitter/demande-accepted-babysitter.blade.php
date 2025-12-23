<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #B82E6E;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .info-box {
            background-color: rgba(184, 46, 110, 0.1);
            border-left: 4px solid #B82E6E;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .footer {
            background-color: #f1f1f1;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Nouvelle Mission Confirmée !</h2>
        </div>
        <div class="content">
            <p>Félicitations ! Vous avez une nouvelle mission confirmée.</p>
            
            <div class="info-box">
                <h3 style="margin-top: 0; color: #B82E6E;">Détails du client :</h3>
                <p style="margin: 5px 0;"><strong>Nom :</strong> {{ $demande->client->nom }} {{ $demande->client->prenom }}</p>
                <p style="margin: 5px 0;"><strong>Téléphone :</strong> {{ $demande->client->telephone }}</p>
                <p style="margin: 5px 0;"><strong>Email :</strong> {{ $demande->client->email }}</p>
            </div>
            
            <div class="info-box">
                <h3 style="margin-top: 0; color: #B82E6E;">Détails de la mission :</h3>
                <p style="margin: 5px 0;"><strong>Date :</strong> {{ $demande->dateSouhaitee->format('d/m/Y') }}</p>
                <p style="margin: 5px 0;"><strong>Heure :</strong> {{ $demande->heureDebut->format('H:i') }} - {{ $demande->heureFin->format('H:i') }}</p>
                <p style="margin: 5px 0;"><strong>Lieu :</strong> {{ $demande->lieu }}</p>
                <p style="margin: 5px 0;"><strong>Enfants :</strong> {{ $demande->enfants->count() }}</p>
            </div>
            
            <p>Merci d'utiliser notre plateforme !</p>
        </div>
        <div class="footer">
            <p>Cet email a été envoyé automatiquement par Helpora Platform.</p>
            <p>&copy; {{ date('Y') }} Helpora Platform. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
