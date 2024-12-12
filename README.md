# Projet ShadyCorp

Bienvenue dans le projet **ShadyCorp** ! Ce guide vous aidera à installer et configurer le projet pas à pas.

---

## Prérequis

Avant de commencer, assurez-vous d'avoir les outils suivants installés sur votre machine :

- **PHP** : Version 7.4 ou plus récente.
- **Composer** : Gestionnaire de dépendances PHP.
- **Git** : Pour cloner le dépôt du projet.
- **Serveur local** : Par exemple, WAMP, XAMPP, ou Docker.

---

## Informations sur le projet

Ce projet utilise le **Laravel Framework 11.28.1**.

---

## Installation

Suivez les étapes ci-dessous pour installer et configurer le projet :

### 1. Cloner le projet

Clonez le dépôt Git du projet et accédez au dossier :

```bash
git clone https://github.com/NicolasLambard/projetE5
cd projetE5
```

### 2. Installer les dépendances avec Composer

Dans le dossier du projet, exécutez la commande suivante pour installer toutes les dépendances :

```bash
composer install
```

### 3. Configurer le fichier `.env`

1. Créez un fichier `.env` en copiant le fichier `.env.example` :

   ```bash
   cp .env.example .env
   ```

2. Ouvrez le fichier `.env` avec un éditeur de texte et configurez les paramètres de connexion à votre base de données :

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nom_de_votre_base_de_donnees
   DB_USERNAME=votre_utilisateur
   DB_PASSWORD=votre_mot_de_pass
   DB_TABLE_PREFIX = APP_
   ```

3. Si vous utilisez MariaDB, commentez la ligne `DB_CONNECTION=sqlite` (si présente).

### 4. Générer la clé d'application

Générez une clé unique pour votre application Laravel :

```bash
php artisan key:generate
```

### 5. Migrer la base de données

Appliquez les migrations pour créer les tables nécessaires dans la base de données :

```bash
php artisan migrate
```

### 6. Supprimer la table `APP_Users` et insérer le SQL

Avant d’insérer des données SQL, supprimez la table inutile nommée `APP_Users` en retirant également ses contraintes associées. Vous pouvez utiliser la commande SQL suivante :

```sql
DROP TABLE APP_Users;
```

Ensuite, insérez le fichier SQL nommé `Application.SQL` disponible dans le projet dans votre base de données. Utilisez votre outil de gestion de base de données (par exemple, phpMyAdmin ou MySQL Workbench) pour exécuter ce fichier.

Après avoir inséré les données, installez les dépendances nécessaires avec les commandes suivantes dans votre terminal :

```bash
npm install
npm install vite --save-dev
npm audit fix
```


### 7. Lancer le serveur local

Démarrez le serveur Laravel pour tester le projet :

```bash
php artisan serve
```

Accédez au projet via l'URL affichée, généralement `http://127.0.0.1:8000`.

---

## Félicitations !

Votre projet **ShadyCorp** est maintenant installé et configuré. 🎉

En cas de problème ou de questions, consultez la documentation officielle de Laravel ou contactez le développeur responsable du projet.

Bon travail !
