# Configuration de l'Automatisation sur le Serveur (Cron Job)

Pour que les tâches automatiques (comme l'annulation des réservations expirées) fonctionnent sur votre hébergement, vous devez ajouter une **entrée Cron** sur votre serveur.

C'est une opération standard que vous faites une seule fois lors du déploiement.

## 1. Accéder à votre serveur ou panneau de contrôle
Connectez-vous à votre panneau de gestion (cPanel, Plesk, ou via SSH pour un serveur VPS).

## 2. Trouver la rubrique "Tâches Cron" (Cron Jobs)
Cherchez "Cron Jobs", "Planificateur de tâches" ou "Tâches planifiées".

## 3. Ajouter la commande suivante
Vous devez ajouter une nouvelle tâche qui s'exécute **chaque minute** (`* * * * *`).

La commande à insérer est :

```bash
cd /chemin/vers/votre/projet && php artisan schedule:run >> /dev/null 2>&1
```

### Important : Adapter le chemin
Remplacez `/chemin/vers/votre/projet` par le vrai chemin absolu où se trouve votre dossier `service-platform-1` sur le serveur.
Par exemple : `/var/www/html/helpora` ou `/home/user/public_html`.

## Explication
Cette configuration dit au serveur : "Chaque minute, checke s'il y a quelque chose à faire dans Laravel".
Laravel regardera alors votre fichier `routes/console.php`. Si une heure s'est écoulée, il lancera l'annulation des réservations. Sinon, il ne fera rien.

## Si vous utilisez Laravel Forge ou un service managé
Si vous utilisez des services comme Laravel Forge, Vercel (avec limitations), ou Heroku, la configuration peut être légèrement différente (via une interface graphique "Scheduler").
