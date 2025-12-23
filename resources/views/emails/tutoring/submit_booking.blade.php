<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle demande de réservation</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #2B5AA8 0%, #1a3d6d 100%);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .header p {
            margin: 10px 0 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .content {
            padding: 30px 20px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #2B5AA8;
            margin-bottom: 20px;
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #2B5AA8;
            padding: 15px;
            margin: 20px 0;
            border-radius: 6px;
        }
        .info-box h3 {
            margin: 0 0 10px;
            font-size: 16px;
            color: #2B5AA8;
            font-weight: 600;
        }
        .info-row {
            display: flex;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #555;
            min-width: 140px;
        }
        .info-value {
            color: #333;
        }
        .time-slot {
            background-color: #e7f3ff;
            padding: 8px 12px;
            border-radius: 6px;
            margin: 5px 0;
            display: inline-block;
            font-size: 14px;
            color: #2B5AA8;
            font-weight: 500;
        }
        .total-section {
            background-color: #2B5AA8;
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .total-section .amount {
            font-size: 32px;
            font-weight: 700;
            margin: 10px 0;
        }
        .total-section .details {
            font-size: 14px;
            opacity: 0.9;
        }
        .note-box {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .note-box strong {
            color: #856404;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .button {
            display: inline-block;
            padding: 14px 30px;
            background-color: #ffffff;
            color: #2B5AA8;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s;
            border: 2px solid #2B5AA8;
        }
        .button:hover {
            background-color: #2B5AA8;
            color: #ffffff;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
            border-top: 1px solid #e9ecef;
        }
        .divider {
            height: 1px;
            background-color: #e9ecef;
            margin: 20px 0;
        }
        @media only screen and (max-width: 600px) {
            .container {
                margin: 0;
                border-radius: 0;
            }
            .content {
                padding: 20px 15px;
            }
            .info-row {
                flex-direction: column;
            }
            .info-label {
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Nouvelle Demande de Réservation</h1>
            <p>Un étudiant souhaite réserver un cours avec vous</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Bonjour {{ $professeur->prenom }} {{ $professeur->nom }},
            </div>

            <p>Vous avez reçu une nouvelle demande de réservation. Voici les détails :</p>

            <!-- Student Information -->
            <div class="info-box">
                <h3>Informations de l'étudiant</h3>
                <div class="info-row">
                    <span class="info-label">Nom complet :</span>
                    <span class="info-value">{{ $client->prenom }} {{ $client->nom }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email :</span>
                    <span class="info-value">{{ $client->email }}</span>
                </div>
                @if($client->numero_telephone)
                <div class="info-row">
                    <span class="info-label">Téléphone :</span>
                    <span class="info-value">{{ $client->numero_telephone }}</span>
                </div>
                @endif
            </div>

            <!-- Course Details -->
            <div class="info-box">
                <h3>Détails du cours</h3>
                <div class="info-row">
                    <span class="info-label">Matière :</span>
                    <span class="info-value"><strong>{{ $service->matiere->nom_matiere }}</strong></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Niveau :</span>
                    <span class="info-value">{{ $service->niveau->nom_niveau }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Mode de cours :</span>
                    <span class="info-value">
                        @if($typeService === 'enligne')
                            En ligne (Visioconférence)
                        @else
                            À domicile
                        @endif
                    </span>
                </div>
                @if($typeService === 'domicile' && $ville)
                <div class="info-row">
                    <span class="info-label">Ville :</span>
                    <span class="info-value">{{ $ville }}</span>
                </div>
                @endif
                @if($typeService === 'domicile' && $adresse)
                <div class="info-row">
                    <span class="info-label">Adresse :</span>
                    <span class="info-value">{{ $adresse }}</span>
                </div>
                @endif
            </div>

            <!-- Schedule -->
            <div class="info-box">
                <h3>Créneaux demandés</h3>
                <div class="info-row">
                    <span class="info-label">Date :</span>
                    <span class="info-value"><strong>{{ \Carbon\Carbon::parse($selectedDate)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</strong></span>
                </div>
                <div style="margin-top: 15px;">
                    <span class="info-label" style="display: block; margin-bottom: 10px;">Horaires :</span>
                    @foreach($demandes as $demande)
                        <div class="time-slot">
                            {{ \Carbon\Carbon::parse($demande->heureDebut)->format('H:i') }} - {{ \Carbon\Carbon::parse($demande->heureFin)->format('H:i') }}
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Special Notes -->
            @if($noteSpeciales)
            <div class="note-box">
                <strong>Notes spéciales de l'étudiant :</strong>
                <p style="margin: 10px 0 0;">{{ $noteSpeciales }}</p>
            </div>
            @endif

            <div class="divider"></div>

            <!-- Total Section -->
            <div class="total-section">
                <div>Montant total</div>
                <div class="amount">{{ number_format($montantTotal, 2) }} DH</div>
                <div class="details">
                    {{ $nombreHeures }} heure{{ $nombreHeures > 1 ? 's' : '' }} × {{ number_format($service->prix_par_heure, 2) }} DH/h
                </div>
            </div>

            <p style="text-align: center; color: #6c757d; font-size: 14px; margin-top: 20px;">
                Vous pouvez accepter ou refuser cette demande depuis votre tableau de bord.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Cet email a été envoyé automatiquement. Merci de ne pas y répondre directement.</p>
            <p style="margin-top: 10px;">
                &copy; {{ date('Y') }} - Tous droits réservés
            </p>
        </div>
    </div>
</body>
</html>