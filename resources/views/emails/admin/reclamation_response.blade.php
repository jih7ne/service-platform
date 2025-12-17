<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réponse à votre réclamation</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .email-body {
            padding: 30px;
        }
        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info-box h3 {
            margin: 0 0 10px 0;
            color: #667eea;
            font-size: 14px;
            text-transform: uppercase;
            font-weight: 600;
        }
        .info-box p {
            margin: 0;
            color: #666;
        }
        .response-box {
            background-color: #e8f5e9;
            border-left: 4px solid #4caf50;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .response-box h3 {
            margin: 0 0 15px 0;
            color: #2e7d32;
            font-size: 16px;
            font-weight: 600;
        }
        .response-text {
            color: #333;
            line-height: 1.8;
            white-space: pre-wrap;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #e0e0e0;
        }
        .footer p {
            margin: 5px 0;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: 600;
        }
        .divider {
            height: 1px;
            background-color: #e0e0e0;
            margin: 25px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>✓ Réponse à votre réclamation</h1>
        </div>

        <div class="email-body">
            <div class="greeting">
                <p>Bonjour <strong>{{ $reclamation->auteur->prenom ?? '' }} {{ $reclamation->auteur->nom ?? '' }}</strong>,</p>
            </div>

            <p>Nous avons bien reçu votre réclamation et souhaitons vous apporter une réponse.</p>

            <div class="info-box">
                <h3>Votre réclamation</h3>
                <p><strong>Sujet:</strong> {{ $reclamation->sujet }}</p>
                <p style="margin-top: 10px;"><strong>Description:</strong></p>
                <p style="margin-top: 5px;">{{ $reclamation->description }}</p>
            </div>

            <div class="response-box">
                <h3>Notre réponse</h3>
                <div class="response-text">{{ $reponseTexte }}</div>
            </div>

            <div class="divider"></div>

            <p>Si vous avez d'autres questions ou si cette réponse ne résout pas complètement votre préoccupation, n'hésitez pas à nous contacter.</p>

            <p style="margin-top: 25px;">Cordialement,<br><strong>L'équipe Support</strong></p>
        </div>

        <div class="footer">
            <p><strong>Service Client</strong></p>
            <p>Cet email a été envoyé en réponse à votre réclamation du {{ \Carbon\Carbon::parse($reclamation->dateCreation)->format('d/m/Y') }}</p>
            <p style="margin-top: 10px;">© {{ date('Y') }} Votre Service. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>