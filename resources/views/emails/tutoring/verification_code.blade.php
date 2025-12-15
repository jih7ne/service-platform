<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f4f7; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; margin-top: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .header { background: linear-gradient(135deg, #2B5AA8 0%, #1E40AF 100%); padding: 30px; text-align: center; color: white; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 40px 30px; text-align: center; }
        .code-container { background: #EFF6FF; border: 3px dashed #2B5AA8; border-radius: 12px; padding: 30px; margin: 30px 0; }
        .code { font-size: 36px; font-weight: bold; letter-spacing: 8px; color: #2B5AA8; font-family: 'Courier New', monospace; }
        .warning { background: #FEF3C7; border-left: 4px solid #F59E0B; padding: 15px; margin: 20px 0; text-align: left; border-radius: 6px; }
        .footer { background-color: #f9fafb; padding: 20px; text-align: center; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1> Code de Vérification</h1>
        </div>
        
        <div class="content">
            <p style="font-size: 18px; color: #374151; margin-bottom: 10px;">
                Bonjour <strong>{{ $prenom }}</strong>,
            </p>
            
            <p style="font-size: 15px; color: #6B7280; line-height: 1.6;">
                Voici votre code de vérification pour finaliser votre inscription sur Helpora :
            </p>

            <div class="code-container">
                <div class="code">{{ $code }}</div>
                <p style="margin: 15px 0 0 0; font-size: 13px; color: #6B7280;">
                    Ce code est valide pendant <strong>10 minutes</strong>
                </p>
            </div>

            <div class="warning">
                <p style="margin: 0; font-size: 14px; color: #92400E;">
                    <strong> Important :</strong> Ne partagez jamais ce code avec qui que ce soit. 
                    L'équipe Helpora ne vous demandera jamais ce code par téléphone ou email.
                </p>
            </div>

            <p style="font-size: 13px; color: #9CA3AF; margin-top: 30px;">
                Si vous n'avez pas demandé ce code, ignorez simplement cet email.
            </p>
        </div>

        <div class="footer">
            © Helpora - Plateforme de soutien scolaire
        </div>
    </div>
</body>
</html>