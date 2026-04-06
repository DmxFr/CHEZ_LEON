🍽️ Chez Léon — Plateforme IoT Gastronomique 
L'excellence culinaire, pilotée par la technologie.
Projet de Développement Web · ING1 CY Tech · 2025-2026 
Laravel 11 PHP 8.3 Bootstrap 5 SQLite Vite 
📖 À propos du projet 
Chez Léon est une plateforme numérique intelligente dédiée à un restaurant gastronomique étoilé. Ce projet explore l'Internet des
Objets (IoT) dans la haute gastronomie pour répondre à des problématiques concrètes : maîtrise de la chaîne du froid, contrôle précis
des températures de cuisson et gestion éco-responsable des équipements. 
🎯 Modules de la plateformeModule Accès FonctionnalitésInformation Visiteurs Actualités, visite guidée, recherche publiqueVisualisation Simple (Débutant/Intermédiaire) Consultation des objets IoT, profil, historique XPGestion Complexe (Avancé+) CRUD appareils, contrôle IoT, rapportsAdministration Admin (Expert) Gestion utilisateurs, approbations, supervision globale 
⭐ Points techniques forts 
Sécurité à double dimension — Contrôle d'accès croisant rôle métier × niveau d'expérience via 4 middlewares personnalisés
Moteur de gamification — ExperienceService injectable avec transactions DB, anti-spam par cache
Cache optimisé — Pattern toArray() / forceFill() éliminant les bugs de désérialisation PHP
(__PHP_Incomplete_Class)
Design Gastro-Tech Luxe — Glassmorphism, Cormorant Garamond, surcharge Bootstrap globale sans modifier le HTML 
🛠️ Stack technologique 
Backend : Laravel 11 (PHP 8.3) — MVC, Middlewares, Cache natif, Eloquent ORM
Base de données : SQLite (dev) / MySQL (prod) — Migrations, Soft Deletes, relations polymorphiques
Frontend : Bootstrap 5 + CSS personnalisé — Mobile-First, Glassmorphism, animations
Build : Vite 8 + Tailwind CSS 4

⚙️ Installation et démarrage 
Prérequis 
PHP 8.3+
Composer
Node.js 18+
Git 
Étapes 
# 1. Cloner le dépôt
git clone https://github.com/Neimad1612/Projet-dev-web.git
cd Projet-dev-web
# 2. Installer les dépendances PHP
composer install
# 3. Installer les dépendances JavaScript et compiler les assets
npm install
npm run build
# 4. Configurer l'environnement
cp .env.example .env
php artisan key:generate
Note : Vérifiez que votre .env contient DB_CONNECTION=sqlite et MAIL_MAILER=log. 
# 5. Créer la base de données et injecter les données de démonstration
php artisan migrate:fresh --seed
# 6. Lancer le serveur de développement
php artisan serve

L'application est accessible sur **http://127.0.0.1:8000** 
🎬 Scénario de démonstration 
Phase 1 — Expérience visiteur & sécurité d'inscription 
Ouvrir le site en navigation privée
Parcourir la page d'accueil, les actualités et la visite guidée
Cliquer sur S'inscrire et créer un compte
Résultat attendu : message flash indiquant que le compte est en attente d'approbation — accès refusé (403) grâce au
middleware CheckRole 
Phase 2 — Rôle administrateur 
Se connecter avec le compte administrateur (créé par les Seeders)
Aller dans Administration > En attente
Approuver le nouveau compte
Résultat attendu : statut approuvé, rôle Simple attribué
Ouvrir storage/logs/laravel.log pour voir l'e-mail de confirmation simulé 
Phase 3 — Moteur de gamification (XP) 
Se connecter avec le nouveau compte approuvé
Connexion : le middleware TrackLogin attribue 5 XP automatiquement (1 fois/jour)
Consultation : cliquer sur un appareil IoT — TrackDeviceView attribue 2 XP (1 fois/heure/appareil)
Vérifier la barre de progression XP dans la navbar et l'historique dans Mon profil
L'ExperienceService recalcule le niveau automatiquement via une transaction DB 
Phase 4 — Gestion des objets IoT 
Aller sur Objets connectés et tester les 4 filtres dynamiques (catégorie, zone, statut, recherche)
Se connecter en tant qu'administrateur pour accéder au CRUD complet
Ajouter un équipement (four, thermostat, cave à vin)
Note : la suppression est logique (Soft Delete) pour préserver l'historique des capteurs et la traçabilité des consommations
énergétiques 
📁 Structure du projet 
app/
├── Http/
│ ├── Controllers/
│ │ ├── Admin/ # AdminDashboardController, AdminUserController
│ │ ├── Auth/ # LoginController, RegisterController
│ │ ├── Complex/ # DeviceManagementController
│ │ └── Simple/ # DeviceViewController, ProfileController, ExperienceController
│ └── Middleware/
│ ├── CheckRole.php # Contrôle du rôle métier
│ ├── CheckLevel.php # Contrôle du niveau XP
│ ├── TrackLogin.php # Attribution XP à la connexion
│ └── TrackDeviceView.php # Attribution XP à la consultation
├── Models/ # User, Device, Zone, DeviceCategory, ExperienceLog...
├── Services/
│ └── ExperienceService.php # Moteur de gamification
└── Observers/
└── UserObserver.php
database/├── migrations/ # 10 migrations versionnées
├── seeders/ # DatabaseSeeder (admin, appareils IoT, actualités)
└── factories/ # UserFactory, DeviceFactory
resources/
├── views/
│ ├── layouts/app.blade.php # Layout maître (design Gastro-Tech Luxe)
│ ├── public/ # Accueil, actualités, visite guidée
│ ├── auth/ # Login, inscription
│ ├── simple/ # Dashboard, objets, profil, XP
│ ├── complex/ # Création et édition d'appareils
│ └── admin/ # Dashboard admin, gestion utilisateurs
└── css/app.css

👥 ÉquipeMembre Rôle ResponsabilitésNeimad Tech Lead & Backend Architecture Laravel, middlewares de sécurité, système XP, cache, contrôleurs
métierBrice & Mathéo Frontend & UI/UX Design Gastro-Tech Luxe, vues Blade, Bootstrap 5, accessibilité WCAGDamien D. & Damien F. Base de données & IoT MCD, migrations, modèles Eloquent, Seeders et Factories IoT📄 Licence 
Projet académique — CY Tech ING1 · 2025-2026. Tous droits réservés