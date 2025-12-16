<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Demande de Réservation</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f7f9fc;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .content {
            padding: 30px;
        }
        .info-card {
            background: #f8fafc;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
            border-left: 4px solid #4f46e5;
        }
        .info-card h3 {
            color: #4f46e5;
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 18px;
        }
        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 25px;
        }
        .detail-item {
            background: #f1f5f9;
            padding: 15px;
            border-radius: 8px;
        }
        .detail-label {
            font-size: 14px;
            color: #64748b;
            display: block;
            margin-bottom: 5px;
        }
        .detail-value {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
        }
        .highlight-box {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 25px 0;
        }
        .highlight-box .amount {
            font-size: 28px;
            font-weight: 800;
            color: #d97706;
            margin: 10px 0;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin-top: 20px;
            text-align: center;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background: #f1f5f9;
            color: #64748b;
            font-size: 14px;
        }
        .id-badge {
            display: inline-block;
            background: #e0e7ff;
            color: #4f46e5;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        @media (max-width: 600px) {
            .details-grid {
                grid-template-columns: 1fr;
            }
            .content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Nouvelle Demande de Réservation</h1>
            <p>{{ $serviceName }}</p>
        </div>
        
        <div class="content">
            <div class="info-card">
                <h3>Bonjour {{ $intervenantNom }},</h3>
                <p>Une nouvelle demande de réservation vous a été assignée. Voici les détails de la demande :</p>
            </div>
            
            <div class="details-grid">
                <div class="detail-item">
                    <span class="detail-label">Client</span>
                    <span class="detail-value">{{ $clientName }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Date de début</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($dateDebut)->translatedFormat('l d F Y') }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Nombre de créneaux</span>
                    <span class="detail-value">{{ $nombreCreneaux }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Nombre d'animaux</span>
                    <span class="detail-value">{{ $nombreAnimaux }}</span>
                </div>
            </div>
            
            <div class="highlight-box">
                <div style="font-size: 16px; color: #92400e; font-weight: 600;">Montant total de la réservation</div>
                <div class="amount">{{ number_format($montantTotal, 2, ',', ' ') }} €</div>
                <div style="font-size: 14px; color: #92400e;">TTC</div>
            </div>
            
            <div style="text-align: center; margin: 30px 0;">
                <div style="margin-bottom: 15px; font-weight: 600;">Référence de la demande</div>
                <div class="id-badge">#{{ $demandeId }}</div>
            </div>
            
            <div style="text-align: center;">
                <p style="margin-bottom: 20px; color: #475569;">
                    Veuillez vous connecter à votre espace professionnel pour accepter ou refuser cette demande.
                </p>
                <a href="{{ url('/intervenant/demandes') }}" class="cta-button">Voir la demande</a>
            </div>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} - Votre entreprise de services animaliers</p>
            <p style="font-size: 12px; margin-top: 10px;">
                Cet email a été envoyé automatiquement, merci de ne pas y répondre directement.
            </p>
        </div>
    </div>
</body>
</html>