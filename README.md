# JobHunt

JobHunt est une application PHP de recherche d'emploi et de recrutement. Elle comprend un site public, des comptes candidats, des comptes entreprises et une zone administrateur.

## Fonctionnalites principales

- Recherche et filtrage des offres d'emploi.
- Inscription, connexion et deconnexion.
- Profils candidats, CV PDF/DOC/DOCX et candidatures.
- Offres en favoris et suivi des candidatures.
- Espace entreprise pour publier des offres et traiter les candidatures.
- Espace administrateur pour gerer les utilisateurs et les categories.
- Protection CSRF, mots de passe hashes et pages protegees par role.

## Technologies

- PHP 8.2 ou plus recent
- MySQL 8 ou MariaDB
- Apache
- PDO pour les requetes de base de donnees
- HTML, CSS et JavaScript sans framework frontend
- Composer pour l'autoload PSR-4 (aucune dependance tiers externe obligatoire)

## Prerequis sous Windows

1. Installer XAMPP avec Apache, MySQL/MariaDB et PHP.
2. Verifier que PHP est en version 8.2 ou superieure.
3. Installer Composer.
4. Activer les extensions PHP `pdo_mysql`, `fileinfo`, `mbstring` et `openssl` si elles sont disponibles.

## Recuperer le projet

Placez le dossier sous `C:\xampp\htdocs\tests\jobhunt`, puis ouvrez un terminal dans ce dossier.

```powershell
git clone https://github.com/mehdizmndev/JobHunt.git C:\xampp\htdocs\tests\jobhunt
cd C:\xampp\htdocs\tests\jobhunt
```

Si Apache utilise un dossier XAMPP different, copiez simplement le depot dans le dossier `htdocs` de votre installation.

## Installer les dependances

Le projet n'utilise aucune bibliotheque PHP tierce, mais Composer doit rester present pour confirmer l'autoload.

```powershell
composer install
```

## Creer et importer la base

1. Demarrer MySQL depuis le panneau XAMPP ou avec `C:\xampp\mysql_start.bat`.
2. Le fichier SQL reconstruit automatiquement une base `jobhunt` propre.
3. Importez-le avec une invite Windows :

```powershell
& $env:ComSpec /c '"C:\xampp\mysql\bin\mysql.exe" -u root < "C:\xampp\htdocs\tests\jobhunt\database\jobhunt.sql"'
```

Sans mot de passe MySQL, cette commande convient a une installation XAMPP locale.

Alternative par interface :

1. Ouvrir `http://localhost/phpmyadmin`.
2. Selectionner l'onglet **Importer**.
3. Choisir `database/jobhunt.sql`.
4. Cliquer sur **Importer**.

## Configuration

La configuration locale par defaut se trouve dans `config/database.php` :

- Hote : `127.0.0.1`
- Port : `3306`
- Base : `jobhunt`
- Utilisateur : `root`
- Mot de passe : vide

Pour modifier la configuration sans ecrire les identifiants dans Git, copier `.env.example` vers `.env`, puis adapter les valeurs.

```powershell
Copy-Item .env.example .env
```

```text
APP_URL=http://localhost/tests/jobhunt/public
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jobhunt
DB_USERNAME=root
DB_PASSWORD=
```

Le fichier `.env` est ignore par Git. Si Apache tourne sur Windows via XAMPP, redemarrez Apache apres toute modification importante.

## Demarrer l'application

1. Demarrer Apache et MySQL dans XAMPP.
2. Ouvrir :

```text
http://localhost/tests/jobhunt/public/index.php?page=home
```

Le dossier utilise ici correspond au depot place dans `C:\xampp\htdocs\tests\jobhunt`. Si votre depot a ete place ailleurs dans `htdocs`, remplacez `tests/jobhunt` par son chemin relatif.

## Comptes de demonstration

Ces comptes sont crees par `database/jobhunt.sql`.

| Role | Adresse | Mot de passe |
|---|---|---|
| Candidat | `candidate@jobhunt.test` | `Candidate123!` |
| Entreprise | `company@jobhunt.test` | `Company123!` |
| Administrateur | `admin@jobhunt.test` | `Admin123!` |

Ces comptes sont prevus pour le developpement et les demonstrations locales. Changez leurs mots de passe avant toute mise en production.

## Principales pages

- Accueil : `index.php?page=home`
- Offres : `index.php?page=jobs`
- Entreprises : `index.php?page=companies`
- Connexion : `index.php?page=signin`
- Creation de compte : `index.php?page=account-type`
- Tableau de bord candidat : `index.php?page=candidate-dashboard`
- Tableau de bord entreprise : `index.php?page=company-dashboard`
- Tableau de bord administrateur : `index.php?page=admin-dashboard`

## Structure

- `app/Controllers/` : `PageController.php` dirige les pages ; `AuthController.php`, `CandidateController.php`, `CompanyController.php` et `AdminController.php` s'occupent chacun de leur espace.
- `app/Core/` : connexion PDO et rendu des vues.
- `app/Models/` : lectures de donnees simples.
- `config/` : configuration locale de l'application et de la base.
- `database/` : fichier SQL reconstruit depuis zero.
- `public/` : point d'entree HTTP, CSS et JavaScript.
- `resources/views/` : vues PHP publiques, candidats, entreprises et administrateur.
- `routes/` : listes des routes principales.
- `storage/private/` : fichiers CV non accessibles directement dans le dossier public.
- `vendor/` : fichiers generes par Composer.

## Tester l'installation

Verifier la base, les comptes et les offres apres l'import :

```powershell
& C:\xampp\php\php.exe tests\smoke.php
```

## Erreurs frequentes

### 404 ou page introuvable

- Verifiez que le dossier est sous `C:\xampp\htdocs\`.
- Utilisez exactement l'URL `http://localhost/tests/jobhunt/public/index.php?page=home`.
- Redemarrez Apache si Apache a ete configure apres la copie du projet.

### Erreur de connexion MySQL

- Demarrez MySQL dans XAMPP.
- Confirmez que l'utilisateur MySQL est bien `root` avec un mot de passe vide.
- Si votre mot de passe est different, renseignez-le dans `.env`.
- Redemarrez Apache apres modification de `.env`.

### Page blanche

- Activez l'affichage des erreurs dans PHP uniquement en environnement local.
- Consultez `C:\xampp\apache\logs\error.log` et `C:\xampp\php\logs\php_error_log`.
- Verifiez que PHP est en version 8.2 ou superieure.

### Impossible d'importer le fichier SQL

- Utilisez MariaDB/MySQL avec les privileges CREATE DATABASE/DROP DATABASE.
- Fermez les applications utilisant la base `jobhunt`.
- Relancez l'import depuis une invite `cmd.exe` si PowerShell refuse la redirection `<`.
