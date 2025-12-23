# 🏠 Service Platform - Plateforme Multi-Services
<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire-3.7-4E56A6?style=for-the-badge&logo=livewire&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.4+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Tailwind](https://img.shields.io/badge/Tailwind-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

![License](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)
![Status](https://img.shields.io/badge/Status-Active-success.svg?style=flat-square)
![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg?style=flat-square)

</div>

Une plateforme web moderne et complète permettant la gestion de plusieurs services professionnels : garde d'animaux, babysitting, et soutien scolaire.

## 📋 Table des Matières

- [À propos](#-à-propos)
- [Fonctionnalités](#-fonctionnalités)
- [Technologies](#-technologies)
- [Prérequis](#-prérequis)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Utilisation](#-utilisation)
- [Architecture](#-architecture)
- [Tests](#-tests)
- [License](#-license)
- [Support](#-support)
- [Équipe de développement](#-équipe-de-développement)

## 🎯 À propos

**Helpora** est une plateforme web moderne de services développée avec Laravel 12 et Livewire 3. Elle connecte des clients avec des professionnels qualifiés dans trois domaines essentiels : le soutien scolaire, le babysitting et la garde d'animaux.

### 🌟 Notre Mission

Faciliter l'accès à des services de qualité tout en offrant aux intervenants une plateforme simple pour gérer leur activité professionnelle.

### 🎓 Contexte du Projet

Ce projet a été développé dans le cadre de module de Développement Web Avancé à ENSA de Tétouan par une équipe de 12 étudiants, organisée en 3 groupes spécialisés.

**Période** : Du début Novembre à la fin Décembre 2025


## ✨ Fonctionnalités

### Pour les Clients
- ✅ Inscription et authentification sécurisée
- 🔍 Recherche et réservation de services
- 📅 Gestion de demandes d'intervention
- 💬 Système de feedback et d'avis
- 🔔 Notifications en temps réel par email
- 📝 Gestion des réclamations

### Pour les Intervenants
- 👤 Profil professionnel personnalisable
- 📋 Tableau de bord des missions
- 📅 Gestion des disponibilités
- ✔️ Acceptation/refus de demandes
- 📈 Suivi des interventions
- ⭐ Gestion des avis clients
- 💰 Calcul automatique des tarifs

### Pour les Administrateurs
- 🎛️ Dashboard administrateur complet
- 👥 Gestion des utilisateurs (clients, intervenants)
- 📊 Statistiques détaillées
- 🚨 Gestion des réclamations 
- ✅ Validation des comptes intervenants


### Fonctionnalités Techniques
- 🔒 Authentification multi-rôles (client, intervenant, admin)
- 💾 Système de stockage de fichiers
- 📧 Notifications par email
- 🔄 Mises à jour en temps réel avec Livewire
- 📱 Interface responsive
- 🎨 UI moderne et intuitive
- 🔐 Sécurité renforcée (CSRF, validation, sanitization)

## 🛠️ Technologies

### Backend
- **Framework** : Laravel 12.x
- **PHP** : 8.4+
- **Base de données** : MySQL
- **ORM** : Eloquent

### Frontend
- **Framework UI** : Livewire 3.7
- **Build Tool** : Vite
- **Styling** : Tailwind CSS
- **JavaScript** : Vanilla JS + intégration Livewire

### Outils de Développement
- **Testing** : PHPUnit 11.5
- **Code Quality** : Laravel Pint
- **Development Server** : Laravel Sail (optionnel)
- **Queue Management** : Laravel Queue
- **Logging** : Laravel Pail

## 📦 Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- PHP >= 8.4
- Composer >= 2.x
- Node.js >= 18.x et npm
- MySQL >= 8.0
- Serveur web (Apache/Nginx) et utiliser `php artisan serve`

## 🚀 Installation

### 1. Cloner le dépôt

```bash
git clone <repository-url> 
cd <repository-name>
```

### 2. Installation automatique (Recommandé)

```bash
composer run setup
```

Cette commande exécutera automatiquement :
- Installation des dépendances PHP
- Copie du fichier `.env.example` vers `.env`
- Génération de la clé d'application
- Exécution des migrations
- Installation des dépendances Node.js
- Build des assets frontend

### 3. Installation manuelle

Si vous préférez une installation étape par étape :

```bash
# Installer les dépendances PHP
composer install

# Copier le fichier d'environnement
cp .env.example .env

# Générer la clé d'application
php artisan key:generate

# Configurer la base de données dans .env
# Puis exécuter les migrations
php artisan migrate

# Installer les dépendances Node.js
npm install

# Compiler les assets
npm run build
```

## ⚙️ Configuration

### 1. Configuration de la base de données

Éditez le fichier `.env` et configurez votre connexion à la base de données :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=service_platform
DB_USERNAME=votre_username
DB_PASSWORD=votre_password
```

### 2. Configuration du Mail

Pour les notifications par email :

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=votre_username
MAIL_PASSWORD=votre_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@serviceplatform.com
MAIL_FROM_NAME="Service Platform"
```

### 3. Seed des données de test (Optionnel)

```bash
php artisan db:seed
```

## 💻 Utilisation

### Démarrage en mode développement

Pour lancer l'application en développement avec tous les services :

```bash
composer run dev
```

Cette commande démarre :
- 🌐 Serveur Laravel (`http://localhost:8000`)
- ⚡ Queue worker
- 📝 Log viewer (Pail)
- 🔧 Vite dev server (Hot Module Replacement)

### Démarrage manuel

```bash
# Terminal 1 - Serveur Laravel
php artisan serve

# Terminal 2 - Queue worker
php artisan queue:listen

# Terminal 3 - Vite dev server
npm run dev
```

### Accès à l'application

Une fois l'application démarrée, accédez à : `http://localhost:8000`

## 🏗️ Architecture

### Structure des dossiers

```
service-platform/
├── app/
│   ├── Http/
│   │   └── Controllers/     # Contrôleurs HTTP et API
│   ├── Livewire/            # Components Livewire
│   │   ├── Babysitter/      # Gestion babysitting
│   │   ├── Client/          # Interface client
│   │   ├── PetKeeping/      # Garde d'animaux
│   │   ├── Tutoring/        # Soutien scolaire
│   │   └── Shared/          # Composants partagés
│   ├── Models/              # Modèles Eloquent
│   └── Observers/           # Observers pour les événements
├── database/
│   ├── migrations/          # Migrations de base de données
│   ├── seeders/             # Seeders de données
│   └── factories/           # Factories pour les tests
├── resources/
│   ├── views/               # Vues Blade
│   │   └── livewire/        # Vues des composants Livewire
│   └── css/                 # Fichiers CSS
├── routes/
│   ├── web.php              # Routes web
│   └── api.php              # Routes API
└── tests/                   # Tests automatisés
    ├── Feature/             # Tests fonctionnels
    └── Unit/                # Tests unitaires
```

### Modèles principaux

- **Utilisateur** - Gestion des utilisateurs
- **DemandeIntervention** - Demandes des services
- **Feedback** - Avis et retours clients et intervenants
- **Animal** - Informations sur les animaux (pour le service de garde d'animaux)
- **ServiceProfessionnel** - Services proposés

### Rôles utilisateurs

1. **Client** - Réserve et consomme les services
2. **Intervenant** - Fournit les services (babysitter, pet keeper, tuteur)
3. **Super Admin** - Gestion complète de la plateforme

## 🧪 Tests

### Exécuter les tests

```bash
# Tous les tests
composer run test

# Tests avec couverture
php artisan test --coverage

# Tests spécifiques
php artisan test --filter NomDuTest
```

## 📄 License

Ce projet est sous licence MIT.
---

## 📞 Support

Pour toute question ou problème :
- Consultez la documentation Laravel : https://laravel.com/docs
- Consultez la documentation Livewire : https://livewire.laravel.com

---
## 👥 Équipe de développement

### 📚 Soutien Scolaire
- **Chouhe Jihane** 
- **Elmessaoudi Fatima** 
- **Essebaiy Aya** 
- **Erraboun Nouha** 

### 👶 Babysitting
- **Aya Raissouni** 
- **Douae Moeniss** 
- **Oumaima Ameziane** 
- **Raihana Mohito** 

### 🐾 Garde d'Animaux
- **Nyirenda Amos** 
- **El Bouzidi Imane** 
- **Wiam Benkrimen** 
- **Wissal Khalid** 