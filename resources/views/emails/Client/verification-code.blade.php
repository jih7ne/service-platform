<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code de vérification - Helpora</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f7f7;
            padding: 40px 20px;
            line-height: 1.6;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #2B5AA8 0%, #1e4380 100%);
            padding: 40px 30px;
            text-align: center;
        }
        
        .logo {
            font-size: 32px;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }
        
        .header-subtitle {
            color: #e1eaf7;
            font-size: 14px;
            font-weight: 500;
        }
        
        .content {
            padding: 50px 40px;
        }
        
        .greeting {
            font-size: 24px;
            font-weight: 600;
            color: #2a2a2a;
            margin-bottom: 20px;
        }
        
        .message {
            font-size: 16px;
            color: #6b7280;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        
        .code-container {
            background: linear-gradient(135deg, #E1EAF7 0%, #f0f4fa 100%);
            border: 2px solid #2B5AA8;
            border-radius: 12px;
            padding: 30px;
            margin: 30px 0;
            text-align: center;
        }
        
        .code-label {
            font-size: 14px;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }
        
        .verification-code {
            font-size: 42px;
            font-weight: bold;
            color: #2B5AA8;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
            padding: 15px;
            background-color: #ffffff;
            border-radius: 8px;
            display: inline-block;
            box-shadow: 0 2px 10px rgba(43, 90, 168, 0.2);
        }
        
        .expiry-notice {
            background-color: #FFF3CD;
            border-left: 4px solid #FFC107;
            padding: 15px 20px;
            margin: 25px 0;
            border-radius: 6px;
        }
        
        .expiry-notice p {
            font-size: 14px;
            color: #856404;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .warning-icon {
            font-size: 20px;
        }
        
        .info-box {
            background-color: #E3F2FD;
            border-left: 4px solid #2196F3;
            padding: 20px;
            margin: 25px 0;
            border-radius: 6px;
        }
        
        .info-box p {
            font-size: 14px;
            color: #1565C0;
            margin: 0;
            line-height: 1.6;
        }
        
        .security-tips {
            margin: 30px 0;
            padding: 20px;
            background-color: #f9fafb;
            border-radius: 8px;
        }
        
        .security-tips h3 {
            font-size: 16px;
            color: #2a2a2a;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .security-tips ul {
            list-style: none;
            padding: 0;
        }
        
        .security-tips li {
            font-size: 14px;
            color: #6b7280;
            padding: 8px 0;
            padding-left: 25px;
            position: relative;
        }
        
        .security-tips li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #10b981;
            font-weight: bold;
            font-size: 16px;
        }
        
        .help-section {
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #e5e7eb;
        }
        
        .help-section p {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 15px;
        }
        
        .button {
            display: inline-block;
            padding: 14px 35px;
            background-color: #2B5AA8;
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(43, 90, 168, 0.3);
        }
        
        .button:hover {
            background-color: #224A91;
            box-shadow: 0 6px 16px rgba(43, 90, 168, 0.4);
        }
        
        .footer {
            background-color: #f9fafb;
            padding: 30px 40px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        
        .footer p {
            font-size: 13px;
            color: #9ca3af;
            margin: 5px 0;
        }
        
        .social-links {
            margin: 20px 0;
        }
        
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
        }
        
        .divider {
            height: 1px;
            background-color: #e5e7eb;
            margin: 25px 0;
        }
        
        @media only screen and (max-width: 600px) {
            body {
                padding: 20px 10px;
            }
            
            .content {
                padding: 30px 20px;
            }
            
            .verification-code {
                font-size: 32px;
                letter-spacing: 4px;
            }
            
            .greeting {
                font-size: 20px;
            }
            
            .footer {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">HELPORA</div>
            <div class="header-subtitle">Votre plateforme de services à domicile</div>
        </div>
        
        <!-- Content -->
        <div class="content">
            <h1 class="greeting">Bonjour {{ $firstName }} {{ $lastName }} ! 👋</h1>
            
            <p class="message">
                Merci de vous inscrire sur <strong>Helpora</strong> ! Pour finaliser la création de votre compte client, 
                veuillez utiliser le code de vérification ci-dessous :
            </p>
            
            <!-- Code Container -->
            <div class="code-container">
                <div class="code-label">Votre code de vérification</div>
                <div class="verification-code">{{ $verificationCode }}</div>
            </div>
            
            <!-- Expiry Notice -->
            <div class="expiry-notice">
                <p>
                    <span class="warning-icon">⏱️</span>
                    <strong>Important :</strong> Ce code expire dans <strong>10 minutes</strong>. 
                    Veuillez l'utiliser rapidement pour compléter votre inscription.
                </p>
            </div>
            
            <!-- Info Box -->
            <div class="info-box">
                <p>
                    💡 <strong>Conseil :</strong> Si vous ne trouvez pas cet email, vérifiez votre dossier 
                    <strong>Spam</strong> ou <strong>Courrier indésirable</strong>. Vous pouvez également demander 
                    un nouveau code directement depuis la page d'inscription.
                </p>
            </div>
            
            <div class="divider"></div>
            
            <!-- Security Tips -->
            <div class="security-tips">
                <h3>🔒 Conseils de sécurité</h3>
                <ul>
                    <li>Ne partagez jamais ce code avec qui que ce soit</li>
                    <li>Helpora ne vous demandera jamais votre code par email ou téléphone</li>
                    <li>Si vous n'avez pas demandé ce code, ignorez cet email</li>
                    <li>Assurez-vous d'être sur le site officiel Helpora avant de saisir le code</li>
                </ul>
            </div>
            
            <!-- Help Section -->
            <div class="help-section">
                <p>Vous rencontrez un problème ou avez une question ?</p>
                <a href="mailto:support@helpora.com" class="button">Contactez notre support</a>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p><strong>Helpora</strong> - Services à domicile de qualité</p>
            <p>📍 Maroc | 📧 contact@helpora.com | 📞 +212 XXX XXX XXX</p>
            
            <div class="social-links">
                <a href="#">Facebook</a> • 
                <a href="#">Instagram</a> • 
                <a href="#">LinkedIn</a>
            </div>
            
            <div class="divider"></div>
            
            <p style="font-size: 12px; color: #9ca3af;">
                Cet email a été envoyé automatiquement, merci de ne pas y répondre.<br>
                Si vous n'avez pas demandé ce code, vous pouvez ignorer cet email en toute sécurité.
            </p>
            
            <p style="font-size: 11px; color: #d1d5db; margin-top: 15px;">
                © {{ date('Y') }} Helpora. Tous droits réservés.
            </p>
        </div>
    </div>
</body>
</html>