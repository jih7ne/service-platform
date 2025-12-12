<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; background-color: #f3f4f6; padding: 20px; }
        .card { background: white; padding: 30px; border-radius: 10px; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h1 { color: #d97706; text-align: center; }
        .info { background: #fffbeb; padding: 15px; border-radius: 5px; border-left: 4px solid #d97706; margin: 20px 0; }
        .btn { display: block; width: 200px; margin: 20px auto; text-align: center; background: #d97706; color: white; padding: 10px; text-decoration: none; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Demande Validée ! ✅</h1>
<p>Bonjour {{ $client->prenom }} {{ $client->nom }},</p>
        <p>Votre demande de garde a été acceptée par <strong>{{ optional($intervenant)->name }}</strong>.</p>
        
        <div class="info">
            <p><strong>🐾 Animal :</strong> {{ optional($demande->animal)->nomAnimal }}</p>
            <p><strong>📅 Date :</strong> {{ $demande->dateSouhaitee }}</p>
            <p><strong>💰 Prix :</strong> {{ $demande->prix }} DH</p>
        </div>

        <p>Vous trouverez ci-joint le récapitulatif (si fichier joint).</p>
        
        <a href="{{ url('/') }}" class="btn">Accéder à mon espace</a>
    </div>
</body>
</html>