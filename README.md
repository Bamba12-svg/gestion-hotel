# 🏨 Gestion Hôtel

> Application web de gestion hôtelière développée dans le cadre du projet L3 Génie Logiciel.

![Laravel](https://img.shields.io/badge/Laravel-12-red?style=flat&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.5-blue?style=flat&logo=php)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple?style=flat&logo=bootstrap)
![SQLite](https://img.shields.io/badge/SQLite-Database-green?style=flat&logo=sqlite)

---

## 📋 Description

**Gestion Hôtel** est une application web complète permettant à un hôtel de gérer ses opérations quotidiennes : chambres, clients, réservations et facturation, le tout depuis une interface moderne et intuitive.

---

## ✨ Fonctionnalités

| Module | Fonctionnalités |
|--------|----------------|
| 🔐 **Authentification** | Login / Logout sécurisé, middleware de protection |
| 🛏️ **Chambres** | Ajouter, modifier, supprimer, filtrer par statut |
| 👤 **Clients** | Gestion complète avec statut VIP automatique |
| 📋 **Réservations** | Création avec sélection chambre, suivi des statuts |
| 🧾 **Factures** | Génération automatique, impression PDF |
| 📊 **Dashboard** | Statistiques en temps réel, taux d'occupation |
| ⚙️ **Paramètres** | Modification profil, changement mot de passe |

---

## 🏗️ Architecture MVC
```
app/
├── Http/Controllers/     # Contrôleurs (logique métier)
│   ├── AuthController.php
│   ├── ChambreController.php
│   ├── ClientController.php
│   ├── ReservationController.php
│   └── FactureController.php
├── Models/               # Modèles Eloquent (base de données)
│   ├── Chambre.php
│   ├── Client.php
│   ├── Reservation.php
│   └── Facture.php
resources/
└── views/                # Vues Blade (interface utilisateur)
    ├── layouts/
    ├── chambres/
    ├── clients/
    ├── reservations/
    └── factures/
```

---

## 🗄️ Base de données

**6 tables :** `users`, `chambres`, `clients`, `reservations`, `factures`, `services`

---

## 🛠️ Stack Technique

- **Backend :** Laravel 12, PHP 8.5
- **Base de données :** SQLite
- **Frontend :** Bootstrap 5.3 (CDN), CSS personnalisé
- **Authentification :** Manuelle (sans package externe)
- **ORM :** Eloquent Laravel

---

## 🚀 Installation
```bash
# 1. Cloner le projet
git clone https://github.com/Bamba12-svg/gestion-hotel.git
cd gestion-hotel

# 2. Installer les dépendances PHP
composer install

# 3. Copier le fichier d'environnement
cp .env.example .env

# 4. Générer la clé de l'application
php artisan key:generate

# 5. Créer la base de données SQLite (Windows)
# Créer manuellement le fichier : database/database.sqlite

# 6. Exécuter les migrations et le seeder
php artisan migrate --seed

# 7. Lancer le serveur
php artisan serve
```

Ouvrir **http://127.0.0.1:8000**

---

## 🔑 Connexion

| Champ | Valeur |
|-------|--------|
| Email | `admin@hotel.com` |
| Mot de passe | `password` |

---

## 👨‍💻 Auteur

**Bamba** — Étudiant L3 Génie Logiciel  
🔗 [GitHub](https://github.com/Bamba12-svg)

---

## 📄 Licence

Projet académique — L3 Génie Logiciel © 2026