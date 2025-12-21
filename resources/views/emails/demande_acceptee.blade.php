<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #fefce8 0%, #fef3c7 100%);
            min-height: 100vh;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1.6;
        }
        
        .card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            max-width: 700px;
            width: 100%;
            margin: 0 auto;
            box-shadow: 0 20px 40px rgba(217, 119, 6, 0.1);
            border: 1px solid rgba(217, 119, 6, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #d97706, #fbbf24);
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }
        
        .success-badge {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #10b981, #34d399);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .success-badge svg {
            width: 40px;
            height: 40px;
            color: white;
        }
        
        h1 {
            color: #1f2937;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        
        .subtitle {
            color: #6b7280;
            font-size: 16px;
            font-weight: 500;
        }
        
        .greeting {
            font-size: 18px;
            color: #374151;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .greeting strong {
            color: #d97706;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        
        .info-card {
            background: #fffbeb;
            padding: 20px;
            border-radius: 12px;
            border-left: 4px solid #d97706;
            transition: transform 0.3s ease;
        }
        
        .info-card:hover {
            transform: translateY(-2px);
        }
        
        .info-title {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #92400e;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-title svg {
            width: 16px;
            height: 16px;
        }
        
        .info-value {
            color: #1f2937;
            font-size: 16px;
            font-weight: 500;
        }
        
        .price-badge {
            background: linear-gradient(135deg, #d97706, #fbbf24);
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            font-size: 18px;
            box-shadow: 0 4px 12px rgba(217, 119, 6, 0.2);
        }
        
        .intervenant-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            margin: 30px 0;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #d97706, #fbbf24);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: 600;
            flex-shrink: 0;
        }
        
        .intervenant-info h3 {
            color: #1f2937;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 4px;
        }
        
        .contact-info {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #4b5563;
            font-size: 14px;
        }
        
        .contact-item svg {
            width: 16px;
            height: 16px;
            color: #d97706;
        }
        
        .message {
            background: #ecfdf5;
            border: 1px solid #d1fae5;
            border-radius: 12px;
            padding: 20px;
            margin: 30px 0;
            text-align: center;
        }
        
        .message p {
            color: #065f46;
            font-weight: 500;
            font-size: 16px;
        }
        
        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
            margin-top: 40px;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 28px;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            min-width: 200px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            color: white;
            box-shadow: 0 4px 15px rgba(217, 119, 6, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(217, 119, 6, 0.4);
        }
        
        .btn-secondary {
            background: white;
            color: #374151;
            border: 2px solid #e5e7eb;
        }
        
        .btn-secondary:hover {
            background: #f9fafb;
            border-color: #d1d5db;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #f3f4f6;
            color: #6b7280;
            font-size: 14px;
        }
        
        @media (max-width: 640px) {
            .card {
                padding: 25px;
            }
            
            h1 {
                font-size: 24px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                min-width: auto;
            }
            
            .intervenant-card {
                flex-direction: column;
                text-align: center;
            }
            
            .contact-info {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <div class="success-badge">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h1>Demande validée avec succès !</h1>
            <p class="subtitle">Votre animal sera entre de bonnes mains</p>
        </div>
        
        <p class="greeting">
            Bonjour <strong>{{ $client->prenom }} {{ $client->nom }}</strong>,
        </p>
        
        <p style="color: #4b5563; margin-bottom: 10px;">
            Excellente nouvelle ! Votre demande de garde a été acceptée.
        </p>
        
        <div class="info-grid">
            <div class="info-card">
                <div class="info-title">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    ANIMAL
                </div>
                <div class="info-value">{{ optional($demande->animal)->nomAnimal ?? 'Non renseigné' }}</div>
            </div>
            
            <div class="info-card">
                <div class="info-title">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    DATE
                </div>
                <div class="info-value">{{ \Carbon\Carbon::parse($demande->dateSouhaitee)->format('d/m/Y') }}</div>
            </div>
        </div>
        
        <div class="info-card">
            <div class="info-title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                MONTANT
            </div>
            <div class="price-badge">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ $demande->prix }} DH
            </div>
        </div>
        
        <div class="intervenant-card">
            <div class="avatar">
                {{ strtoupper(substr($intervenant->prenom, 0, 1) . substr($intervenant->nom, 0, 1)) }}
            </div>
            <div class="intervenant-info">
                <h3>{{ $intervenant->prenom }} {{ $intervenant->nom }}</h3>
                <p style="color: #6b7280; margin-bottom: 12px;">Votre pet-sitter</p>
                <div class="contact-info">
                    <div class="contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ $intervenant->email ?? 'Non disponible' }}
                    </div>
                    <div class="contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        {{ $intervenant->telephone ?? 'Non disponible' }}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="message">
            <p>🐾 Votre animal sera bien pris en charge. N'hésitez pas à contacter votre pet-sitter pour échanger sur les détails de la garde.</p>
        </div>
        
        <div class="actions">
            <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Accéder à mon espace
            </a>
            <a href="{{ url('/mes-demandes') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Voir mes demandes
            </a>
        </div>
        
        <div class="footer">
            <p>Merci de votre confiance • L'équipe PetSitting</p>
            <p style="font-size: 12px; margin-top: 8px; color: #9ca3af;">
                Cet email a été envoyé automatiquement. Veuillez ne pas y répondre.
            </p>
        </div>
    </div>
    
    <script>
        // Add some micro-interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Animate elements on load
            const elements = document.querySelectorAll('.info-card, .intervenant-card');
            elements.forEach((el, index) => {
                setTimeout(() => {
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(20px)';
                    el.style.transition = 'all 0.5s ease';
                    
                    setTimeout(() => {
                        el.style.opacity = '1';
                        el.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 100);
            });
        });
    </script>
</body>
</html>