# 📦 Réservation de Matériel

Application de gestion de réservations de matériel pour les employés.  
Développée avec **Symfony** (backend) et **HTML/CSS/JS** (frontend).

---

## 📋 Fonctionnalités

- Liste des équipements disponibles (ordinateurs, caméras, etc.)
- Réservation d'un équipement pour une période donnée
- Vérification automatique des conflits de réservation
- Messages de succès ou d'erreur en temps réel
- Interface fluide sans rechargement de page (fetch API)

---

## 🏗️ Structure du projet
```
reservation-materiel/
├── back/                      → API Symfony
│   ├── src/
│   │   ├── Controller/        → Gère les requêtes HTTP
│   │   ├── Entity/            → Modèles de données (Equipment, Reservation)
│   │   ├── Repository/        → Requêtes SQL
│   │   ├── Service/           → Logique métier
│   │   └── DataFixtures/      → Données de test
│   └── tests/
│       └── Service/           → Tests unitaires PHPUnit
├── front/                     → Interface utilisateur
│   ├── index.html             → Page principale
│   ├── style.css              → Styles
│   ├── app.js                 → Logique JavaScript
│   └── app.test.js            → Tests Jest
├── docker/
│   ├── Dockerfile             → Configuration PHP
│   └── nginx.conf             → Configuration Nginx
├── docker-compose.yml         → Services Docker
└── README.md
```

---

## 🚀 Lancer le projet

### Prérequis
- [Docker Desktop](https://www.docker.com/products/docker-desktop)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/)

### Étapes

**1. Clone le projet**
```bash
git clone https://github.com/manalez/materiel-reservation.git
cd materiel-reservation
```

**2. Lance Docker**
```bash
docker-compose up -d
```

**3. Installe les dépendances Symfony**
```bash
cd back
composer install
```

**4. Crée la base de données et les tables**
```bash
docker-compose exec php php bin/console doctrine:database:create
docker-compose exec php php bin/console doctrine:migrations:migrate
```

**5. Charge les données de test**
```bash
docker-compose exec php php bin/console doctrine:fixtures:load
```

**6. Lance le frontend**

Ouvre `front/index.html` avec **Live Server** dans VS Code  
ou accède à : `http://127.0.0.1:5500/front/index.html`

---

## 🌐 API

| Méthode | URL | Description |
|---------|-----|-------------|
| GET | `/api/equipments` | Liste tous les équipements |
| POST | `/api/reservations` | Crée une réservation |

### Exemple de requête POST
```json
{
  "equipment_id": 1,
  "user_email": "employe@exemple.com",
  "start_date": "2025-06-01",
  "end_date": "2025-06-05"
}
```

---

## 🧪 Lancer les tests

### Tests backend (PHPUnit)
```bash
cd back
php bin/phpunit
```

### Tests frontend (Jest)
```bash
cd front
npx jest
```

---

## 🐳 Services Docker

| Service | Description | Port |
|---------|-------------|------|
| php | Serveur PHP 8.2 | - |
| nginx | Serveur web | 8080 |
| db | MySQL 8.0 | 3306 |

---

## 🛠️ Technologies utilisées

- **Backend** : Symfony 7, Doctrine ORM, PHPUnit
- **Frontend** : HTML5, CSS3, JavaScript (Fetch API), Jest
- **Base de données** : MySQL 8.0
- **Serveur** : Nginx
- **Conteneurisation** : Docker