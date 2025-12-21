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
            color: #ef4444;
            text-align: center;
        }
        .info {
            background: #fef2f2;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #ef4444;
            margin: 20px 0;
        }
        .btn {
            display: block;
            width: 220px;
            margin: 20px auto;
            text-align: center;
            background: #3b82f6;
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
        <h1>Candidature Refusée</h1>

        <p>
            Bonjour <strong>{{ $user->prenom }} {{ $user->nom }}</strong>,
        </p>

        <p>
            Nous vous remercions pour votre intérêt envers la plateforme Helpora. Malheureusement, votre candidature en tant qu'intervenant <strong>{{ $typeService }}</strong> n'a pas pu être acceptée.
        </p>

        <div class="info">
            <p>
                <strong>Motif du refus :</strong>
            </p>
            <p>
                {{ $reason }}
            </p>
        </div>

        <p>
            Nous vous encourageons à rééssayer ultérieurement avec un profil enrichi. Si vous avez des questions concernant cette décision, n'hésitez pas à nous contacter.
        </p>

        <a href="{{ url('/') }}" class="btn">
            Revenir à l'accueil
        </a>
    </div>
</body>
</html>
