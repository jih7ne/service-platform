<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation Annulée</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #dc3545;
            color: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .details {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
        }
        .details ul {
            list-style: none;
            padding: 0;
            margin: 10px 0;
        }
        .details li {
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .details li:last-child {
            border-bottom: none;
        }
        .details strong {
            color: #856404;
            display: inline-block;
            width: 150px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .footer {
            text-align: center;
            color: #666;
            font-size: 12px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .warning {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Réservation Annulée - Délai dépassé</h1>
        </div>
        
        <div class="content">
            <p>Bonjour <strong>{{ $clientName }}</strong>,</p>
            
            <p>Nous vous informons que votre demande de réservation pour le service de <strong>soutien scolaire</strong> n'a pas reçu de réponse de la part du professeur dans le délai imparti de <strong>48 heures</strong>.</p>
            
            <div class="details">
                <h3>Détails de la demande :</h3>
                <ul>
                    <li>
                        <strong>Date de demande :</strong> {{ $dateDemande }}
                    </li>
                    <li>
                        <strong>Date souhaitée :</strong> {{ $dateSouhaitee }}
                    </li>
                    <li>
                        <strong>Horaire :</strong> {{ $heureDebut }} - {{ $heureFin }}
                    </li>
                    <li>
                        <strong>Matière :</strong> {{ $matiere }}
                    </li>
                    <li>
                        <strong>Niveau :</strong> {{ $niveau }}
                    </li>
                </ul>
            </div>
            
            <div class="warning">
                <p><strong>En conséquence, votre demande a été automatiquement annulée.</strong></p>
            </div>
        </div>
        
        <div class="footer">
            <p>Ceci est un message automatique, merci de ne pas y répondre directement.</p>
            <p>&copy; {{ date('Y') }} Helpora - Plateforme de services</p>
        </div>
    </div>
</body>
</html>