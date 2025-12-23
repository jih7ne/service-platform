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
            <h2>Mise à jour de votre demande</h2>
        </div>
        <div class="content">
            <p>Bonjour {{ $demande->client->prenom }},</p>
            
            <p>Nous sommes désolés de vous informer que votre demande pour le <strong>{{ $demande->dateSouhaitee->format('d/m/Y') }}</strong> a été refusée par l'intervenant.</p>
            
            <div class="info-box">
                <h3 style="margin-top: 0; color: #B82E6E;">Motif du refus :</h3>
                <p style="margin: 0;">{{ $motif }}</p>
            </div>
            
            <p>Nous vous invitons à effectuer une nouvelle recherche sur notre plateforme.</p>
        </div>
        <div class="footer">
            <p>Cet email a été envoyé automatiquement par Helpora Platform.</p>
            <p>&copy; {{ date('Y') }} Helpora Platform. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
