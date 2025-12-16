<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte suspendu</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .content {
            padding: 40px 30px;
        }
        .warning-box {
            background-color: #fee2e2;
            border-left: 4px solid #dc2626;
            padding: 20px;
            margin: 30px 0;
            border-radius: 8px;
        }
        .warning-box h2 {
            color: #991b1b;
            margin: 0 0 10px 0;
            font-size: 18px;
            font-weight: 700;
        }
        .warning-box p {
            color: #7f1d1d;
            margin: 0;
            font-size: 15px;
            line-height: 1.5;
        }
        .reason-box {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 20px;
            margin: 25px 0;
            border-radius: 8px;
        }
        .reason-box h3 {
            color: #374151;
            margin: 0 0 10px 0;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .reason-box p {
            color: #4b5563;
            margin: 0;
            font-size: 15px;
            line-height: 1.6;
        }
        .footer {
            background-color: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            color: #6b7280;
            margin: 5px 0;
            font-size: 13px;
        }
        .contact-info {
            margin: 25px 0;
            padding: 20px;
            background-color: #eff6ff;
            border-radius: 8px;
            border: 1px solid #dbeafe;
        }
        .contact-info p {
            margin: 5px 0;
            color: #1e40af;
            font-size: 14px;
        }
        .contact-info strong {
            color: #1e3a8a;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚠️ Compte Suspendu</h1>
        </div>
        
        <div class="content">
            <p style="font-size: 16px; color: #111827; margin-bottom: 20px;">
                Bonjour <strong>{{ $user->prenom }} {{ $user->nom }}</strong>,
            </p>
            
            <div class="warning-box">
                <h2>Votre compte Helpora a été suspendu</h2>
                <p>
                    Nous vous informons que votre compte sur la plateforme Helpora a été temporairement suspendu par notre équipe d'administration.
                </p>
            </div>
            
            <div class="reason-box">
                <h3>Raison de la suspension</h3>
                <p>{{ $reason }}</p>
            </div>
            
            <p style="font-size: 15px; color: #374151; margin: 25px 0;">
                Durant cette période de suspension, vous ne pourrez pas accéder à votre compte ni utiliser les services de la plateforme.
            </p>
            
            <div class="contact-info">
                <p style="margin-bottom: 10px;">
                    <strong>Vous pensez qu'il s'agit d'une erreur ?</strong>
                </p>
                <p>
                    N'hésitez pas à contacter notre équipe support à l'adresse : 
                    <a href="mailto:support@helpora.com" style="color: #2563eb; text-decoration: none; font-weight: 600;">support@helpora.com</a>
                </p>
                <p style="margin-top: 10px; font-size: 13px; color: #4b5563;">
                    Notre équipe examinera votre situation et vous répondra dans les plus brefs délais.
                </p>
            </div>
            
            <p style="font-size: 14px; color: #6b7280; margin-top: 30px;">
                Cordialement,<br>
                <strong style="color: #2B5AA8;">L'équipe Helpora</strong>
            </p>
        </div>
        
        <div class="footer">
            <p><strong>Helpora</strong> - Plateforme de services à domicile</p>
            <p>© {{ date('Y') }} Helpora. Tous droits réservés.</p>
            <p style="margin-top: 15px;">
                <a href="mailto:support@helpora.com" style="color: #2563eb; text-decoration: none;">support@helpora.com</a>
            </p>
        </div>
    </div>
</body>
</html>