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
        .button {
            display: block;
            width: 200px;
            margin: 30px auto;
            padding: 12px 20px;
            background-color: #B82E6E;
            color: white;
            text-decoration: none;
            text-align: center;
            border-radius: 25px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #96245a;
        }
        .footer {
            background-color: #f1f1f1;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        .alert {
            color: #B82E6E;
            font-weight: bold;
            font-size: 0.9em;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Nouvelle Demande Reçue !</h2>
        </div>
        <div class="content">
            <p>Bonjour,</p>
            <p>Bonne nouvelle ! Vous avez reçu <strong>{{ count($demandes) }}</strong> nouvelle(s) demande(s) de babysitting.</p>
            
            <div class="info-box">
                <p style="margin: 0;">Connectez-vous à votre tableau de bord du service "Babysitting" pour consulter les détails complets (enfants, besoins spécifiques) et répondre à cette demande.</p>
            </div>

            <p class="alert">⚠️ Important : Vous avez 48 heures pour valider ou refuser cette demande, sinon elle sera automatiquement annulée.</p>

    
        </div>
        <div class="footer">
            <p>Cet email a été envoyé automatiquement par Helpora Platform.</p>
            <p>&copy; {{ date('Y') }} Helpora Platform. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
