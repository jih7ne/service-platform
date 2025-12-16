<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demande refusée</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f8f9fa; padding:20px;">
    <div style="max-width:600px; margin:auto; background:white; padding:20px; border-radius:8px;">
        <h2 style="color:#dc2626;">❌ Demande refusée</h2>

        <p>Bonjour <strong>{{ $client->prenom }}</strong>,</p>

        <p>
            Votre demande prévue le
            <strong>{{ \Carbon\Carbon::parse($demande->dateSouhaitee)->format('d/m/Y') }}</strong>
            a été refusée par le petkeeper
            <strong>{{ $intervenant->prenom }}</strong>.
        </p>

        <p><strong>Motif du refus :</strong></p>
        <blockquote style="background:#fee2e2; padding:10px; border-left:4px solid #dc2626;">
            {{ $raison }}
        </blockquote>

        <p style="margin-top:20px;">
            Vous pouvez effectuer une nouvelle demande depuis la plateforme Helpora.
        </p>

        <p style="margin-top:30px;">
            Cordialement,<br>
            <strong>Helpora</strong>
        </p>
    </div>
</body>
</html>
