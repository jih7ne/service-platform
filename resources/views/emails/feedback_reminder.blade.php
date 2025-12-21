<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre avis compte | Helpora</title>
    <style>
        /* Modern Reset */
        body { margin: 0; padding: 0; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f7fa; }
        img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        
        /* Premium Colors */
        .primary-color { color: #2B5AA8; }
        .bg-light { background-color: #F7F7F7; }
        .text-dark { color: #1a1a1a; }
        .text-muted { color: #718096; }
        
        /* Button */
        .btn-primary {
            background: linear-gradient(135deg, #2B5AA8 0%, #1E427E 100%);
            color: #ffffff;
            display: inline-block;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
            user-select: none;
            padding: 14px 32px;
            font-size: 16px;
            border-radius: 50px;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(43, 90, 168, 0.2);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            box-shadow: 0 6px 12px rgba(43, 90, 168, 0.3);
            transform: translateY(-2px);
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f7fa;">
    <!-- Main Wrapper -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f7fa; padding: 40px 0;">
        <tr>
            <td align="center">
                <!-- Content Container -->
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); overflow: hidden;">
                    
                    <!-- Header with Logo -->
                    <tr>
                        <td align="center" style="padding: 40px 0 30px 0; background-color: #ffffff;">
                            <h1 style="font-family: 'Helvetica Neue', Arial, sans-serif; font-size: 28px; font-weight: 800; color: #2B5AA8; margin: 0;">
                                Helpora
                            </h1>
                            <p style="font-size: 12px; font-weight: 600; letter-spacing: 2px; color: #a0aec0; text-transform: uppercase; margin-top: 5px;">Service Platform</p>
                        </td>
                    </tr>

                    <!-- Hero Section with Stars -->
                    <tr>
                        <td align="center" style="padding: 0 40px;">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <span style="font-size: 32px; color: #FFD700;">★</span>
                                        <span style="font-size: 32px; color: #FFD700;">★</span>
                                        <span style="font-size: 32px; color: #FFD700;">★</span>
                                        <span style="font-size: 32px; color: #FFD700;">★</span>
                                        <span style="font-size: 32px; color: #e2e8f0;">★</span>
                                    </td>
                                </tr>
                            </table>
                            <h2 style="font-family: 'Helvetica Neue', Arial, sans-serif; font-size: 24px; font-weight: 700; color: #1a1a1a; margin-top: 20px; margin-bottom: 10px;">
                                Comment s'est passée votre expérience ?
                            </h2>
                            <div style="width: 50px; height: 3px; background-color: #2B5AA8; border-radius: 2px; margin-bottom: 20px;"></div>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td align="center" style="padding: 0 40px 40px 40px;">
                            <p style="font-family: 'Helvetica Neue', Arial, sans-serif; font-size: 16px; line-height: 26px; color: #4a5568; margin-bottom: 20px;">
                                Bonjour <strong>{{ $userName }}</strong>,
                            </p>
                            <p style="font-family: 'Helvetica Neue', Arial, sans-serif; font-size: 16px; line-height: 26px; color: #4a5568; margin-bottom: 25px;">
                                L'intervention du <strong>{{ $dateIntervention }}</strong> avec <strong>{{ $targetName }}</strong> est terminée. Votre avis est précieux pour maintenir l'excellence de notre communauté Helpora.
                            </p>
                            
                            <!-- Action Button -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" style="padding: 20px 0 30px 0;">
                                        <a href="{{ $feedbackUrl }}" class="btn-primary" style="color: #ffffff !important;">
                                            Laisser un avis maintenant
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-family: 'Helvetica Neue', Arial, sans-serif; font-size: 14px; line-height: 22px; color: #718096; margin-bottom: 0;">
                                Cela ne prendra que quelques secondes !
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding: 30px 40px; background-color: #F8FAFC; border-top: 1px solid #edf2f7;">
                            <p style="font-family: 'Helvetica Neue', Arial, sans-serif; font-size: 12px; color: #a0aec0; margin: 0; line-height: 1.5;">
                                Si le bouton ne fonctionne pas, copiez ce lien :<br>
                                <a href="{{ $feedbackUrl }}" style="color: #2B5AA8; text-decoration: none;">{{ $feedbackUrl }}</a>
                            </p>
                            <p style="font-family: 'Helvetica Neue', Arial, sans-serif; font-size: 12px; color: #cbd5e0; margin-top: 20px;">
                                © {{ date('Y') }} Helpora. Tous droits réservés.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
