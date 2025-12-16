<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte Réactivé</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .icon {
            width: 80px;
            height: 80px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #1f2937;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .message {
            font-size: 16px;
            color: #4b5563;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .info-box {
            background-color: #d1fae5;
            border-left: 4px solid #10b981;
            padding: 20px;
            margin: 25px 0;
            border-radius: 6px;
        }
        .info-box h3 {
            color: #065f46;
            font-size: 16px;
            margin: 0 0 10px 0;
            font-weight: 600;
        }
        .info-box p {
            color: #047857;
            margin: 0;
            font-size: 14px;
            line-height: 1.5;
        }
        .note-box {
            background-color: #f3f4f6;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        .note-box h4 {
            color: #374151;
            font-size: 14px;
            margin: 0 0 10px 0;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .note-box p {
            color: #6b7280;
            margin: 0;
            font-size: 14px;
            line-height: 1.6;
            font-style: italic;
        }
        .button {
            display: inline-block;
            padding: 14px 32px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            text-align: center;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
        }
        .button:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }
        .features {
            margin: 30px 0;
        }
        .feature-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        .feature-icon {
            width: 24px;
            height: 24px;
            background-color: #d1fae5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            flex-shrink: 0;
        }
        .feature-text {
            color: #4b5563;
            font-size: 14px;
            line-height: 1.5;
        }
        .footer {
            background-color: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            color: #6b7280;
            font-size: 13px;
            margin: 5px 0;
        }
        .footer a {
            color: #10b981;
            text-decoration: none;
            font-weight: 500;
        }
        .divider {
            height: 1px;
            background-color: #e5e7eb;
            margin: 30px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1>✨ Compte Réactivé</h1>
        </div>

        <div class="content">
            <p class="greeting">Bonjour {{ $user->prenom }} {{ $user->nom }},</p>

            <p class="message">
                Nous avons le plaisir de vous informer que <strong>votre compte Helpora a été réactivé</strong> avec succès ! 
            </p>

            <div class="info-box">
                <h3>🎉 Bienvenue de retour sur Helpora !</h3>
                <p>
                    Vous pouvez maintenant vous reconnecter à votre compte et profiter à nouveau de tous nos services. 
                    Votre profil et toutes vos offres de services ont été réactivés.
                </p>
            </div>

            @if($note)
                <div class="note-box">
                    <h4>📝 Note de l'équipe Helpora</h4>
                    <p>{{ $note }}</p>
                </div>
            @endif

            <div style="text-align: center;">
                <a href="{{ url('/connexion') }}" class="button">
                    Se connecter maintenant
                </a>
            </div>

            <div class="features">
                <p style="color: #374151; font-weight: 600; margin-bottom: 15px;">Ce que vous pouvez faire maintenant :</p>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="3">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <div class="feature-text">Accéder à votre tableau de bord</div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="3">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <div class="feature-text">Consulter et gérer vos demandes</div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="3">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <div class="feature-text">Mettre à jour votre profil et vos offres de services</div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="3">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <div class="feature-text">Reprendre contact avec vos clients</div>
                </div>
            </div>

            <div class="divider"></div>

            <p class="message">
                Si vous rencontrez des difficultés pour vous reconnecter ou si vous avez des questions, 
                n'hésitez pas à nous contacter. Notre équipe est là pour vous aider !
            </p>

            <p class="message" style="margin-top: 20px;">
                Nous vous remercions de votre confiance et sommes ravis de vous revoir parmi nous.
            </p>

            <p class="message" style="margin-top: 30px; color: #1f2937;">
                Cordialement,<br>
                <strong>L'équipe Helpora</strong>
            </p>
        </div>

        <div class="footer">
            <p>Cet email a été envoyé par <strong>Helpora</strong></p>
            <p>
                <a href="{{ url('/contact') }}">Nous contacter</a> | 
                <a href="{{ url('/') }}">Visiter notre site</a>
            </p>
            <p style="margin-top: 15px; font-size: 12px;">
                © {{ date('Y') }} Helpora. Tous droits réservés.
            </p>
        </div>
    </div>
</body>
</html>