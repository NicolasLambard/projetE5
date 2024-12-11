# Projet ShadyCorp

Bienvenue dans le projet ShadyCorp ! Suivez les étapes ci-dessous pour installer et configurer le projet.

## Prérequis

- **PHP** (version 7.4 ou plus récent)
- **Composer** (gestionnaire de dépendances PHP)
- **Git** (pour cloner le projet)
- Un serveur local (par exemple : WAMP, XAMPP, ou Docker)

## Version utilisée

Ce projet utilise **Laravel Framework 11.28.1**.

## Installation

1. **Cloner le projet**  
   Téléchargez le code en exécutant la commande suivante :
   ```bash
   git clone https://github.com/NicolasLambard/projetE5
   cd projetE5
   ```

2. **Installer les dépendances avec Composer**  
   Une fois dans le dossier du projet, exécutez la commande suivante pour installer toutes les dépendances du projet :  
   ```bash
   composer install
   ```

3. **Configurer le fichier `.env`**  
   Copiez le fichier `.env.example` pour créer un nouveau fichier `.env` :
   ```bash
   cp .env.example .env
   ```
   Ensuite, ouvrez le fichier `.env` avec un éditeur de texte et configurez les paramètres de connexion à votre base de données en modifiant les lignes suivantes :  
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nom_de_votre_base_de_donnees
   DB_USERNAME=votre_utilisateur
   DB_PASSWORD=votre_mot_de_passe
   ```
   **Note :** Si vous utilisez MariaDB, commentez la ligne `DB_CONNECTION=sqlite` :
   

4. **Générer la clé d'application**  
   Générez une clé pour votre application Laravel :
   ```bash
   php artisan key:generate
   ```

5. **Migrer la base de données**  
   Appliquez les migrations pour créer les tables nécessaires dans votre base de données :
   ```bash
   php artisan migrate
   ```

6. **Lancer le serveur local**  
   Pour vérifier que tout fonctionne correctement, démarrez le serveur Laravel en exécutant la commande :
   ```bash
   php artisan serve
   ```
   Accédez ensuite au projet via l'URL affichée, généralement `http://127.0.0.1:8000`.

## Félicitations !

Votre projet ShadyCorp est maintenant installé et configuré. 🎉
