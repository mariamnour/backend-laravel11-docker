
# Laravel Sail Docker Project

Ce projet est une application Laravel configurée pour être exécutée avec Docker via Laravel Sail.

---

## Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :

- **Docker** et **Docker Compose**  
  [Téléchargez Docker](https://www.docker.com/products/docker-desktop/)
- **Git**  
  [Téléchargez Git](https://git-scm.com/)

---

## Installation

### Étapes pour démarrer le projet :

1. **Cloner le dépôt :**

   ```bash
   git clone https://github.com/mariamnour/crud-nextjs.git
   cd crud-nextjs
   ```

2. **Copier le fichier d'environnement :**

   Dupliquer le fichier `.env.example` pour créer un fichier `.env` :

   ```bash
   cp .env.example .env
   ```

3. **Installer les dépendances :**

   Installez Laravel Sail et les dépendances avec Composer :

   ```bash
   ./vendor/bin/sail composer install
   ```

4. **Démarrer Sail pour la première fois :**

   ```bash
   ./vendor/bin/sail up -d
   ```

5. **Générer la clé de l'application :**

   ```bash
   ./vendor/bin/sail artisan key:generate
   ```

6. **Lancer les migrations (facultatif) :**

   Si vous souhaitez initialiser la base de données, exécutez :

   ```bash
   ./vendor/bin/sail artisan migrate
   ```

7. **Accéder au projet :**

   Une fois Sail démarré, vous pouvez accéder au projet via [http://localhost](http://localhost).

---

## Commandes utiles

Voici quelques commandes pratiques pour travailler avec Laravel Sail :

- **Démarrer les services Docker :**

  ```bash
  ./vendor/bin/sail up -d
  ```

- **Arrêter les services Docker :**

  ```bash
  ./vendor/bin/sail down
  ```

- **Exécuter des commandes Artisan :**

  ```bash
  ./vendor/bin/sail artisan [commande]
  ```

- **Installer de nouvelles dépendances avec Composer :**

  ```bash
  ./vendor/bin/sail composer require [package]
  ```

- **Accéder au terminal Docker :**

  ```bash
  ./vendor/bin/sail shell
  ```

---

## Structure du projet

- `app/` : Contient le code principal de l'application Laravel.
- `database/` : Fichiers liés à la base de données (migrations, seeders, etc.).
- `routes/` : Définitions des routes de l'application.
- `resources/` : Vues et ressources front-end.

---

## Support

Si vous rencontrez des problèmes, consultez la documentation officielle de Laravel : [Laravel Documentation](https://laravel.com/docs).

### Installation et Configuration de TablePlus

1. **Télécharger TablePlus** :
   - Accédez au site officiel : [https://tableplus.com/](https://tableplus.com/).
   - Téléchargez et installez la version appropriée pour votre système d'exploitation (MacOS, Windows, ou Linux).

2. **Configurer une connexion à votre base de données Docker** :
   - Ouvrez TablePlus.
   - Cliquez sur **Créer une nouvelle connexion**.
   - Sélectionnez **MySQL** (ou le type de base de données utilisé dans votre projet).
   - Remplissez les champs :
     - **Host** : `127.0.0.1`
     - **Port** : `3306`
     - **User** : `root`
     - **Password** : Votre mot de passe de base de données défini dans `.env`.
     - **Database** : Laissez vide pour voir toutes les bases de données ou spécifiez-en une.
   - Cliquez sur **Connecter**.

3. **Accéder et gérer votre base de données** :
   - Une fois connecté, vous pouvez visualiser, éditer et gérer vos tables et données.

TablePlus est un outil puissant pour interagir avec vos bases de données de manière conviviale.
