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
            color: #d97706;
            text-align: center;
        }
        .info {
            background: #fffbeb;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #d97706;
            margin: 20px 0;
        }
        .btn {
            display: block;
            width: 220px;
            margin: 20px auto;
            text-align: center;
            background: #d97706;
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
        <h1>Demande validée ✅</h1>

        <p>
            Bonjour <strong>{{ $client->prenom }} {{ $client->nom }}</strong>,
        </p>

        <p>
            Votre demande de garde a été acceptée par
            <strong>{{ $intervenant->prenom }} {{ $intervenant->nom }}</strong>.
        </p>

        <div class="info">
            <p>
                <strong>🐾 Animal :</strong>
                {{ optional($demande->animal)->nomAnimal ?? 'Non renseigné' }}
            </p>

            <p>
                <strong>📅 Date :</strong>
                {{ \Carbon\Carbon::parse($demande->dateSouhaitee)->format('d/m/Y') }}
            </p>

            <p>
                <strong>💰 Prix :</strong>
                {{ $demande->prix }} DH
            </p>
        </div>

        <p>
            Merci de votre confiance.
        </p>

        <a href="{{ url('/') }}" class="btn">
            Accéder à mon espace
        </a>
    </div>
</body>
</html>
