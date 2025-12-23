<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f4f7; color: #333; margin: 0; padding: 0; }
        .container { max-width: 650px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; margin-top: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .header { background: linear-gradient(135deg, #DC2626 0%, #991B1B 100%); padding: 25px; text-align: center; color: white; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 5px 0 0 0; font-size: 13px; opacity: 0.9; }
        .content { padding: 30px; }
        .alert-badge { background: #FEE2E2; color: #991B1B; padding: 12px 24px; border-radius: 20px; display: inline-block; font-weight: bold; margin: 15px 0; border: 2px solid #DC2626; }
        .profile-card { background: #F9FAFB; border: 2px solid #E5E7EB; border-radius: 8px; padding: 25px; margin: 20px 0; }
        .profile-header { display: flex; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #E5E7EB; }
        .profile-icon { width: 60px; height: 60px; background: #3B82F6; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: bold; margin-right: 15px; }
        .profile-info h2 { margin: 0; color: #111827; font-size: 20px; }
        .profile-info p { margin: 5px 0 0 0; color: #6B7280; font-size: 14px; }
        .details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .detail-item { background: white; padding: 12px; border-radius: 6px; border-left: 3px solid #3B82F6; }
        .detail-label { font-size: 11px; text-transform: uppercase; color: #6B7280; font-weight: bold; margin-bottom: 5px; }
        .detail-value { font-size: 14px; color: #111827; font-weight: 600; }
        .matieres-section { background: #EFF6FF; border: 2px dashed #3B82F6; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .matieres-section h3 { margin: 0 0 15px 0; color: #1E40AF; font-size: 16px; }
        .matiere-tag { display: inline-block; background: white; border: 1px solid #BFDBFE; color: #1E40AF; padding: 8px 15px; border-radius: 20px; margin: 5px; font-size: 13px; font-weight: 500; }
        .action-section { background: #DCFCE7; border-left: 4px solid #16A34A; padding: 20px; border-radius: 6px; margin: 25px 0; text-align: center; }
        .action-button { display: inline-block; background: #16A34A; color: white; padding: 14px 30px; border-radius: 6px; text-decoration: none; font-weight: bold; margin: 10px 5px; transition: background 0.3s; }
        .action-button:hover { background: #15803D; }
        .action-button.secondary { background: #6B7280; }
        .action-button.secondary:hover { background: #4B5563; }
        .documents-list { background: #FEF3C7; border: 1px solid #FCD34D; padding: 15px; border-radius: 6px; margin: 15px 0; }
        .documents-list h4 { margin: 0 0 10px 0; color: #92400E; font-size: 14px; }
        .documents-list ul { margin: 0; padding-left: 20px; }
        .documents-list li { color: #78350F; margin: 5px 0; font-size: 13px; }
        .footer { background-color: #f9fafb; padding: 20px; text-align: center; font-size: 12px; color: #888; }
        .timestamp { background: #F3F4F6; padding: 10px; border-radius: 4px; text-align: center; font-size: 12px; color: #6B7280; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Administration Helpora</h1>
            <p>Nouvelle demande d'inscription professeur</p>
        </div>
        
        <div class="content">
            <div style="text-align: center;">
                <span class="alert-badge">ACTION REQUISE</span>
            </div>

            <p style="font-size: 16px; line-height: 1.6; color: #374151;">
                Une nouvelle demande d'inscription professeur vient d'être soumise et nécessite votre validation.
            </p>

            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-icon">
                        {{ strtoupper(substr($data['prenom'], 0, 1)) }}{{ strtoupper(substr($data['nom'], 0, 1)) }}
                    </div>
                    <div class="profile-info">
                        <h2>{{ $data['prenom'] }} {{ $data['nom'] }}</h2>
  
                    </div>
                </div>

                <div class="details-grid">
                    <div class="detail-item">
                        <div class="detail-label">Email</div>
                        <div class="detail-value">{{ $data['email'] }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">📱 Téléphone</div>
                        <div class="detail-value">{{ $data['telephone'] }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Niveau d'études</div>
                        <div class="detail-value">{{ $data['niveau_etudes'] }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Date de naissance</div>
                        <div class="detail-value">{{ $data['date_naissance'] }}</div>
                    </div>
                </div>
            </div>

            <div class="matieres-section">
                <h3>Matières proposées ({{ $data['nombre_matieres'] }})</h3>
                @foreach($data['matieres'] as $matiere)
                    <span class="matiere-tag">
                        {{ $matiere['matiere'] }} - {{ $matiere['niveau'] }} ({{ $matiere['prix'] }} DH/h)
                    </span>
                @endforeach
            </div>

            <div class="documents-list">
                <h4>Documents joints :</h4>
                <ul>
                    <li>Document CIN</li>
                    @if($data['a_diplome'])
                        <li>Diplôme</li>
                    @endif
                    @if($data['a_photo'])
                        <li>Photo de profil</li>
                    @endif
                </ul>
            </div>

            <div style="background: #F3F4F6; padding: 15px; border-radius: 6px; margin: 20px 0;">
                <p style="margin: 0; font-size: 14px; color: #4B5563;">
                    <strong>Biographie :</strong><br>
                    {{ $data['biographie'] ?: 'Aucune biographie fournie' }}
                </p>
            </div>

            <div class="action-section">
                <p style="margin: 0 0 15px 0; font-size: 15px; color: #166534; font-weight: bold;">
                    Veuillez examiner cette demande et valider le profil
                </p>
                <a href="{{ $data['dashboard_url'] }}" class="action-button">
                    Accéder au tableau de bord
                </a>
                <a href="{{ $data['profile_url'] }}" class="action-button secondary">
                    Voir le profil complet
                </a>
            </div>

            <div class="timestamp">
                Demande reçue le {{ $data['date_inscription'] }} à {{ $data['heure_inscription'] }}
            </div>

            <p style="font-size: 13px; color: #6B7280; margin-top: 25px; text-align: center;">
                Cet email a été envoyé automatiquement par le système Helpora.
            </p>
        </div>

        <div class="footer">
            Email confidentiel - Administration Helpora<br>
            © Helpora - Plateforme de soutien scolaire
        </div>
    </div>
</body>
</html>