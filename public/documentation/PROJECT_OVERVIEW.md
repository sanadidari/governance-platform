# Vue D'ensemble du Projet (Project Overview)

## 📌 À l'attention des futurs développeurs et mainteneurs

Ce document présente la **Plateforme Nationale de Gouvernance des Huissiers de Justice**.
C'est un outil stratégique pour la modernisation du secteur judiciaire au Maroc.

### 1. Objectifs du Projet
*   Disposer d'un annuaire national centralisé et fiable.
*   Suivre en temps réel l'activité judiciaire (Actes, Exécutions).
*   Offrir un outil de gestion moderne aux huissiers (Web & Mobile).
*   Garantir la sécurité et la confidentialité des données par région.

### 2. Choix Techniques
*   **Backend** : Laravel 11 (Robuste, Sécurisé, Standard).
*   **Admin UI** : FilamentPHP (Rapidité de développement, UX Premium).
*   **Base de Données** : MySQL (Compatible partout).
*   **Langue** : 100% Arabe (Interface et Données).

### 3. Architecture Modulaire
Le projet est découpé en modules clairs :
1.  **Core** : Modèles de base (Huissier, Tribunal, Region).
2.  **Business** : Gestion des Actes (Workflow, Statuts).
3.  **Security** : Scopes globaux pour isoler les données par utilisateur.
4.  **API** : Authentification Sanctum pour apps mobiles tiers.

### 4. Ressources
*   **Documentation Technique** : Voir `TECHNICAL_DOCUMENTATION.md` dans ce dossier.
*   **Guides Utilisateurs** : Voir les fichiers `GUIDE_*.md`.

---
*Projet initié en Février 2026.*
