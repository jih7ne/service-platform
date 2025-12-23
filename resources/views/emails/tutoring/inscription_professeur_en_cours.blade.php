<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f4f7; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; margin-top: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .header { background-color: #2563EB; padding: 20px; text-align: center; color: white; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 30px; }
        .status-badge { background: #FEF3C7; color: #92400E; padding: 10px 20px; border-radius: 20px; display: inline-block; font-weight: bold; margin: 20px 0; }
        .info-card { background: #F3F4F6; border-radius: 8px; padding: 20px; margin: 20px 0; border-left: 4px solid #2563EB; }
        .info-card h3 { margin-top: 0; color: #1F2937; font-size: 16px; }
        .info-card ul { margin: 10px 0; padding-left: 20px; }
        .info-card li { margin: 8px 0; color: #4B5563; }
        .highlight { background: #DBEAFE; padding: 15px; border-radius: 6px; margin: 20px 0; border-left: 3px solid #3B82F6; }
        .footer { background-color: #f9fafb; padding: 20px; text-align: center; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Helpora</h1>
        </div>
        
        <div class="content">
            <p>Bonjour <strong>{{ $data['prenom'] }} {{ $data['nom'] }}</strong>,</p>

            <p style="font-size: 16px; line-height: 1.6;">
                Nous avons bien reçu votre demande d'inscription en tant que <strong>professeur</strong> sur la plateforme Helpora.
            </p>

            <div style="text-align: center;">
                <span class="status-badge"> En cours de traitement</span>
            </div>

            <div class="info-card">
                <h3>Récapitulatif de votre demande :</h3>
                <ul>
                    <li><strong>Nom :</strong> {{ $data['nom'] }} {{ $data['prenom'] }}</li>
                    <li><strong>Email :</strong> {{ $data['email'] }}</li>
                    <li><strong>Téléphone :</strong> {{ $data['telephone'] }}</li>
                    <li><strong>Niveau d'études :</strong> {{ $data['niveau_etudes'] }}</li>
                    <li><strong>Nombre de matières :</strong> {{ $data['nombre_matieres'] }}</li>
                </ul>
            </div>

            <div class="highlight">
                <p style="margin: 0; font-size: 14px; color: #1E40AF;">
                    <strong>Délai de traitement :</strong> Votre dossier sera examiné sous 24 à 48 heures par notre équipe.
                </p>
            </div>

            <div class="info-card">
                <h3>Prochaines étapes :</h3>
                <ul>
                    <li>Vérification de vos documents (CIN, diplômes)</li>
                    <li>Validation de votre profil par notre équipe</li>
                    <li>Activation de votre compte professeur</li>
                </ul>
            </div>

            <p style="font-size: 14px; color: #6B7280; margin-top: 25px;">
                Vous recevrez un email de confirmation dès que votre compte sera activé.
            </p>

            <p style="font-size: 14px; color: #6B7280;">
                Si vous avez des questions, n'hésitez pas à nous contacter.
            </p>

            <p style="margin-top: 30px;">
                Cordialement,<br>
                <strong>L'équipe Helpora</strong>
            </p>
        </div>

        <div class="footer">
            Cet email est personnel et contient des données confidentielles.<br>
            © Helpora - Plateforme de soutien scolaire
        </div>
    </div>
</body>
</html>