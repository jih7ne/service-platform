<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f3f4f6;
            padding: 20px;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        h1 {
            color: #10b981;
            text-align: center;
        }
        .info {
            background: #ecfdf5;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #10b981;
            margin: 20px 0;
        }
        .btn {
            display: block;
            width: 220px;
            margin: 20px auto;
            text-align: center;
            background: #10b981;
            color: white;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Candidature Acceptée ✅</h1>

        <p>
            Bonjour <strong>{{ $user->prenom }} {{ $user->nom }}</strong>,
        </p>

        <p>
            Nous avons le plaisir de vous informer que votre candidature en tant qu'intervenant <strong>{{ $typeService }}</strong> a été acceptée !
        </p>

        <div class="info">
            <p>
                ✅ Votre profil est désormais actif sur la plateforme Helpora.
            </p>
            <p>
                Vous pouvez dès maintenant :
            </p>
            <ul>
                <li>Accéder à votre tableau de bord</li>
                <li>Consulter les demandes de service</li>
                <li>Gérer vos disponibilités</li>
                <li>Accepter des missions</li>
            </ul>
        </div>

        <p>
            Merci de votre confiance et bienvenue sur Helpora !
        </p>

        <a href="{{ url('/') }}" class="btn">
            Accéder à mon espace
        </a>
    </div>
</body>
</html>
    </div>
</body>
</html>
