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
        .action-summary { font-size: 16px; margin-bottom: 20px; color: #444; }
        .details-card { background: #F3F4F6; border-radius: 8px; padding: 20px; margin-bottom: 20px; border-left: 4px solid #2563EB; }
        .details-row { display: flex; justify-content: space-between; margin-bottom: 10px; border-bottom: 1px solid #e5e7eb; padding-bottom: 5px; }
        .details-row:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
        .label { font-weight: bold; color: #6b7280; font-size: 13px; text-transform: uppercase; }
        .value { font-weight: 600; color: #111827; text-align: right; }
        .contact-section { background-color: #EFF6FF; border: 1px dashed #3B82F6; padding: 15px; border-radius: 6px; text-align: center; }
        .footer { background-color: #f9fafb; padding: 20px; text-align: center; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Helpora</h1>
        </div>
        
        <div class="content">
            <p>Bonjour <strong>{{ $data['prof_nom'] }}</strong>,</p>

            <p class="action-summary">
                @if($data['statut'] === 'validée')
                    Vous avez <strong>accepté</strong> une nouvelle mission. Voici votre feuille de route :
                @else
                    Vous avez <strong>refusé</strong> la demande de cours suivante :
                @endif
            </p>

            <!-- Détails de la mission -->
            <div class="details-card">
                <div class="details-row">
                    <span class="label">Matière</span>
                    <span class="value">{{ $data['matiere'] }}</span>
                </div>
                <div class="details-row">
                    <span class="label">Niveau</span>
                    <span class="value">{{ $data['niveau'] }}</span>
                </div>
                <div class="details-row">
                    <span class="label">Date</span>
                    <span class="value">{{ $data['date'] }}</span>
                </div>
                <div class="details-row">
                    <span class="label">Horaire</span>
                    <span class="value">{{ $data['heure_debut'] }} - {{ $data['heure_fin'] }}</span>
                </div>
                <div class="details-row">
                    <span class="label">Revenu Net</span>
                    <span class="value" style="color: #059669;">{{ $data['prix'] }} DH</span>
                </div>
            </div>

            @if($data['statut'] === 'validée')
                <h3 style="margin-top: 25px; margin-bottom: 15px; font-size: 16px;"> Infos Client & Localisation</h3>
                
                <div class="contact-section">
                    <p style="margin: 0 0 10px 0; font-size: 16px; font-weight: bold;">
                         {{ $data['client_nom'] }}
                    </p>
                    
                    @if($data['type_service'] === 'enligne')
                        <p style="color: #7C3AED; font-weight: bold;"> Cours en ligne </p>
                        <p style="font-size: 13px; color: #666;">Pensez à envoyer le lien Zoom/Meet au client par email.</p>
                    @else
                        <p style="color: #EA580C; font-weight: bold;"> Cours à domicile</p>
                        <p style="font-size: 14px; margin: 5px 0;">
                            {{ $data['client_adresse'] }}<br>
                            {{ $data['client_ville'] }}
                        </p>
                    @endif

                    <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #bfdbfe;">
                        <a href="tel:{{ $data['client_tel'] }}" style="text-decoration: none; color: #1E40AF; font-weight: bold; margin-right: 15px;">
                            {{ $data['client_tel'] }}
                        </a>
                        <a href="mailto:{{ $data['client_email'] }}" style="text-decoration: none; color: #1E40AF; font-weight: bold;">
                             Envoyer un email
                        </a>
                    </div>
                </div>
            @endif

        </div>

        <div class="footer">
            Cet email est personnel et contient des données confidentielles.<br>
            © Helpora .
        </div>
    </div>
</body>
</html>