# Documentation Technique - Plateforme Nationale de Gouvernance (Huissiers de Justice)

## 1. Architecture du Projet

### Stack Technique
- **Framework Backend** : Laravel 11.x
- **Administration** : FilamentPHP 3.x
- **Base de Données** : MySQL 8.x
- **Authentification API** : Laravel Sanctum
- **Génération PDF** : dompdf
- ** Langue par défaut** : Arabe (`ar`) avec support RTL (Right-to-Left).

### Structure des Dossiers Clés
- `app/Models/` : Modèles de données (Huissier, Acte, Tribunal, Region).
- `app/Filament/Resources/` : Configuration des interfaces d'administration.
- `app/Http/Controllers/Api/` : Points d'accès pour l'application mobile.
- `database/migrations/` : Schéma de la base de données.

---

## 2. Base de Données (Schéma Relationnel)

### `regions`
Représente les 12 régions administratives judiciaires.
- `id` (PK)
- `name` (ex: "Rabat-Salé-Kénitra")
- `code` (ex: "RSK")

### `tribunals`
Les tribunaux (TPI, Cour d'Appel) rattachés aux régions.
- `id` (PK)
- `region_id` (FK -> regions)
- `name` (ex: "TPI Rabat")
- `type` (TPI, CA, COMM, ADM)

### `huissiers`
L'annuaire national des Huissiers de Justice.
- `id` (PK)
- `tribunal_id` (FK -> tribunals)
- `nom`, `prenom`
- `email`, `telephone`, `adresse`
- `status` (active, suspended, retired)

### `actes` (Dossiers / Procédures)
Le cœur du métier : les dossiers traités par les huissiers.
- `id` (PK)
- `huissier_id` (FK -> huissiers)
- `reference` (Unique, ex: "2024/1023")
- `type` (notification, execution, constat)
- `status` (pending, in_progress, completed, archived)
- `date_depot`, `date_execution`
- `objet`, `notes`

### `users`
Utilisateurs de la plateforme.
- `role` : `super_admin`, `regional_admin`, ou `huissier`.
- `huissier_id` : Si rôle = huissier (lien vers sa fiche).
- `region_id` : Si rôle = regional_admin (lien vers sa région).

---

## 3. Gestion des Rôles et Permissions (Sécurité)

Le système utilise des **Global Scopes** pour cloisonner les données.

| Rôle | Accès | Logique Technique |
| :--- | :--- | :--- |
| **Super Admin** | **Total** | Voit toutes les données sans restriction. |
| **Admin Régional** | **Restreint** | Ne voit que les Huissiers et Actes liés aux tribunaux de **SA** région (`$user->region_id`). |
| **Huissier** | **Strict** | Ne voit que **SES** propres dossiers (`$user->huissier_id`). |

*Fichiers concernés : `ActesResource.php` (méthode `getEloquentQuery`), `HuissierResource.php`.*

---

## 4. API Mobile (Intégration)

L'API permet à une application externe (Mobile/Web) de se connecter.
**Base URL** : `http://votre-domaine.com/api`

### Authentification
**POST** `/api/login`
- Body : `{ "email": "...", "password": "..." }`
- Réponse : `{ "token": "sanctum_token...", "user": {...} }`

### Récupération des Dossiers
**GET** `/api/actes`
- Header : `Authorization: Bearer {token}`
- Réponse : Liste des dossiers assignés à l'huissier connecté.

### Mise à jour d'un Dossier
**POST** `/api/actes/{id}/status`
- Header : `Authorization: Bearer {token}`
- Body : `{ "status": "completed", "date_execution": "2024-02-12", "notes": "Fait." }`

---

## 5. Fonctionnalités Clés

### Tableau de Bord (Dashboard)
- Widgets temps réel : Nombre total d'huissiers, répartition par région, statut des dossiers.
- Graphiques interactifs (Chart.js via Filament).

### Génération de Documents
- Bouton "Imprimer" sur chaque dossier.
- Génère un PDF officiel (Certificat de remise) via `dompdf`.
- Template : `resources/views/actes/pdf.blade.php` (Compatible Arabe/RTL).

---

## 6. Déploiement

1.  **Pré-requis** : PHP 8.2+, MySQL, Composer.
2.  **Installation** :
    ```bash
    git clone ...
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate --seed
    ```
3.  **Production** :
    - passer `APP_ENV=production` et `APP_DEBUG=false`.
    - Configurer le cache : `php artisan config:cache` et `php artisan route:cache`.
